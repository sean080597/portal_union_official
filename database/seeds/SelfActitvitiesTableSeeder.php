<?php

use Illuminate\Database\Seeder;
use App\SelfActivity;
use Carbon\Carbon;

class SelfActitvitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('self_activities')->insert([
            [
                'title' => 'Rèn luyện về nhận thức về chính trị, đạo đức lối sống: (0 – 10',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Rèn luyện về chuyên môn, nghiệp vụ, tinh thần tình nguyện: (0 – 10)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Rèn luyện về sức khỏe, kỹ năng thực hành xã hội: (0 – 10)',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
