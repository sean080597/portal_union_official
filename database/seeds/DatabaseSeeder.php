<?php

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
        $this->call(CriteriaMandatoryTableSeeder::class);
        $this->call(CriteriaSelfRegisTableSeeder::class);
        $this->call(FacultiesTableSeeder::class);
        $this->call(ClassRoomsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(UpdateFacClaTableSeeder::class);
        $this->call(SchoolsActitvitiesTableSeeder::class);
        $this->call(SelfActitvitiesTableSeeder::class);
        //$this->call(ScoreBoardTableSeeder::class);
        //$this->call(ScoreBoardSchoolsActivitiesTableSeeder::class);
        //$this->call(ScoreBoardSelfActivitiesTableSeeder::class);
        $this->call(TempSeeder::class);
    }
}
