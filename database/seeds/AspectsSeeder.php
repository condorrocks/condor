<?php

use App\Aspect;
use Illuminate\Database\Seeder;

class AspectsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Aspect::updateOrCreate(['name' => 'uptime']);
        Aspect::updateOrCreate(['name' => 'sslcertificate']);
    }
}
