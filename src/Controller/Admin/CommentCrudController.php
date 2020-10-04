<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
// use App\Entity\Conference;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CommentCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Comment::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        // Sirve para cargar un archivo con el complemento Vich.
        $thumbnail = ImageField::new('thumbnail')->setFormType(VichImageType::class);
        // Sirve para mostrar un archivo previamente cargado.
        $photoFilename = ImageField::new('photoFilename')->setBasePath('/images/thumbnails');

        $fields = [
            TextField::new('author'),
            TextField::new('email'),
            AssociationField::new('conference')->autocomplete(),
            TextEditorField::new('text'),
            DateTimeField::new('createdAt'),
           
        ];

        // Verifico en que pagina estoy y en fucnion de esto utilizo una u otra variable.
        if($pageName == Crud::PAGE_INDEX or $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $photoFilename;
        } else {
            $fields[] = $thumbnail;
        }

        return $fields;
    }
    
}
