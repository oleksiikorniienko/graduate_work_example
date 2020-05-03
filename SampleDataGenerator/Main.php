<?php

namespace SampleDataGenerator;

use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

/**
 * @example
 * name,adapted_for_city,appearance,profitability,power,cost,adapted_for_off_road,family,comfort
 * "type #1",75,100,25,16.67,66.67,33.33,50,25
 * "type #2",75,33.33,50,33.33,66.67,100,75,25
 * "type #3",50,33.33,100,33.33,50,66.67,25,50
 * "type #4",50,33.33,100,83.33,100,33.33,25,25
 * "type #5",75,33.33,75,66.67,100,100,25,75
 * "type #6",50,33.33,75,33.33,33.33,66.67,75,25
 * "type #7",25,100,25,33.33,50,100,100,25
 * "type #8",50,66.67,50,50,66.67,33.33,50,25
 * "type #9",50,66.67,100,50,83.33,66.67,100,50
 * "type #10",25,100,100,16.67,66.67,66.67,75,75
 * ...
 */
class Main
{
    public const SAMPLE_DATA_COUNT = 200;
    public const ADAPTER_FOR_CITY_COUNT_QUESTIONS = 4;
    public const APPEARANCE_COUNT_QUESTIONS = 3;
    public const PROFITABILITY_COUNT_QUESTIONS = 4;
    public const POWER_COUNT_QUESTIONS = 6;
    public const COST_COUNT_QUESTIONS = 6;
    public const ADAPTED_FOR_OFF_ROAD_COUNT_QUESTIONS = 3;
    public const FAMILY_COUNT_QUESTIONS = 4;
    public const COMFORT_COUNT_QUESTIONS = 4;

    public function main()
    {
        try {
            $writer = Writer::createFromPath('./GraduateWork/Resources/samples.csv', 'w');

            $writer->insertOne([
                "name",
                "adapted_for_city",
                "appearance",
                "profitability",
                "power",
                "cost",
                "adapted_for_off_road",
                "family",
                "comfort"
            ]);

            $sampleData = [];

            for ($i = 0; $i < self::SAMPLE_DATA_COUNT; $i++) {
                $name = 'type #' . (string) ($i + 1);

                $adaptedForCity = $this->generateRandomValue(self::ADAPTER_FOR_CITY_COUNT_QUESTIONS);
                $appearance = $this->generateRandomValue(self::APPEARANCE_COUNT_QUESTIONS);
                $profitability = $this->generateRandomValue(self::PROFITABILITY_COUNT_QUESTIONS);
                $power = $this->generateRandomValue(self::POWER_COUNT_QUESTIONS);
                $cost = $this->generateRandomValue(self::COST_COUNT_QUESTIONS);
                $adaptedForOffRoad = $this->generateRandomValue(self::ADAPTED_FOR_OFF_ROAD_COUNT_QUESTIONS);
                $family = $this->generateRandomValue(self::FAMILY_COUNT_QUESTIONS);
                $comfort = $this->generateRandomValue(self::COMFORT_COUNT_QUESTIONS);

                $sampleData[] = [
                    $name,
                    $adaptedForCity,
                    $appearance,
                    $profitability,
                    $power,
                    $cost,
                    $adaptedForOffRoad,
                    $family,
                    $comfort
                ];
            }

            $writer->insertAll($sampleData);
        } catch (CannotInsertRecord $e) {
            die($e->getMessage());
        }
    }

    private function generateRandomValue(int $countQuestions): float
    {
        return round(rand(1, $countQuestions) * (100 / $countQuestions), 2);
    }
}
