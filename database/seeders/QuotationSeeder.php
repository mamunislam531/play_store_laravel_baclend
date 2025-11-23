<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuotationSeeder extends Seeder
{
    public function run()
    {
        $quotations = [
            ["category_id"=>9,"quote"=>"সময় হলো সবচেয়ে মূল্যবান জিনিস যা একজন মানুষ ব্যয় করতে পারে।","author"=>"Anonymous"],
            ["category_id"=>9,"quote"=>"হারানো সময় আর ফিরে আসে না।","author"=>"Benjamin Franklin"],
            ["category_id"=>9,"quote"=>"গুরুত্বপূর্ণ হলো সময় ব্যয় নয়, বরং বিনিয়োগ করা।","author"=>"Stephen R. Covey"],
            ["category_id"=>9,"quote"=>"ঘড়ি দেখো না; যা ঘড়ি করে তাই করো। চলতে থাকো।","author"=>"Sam Levenson"],
            ["category_id"=>9,"quote"=>"যতক্ষণ আমরা সময়কে নিয়ন্ত্রণ করতে পারি না, ততক্ষণ আমরা আর কিছু নিয়ন্ত্রণ করতে পারব না।","author"=>"Peter Drucker"]
            // এখানে তোমার আরও 20 বা 50 quotes add করতে পারো
        ];

        DB::table('quotations')->insert($quotations);
    }
}
