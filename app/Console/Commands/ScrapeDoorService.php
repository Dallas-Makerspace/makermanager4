<?php

namespace App\Console\Commands;

use App\LogUserVisit;
use Illuminate\Console\Command;

class ScrapeDoorService extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'scrape:door-service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrapes the chinese door service for it\'s badge access log.';

    protected $client;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(\Goutte\Client $client)
    {
        parent::__construct();

        $this->client = $client;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = $this->client;

        $crawler = $client->request('GET', config('services.doorcontrol.scrape_url'));

//        $crawler = $client->click($crawler->selectLink('Sign in')->link());
        $form = $crawler->selectButton('Login')->form();
        $crawler = $client->submit($form, array(
            'username' => config('services.doorcontrol.scrape_username'),
            'pwd' => config('services.doorcontrol.scrape_password')
        ));

        $form = $crawler->selectButton('Swipe')->form();
        $crawler = $client->submit($form);

        $pages = 10176;

        $records = [];
        for($i = 0; $i < $pages; $i++) {
            $table = $crawler->filter('table')->filter('tr')->each(function ($tr, $i) {
                return $tr->filter('td')->each(function ($td, $i) {
                    return trim($td->text());
                });
            });

            echo($table[2][0]).PHP_EOL;

            foreach($table as $item) {
                if(count($item) < 5) {
                    continue;
                }

                $records[] = [
                    'Record ID' => $item[0],
                    'Card NO' => $item[1],
                    'Name' => $item[2],
                    'Status' => $item[3],
                    'DateTime' => $item[4]
                ];

                preg_match("/(Allow|Forbid) (IN|OUT)\[\#(\d+)(DOOR)\]/", $item[3], $matches);
                if(count($matches) < 5) {
                    $this->error('Unexpected input: ' . $item[3]);
                    continue;
                }

                $r = LogUserVisit::firstOrCreate([
                    'source' => 'china',
                    'source_id' => $item[0],
                    'card_number' => $item[1],
                    'source_name' => $item[2],
                    'status' => $matches[1],
                    'door' => (int)$matches[3],
                    'created_at' => date('Y-m-d H:i:s', strtotime($item[4]))
                ]);
                if($r->wasRecentlyCreated) {
                    $this->info("Created record: " . json_encode($r));
                }
            }


            // Get form data and set PN=Next


            //$form = $crawler->filter('[name=swipeRec]')->form();
            $form = $crawler->selectButton('Next')->form();;
            $data = $form->getValues();
            //$data['PN'] = 'Next';

            $this->info("Page info: " . json_encode($data));

            $crawler = $client->request('POST', config('services.doorcontrol.scrape_url'), $data);
            //dd($crawler);

            //$this->info("Turning to page " . $i);
        }


    }

    private function convertTag($tagg)
    {
        $tagg_bin = decbin($tagg);
        $tagg_hex = dechex($tagg);
        if (strlen($tagg_bin) != 32) { // Pad to 32 bits
            $tagg_bin_corr = str_pad($tagg_bin, 32, "0", STR_PAD_LEFT);
        }
// Prepare RCO code string
        $arr_rco = str_split("" . $tagg_hex, 3);
// Prepare ASSA code string
        $arr_assa3 = str_split($tagg_bin_corr, 4); // e.g. [1100][0010]...
        for ($x = 0; $x <= 7; $x++) {
            $arr_assa3[$x] = strrev($arr_assa3[$x]); // e.g. [0011][0100]...
        }
        $arr_assa2 = array(1, 0, 3, 2, 5, 4, 7, 6); // e.g. [0100][0011]...
        foreach ($arr_assa2 as $index) {
            $arr_assa[$index] = $arr_assa3[$index];
        }
        return [
            'ASSA' => bindec(implode("", $arr_assa)),
            'BEWATOR' => "0010" . $tagg,
            'RCO' => hexdec($arr_rco[0]) . hexdec($arr_rco[1]),
            'AXEMA' => "0" . hexdec(substr($tagg_hex, 1)),
            'HEX' => $tagg_hex,
            'BIN' => $tagg_bin_corr,
            'DEC' => $tagg
        ];
    }

    private function convertToBadgeNumber($inp) {
        $inp = '11033091';
        // My badge 11033091

        // binary 24 bits long
        // take first octet turn that into decimal
        // take next 16 into decimal
        // remove 0's from both
        // concat

        // to binary
        $value = unpack('H*', $inp);
        $bin = base_convert($value[1], 16, 2);

        $first = bindec(substr($bin, 0, 8));
        $second = bindec(substr($bin, 8, 8 + 16));

        // take first 8 bits

        return str_replace('0', '', $first . $second);
    }
}
