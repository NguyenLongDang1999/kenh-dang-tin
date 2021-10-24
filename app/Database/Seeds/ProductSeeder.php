<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $post = new Product;
		$faker = \Faker\Factory::create();

		for ($i = 1; $i <= 2000; $i++) {
			$post->save(
				[
                    'name' 		       	=>    $faker->name(),
					'slug'       		=>    $faker->slug(),
                    'sku'               =>    'Fashion - ' . $i,
                    'image' 	    	=> 	  $faker->imageUrl(350, 250),
                    'image_list' 		=> 	  $faker->imageUrl(650, 450),
                    'small_description' =>    $faker->text(),
                    'large_description'	=>	  $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text() . $faker->text(),
                    'quantity'    		=>    rand(1, 200),
                    'cat_id'    		=>    rand(1, 120),
                    'brand_id'          =>    null,
                    'number_buy'   		=>    rand(1, 50),
                    'sale'         		=>    rand(0, 100),
                    'price'				=> 	  rand(),
                    'view'      		=>    rand(1, 120),
                    'status'			=>    rand(0, 1),
					'featured'			=>	  rand(0, 1),
                    'meta_title'        =>	  $faker->text(),
					'meta_description'  =>	  $faker->text(),
					'meta_keyword'  	=>	  $faker->text(),
				]
			);
		}
    }
}
