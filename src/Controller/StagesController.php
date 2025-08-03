<?php

namespace App\Controller;

use App\Entity\Stages;
use App\Entity\Adherents;
use App\Entity\StagesHiver;
use App\Entity\StagesPaques;
use App\Entity\StagesToussaint;
use App\Form\InscriptionAnnuelleType;
use Symfony\Component\Form\FormError;
use App\Repository\AdherentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StagesController extends AbstractController
{
    #[Route('/stages/monaco', name: 'app_stages_monaco')]
    public function index(
        Request $request, 
        EntityManagerInterface $entityManager, 
        AdherentsRepository $adherentsRepository): Response
    {
        $inscription = new Adherents();

        $form = $this->createForm(InscriptionAnnuelleType::class, $inscription, [
            'include_stage_ad' => true, 
            'include_garderie_stage' => true,
        ]);

        $stagerepo = $entityManager->getRepository(Stages::class);
        $allstage = $stagerepo->findAll();
        
        function updateMaxForChunk($chunk, $allstage) {
            $nbrmatin = 0;
            $nbrjour = 0;
            $nbraprem = 0;
        
            foreach ($allstage as $stage) {
                if ($stage->getChunk() == $chunk) {
                    if ($stage->getType() == "matin") {
                        foreach ($stage->getAdherents() as $unique) {
                            $nbrmatin++;
                            $stage->setMax("0");
                        }
                    }
        
                    if ($stage->getType() == "jour") {
                        foreach ($stage->getAdherents() as $unique) {
                            $nbrjour++;
                            $stage->setMax("0");
                        }
                    }
        
                    if ($stage->getType() == "aprem") {
                        foreach ($stage->getAdherents() as $unique) {
                            $nbraprem++;
                            $stage->setMax("0");
                        }
                    }
                }
            }
        
            $totalmatin = $nbrmatin + $nbrjour;
            $totaljour = $nbrmatin + $nbraprem + $nbrjour;
            $totalaprem = $nbraprem + $nbrjour;

        
            foreach ($allstage as $stage) {
                if ($stage->getChunk() == $chunk) {
                    if ($stage->getType() == "matin" && $totalmatin >= 30 && strpos($stage->getNomStage(), "COMPLET") === false) 
                    {
                        $stage->setMax("1");
                        $stage->setNomStage($stage->getNomStage() . " COMPLET");
                    }
        
                    if ($stage->getType() == "jour" && $totaljour >= 30 && strpos($stage->getNomStage(), "COMPLET") === false) 
                    {
                        $stage->setMax("1");
                        $stage->setNomStage($stage->getNomStage() . " COMPLET");
                    }
        
                    if ($stage->getType() == "aprem" && $totalaprem >= 30 && strpos($stage->getNomStage(), "COMPLET") === false) 
                    {
                        $stage->setMax("1");
                        $stage->setNomStage($stage->getNomStage() . " COMPLET");
                    }
                }
            }
        }

        $chunks = ["semaine1", "semaine2", "semaine3", "semaine4", "semaine5"];
        
        foreach ($chunks as $chunk) {
        updateMaxForChunk($chunk, $allstage);
        }

        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            
            foreach ($errors as $error) {
                if ($error->getOrigin()->getName() === 'mail_ad') {
                    $this->addFlash(
                        'mail',
                        'Un problème est survenu, veuillez nous contacter.'
                    );
                    break; 
                }
            }}
            if ($form->isSubmitted() && $form->isValid()) {
                $inscription = $form->getData();
                $selectedStage = $inscription->getStageAd()->first();
                $existingAdherent = $adherentsRepository->findOneBy([
                    'nom_ad' => $inscription->getNomAd(),
                    'prenom_ad' => $inscription->getPrenomAd(),
                    'date_naissance_ad' => $inscription->getDateNaissanceAd(),
                ]);
    
                if ($selectedStage && $selectedStage->isMax()) {
                    $this->addFlash(
                        'fail',
                        'Le stage selectionné est complet. Veuillez choisir un autre stage.'
                    );
                }else if ($existingAdherent) {
                    $stagesAd = $inscription->getStageAd();
                        foreach ($stagesAd as $stageAd) {
                            $existingAdherent->addStageAd($stageAd);
                        }
                    $existingAdherent->setGarderieStage($inscription->isGarderieStage())
                                     ->setSortieAutonome($inscription->isSortieAutonome());
                    $entityManager->persist($existingAdherent);
                } else {
                    $entityManager->persist($inscription);
                } 
    
                $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre inscription à été soumise avec succés !'
            );

            return $this->redirectToRoute('app_stages_monaco');
        }

        return $this->render('stages/ete.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/stages/toussaint', name: 'app_stages_toussaint')]
    public function toussaint(Request $request, EntityManagerInterface $entityManager, AdherentsRepository $adherentsRepository): Response
    {
        $inscription = new Adherents();

        $form = $this->createForm(InscriptionAnnuelleType::class, $inscription, [
            'include_stage_toussaint' => true,
            'include_garderie_stage' => true, 
        ]);
        $stagerepo = $entityManager->getRepository(StagesToussaint::class);
        $allstage = $stagerepo->findAll();
            
        $nbrmatin = 0;
        $nbrjour = 0;
        $nbraprem = 0;
        
            foreach ($allstage as $stage) {
                if ($stage->getType() == "matin") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbrmatin++;
                    }
                }
        
                if ($stage->getType() == "jour") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbrjour++;
                    }
                }
        
                if ($stage->getType() == "aprem") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbraprem++;
                    }
                }
            }
        
            $totalmatin = $nbrmatin + $nbrjour;
            $totaljour = $nbrmatin + $nbraprem + $nbrjour;
            $totalaprem = $nbraprem + $nbrjour;
        
            foreach ($allstage as $stage) {
                if ($stage->getType() == "matin" && $totalmatin >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
                if ($stage->getType() == "jour" && $totaljour >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
                if ($stage->getType() == "aprem" && $totalaprem >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
            }

        $form->handleRequest($request);
        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            
            foreach ($errors as $error) {
                if ($error->getOrigin()->getName() === 'mail_ad') {
                    $this->addFlash(
                        'mail',
                        'Un problème est survenu, veuillez nous contacter.'
                    );
                    break; 
                }
            }}
            if ($form->isSubmitted() && $form->isValid()) {
                $inscription = $form->getData();
                $selectedStage = $inscription->getStageToussaint()->first();
                $existingAdherent = $adherentsRepository->findOneBy([
                    'nom_ad' => $inscription->getNomAd(),
                    'prenom_ad' => $inscription->getPrenomAd(),
                    'date_naissance_ad' => $inscription->getDateNaissanceAd(),
                ]);
    
                if ($selectedStage && $selectedStage->isMax()) {
                    $this->addFlash(
                        'fail',
                        'Un problème est survenu, veuillez nous contacter.'
                    );
                }else if ($existingAdherent) {
                    $stagesToussaint = $inscription->getStageToussaint();
                        foreach ($stagesToussaint as $stageToussaint) {
                            $existingAdherent->addStageToussaint($stageToussaint);
                        }
                    $existingAdherent->setGarderieStage($inscription->isGarderieStage())
                                     ->setSortieAutonome($inscription->isSortieAutonome());
                    $entityManager->persist($existingAdherent);
                } else {
                    $entityManager->persist($inscription);
                } 
    
                $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre inscription à été soumise avec succés !'
            );

            return $this->redirectToRoute('app_stages_toussaint');
        }

        return $this->render('stages/toussaint.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/stages/fevrier', name: 'app_stages_fevrier')]
    public function fevrier(Request $request, EntityManagerInterface $entityManager, AdherentsRepository $adherentsRepository): Response
    {
        $inscription = new Adherents();

        $form = $this->createForm(InscriptionAnnuelleType::class, $inscription, [
            'include_stage_hiver' => true,
            'include_garderie_stage' => true,
        ]);
        $stagerepo = $entityManager->getRepository(StagesHiver::class);
        $allstage = $stagerepo->findAll();
            
        $nbrmatin = 0;
        $nbrjour = 0;
        $nbraprem = 0;
        
            foreach ($allstage as $stage) {
                if ($stage->getType() == "matin") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbrmatin++;
                        $stage->setMax("0");
                    }
                }
        
                if ($stage->getType() == "jour") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbrjour++;
                        $stage->setMax("0");
                    }
                }
        
                if ($stage->getType() == "aprem") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbraprem++;
                        $stage->setMax("0");
                    }
                }
            }
        
            $totalmatin = $nbrmatin + $nbrjour;
            $totaljour = $nbrmatin + $nbraprem + $nbrjour;
            $totalaprem = $nbraprem + $nbrjour;
        
            foreach ($allstage as $stage) {
                if ($stage->getType() == "matin" && $totalmatin >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
                if ($stage->getType() == "jour" && $totaljour >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
                if ($stage->getType() == "aprem" && $totalaprem >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
            }

        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            
            foreach ($errors as $error) {
                if ($error->getOrigin()->getName() === 'mail_ad') {
                    $this->addFlash(
                        'mail',
                        'Un problème est survenu, veuillez nous contacter.'
                    );
                    break; 
                }
            }}

        if ($form->isSubmitted() && $form->isValid()) {
            $inscription = $form->getData();
            $selectedStage = $inscription->getStageHiver()->first();
            $existingAdherent = $adherentsRepository->findOneBy([
                'nom_ad' => $inscription->getNomAd(),
                'prenom_ad' => $inscription->getPrenomAd(),
                'date_naissance_ad' => $inscription->getDateNaissanceAd(),
            ]);

            if ($selectedStage && $selectedStage->isMax()) {
                $this->addFlash(
                    'fail',
                    'Un problème est survenu, veuillez nous contacter.'
                );
            }else if ($existingAdherent) {
                $stagesHiver = $inscription->getStageHiver();
                    foreach ($stagesHiver as $stageHiver) {
                        $existingAdherent->addStageHiver($stageHiver);
                    }
                $existingAdherent->setGarderieStage($inscription->isGarderieStage())
                                 ->setSortieAutonome($inscription->isSortieAutonome());
                $entityManager->persist($existingAdherent);
            } else {
                $entityManager->persist($inscription);
            } 

            $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre inscription à été soumise avec succés !'
            );

            return $this->redirectToRoute('app_stages_fevrier');
        }

        return $this->render('stages/fevrier.html.twig', [
            'form' => $form,
        ]);
    }
    #[Route('/stages/paques', name: 'app_stages_paques')]
    public function paques(Request $request, EntityManagerInterface $entityManager, AdherentsRepository $adherentsRepository): Response
    {
        $inscription = new Adherents();

        $form = $this->createForm(InscriptionAnnuelleType::class, $inscription, [
            'include_stage_paques' => true,
            'include_garderie_stage' => true, 
        ]);
        $stagerepo = $entityManager->getRepository(StagesPaques::class);
        $allstage = $stagerepo->findAll();
            
        $nbrmatin = 0;
        $nbrjour = 0;
        $nbraprem = 0;
        
            foreach ($allstage as $stage) {
                if ($stage->getType() == "matin") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbrmatin++;
                        $stage->setMax("0");
                    }
                }
        
                if ($stage->getType() == "jour") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbrjour++;
                        $stage->setMax("0");
                    }
                }
        
                if ($stage->getType() == "aprem") {
                    foreach ($stage->getAdherents() as $unique) {
                        $nbraprem++;
                        $stage->setMax("0");
                    }
                }
            }
        
            $totalmatin = $nbrmatin + $nbrjour;
            $totaljour = $nbrmatin + $nbraprem + $nbrjour;
            $totalaprem = $nbraprem + $nbrjour;
        
            foreach ($allstage as $stage) {
                if ($stage->getType() == "matin" && $totalmatin >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
                if ($stage->getType() == "jour" && $totaljour >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
                if ($stage->getType() == "aprem" && $totalaprem >= 25) {
                    $stage->setMax("1");
                    $stage->setNomStage($stage->getNomStage() . " COMPLET");
                }
            }

        $form->handleRequest($request);

        if ($form->isSubmitted() && !$form->isValid()) {
            $errors = $form->getErrors(true);
            
            foreach ($errors as $error) {
                if ($error->getOrigin()->getName() === 'mail_ad') {
                    $this->addFlash(
                        'mail',
                        'Un problème est survenu, veuillez nous contacter.'
                    );
                    break; 
                }
            }}
        if ($form->isSubmitted() && $form->isValid()) {
            $inscription = $form->getData();
            $selectedStage = $inscription->getStagePaques()->first();

            $existingAdherent = $adherentsRepository->findOneBy([
                'nom_ad' => $inscription->getNomAd(),
                'prenom_ad' => $inscription->getPrenomAd(),
                'date_naissance_ad' => $inscription->getDateNaissanceAd(),
            ]);

            if ($selectedStage && $selectedStage->isMax()) {
                $this->addFlash(
                    'fail',
                    'Un problème est survenu, veuillez nous contacter.'
                );
            }else if ($existingAdherent) {
                $stagesPaques = $inscription->getStagePaques();
                    foreach ($stagesPaques as $stagePaques) {
                        $existingAdherent->addStagePaque($stagePaques);
                    }
                $existingAdherent->setGarderieStage($inscription->isGarderieStage())
                                 ->setSortieAutonome($inscription->isSortieAutonome());
                $entityManager->persist($existingAdherent);
            } else {
                $entityManager->persist($inscription);
            } 
            $entityManager->flush();

            $this->addFlash(
                'succes',
                'Votre inscription à été soumise avec succés !'
            );


            return $this->redirectToRoute('app_stages_paques');
        }

        return $this->render('stages/paques.html.twig', [
            'form' => $form,
        ]);
    }
}
