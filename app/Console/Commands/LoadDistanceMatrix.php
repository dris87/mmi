<?php

namespace App\Console\Commands;

use App\Helpers\Mailer;
use App\Models\DistanceMatrix;
use App\Models\EmailTemplate;
use App\Models\Factories\PostalCodeFactory;
use App\Models\PostalCode;
use App\Repositories\UserRepository;
use Illuminate\Console\Command;

class LoadDistanceMatrix extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'distance-matrix:load';

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
        $arrAll2 = (new PostalCodeFactory())->getAll();
        /**
         * @var $objPostCode PostalCode
         */
        foreach ($arrAll as $key => $objPostCode) {

            $this->info($objPostCode->getPostalCode()."...");

            /**
             * @var $objPostCode2 PostalCode
             */
            foreach ($arrAll2 as $key2 => $objPostCode2) {

                if($objPostCode->getPostalCode()===$objPostCode2->getPostalCode()){
                    $this->info("same postcodes");
                    continue;
                }

                if(empty($objPostCode->getLat())){
                    $this->error("missing latlong");
                    continue;
                }

                if(empty($objPostCode2->getLat())){
                    $this->error("missing latlong");
                    continue;
                }

                $distance = $this->haversineGreatCircleDistance($objPostCode->getLat(),$objPostCode->getLong(),$objPostCode2->getLat(),$objPostCode2->getLong());
                //$this->info($objPostCode->getPostalCode()." > ".$objPostCode2->getPostalCode()." : ".$distance." m");

                $objDistanceMatrix = new DistanceMatrix();
                $objDistanceMatrix->setPostalCodeFrom($objPostCode->getPostalCode());
                $objDistanceMatrix->setPostalCodeTo($objPostCode2->getPostalCode());
                $objDistanceMatrix->setDistance($distance);
                $objDistanceMatrix->save();
            }
            $this->info("Done.");
        }
    }

    /**
     * Calculates the great-circle distance between two points, with
     * the Haversine formula.
     * @param float $latitudeFrom Latitude of start point in [deg decimal]
     * @param float $longitudeFrom Longitude of start point in [deg decimal]
     * @param float $latitudeTo Latitude of target point in [deg decimal]
     * @param float $longitudeTo Longitude of target point in [deg decimal]
     * @param float $earthRadius Mean earth radius in [m]
     * @return float Distance between points in [m] (same as earthRadius)
     */
    private function haversineGreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
    {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
                               cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        return round($angle * $earthRadius);
    }
}
