<?php

namespace App\Form;

use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Adherents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class InscriptionAnnuelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_ad')
            ->add('prenom_ad')
            ->add('adresse_ad')
            ->add('code_postal_ad')
            ->add('ville')
            ->add('mail_ad', null, [
                'constraints' => [
                    new Assert\Regex([
                        'pattern' => '/^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$/',
                        'message' => 'Veuillez entrer une adresse email valide.',
                    ]),
                ],
            ])
            ->add('date_naissance_ad', DateType::class, [
                'years' => range(1940, 2022),
            ])
            ->add('tel_ad')
            ->add('tel_secours_ad')
            ->add('tel_pere_ad')
            ->add('tel_mere_ad')
            ->add('autorisation_urgence', CheckboxType::class, [
                'required' => true, 
            ])
            ->add('vaccins_ad', CheckboxType::class, [
                'required' => true,
            ])
            ->add('antecedents_medicaux_ad')
            ->add('droit_image_ad', CheckboxType::class, [
                'required' => true, 
            ]);
            if ($options['include_cours_ad']) {
                $builder->add('cours_ad', null, [
                    'required' => true,
                ]);
            };
            if ($options['include_stage_ad']) {
                $builder->add('stage_ad', null, [
                    'required' => true,
                ]);
            };
            if ($options['include_garderie_stage']) {
                $builder->add('garderie_stage');
            };
            if ($options['include_stage_toussaint']) {
                $builder->add('stage_toussaint', null, [
                    'required' => true,
                ]);
            };
            if ($options['include_stage_hiver']) {
                $builder->add('stage_hiver', null, [
                    'required' => true,
                ]);
            };
            if ($options['include_stage_paques']) {
                $builder->add('stage_paques', null, [
                    'required' => true,
                ]);
            };
            if ($options['include_sortie_autonome']) {
                $builder->add('sortie_autonome');
            };
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adherents::class,
            'include_cours_ad' => false,
            'include_stage_ad' => false,
            'include_garderie_stage' => false,
            'include_stage_toussaint' => false,
            'include_stage_hiver' => false,
            'include_stage_paques' => false,
            'include_sortie_autonome' => true,
        ]);
    }
}
