<?php

namespace SampleDataGenerator;

class VehicleType
{
    /** @var string */
    private $name;

    /** @var Int */
    private $costFrom;

    /** @var Int */
    private $costTo;

    /** @var Int */
    private $powerFrom;

    /** @var Int */
    private $powerTo;

    /** @var Int */
    private $comfortFrom;

    /** @var Int */
    private $comfortTo;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param  string  $name
     * @return VehicleType
     */
    public function setName(string $name): VehicleType
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return Int
     */
    public function getCostFrom(): int
    {
        return $this->costFrom;
    }

    /**
     * @param  Int  $costFrom
     * @return VehicleType
     */
    public function setCostFrom(int $costFrom): VehicleType
    {
        $this->costFrom = $costFrom;
        return $this;
    }

    /**
     * @return Int
     */
    public function getCostTo(): int
    {
        return $this->costTo;
    }

    /**
     * @param  Int  $costTo
     * @return VehicleType
     */
    public function setCostTo(int $costTo): VehicleType
    {
        $this->costTo = $costTo;
        return $this;
    }

    /**
     * @return Int
     */
    public function getPowerFrom(): int
    {
        return $this->powerFrom;
    }

    /**
     * @param  Int  $powerFrom
     * @return VehicleType
     */
    public function setPowerFrom(int $powerFrom): VehicleType
    {
        $this->powerFrom = $powerFrom;
        return $this;
    }

    /**
     * @return Int
     */
    public function getPowerTo(): int
    {
        return $this->powerTo;
    }

    /**
     * @param  Int  $powerTo
     * @return VehicleType
     */
    public function setPowerTo(int $powerTo): VehicleType
    {
        $this->powerTo = $powerTo;
        return $this;
    }

    /**
     * @return Int
     */
    public function getComfortFrom(): int
    {
        return $this->comfortFrom;
    }

    /**
     * @param  Int  $comfortFrom
     * @return VehicleType
     */
    public function setComfortFrom(int $comfortFrom): VehicleType
    {
        $this->comfortFrom = $comfortFrom;
        return $this;
    }

    /**
     * @return Int
     */
    public function getComfortTo(): int
    {
        return $this->comfortTo;
    }

    /**
     * @param  Int  $comfortTo
     * @return VehicleType
     */
    public function setComfortTo(int $comfortTo): VehicleType
    {
        $this->comfortTo = $comfortTo;
        return $this;
    }

    public function generateSamples(): array
    {
        $rangeParams = [
            [$this->costFrom, $this->costTo],
            [$this->powerFrom, $this->powerTo],
            [$this->comfortFrom, $this->comfortTo],
        ];

        return $this->generate($rangeParams);
    }

    private function generate($rangeParams, $rangeParamIndex = 0, $data = [[]])
    {
        if ($rangeParamIndex == count($rangeParams)) {
            return $data;
        }

        $newData = [];
        list($from, $to) = $rangeParams[$rangeParamIndex];
        $step = ($to - $from) * 0.1;

        foreach ($data as $dataItem) {
            for($current = $from; $current <= $to; $current+=$step) {
                $newData[] = array_merge($dataItem, [$current]);
            }
        }

        return $this->generate($rangeParams, $rangeParamIndex + 1, $newData);
    }
}