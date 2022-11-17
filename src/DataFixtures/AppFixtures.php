<?php

namespace App\DataFixtures;
use App\Entity\CardValue;
use App\Entity\CardColor;
use App\Entity\Player;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AppFixtures extends Fixture
{
    /**
     * Faker Generator
     * 
     * @var Generator
     */
    private Generator $faker;

    public function __construct(){
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        $aCard = new CardValue();
        $aCard->setValue("A");
        $manager->persist($aCard);
        $kCard = new CardValue();
        $kCard->setValue("K");
        $manager->persist($kCard);
        $qCard = new CardValue();
        $qCard->setValue("Q");
        $manager->persist($qCard);
        $jCard = new CardValue();
        $jCard->setValue("J");
        $manager->persist($jCard);
        $tenCard = new CardValue();
        $tenCard->setValue("10");
        $manager->persist($tenCard);
        $nineCard = new CardValue();
        $nineCard->setValue("9");
        $manager->persist($nineCard);
        $eightCard = new CardValue();
        $eightCard->setValue("8");
        $manager->persist($eightCard);
        $sevenCard = new CardValue();
        $sevenCard->setValue("7");
        $manager->persist($sevenCard);
        $sixCard = new CardValue();
        $sixCard->setValue("6");
        $manager->persist($sixCard);
        $fiveCard = new CardValue();
        $fiveCard->setValue("5");
        $manager->persist($fiveCard);
        $fourCard = new CardValue();
        $fourCard->setValue("4");
        $manager->persist($fourCard);
        $threeCard = new CardValue();
        $threeCard->setValue("3");
        $manager->persist($threeCard);
        $twoCard = new CardValue();
        $twoCard->setValue("2");
        $manager->persist($twoCard);

        $heartCard = new CardColor();
        $heartCard->setColor("heart");
        $manager->persist($heartCard);
        $spadesCard = new CardColor();
        $spadesCard->setColor("spade");
        $manager->persist($spadesCard);
        $diamondCard = new CardColor();
        $diamondCard->setColor("diamond");
        $manager->persist($diamondCard);
        $clubCard = new CardColor();
        $clubCard->setColor("club");
        $manager->persist($clubCard);

        $dealerPlayer = new Player();
        $dealerPlayer->setName("dealer");
        $manager->persist($dealerPlayer);

        $manager->flush();
    }
}
