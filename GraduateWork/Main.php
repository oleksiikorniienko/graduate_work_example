<?php

namespace GraduateWork;

use League\Csv\Exception;
use League\Csv\Reader;
use Phpml\Classification\NaiveBayes;

class Main
{
    public function main()
    {
        try {
            $reader = Reader::createFromPath('./GraduateWork/Resources/samples.csv', 'r');
            $reader->setDelimiter(',');
            $reader->setHeaderOffset(0);
            $records = $reader->getRecords();

            $samples = [];
            $labels = [];

            foreach ($records as $record) {
                $labels[] = $record['name'];

                $samples[] = [
                    (int) $record['adapted_for_city'],
                    (int) $record['appearance'],
                    (int) $record['profitability'],
                    (int) $record['power'],
                    (int) $record['cost'],
                    (int) $record['adapted_for_off_road'],
                    (int) $record['family'],
                    (int) $record['comfort']
                ];
            }

            $classifier = new NaiveBayes();
            $classifier->train($samples, $labels);

            // важность параметров, чем больше разброс тем меньше важность
            $deviation = [
                3 => 20, // +- 20
                4 => 10, // +- 10
                5 => 10, // +- 10
            ];

            // коефициенты от 0 до 100 для каждого их свойств типа
            $userData = [100, 75, 100, 30, 20, 30, 75, 60];
            // наложение важности на пользовательские параметры
            $computedData = $this->generateDataToPredict($deviation, $userData);
            $predicted = $classifier->predict($computedData);

            $grouped = collect($predicted)->flip()->keys()->toArray();
            print(implode(',', $grouped) . PHP_EOL);
        } catch (Exception $e) {
            die($e->getMessage());
        }
    }

    private function generateDataToPredict(array $deviation, array $data): array
    {
        $result = [$data];

        foreach ($deviation as $key => $value) {
            $max = $data[$key] + $value > 100 ? 100 : $data[$key] + $value;
            $min = $data[$key] - $value < 0 ? 0 : $data[$key] - $value;

            for ($i = $min; $i <= $max; $i += round(($max - $min) * 0.2)) {
                $modifiedDataItem = $data;

                if ($data[$key] !== $i) {
                    $modifiedDataItem[$key] = $i;
                    $result[] = $modifiedDataItem;
                }
            }
        }

        return $result;
    }
}