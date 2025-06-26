<?php

namespace App\Console\Commands;

use App\Models\Factories\PostalCodeFactory;
use App\Models\PostalCode;
use Illuminate\Console\Command;

class LoadLatLong extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'latlong:load';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test Email';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arrAll = (new PostalCodeFactory())->getAll();
        /**
         * @var $objPostCode PostalCode
         */
        foreach ($arrAll as $key => $objPostCode) {
            $arrAddressData = $this->getAddressData($objPostCode->postal_code,$objPostCode->town);

            if ($arrAddressData === false) {
                $this->error("data not found (1) :" . $objPostCode->postal_code);
                continue;
            }

            if (!isset($arrAddressData["results"][0]["geometry"]["location"])) {
                $this->error("data not found (2):" . $objPostCode->postal_code);
                continue;
            }

            $this->info(
                $objPostCode->postal_code . " => " . $arrAddressData["results"][0]["geometry"]["location"]["lat"] . " , " . $arrAddressData["results"][0]["geometry"]["location"]["lng"]
            );

            $objPostCode->setLat($arrAddressData["results"][0]["geometry"]["location"]["lat"]);
            $objPostCode->setLong($arrAddressData["results"][0]["geometry"]["location"]["lng"]);
            if (!$objPostCode->save()) {
                $this->error("Could not save data.");
            }

            usleep(200000);
        }
    }

    private function getAddressData($zip, $city)
    {
        $curl = curl_init();
        $url =  'https://maps.googleapis.com/maps/api/geocode/json?address=' . trim($city) . ',' . trim($zip) . ',HUNGARY&key=AIzaSyBXXQRtSWcU6-3KT44GSXRGW0nMNUM0VCs';
        $this->info($url);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $arrResponse = json_decode($response, true);
        if (!is_array($arrResponse)) {
            return false;
        }
        return $arrResponse;
    }
}
