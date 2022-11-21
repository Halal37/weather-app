<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use App\Entity\Weather;

class FahrenheitTest extends TestCase
{
    public function testFahrenheit(): void
    {
        $weather = new Weather();
        $value = $weather->Fahrenheit(13);
        $this->assertSame(55.4, $value);
    }

    /**
     * @dataProvider provideFahrenheitData
     */
    public function testFahrenheitDataProvider($temp_f, $input): void
    {
        self::assertSame($temp_f, $input);
    }

    public function provideFahrenheitData(): array
    {
        $weather = new Weather();

        return [
            [53.6, $weather->Fahrenheit(12.0)],
            [0.9, $weather->Fahrenheit(-17.3)],
            [-6.0, $weather->Fahrenheit(-21.1)],
            [572.0, $weather->Fahrenheit(300.0)],
            [26.6, $weather->Fahrenheit(-3)],
            [32.0, $weather->Fahrenheit(0)],
            [32.0, $weather->Fahrenheit(null)],
        ];
    }
}
