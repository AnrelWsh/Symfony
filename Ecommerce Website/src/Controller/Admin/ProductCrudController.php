<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Validator\Constraints\File;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            AssociationField::new('category'),
            MoneyField::new('price')->setCurrency('EUR'),
            ImageField::new('pictureUrl')
                ->setUploadDir('public/uploads/categories')
                ->setBasePath('uploads/categories')
                ->setUploadedFileNamePattern('[slug]-[randomhash].[extension]')
                /*->setFormTypeOption('constraints', [
                    new File([
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/svg+xml',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image (JPEG, PNG, SVG)',
                    ])
                ])*/,
            TextField::new('description'),
            IntegerField::new('stock'),
        ];
    }
}
