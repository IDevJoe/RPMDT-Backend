<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $u = \App\User::create(['name' => 'Test', 'email' => 'test@example.com', 'password' => \Illuminate\Support\Facades\Hash::make('test')]);
        \App\Callsign::create(['user_id' => $u->id, 'callsign' => '1A-1', 'type' => \App\Callsign::TYPE_POLICE]);
        \App\Callsign::create(['user_id' => $u->id, 'callsign' => '1A-2', 'type' => \App\Callsign::TYPE_POLICE]);
        \App\Callsign::create(['user_id' => $u->id, 'callsign' => '1A-3', 'type' => \App\Callsign::TYPE_POLICE]);
        $u2 = \App\User::create(['name' => 'Test', 'email' => 'tes2t@example.com', 'password' => \Illuminate\Support\Facades\Hash::make('test')]);
        \App\Callsign::create(['user_id' => $u2->id, 'callsign' => '2A-1', 'type' => \App\Callsign::TYPE_POLICE]);
        \App\Callsign::create(['user_id' => $u2->id, 'callsign' => '2A-2', 'type' => \App\Callsign::TYPE_POLICE]);
        \App\Callsign::create(['user_id' => $u2->id, 'callsign' => '2A-3', 'type' => \App\Callsign::TYPE_POLICE]);
    }
}
