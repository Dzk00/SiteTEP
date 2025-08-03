<?php

namespace App\Controller\Admin;

use App\Entity\Blog;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class BlogCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Blog::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('titre')
        ->setLabel("Titre de l'article (max 60 carac.)");
        yield TextField::new('titre_court')
        ->hideOnForm()
        ->setLabel("Titre racourci (max 20 carac.)");
        yield TextField::new('titre_court')
        ->setLabel("Titre racourci (Max 20 carac.)")
        ->onlyOnForms();
        yield TextareaField::new('description_courte')
        ->setLabel('Description version courte (Max 250 carac.)')
        ->onlyOnForms();
        yield TextareaField::new('description_longue_un')
        ->setLabel('Description (Max 500 carac.)')
        ->onlyOnForms();
        yield TextareaField::new('description_longue_2')
        ->setLabel('Description (Max 500 carac.)')
        ->onlyOnForms();
        yield ImageField::new('imageFile')
            ->setLabel('Image (ne pas uploader une nouvelle image si vous modifiez un blog)')
            ->setUploadDir('public/images/blog') 
            ->setBasePath('/images/blog') 
            ->onlyOnForms();
    
        yield ImageField::new('image')
            ->setLabel('Image')
            ->setBasePath('/images/blog') 
            ->onlyOnDetail(); 
        }
}
