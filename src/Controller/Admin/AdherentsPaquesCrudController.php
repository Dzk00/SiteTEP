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
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class AdherentsPaquesCrudController extends AbstractCrudController
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
    $generatePdfAction = Action::new('app_generate_pdf_paques', 'Générer PDF')
        ->linkToRoute('app_generate_pdf_paques');

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

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Adherents')
            ->setEntityLabelInPlural('Adherents')
            ->setDefaultSort(['nom_ad' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            TextField::new('nom_ad'),
            TextField::new('prenom_ad'),
            TextField::new('mail_ad'),
            TextField::new('tel_ad'),
            TextField::new('tel_secours_ad'),
            AssociationField::new('stage_paques')
                ->setLabel('Stage')
                ->onlyOnForms(),
            IntegerField::new('stage_paques')
                ->setLabel('Stage')
                ->hideOnForm()
                ->formatValue(function ($value, $entity) {
                    $stageNames = [];
    
                    foreach ($value as $stage) {
                        $stageNames[] = $stage->getNomStage(); 
                    }
    
                    return implode(', ', $stageNames);
                }
            ),
            TextField::new('code_postal_ad')
            ->onlyOnForms(),
            TextField::new('ville')
            ->onlyOnForms(),
            DateField::new('date_naissance_ad')
            ->onlyOnForms(),
            ChoiceField::new('state')->setChoices(AdherentsStateType::getChoices())->setRequired(true)
            ->setLabel('Etat'),

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
        $queryBuilder = $entityManager->createQueryBuilder();
    
        $queryBuilder->select('entity')->from(Adherents::class, 'entity');
        $queryBuilder->join('entity.stage_paques', 's'); 

        $queryBuilder->andWhere('s IS NOT NULL'); 
    
        return $queryBuilder;
    }

    public function generatePdfAction(EntityManagerInterface $entityManager): Response
    {
        $subquery = $entityManager->createQueryBuilder()
            ->select('a.id')
            ->from(Adherents::class, 'a')
            ->join('a.stage_paques', 's')
            ->orderBy('s.nom_stage', 'ASC')
            ->getQuery();

        $adherentIds = array_column($subquery->getScalarResult(), 'id');

        $dql = 'SELECT a FROM App\Entity\Adherents a WHERE a.id IN (:adherentIds) AND a.state = :validatedState';
        $query = $entityManager->createQuery($dql);
        $query->setParameter('adherentIds', $adherentIds);
        $query->setParameter('validatedState', 'validated');

        $adherents = $query->getResult();

        $adherentsGroupedByStage = [];
        foreach ($adherents as $adherent) {
            foreach ($adherent->getStagePaques() as $stage) {
                $stageName = $stage->getNomStage();
                $adherentsGroupedByStage[$stageName][] = $adherent;
            }
        }
        
        $adherentsValides = array_filter($adherents, function ($adherent) {
            return $adherent->getState() === 'validé';
        });

        
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isPhpEnabled', true);

        $dompdf = new Dompdf($options);

        $html = $this->renderView('admin/pdf/adherents_pdf.html.twig', [
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

