<?php

use App\Account;
use App\Aspect;
use App\Board;
use App\Feed;
use App\User;
use Illuminate\Database\Seeder;

class TestingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds for a Demo Fixture.
     *
     * @return void
     */
    public function run()
    {
        $user = User::updateOrcreate([
            'email'    => 'alariva@gmail.com',
            ],[
            'name'     => 'alariva',
            'password' => bcrypt('123123'),
            ]);

        $account = Account::updateOrcreate([
            'name' => 'free',
            ]);

        $user->accounts()->save($account);

        $board = Board::updateOrcreate([
            'name' => 'hosting',
            ]);

        $account->boards()->save($board);

        $aspect = Aspect::whereName('uptime')->first();

        $feed1 = Feed::updateOrcreate([
            'aspect_id' => $aspect->id,
            'apikey'    => 'm776542984-32a9dfab847470f69aedbb40',
            ], ['name' => 'dkvm']);

        $feed2 = Feed::updateOrcreate([
            'aspect_id' => $aspect->id,
            'apikey'    => 'm776554617-249651edae01a82102037a1c',
            ], ['name' => 'wcv']);

        $board->feeds()->save($feed1);
        $board->feeds()->save($feed2);

        $board = Board::updateOrcreate([
            'name' => 'hosting2',
            ]);

        $account->boards()->save($board);

        $feed3 = Feed::updateOrcreate([
            'aspect_id' => $aspect->id,
            'apikey'    => 'm776515791-2d829b56776e1bc3b53cda06',
            ], ['name' => 'conievallese']);

        $board->feeds()->save($feed3);
    }
}
