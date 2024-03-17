<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i <= 10; $i++) {

            $article = new Article();
            $article->setName($faker->name);
            $article->setDescription($faker->text);

            $manager->persist($article);

        }

        for($j=0;$j<=3;$j++){

            $comment = new Comment();
            $comment->setContent($faker->sentence);
            $manager->persist($comment);
        }

//        $manager->flush();
    }
}