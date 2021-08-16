<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HostingPlans;

class HostingPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'id'             => 1,
                'name'           => 'Basic'
            ],
            [
                'id'             => 2,
                'name'           => 'Pro'
            ]

        ];

        HostingPlans::insert($plans);
    }
}
