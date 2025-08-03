<?php

namespace App\Controller;

use App\Entity\Adherents;
use App\Form\InscriptionAnnuelleType;
use Symfony\Component\Form\FormError;
use App\Repository\AdherentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InscriptionsController extends AbstractController
{
    #[Route('/inscriptions/coursannuels', name: 'app_inscriptions')]
    public function index(
        Request $request, 
        EntityManagerInterface $entityManager, 
        AdherentsRepository $adherentsRepository): Response
    {
        $inscription = new Adherents();

        $form = $this->createForm(InscriptionAnnuelleType::class, $inscription, [
            'include_cours_ad' => true,
            'include_garderie_stage' => false,
            'include_sortie_autonome' => false,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            
            foreach ($errors as $error) {
                if ($error->getOrigin()->getName() === 'mail_ad') {
                    $this->addFlash(
                        'mail',
                        'Votre adresse mail est incorrecte, merci de vérifier.'
                    );
                    break; 
                }
            }}

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription = $form->getData();

            $existingAdherent = $adherentsRepository->findOneBy([
                'nom_ad' => $inscription->getNomAd(),
                'prenom_ad' => $inscription->getPrenomAd(),
                'date_naissance_ad' => $inscription->getDateNaissanceAd(),
            ]);

            if ($existingAdherent) {
                $existingAdherent->setCoursAd($inscription->getCoursAd());
                $entityManager->persist($existingAdherent);
            } else {
                $entityManager->persist($inscription);
            }            
            
            $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre inscription à été soumise avec succés !'
            );

            return $this->redirectToRoute('app_inscriptions');
        }
        return $this->render('inscriptions/annuelle.html.twig', [
            'form' => $form,
        ]);
    }
}
