<?php

namespace App\DataFixtures;

use App\Entity\Flag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class FlagFixtures extends Fixture
{
    public const REFERENCE_PREFIX = 'flag';

    public function load(ObjectManager $manager): void
    {
        $flags = [
            [
                'name' => 'XSS',
                'value' => 'LV_XSS_ST0RED_YOU_ROCK',
            ],
            [
                'name' => 'SQL Injection 1',
                'value' => 'LV_SQL_INJECTION_4_THE_WIN',
            ],
            [
                'name' => 'SQL Injection 2',
                'value' => 'LV_SQL_INJECTION_WITH_AN_ADMIN_ACCOUNT',
            ],
            [
                'name' => 'LFI',
                'value' => 'LV_L0CAL_FIL3_INCLU5ION',
            ],
            [
                'name' => 'SSTI',
                'value' => 'pprice',
            ],
            [
                'name' => 'File Upload 1',
                'value' => '/var/www/html/public/uploads/waiting',
            ],
            [
                'name' => 'File Upload 2',
                'value' => 'LV_UPL0AD_WITH_EXTENSION_CHECK',
            ],
            [
                'name' => 'File Upload 3',
                'value' => 'LV_UPL0AD_MAG1C_NUMB3RS_CHECK',
            ],
            [
                'name' => 'CSRF',
                'value' => 'LV_CSRF_IS_NIC3',
            ],
            [
                'name' => 'JSON ALG',
                'value' => 'LV_JSON_WEB_TOKEN_ALG_N0NE',
            ],
            [
                'name' => 'JSON Brute force',
                'value' => 'pass',
            ],
            [
                'name' => 'Brute force login',
                'value' => 'LV_BRUTE_FORCE_ITS_4_LAST_CHANCE',
            ],
        ];

        foreach ($flags as $value) {
            $flag = new Flag();
            $flag
                ->setName($value['name'])
                ->setValue($value['value'])
            ;

            $this->addReference(sprintf('%s-%s', FlagFixtures::REFERENCE_PREFIX, strtolower($value['name'])), $flag);

            $manager->persist($flag);
        }

        $manager->flush();
    }
}
