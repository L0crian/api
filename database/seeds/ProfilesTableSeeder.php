<?php

use App\Profile;
use Illuminate\Database\Seeder;

class ProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        foreach (range(1,10) as $index) {
            Profile::create([
                'user_id' => factory('App\User')->create()->id,
                'city' => $faker->city,
                'country' => $faker->country,
                'about' => $faker->paragraph(3)
            ]);
        }
    }
}

