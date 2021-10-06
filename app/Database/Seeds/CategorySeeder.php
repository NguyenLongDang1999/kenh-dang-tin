<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $category = new Category;
        $faker = \Faker\Factory::create();

        $sum = 1;
        for ($i = 1; $i <= 12; $i++) {
            $category->save(
                [
                    'name'                      =>  'Danh mục ' . $i,
                    'slug'                      =>  $faker->slug(),
                    'description'               =>  $faker->text(),
                    'image'                     =>  $faker->imageUrl(100, 100),
                    'parent_id'                 =>  0,
                    'sort'                      =>  $sum++,
                    'meta_title'                =>  $faker->text(),
                    'meta_description'          =>  $faker->text(),
                    'meta_keyword'              =>  $faker->text(),
                ]
            );

            for ($j = 1; $j <= 9; $j++) {
                $category->save(
                    [
                        'name'                  =>  'Danh mục ' . $i . '.' . $j,
                        'slug'                  =>  $faker->slug(),
                        'description'           =>  $faker->text(),
                        'image'                 =>  $faker->imageUrl(100, 100),
                        'parent_id'             => ($i > 1) ? (($i - 1) * 10) + 1 : $i,
                        'sort'                  =>  $sum++,
                        'meta_title'            =>  $faker->text(),
                        'meta_description'      =>  $faker->text(),
                        'meta_keyword'          =>  $faker->text(),
                    ]
                );
            }
        }
    }
}
