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
                'title' => 'Activity 1',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Activity 2',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Activity 3',
                'description' => 'This is description',
                'total_score' => 10,
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]
        ]);
    }
}
