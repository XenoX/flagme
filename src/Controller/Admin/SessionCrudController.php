<?php

namespace App\Controller\Admin;

use App\Entity\Session;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SessionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Session::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Name'),
            BooleanField::new('isClosed', 'Closed'),
            AssociationField::new('users'),
        ];
    }
}
