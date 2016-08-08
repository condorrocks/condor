<?php

use App\Aspect;
use Symfony\Component\Console\Tester\CommandTester;

class WhoisCommandTest extends FeedCommandTest
{
    use CreateUser, CreateAccount, CreateBoard, CreateFeed;

    /** @test */
    public function it_runs_whois_feeds()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'aspect'  => 'whois',
        ]);

        $this->assertRegExp('/Feeding aspect whois/', $this->commandTester->getDisplay());
    }

    /** @test */
    public function it_runs_feeds_with_specific_boards()
    {
        $this->commandTester->execute([
            'command' => $this->command->getName(),
            'aspect'  => 'whois',
            'boards'  => '1,2,4,7',
        ]);

        $this->assertRegExp('/Feeding aspect whois/', $this->commandTester->getDisplay());
    }

    protected function scenario()
    {
        $user = $this->createUser();

        $account = $this->createAccount();

        $user->accounts()->save($account);

        $board = $this->createBoard();

        $account->boards()->save($board);

        $aspect = Aspect::whereName('whois')->first();

        $feed = $this->createFeed([
            'aspect_id' => $aspect->id,
            'name'      => 'Condor Whois',
            'apikey'    => '', // Dummy API Key
            'params'    => json_encode(['domain' => 'condor.rocks']),
            ]);

        $board->feeds()->save($feed);
    }

    protected function mockAPI()
    {
        $this->app->bind('Whois', function () {
            $mock = Mockery::mock(Whois::class)->makePartial();

            $mock->shouldReceive('Lookup')->with('condor.rocks', false)->once()->andReturn($this->sampleData());

            return $mock;
        });
    }

    protected function sampleData()
    {
        return  [
          'regrinfo' => [
            'domain' => [
              'name'    => 'example.org',
              'handle'  => 'D189423523-LROR',
              'created' => '2016-07-22',
              'sponsor' => 'GoDaddy.com, LLC',
              'status'  => [
                0 => 'clientDeleteProhibited https://icann.org/epp#clientDeleteProhibited',
                1 => 'clientRenewProhibited https://icann.org/epp#clientRenewProhibited',
                2 => 'clientTransferProhibited https://icann.org/epp#clientTransferProhibited',
                3 => 'clientUpdateProhibited https://icann.org/epp#clientUpdateProhibited',
                4 => 'serverTransferProhibited https://icann.org/epp#serverTransferProhibited',
              ],
              'nserver' => [
                'ns1.afraid.org' => '50.23.197.95',
                'ns2.afraid.org' => '208.43.71.243',
                'ns3.afraid.org' => '69.197.18.162',
                'ns4.afraid.org' => '70.39.97.253',
              ],
            ],
            'owner' => [
              'handle'  => 'CR123456789',
              'name'    => 'Ariel Vallese',
              'address' => [
                'street' => [
                  0 => 'Street 123',
                  1 => '1Floor',
                ],
                'city'    => 'Buenos Aires',
                'state'   => 'N/A',
                'pcode'   => '1603',
                'country' => 'AR',
              ],
              'phone' => '+54.1198765432',
              'email' => 'alariva@timegrid.io',
            ],
            'admin' => [
              'handle'  => 'CR247942118',
              'name'    => 'Ariel Vallese',
              'address' => [
                'street' => [
                  0 => 'Street 123',
                  1 => '1Floor',
                ],
                'city'    => 'Buenos Aires',
                'state'   => 'N/A',
                'pcode'   => '0123',
                'country' => 'AR',
              ],
              'phone' => '+54.1198765432',
              'email' => 'alariva@timegrid.io',
            ],
            'tech' => [
              'handle'  => 'CR247942117',
              'name'    => 'Ariel Vallese',
              'address' => [
                'street' => [
                  0 => 'Street 123',
                  1 => '1Floor',
                ],
                'city'    => 'Buenos Aires',
                'state'   => 'N/A',
                'pcode'   => '1603',
                'country' => 'AR',
              ],
              'phone' => '+54.1198765432',
              'email' => 'alariva@timegrid.io',
            ],
            'registered' => 'yes',
          ],
          'regyinfo' => [
            'referrer'  => 'http://www.pir.org/',
            'registrar' => 'Public Interest Registry',
            'servers'   => [
              0 => [
                'server' => 'whois.pir.org',
                'args'   => 'example.org',
                'port'   => 43,
              ],
            ],
            'type' => 'domain',
          ],
          'rawdata' => [
            0  => "Domain Name: EXAMPLE.ORG\r",
            1  => "Domain ID: D123456789-LROR\r",
            2  => "WHOIS Server:\r",
            3  => "Referral URL: http://www.godaddy.com\r",
            4  => "Updated Date: 2016-07-22T14:39:41Z\r",
            5  => "Creation Date: 2016-07-22T14:38:00Z\r",
            6  => "Registry Expiry Date: 2017-07-22T14:38:00Z\r",
            7  => "Sponsoring Registrar: GoDaddy.com, LLC\r",
            8  => "Sponsoring Registrar IANA ID: 146\r",
            9  => "Domain Status: clientDeleteProhibited https://icann.org/epp#clientDeleteProhibited\r",
            10 => "Domain Status: clientRenewProhibited https://icann.org/epp#clientRenewProhibited\r",
            11 => "Domain Status: clientTransferProhibited https://icann.org/epp#clientTransferProhibited\r",
            12 => "Domain Status: clientUpdateProhibited https://icann.org/epp#clientUpdateProhibited\r",
            13 => "Domain Status: serverTransferProhibited https://icann.org/epp#serverTransferProhibited\r",
            14 => "Registrant ID: CR247942116\r",
            15 => "Registrant Name: Ariel Vallese\r",
            16 => "Registrant Organization:\r",
            17 => "Registrant Street: Street 123\r",
            18 => "Registrant Street: 1Floor\r",
            19 => "Registrant City: Buenos Aires\r",
            20 => "Registrant State/Province: N/A\r",
            21 => "Registrant Postal Code: 1603\r",
            22 => "Registrant Country: AR\r",
            23 => "Registrant Phone: +54.1198765432\r",
            24 => "Registrant Phone Ext:\r",
            25 => "Registrant Fax:\r",
            26 => "Registrant Fax Ext:\r",
            27 => "Registrant Email: alariva@timegrid.io\r",
            28 => "Admin ID: CR247942118\r",
            29 => "Admin Name: Ariel Vallese\r",
            30 => "Admin Organization:\r",
            31 => "Admin Street: Street 123\r",
            32 => "Admin Street: 1Floor\r",
            33 => "Admin City: Buenos Aires\r",
            34 => "Admin State/Province: N/A\r",
            35 => "Admin Postal Code: 1603\r",
            36 => "Admin Country: AR\r",
            37 => "Admin Phone: +54.1198765432\r",
            38 => "Admin Phone Ext:\r",
            39 => "Admin Fax:\r",
            40 => "Admin Fax Ext:\r",
            41 => "Admin Email: alariva@timegrid.io\r",
            42 => "Tech ID: CR247942117\r",
            43 => "Tech Name: Ariel Vallese\r",
            44 => "Tech Organization:\r",
            45 => "Tech Street: Street 123\r",
            46 => "Tech Street: 1Floor\r",
            47 => "Tech City: Buenos Aires\r",
            48 => "Tech State/Province: N/A\r",
            49 => "Tech Postal Code: 1603\r",
            50 => "Tech Country: AR\r",
            51 => "Tech Phone: +54.1198765432\r",
            52 => "Tech Phone Ext:\r",
            53 => "Tech Fax:\r",
            54 => "Tech Fax Ext:\r",
            55 => "Tech Email: alariva@timegrid.io\r",
            56 => "Name Server: NS1.AFRAID.ORG\r",
            57 => "Name Server: NS2.AFRAID.ORG\r",
            58 => "Name Server: NS3.AFRAID.ORG\r",
            59 => "Name Server: NS4.AFRAID.ORG\r",
            60 => "DNSSEC: unsigned\r",
            61 => ">>> Last update of WHOIS database: 2016-08-01T19:21:30Z <<<\r",
            62 => "\r",
            63 => "For more information on Whois status codes, please visit https://icann.org/epp\r",
            64 => "\r",
            65 => "Access to Public Interest Registry WHOIS information is provided to assist persons in determining the contents of a domain name registration record in the Public Interest Registry registry database. The data in this record is provided by Public Interest Registry for informational purposes only, and Public Interest Registry does not guarantee its accuracy. This service is intended only for query-based access. You agree that you will use this data only for lawful purposes and that, under no circumstances will you use this data to(a) allow, enable, or otherwise support the transmission by e-mail, telephone, or facsimile of mass unsolicited, commercial advertising or solicitations to entities other than the data recipient's own existing customers; or (b) enable high volume, automated, electronic processes that send queries or data to the systems of Registry Operator, a Registrar, or Afilias except as reasonably necessary to register domain names or modify existing registrations. All rights reserved. Public Interest Registry reserves the right to modify these terms at any time. By submitting this query, you agree to abide by this policy.\r",
          ],
        ];
    }
}
