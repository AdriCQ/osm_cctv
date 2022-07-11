<?php

namespace Database\Seeders;

use App\Models\Camera;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->insert([
            'name' => 'AdminCCTV',
            'email' => 'cctv@mn.cfg',
            'password' => bcrypt('Admincctv2022+-+-')
        ]);

        $this->seedCameras();
    }

    private function seedCameras()
    {
        $faker = Factory::create();
        $data = [];
        for ($r = 0; $r < 20; $r++) {
            array_push($data, [
                'title' => $faker->words(3, true),
                'comments' => $faker->text,
                'ip' => '127.0.0.1',
                'brand' => $faker->randomElement(['AXIS', 'HUAWEI', 'PANASONIC']),
                'model' => $faker->word,
                'dome' => $faker->boolean(75),
                'works' => $faker->boolean(75),
                'position' => json_encode([
                    'lat' => $faker->randomFloat(5, 22.1300, 22.180),
                    'lng' => $faker->randomFloat(5, -80.4200, -80.4500)
                ]),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        Camera::query()->insert($data);
    }
}
