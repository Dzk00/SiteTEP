<?php

namespace App\Controller\Admin;


use Exception;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Entity\Adherents;
use Doctrine\ORM\QueryBuilder;
use App\Workflow\AdherentsWorkflow;
use App\DBAL\Types\AdherentsStateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdherentsCoursCrudController extends AbstractCrudController
{
    public function __construct(EntityManagerInterface $entityManager, AdherentsWorkflow $adherentsWorkflow)
    {
        $this->entityManager = $entityManager;
        $this->adherentsStateMachine = $adherentsWorkflow;
    }
    
    public static function getEntityFqcn(): string
    {
        return Adherents::class;
    }
    
    public function configureActions(Actions $actions): Actions
    {
    $generatePdfAction = Action::new('app_generate_pdf_cours', 'Générer PDF')
        ->linkToRoute('app_generate_pdf_cours');

    $validateAction = Action::new('validate', 'Validation')
        ->linkToCrudAction('validate')
            ->displayIf(fn (Adherents $adherents) => $this->adherentsStateMachine->canValidate($adherents));

    return $actions
        // ->add(Crud::PAGE_INDEX, $filterByStageAction)
        ->add(Crud::PAGE_INDEX, $generatePdfAction)
        ->add(Crud::PAGE_INDEX, $validateAction);

    }
    
    public function validate(AdminContext $context, AdminUrlGenerator $adminUrlGenerator): Response
    {
        $adherents = $context->getEntity()->getInstance();

        if (!$adherents instanceof Adherents) {
            throw new \RuntimeException('Invalid user');
        }

        /** @var Session $session */
        $session = $context->getRequest()->getSession();
        $adminUrlGenerator->setController(self::class)->setAction('index')->removeReferrer()->setEntityId(null);

        try {
            $this->adherentsStateMachine->validate($adherents);
            $this->entityManager->flush();
            $session->getFlashBag()->add('success', "Adhérent {$adherents->getNomAd()} {$adherents->getPrenomAd()} inscrit.");
        } catch (Exception $e) {
            $session->getFlashBag()->add('error', $e->getMessage());
        }

        return $this->redirect($adminUrlGenerator->generateUrl());
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('nom_ad'),
            TextField::new('prenom_ad'),
            TextField::new('mail_ad'),
            TextField::new('tel_ad'),
            TextField::new('tel_secours_ad'),
            AssociationField::new('cours_ad')
                ->setLabel('Cours'),
            TextField::new('code_postal_ad')
            ->onlyOnForms(),
            TextField::new('ville')
            ->onlyOnForms(),
            DateField::new('date_naissance_ad')
            ->onlyOnForms(),
            ChoiceField::new('state')->setChoices(AdherentsStateType::getChoices())->setRequired(true),

        ];

        return $fields;
    }

    public function createIndexQueryBuilder(
        SearchDto $searchDto,
        EntityDto $entityDto,
        FieldCollection $fields,
        FilterCollection $filters
    ): QueryBuilder {
        $entityManager = $this->entityManager;
        $repository = $entityManager->getRepository(Adherents::class);
        $queryBuilder = $repository->createQueryBuilder('entity');
        $queryBuilder->andWhere('entity.cours_ad IS NOT NULL');

        return $queryBuilder;
    }

    public function generatePdfAction(EntityManagerInterface $entityManager): Response
    {
        $repository = $entityManager->getRepository(Adherents::class);

        $adherents = $repository->createQueryBuilder('a')
            ->leftJoin('a.cours_ad', 'ca') // Rejoignez la table de liaison CoursAd
            ->leftJoin('ca.adherents', 'c')
            ->andWhere('c IS NOT NULL')
            ->andWhere('a.state = :validatedState')
            ->setParameter('validatedState', 'validated')
            ->getQuery()
            ->getResult();

        
        // $adherentsGroupedByStage = [];
        // foreach ($adherents as $adherent) {
        //     foreach ($adherent->getCoursAd() as $coursAd) {
        //         $cours = $coursAd->getNomCours(); // Accédez à l'entité Cours
        //         $adherentsGroupedByStage[$cours][] = $adherent;
        //     }
        // }

        $adherentsGroupedByStage = [];
        foreach ($adherents as $adherent) {
            foreach ($adherent->getCoursAd() as $coursAd) {
                $cours = $coursAd->getCours(); // Accédez à l'entité Cours
                $idCours = $cours->getId(); // Obtenez l'ID du cours (ou autre clé unique)
                
                // Stockez le cours dans le tableau associatif
                $adherentsGroupedByStage[$idCours] = $cours;
            }
        }

        $adherentsValides = array_filter($adherents, function ($adherent) {
            return $adherent->getState() === 'validé';
        });

        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->renderView('admin/pdf/adherents_pdf_cours.html.twig', [
            'adherents' => $adherents,
            'adherentsGroupedByStage' => $adherentsGroupedByStage,
        ]);

        $dompdf->loadHtml($html);

        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        $response->headers->set('Content-Disposition', 'inline; filename="adherents.pdf"');

        return $response;
    }
    
}


