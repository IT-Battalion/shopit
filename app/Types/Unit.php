<?php

namespace App\Types;

use App\Exceptions\InvalidUnitException;
use Illuminate\Contracts\Database\Eloquent\Castable;
use JetBrains\PhpStorm\ArrayShape;
use JsonSerializable;

class Unit implements Castable, JsonSerializable
{
    private int $value;

    protected $units = [''];

    protected $unitStep = 1;

    /**
     * @throws InvalidUnitException
     */
    public function __construct(int $value, string $unit = '')
    {
        $unitIndex = array_search($unit, $this->units);

        if (is_bool($unitIndex)) {
            throw new InvalidUnitException();
        }

        $this->value = $value * (int) (pow(10, $unitIndex * $this->unitStep));
    }

    public function getOptimalUnitStep(): int {
        return min((int) log($this->value, pow(10, $this->unitStep)), sizeof($this->units) - 1);
    }

    public function getOptimalUnit(): string {
        return $this->units[$this->getOptimalUnitStep()];
    }

    public function getOptimalValue(): float {
        return $this->value / pow(10, $this->getOptimalUnitStep() * $this->unitStep);
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @param int $value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    public function getUnits() {
        return $this->units;
    }

    public static function castUsing(array $arguments)
    {
        return new UnitCast(static::class);
    }

    #[ArrayShape(['value' => "float", 'unit' => "string"])]
    public function jsonSerialize(): array
    {
        return [
            'value' => $this->getOptimalValue(),
            'unit' => $this->getOptimalUnit(),
        ];
    }
}
