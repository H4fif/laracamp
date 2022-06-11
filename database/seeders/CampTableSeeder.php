<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Camp;

class CampTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 1st method using Model::create() -> timestamps automatically filled
        $camps = [
            [
                'title' => 'Gila Belajar',
                'slug' => 'gila-belajar',
                'price' => 280,
            ],
            [
                'title' => 'Baru Mulai',
                'slug' => 'baru-mulai',
                'price' => 140,
            ],
        ];

        foreach ($camps as $camp) {
            Camp::create($camp);
        }

        // 2nd method using batch insert Model::insert() timestamps should manually filled or will set to null
        // $camps = [
        //     [
        //         'title' => 'Gila Belajar',
        //         'slug' => 'gila-belajar',
        //         'price' => 280,
        //         'created_at' => date('Y-m-d H:i:s', time()),
        //         'updated_at' => date('Y-m-d H:i:s', time()),
        //     ],
        //     [
        //         'title' => 'Baru Mulai',
        //         'slug' => 'baru-mulai',
        //         'price' => 140,
        //         'created_at' => date('Y-m-d H:i:s', time()),
        //         'updated_at' => date('Y-m-d H:i:s', time()),
        //     ],
        // ];

        // Camp::insert($camps);
    }
}
