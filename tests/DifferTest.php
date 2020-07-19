<?php

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiffJson()
    {
        $file1 = __DIR__ . '/fixtures/1.json';
        $file2 = __DIR__ . '/fixtures/2.json';

        $diff = genDiff($file1, $file2);

        $expectedDiff = trim(file_get_contents(__DIR__ .'/fixtures/result.txt'));

        $this->assertEquals($expectedDiff, $diff);
    }
    public function testGenDiffYaml()
    {
        $file1 = __DIR__ . '/fixtures/1.yml';
        $file2 = __DIR__ . '/fixtures/2.yml';

        $diff = genDiff($file1, $file2);

        $expectedDiff = trim(file_get_contents(__DIR__ .'/fixtures/result.txt'));

        $this->assertEquals($expectedDiff, $diff);
    }
}
