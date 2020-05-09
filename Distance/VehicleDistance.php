<?php

namespace Distance;

use Phpml\Exception\InvalidArgumentException;
use Phpml\Math\Distance;

class VehicleDistance implements Distance
{
    protected $importance;

    public function __construct(array $importance)
    {
        $this->importance = $importance;
    }

    /**
     * @param  array  $a
     * @param  array  $b
     * @return float
     * @throws InvalidArgumentException
     */
    public function distance(array $a, array $b): float
    {
        $count = count($a);

        if ($count !== count($b) || count($this->importance) !== $count) {
            throw new InvalidArgumentException('Size of given arrays does not match');
        }

        $count = count($a);
        $distance = 0;

        for ($i = 0; $i < $count; $i++) {
            $distance += abs($a[$i] - $b[$i]) * $this->importance[$i];
        }

        return $distance;
    }
}