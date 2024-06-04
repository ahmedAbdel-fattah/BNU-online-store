<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        $categories = [
            ['id' => 1, 'name' => 'كاميرات', 'description' => 'كاميرات الكترونيه', 'imagepath' => 'assets\img\t1.jpg'],
            ['id' => 2, 'name' => 'تحف', 'description' => ' ', 'imagepath' => 'assets\img\h1.jpg'],
            ['id' => 3, 'name' => 'ورق', 'description' => ' ', 'imagepath' => 'assets\img\s1.jpg'],
            ['id' => 4, 'name' => 'مكياج', 'description' => ' ', 'imagepath' => 'assets\img\h2.jpg'],
            ['id' => 5, 'name' => 'زينه', 'description' => ' ', 'imagepath' => 'assets\img\e1.jpg'],
            ['id' => 6, 'name' => 'مكاتب', 'description' => ' ', 'imagepath' => 'assets\img\e2.jpg'],




        ];

        DB::table('categories')->insertOrIgnore($categories);



        for ($i = 1; $i <= 10; $i++) {
            Product::create([

                'name' => 'product ' . $i,
                'description' => 'this is productnumber ' . $i,
                'price' => rand(10, 100),
                'quantity' => rand(1, 50),
                'category_id' => rand(1, 6),




            ]);
        }
    }
}
