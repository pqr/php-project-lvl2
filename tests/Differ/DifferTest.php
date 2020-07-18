<?php

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiff()
    {
        $file1 = __DIR__ . '/../fixtures/1.json';
        $file2 = __DIR__ . '/../fixtures/2.json';

        $diff = genDiff($file1, $file2);

        $expectedDiff = <<<DIFF
{
    host: hexlet.io
  + timeout: 20
  - timeout: 50
  - proxy: 123.234.53.22
  + verbose: 1
}
DIFF;

        $this->assertEquals($expectedDiff, $diff);

    }
}
