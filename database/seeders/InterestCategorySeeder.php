<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InterestCategory;

class InterestCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id'             => 1,
                'name'           => 'Agriculture',
                'cover_art'      => '/storage/app/public/categories/category_art.png'
            ],
            [
                'id'             => 2,
                'name'           => 'Technology',
                'cover_art'      => '/storage/app/public/categories/category_art.png'
            ],
            [
                'id'             => 3,
                'name'           => 'Religion',
                'cover_art'      => '/storage/app/public/categories/category_art.png'
            ],
            [
                'id'             => 4,
                'name'           => 'Food & Nutrition',
                'cover_art'      => '/storage/app/public/categories/category_art.png'
            ]

        ];

        InterestCategory::insert($categories);
    }
}
