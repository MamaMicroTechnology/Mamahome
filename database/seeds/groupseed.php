<?php

use Illuminate\Database\Seeder;
use App\Group;

class groupseed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('groups')->delete();
        $groups = ['Admin','Team Lead','Manager','Asst. Manager','Employee'];
        foreach($groups as $group){
        	$data[] = [
        		'group_name' =>	$group
        	];
        }
        DB::table('groups')->insert($data);
    }
}
