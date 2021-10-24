<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = new UserModel;
        $faker = \Faker\Factory::create();
        $config = config('Auth');

        $hashOptions = [
            'cost' => $config->hashCost
        ];

        $password_hash_admin = password_hash(
            base64_encode(
                hash('sha384', 'dang04121999', true)
            ),
            $config->hashAlgorithm,
            $hashOptions
        );

        $user = $user->withGroup('super-admin');
        $user->save(
            [
                'fullname'            =>    'Super Administrator',
                'email'               =>    'longdang0412@gmail.com',
                'password_hash'        =>    $password_hash_admin,
                'phone'               =>    '0389747179',
                'avatar'             =>       $faker->imageUrl(150, 150),
                'gender'             =>       GENDER_MALE,
                'active'            =>       STATUS_ACTIVE,
            ]
        );

        for ($i = 2; $i <= 200; $i++) {
            $password_hash = password_hash(
                base64_encode(
                    hash('sha384', $faker->password, true)
                ),
                $config->hashAlgorithm,
                $hashOptions
            );

            if (!empty($config->defaultUserGroup)) {
                $user = $user->withGroup($config->defaultUserGroup);
            }

            $user->save(
                [
                    'fullname'            =>    $faker->name,
                    'email'               =>    $faker->email,
                    'password_hash'        =>    $password_hash,
                    'phone'               =>    $faker->phoneNumber,
                    'avatar'             =>       $faker->imageUrl(150, 150),
                    'gender'             =>       rand(GENDER_FEMALE, GENDER_MALE),
                    'active'            =>       STATUS_ACTIVE,
                ]
            );
        }
    }
}
