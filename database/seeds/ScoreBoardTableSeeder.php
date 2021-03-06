<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ScoreBoardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('score_boards')->insert([
            [
                'year' => '2019',
                'averageScore' => '0',
                'confirmingStudent' => '0',
                'confirmingClass' => '0',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511060009',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

            [
                'year' => '2019',
                'averageScore' => '0',
                'confirmingStudent' => '0',
                'confirmingClass' => '0',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511060010',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

            [
                'year' => '2019',
                'averageScore' => '0',
                'confirmingStudent' => '0',
                'confirmingClass' => '0',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511060012',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],

            [
                'year' => '2019',
                'averageScore' => '0',
                'confirmingStudent' => '0',
                'confirmingClass' => '0',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511060019',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'year' => '2019',
                'averageScore' => '75',
                'confirmingStudent' => '1',
                'confirmingClass' => '1',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511060022',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'year' => '2019',
                'averageScore' => '95',
                'confirmingStudent' => '1',
                'confirmingClass' => '1',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511061004',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],[
                'year' => '2018',
                'averageScore' => '88',
                'confirmingStudent' => '1',
                'confirmingClass' => '1',
                'confirmingFaculty' => '1',
                'confirmingSchool' => '1',
                'student_id' => '1511061004',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'year' => '2018',
                'averageScore' => '85',
                'confirmingStudent' => '1',
                'confirmingClass' => '1',
                'confirmingFaculty' => '1',
                'confirmingSchool' => '1',
                'student_id' => '1511061278',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ],
            [
                'year' => '2019',
                'averageScore' => '1',
                'confirmingStudent' => '1',
                'confirmingClass' => '0',
                'confirmingFaculty' => '0',
                'confirmingSchool' => '0',
                'student_id' => '1511060032',
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]

        ]);
    }
}
