<?php

use Illuminate\Database\Seeder;
use App\Models\Supplierdetails;
class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(firstuser::class);
        $this->call(groupseed::class);
    }
}
