<?php

namespace Database\Seeders;

use App\Models\Vehicle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $elektrikli_araclar = array(
            array(
                "name" => "Tesla Model 3",
                "vehicleMaxSpeed" => 250,
                "vehicleWeight" => 1611,
                "vehicleAxleWeight" => 1500,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4694,
                "vehicleWidth" => 1850,
                "vehicleHeight" => 1443,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 75,
                // "maxChargeInkWh" => 75,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 15,
                "image" => "01HY5N944CQE13YD02QJ91AFMJ.jpg"
            ),
            array(
                "name" => "Ford Mustang Mach-E",
                "vehicleMaxSpeed" => 180,
                "vehicleWeight" => 2218,
                "vehicleAxleWeight" => 2000,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4739,
                "vehicleWidth" => 1881,
                "vehicleHeight" => 1621,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 88,
                // "maxChargeInkWh" => 88,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 18,
                "image" => "01HY5MZ466PT98T446Z7MC9P7N.jpg"
            ),
            array(
                "name" => "Volkswagen ID.4",
                "vehicleMaxSpeed" => 180,
                "vehicleWeight" => 2124,
                "vehicleAxleWeight" => 1800,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4584,
                "vehicleWidth" => 1852,
                "vehicleHeight" => 1636,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 77,
                // "maxChargeInkWh" => 77,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 17,
                "image" => "01HY5N02FGNCYEZQMKSAHVJW83.jpg"
            ),
            array(
                "name" => "Nissan Ariya",
                "vehicleMaxSpeed" => 160,
                "vehicleWeight" => 1966,
                "vehicleAxleWeight" => 1700,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4595,
                "vehicleWidth" => 1850,
                "vehicleHeight" => 1660,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 87,
                // "maxChargeInkWh" => 87,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 19,
                "image" => "01HY5N119AKJDN4Z2ASFJA4TKH.jpg"
            ),
            array(
                "name" => "Hyundai Ioniq 5",
                "vehicleMaxSpeed" => 185,
                "vehicleWeight" => 2100,
                "vehicleAxleWeight" => 1800,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4635,
                "vehicleWidth" => 1890,
                "vehicleHeight" => 1605,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 77,
                // "maxChargeInkWh" => 77,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 16,
                "image" => "01HY5N1XQ10001S5WDN594RDS4.jpg"
            ),
            array(
                "name" => "Kia EV6",
                "vehicleMaxSpeed" => 250,
                "vehicleWeight" => 2090,
                "vehicleAxleWeight" => 1800,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4680,
                "vehicleWidth" => 1880,
                "vehicleHeight" => 1550,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 77.4,
                // "maxChargeInkWh" => 77.4,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 17,
                "image" => "01HY5N2P64H7KTSFH35ZMZ0CFY.jpg"
            ),
            array(
                "name" => "Chevrolet Bolt EV",
                "vehicleMaxSpeed" => 145,
                "vehicleWeight" => 1625,
                "vehicleAxleWeight" => 1500,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4166,
                "vehicleWidth" => 1765,
                "vehicleHeight" => 1595,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 66,
                // "maxChargeInkWh" => 66,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 14,
                "image" => "01HY5N3KZ9561VZPK6ZG3M2DBB.jpg"
            ),
            array(
                "name" => "BMW iX3",
                "vehicleMaxSpeed" => 180,
                "vehicleWeight" => 2185,
                "vehicleAxleWeight" => 2000,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4734,
                "vehicleWidth" => 1891,
                "vehicleHeight" => 1668,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 74,
                // "maxChargeInkWh" => 74,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 18,
                "image" => "01HY5N5FC3QV6FSVZQB5XK9PGG.jpg"
            ),
            array(
                "name" => "Audi e-tron",
                "vehicleMaxSpeed" => 200,
                "vehicleWeight" => 2565,
                "vehicleAxleWeight" => 2200,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4901,
                "vehicleWidth" => 1935,
                "vehicleHeight" => 1629,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 95,
                // "maxChargeInkWh" => 95,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 21,
                "image" => "01HY5N68766QX7FC9ADN4WTADT.webp"
            ),
            array(
                "name" => "Togg T10X",
                "vehicleMaxSpeed" => 185,
                "vehicleWeight" => 1948,
                "vehicleAxleWeight" => 2000,
                "vehicleNumberOfAxles" => 2,
                "vehicleLength" => 4599,
                "vehicleWidth" => 1886,
                "vehicleHeight" => 1676,
                "vehicleEngineType" => "electric",
                // "currentChargeInkWh" => 88.5,
                // "maxChargeInkWh" => 88.5,
                // "auxiliaryPowerInkW" => 10,
                // "constantSpeedConsumptionInkWhPerHundredkm" => 20,
                "image" => "01HY5N7C9ADFNZ3BQM8P6ZQAF8.jpg"
            )
        );


        foreach ($elektrikli_araclar as $vehicle) {
            Vehicle::create($vehicle);
        }

    }
}
