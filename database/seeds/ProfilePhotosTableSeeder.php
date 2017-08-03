<?php

use App\Profile;
use Illuminate\Database\Seeder;

class ProfilePhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        $lessonIds = Profile::pluck('id')->all();

        foreach ($lessonIds as $index) {
            DB::table('profile_photos')->insert([
                'profile_id' => $index,
                'name' => $faker->word(),
                'path' => 'random_url_path'
            ]);
        }
    }
}
