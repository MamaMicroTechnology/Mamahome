<?php

use Illuminate\Database\Seeder;
use App\User;
use App\UserGroup;

class firstuser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $user = User::create([
        	'employeeId' => 'MH001',
            'department_id' => '0',
        	'name'	=>	'mhadmin',
        	'email'	=>	'mhadmin@mamahome.com',
            'group_id' => '1',
        	'password'	=>	bcrypt('mhadmin123')
        ]);
    }
}
