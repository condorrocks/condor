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
        $aspects = collect([
            ['name' => 'uptime'],
            ['name' => 'sslcertificate'],
            ['name' => 'whois'],
        ]);

        $aspects->each(function($aspect){
            Aspect::updateOrCreate($aspect);
        });
    }
}
