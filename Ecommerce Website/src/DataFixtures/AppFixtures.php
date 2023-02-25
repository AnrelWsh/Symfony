<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher
    )
    {
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 1; $i <= 50; $i++){
            $user = new User();
            $user->setEmail('angel' .$i. '@ex.com');
            $user->setFirstName('Angel' . $i);
            $user->setLastName('Hmeli' . $i);
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    'password'
                )
            );

            if($i === 1){
                $user->setRoles(['ROLE_ADMIN']);
            }

            $manager->persist($user);
        };

        $manager->flush();

        for ($i = 1; $i <= 10; $i++){
            $category = new Category();
            $category->setName('Category ' .$i);
            $category->setPictureUrl('https://cdns.iconmonstr.com/wp-content/releases/preview/2012/240/iconmonstr-triangle-1.png');

            $manager->persist($category);
        }
        $manager->flush();

        $categories = $manager->getRepository(Category::class)->findAll();

        foreach ($categories as $category) {
            for ($i = 1; $i <= 20; $i++) {
                $product = new Product();
                $product->setName('Product ' . $i);
                $product->setPrice(rand(10, 1000) / 10);
                $product->setPictureUrl('https://cdn-icons-png.flaticon.com/512/81/81227.png');
                $product->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum');
                $product->setStock(rand(50, 100));
                $product->setCategory($category);

                $manager->persist($product);
            }
        }

        $manager->flush();
    }
}
