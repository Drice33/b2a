<?php
/**
 * Created by IntelliJ IDEA.
 * User: benjamin
 * Date: 18/10/17
 * Time: 11:06
 */

namespace AppBundle\DataFixtures\ORM;


use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Products extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 20 products! Bam!
        for ($i = 0; $i < 20; $i++) {
            $product = new Product();
            $product->setTitle('product '.$i);
            $product->setDescription('description product '.$i.'....');
            $product->setPrice(mt_rand(10, 100));
            $manager->persist($product);
        }

        $manager->flush();
    }
}