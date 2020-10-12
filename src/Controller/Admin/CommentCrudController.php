<?php

namespace App\Controller\Admin;

use App\Entity\Comment;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
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

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            // ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
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
            // DateTimeField::new('createdAt'),
           
        ];

        // Verifico en que pagina estoy y en fucnion de esto utilizo una u otra variable.
        if($pageName == Crud::PAGE_INDEX or $pageName == Crud::PAGE_DETAIL) {
            $fields[] = $photoFilename;
            $fields[] = DateTimeField::new('createdAt');
        } else {
            $fields[] = $thumbnail;
        }

        return $fields;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('author')
            ->add('conference')
            ->add('createdAt')
        ;
    }
}
