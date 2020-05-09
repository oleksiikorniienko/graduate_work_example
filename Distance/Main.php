<?php

namespace Distance;

use Phpml\Preprocessing\Normalizer;
use SampleDataGenerator\VehicleType;

class Main
{
    public function main()
    {
        $vehicleType1 = (new VehicleType())
            ->setCostFrom(1)
            ->setCostTo(3)
            ->setPowerFrom(1)
            ->setPowerTo(3)
            ->setComfortFrom(1)
            ->setComfortTo(3);

        $vehicleType2 = (new VehicleType())
            ->setCostFrom(3)
            ->setCostTo(6)
            ->setPowerFrom(1)
            ->setPowerTo(3)
            ->setComfortFrom(4)
            ->setComfortTo(6);

        $vehicleType3 = (new VehicleType())
            ->setCostFrom(3)
            ->setCostTo(6)
            ->setPowerFrom(3)
            ->setPowerTo(6)
            ->setComfortFrom(1)
            ->setComfortTo(3);

        $vehicleType4 = (new VehicleType())
            ->setCostFrom(7)
            ->setCostTo(10)
            ->setPowerFrom(7)
            ->setPowerTo(10)
            ->setComfortFrom(4)
            ->setComfortTo(6);

        $vehicleType5 = (new VehicleType())
            ->setCostFrom(7)
            ->setCostTo(10)
            ->setPowerFrom(4)
            ->setPowerTo(6)
            ->setComfortFrom(7)
            ->setComfortTo(10);

        $vehicleTypes = [
            'не догая, не мощьная, не комфортная' => $vehicleType1,
            'средняя цена, не мощьная, комфортная' => $vehicleType2,
            'средняя цена, мощьная, не комфортная' => $vehicleType3,
            'дорогая, очень мощьная, комфортная' => $vehicleType4,
            'дорогая, мощьная, очень комфортная' => $vehicleType5,
        ];

        $names = [];
        $samples = [];
        /**
         * @var int $key
         * @var VehicleType $value
         */
        foreach ($vehicleTypes as $key => $value) {
            $samplesGenerated = $value->generateSamples();
            $names = array_merge($names, array_fill(0, count($samplesGenerated), $key));
            $samples = array_merge($samples, $samplesGenerated);
        }

        // normal 1
        // high 1.4
        // low 0.6
        $importance = [1, .6, 1.4];
        $userInput = [[4, 4, 4]];

        $normalizer = new Normalizer(Normalizer::NORM_STD);
        $normalizer->transform($samples);
        $normalizer->transform($userInput);


        $k = new KNearestNeighborsSuspended(7, new VehicleDistance($importance));
        $k->train($samples, $names);
        $result = $k->predict($userInput[0]);
        var_dump($result);
    }
}