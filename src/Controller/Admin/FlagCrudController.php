<?php

namespace App\Controller\Admin;

use App\Entity\Flag;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class FlagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Flag::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            TextField::new('value'),
        ];
    }
}
