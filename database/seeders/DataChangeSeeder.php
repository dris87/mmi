<?php

namespace Database\Seeders;

use App\Models\NotificationSetting;
use Illuminate\Database\Seeder;

/**
 * Class UpdateTypeNotificationSettingSeeder
 */
class DataChangeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $objSettingLogo = \App\Models\Setting::where('key', '=', 'logo')->first();
        $objSettingLogo->value = "assets/img/main-logo.png";
        $objSettingLogo->save();

        $objSettingLogo = \App\Models\Setting::where('key', '=', 'footer_logo')->first();
        $objSettingLogo->value = "assets/img/main-logo.png";
        $objSettingLogo->save();

        $objCountry = new \App\Models\Country();
        $objCountry->id = 1;
        $objCountry->name ="Magyarország";
        $objCountry->short_code ="HU";
        $objCountry->phone_code ="+36";
        $objCountry->save();

        $objState = new \App\Models\State();
        $objState->id = 1;
        $objState->name ="default_state";
        $objState->country_id = \App\Models\Country::HUNGARY;
        $objState->save();

        $CityFactory = new \App\Models\Factories\CityFactory();
        $arrPostalCodes = \App\Models\PostalCode::get();

        /**
         * @var $objPostalCode \App\Models\PostalCode
         */
        foreach ($arrPostalCodes as $key => $objPostalCode){

            $objCity = $CityFactory->createIfNotExist($objPostalCode->getTown());
            $objPostalCode->setCityId($objCity->id);
            $objPostalCode->save();
        }


        $SettingsFactory = new \App\Models\Factories\SettingsFactory();

        $objSetting = $SettingsFactory->getByKey("application_name");
        $objSetting->value = "Mumi.hu";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("company_description");
        $objSetting->value = "Mumi.hu - Munkalehetőség Mindenkinek Kft.";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("address");
        $objSetting->value = "2800 Tatabánya, Fő tér 20";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("phone");
        $objSetting->value = "+36 30 345 7061";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("email");
        $objSetting->value = "ugyfelszolgalat@imumi.hu";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("facebook_url");
        $objSetting->value = "https://www.facebook.com/mumi/";
        $objSetting->save();


        $objSetting = $SettingsFactory->getByKey("twitter_url");
        $objSetting->value = "https://twitter.com/mumi?lang=en";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("google_plus_url");
        $objSetting->value = "https://mumi.hu/";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("linkedIn_url");
        $objSetting->value = "";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("about_us");
        $objSetting->value = "A www.mumi.hu, egy olyan egyedi és speciális állásportál, amely országosan fogja össze az állást keresőket és váltani kívánókat. A Munkalehetőség Mindenkinek Kft. működése és filozófiája teljes mértékben eltér a munkaerőpiac jelenleg ismert szereplőitől.";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("company_url");
        $objSetting->value = "www.mumi.hu";
        $objSetting->save();

        $objSetting = $SettingsFactory->getByKey("region_code");
        $objSetting->value = "";
        $objSetting->save();

        $CmsServicesFactory = new \App\Models\Factories\CmsServicesFactory();

        $objService = $CmsServicesFactory->getByKey("home_title");
        $objService->value = "Regisztrálj és böngéssz több ezer állás közt";
        $objService->save();

        $objService = $CmsServicesFactory->getByKey("home_description");
        $objService->value = "Találd meg a számodra legmegfelelőbb munkát";
        $objService->save();

        $objService = $CmsServicesFactory->getByKey("about_title_one");
        $objService->value = "Regisztrálás";
        $objService->save();
    }
}
