<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
// use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Schema::disableForeignKeyConstraints();
    	DB::table('user_action_logs')->truncate();
    	DB::table('users')->truncate();
    	Schema::enableForeignKeyConstraints();

    	$users = [
    		[
        		'email' => 'user1@test.com',
        	],
        	[
        		'email' => 'user2@test.com',
        	],
        	[
        		'email' => 'user3@test.com',
        	],
        	[
        		'email' => 'user4@test.com',
        	],
        	[
        		'email' => 'user5@test.com',
        	],
        	[
        		'email' => 'user6@test.com',
        	],
        	[
        		'email' => 'user7@test.com',
        	],
        	[
        		'email' => 'user8@test.com',
        	],
        	[
        		'email' => 'user9@test.com',
        	],
        	[
        		'email' => 'user10@test.com',
        	],
    	];

    	foreach($users as $user) {
    		$user = factory(User::class)->create(['email' => $user['email']]);
    	} 
        
    }
}
