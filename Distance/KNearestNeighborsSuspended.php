<?php

declare(strict_types=1);

namespace Distance;

use Phpml\Classification\Classifier;
use Phpml\Exception\InvalidArgumentException;
use Phpml\Helper\Predictable;
use Phpml\Helper\Trainable;
use Phpml\Math\Distance;
use Phpml\Math\Distance\Euclidean;

class KNearestNeighborsSuspended implements Classifier
{
    use Trainable;
    use Predictable;

    /**
     * @var int
     */
    private $k;

    /**
     * @var Distance
     */
    private $distanceMetric;

    /**
     * @param  int  $k
     * @param  Distance|null  $distanceMetric  (if null then Euclidean distance as default)
     */
    public function __construct(int $k = 3, ?Distance $distanceMetric = null)
    {
        if ($distanceMetric === null) {
            $distanceMetric = new Euclidean();
        }

        $this->k = $k;
        $this->samples = [];
        $this->targets = [];
        $this->distanceMetric = $distanceMetric;
    }

    /**
     * @return mixed
     * @throws InvalidArgumentException
     */
    protected function predictSample(array $sample)
    {
        $distances = $this->kNeighborsDistances($sample);
        $predictions = (array) array_combine(array_values($this->targets), array_fill(0, count($this->targets), []));

        foreach ($distances as $index => $distance) {
            $predictions[$this->targets[$index]][] = $distance;
        }

        $predictions = array_map(function ($distances) {
            return array_reduce($distances, function ($acc, $distance) {
                return $acc + (1 / $distance);
            }, 0);
        }, $predictions);

        arsort($predictions);
        reset($predictions);
        var_dump($predictions); // todo: remove
        return key($predictions);
    }

    /**
     * @param  array  $sample
     * @return array
     * @throws InvalidArgumentException
     */
    private function kNeighborsDistances(array $sample): array
    {
        $distances = [];

        foreach ($this->samples as $index => $neighbor) {
            $distances[$index] = $this->distanceMetric->distance($sample, $neighbor);
        }

        asort($distances);
        var_dump(array_slice($distances, 0, $this->k, true)); // todo: remove
        return array_slice($distances, 0, $this->k, true);
    }
}
