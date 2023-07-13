<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class RolesSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['id' => 1, 'name' => 'Админ', 'alias' => 'admin', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Школа', 'alias' => 'school', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Ученик', 'alias' => 'student', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ];

        foreach ($data as $item) {
            DB::table('roles')->updateOrInsert(
                ['id' => $item['id']],
                [
                    'name' => $item['name'],
                    'alias' => $item['alias'],
                    'created_at' => $item['created_at'],
                    'updated_at' => $item['updated_at'],
                ]
            );
        }
    }
}
