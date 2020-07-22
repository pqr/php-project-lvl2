<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    public function testGenDiffJsonToPretty()
    {
        $file1 = __DIR__ . '/fixtures/1.json';
        $file2 = __DIR__ . '/fixtures/2.json';

        $diff = genDiff($file1, $file2, 'pretty');

        $expectedDiff = trim(file_get_contents(__DIR__ . '/fixtures/result_pretty.txt'));

        $this->assertEquals($expectedDiff, $diff);
    }

    public function testGenDiffJsonToPlain()
    {
        $file1 = __DIR__ . '/fixtures/1.json';
        $file2 = __DIR__ . '/fixtures/2.json';

        $diff = genDiff($file1, $file2, 'plain');

        $expectedDiff = trim(file_get_contents(__DIR__ . '/fixtures/result_plain.txt'));

        $this->assertEquals($expectedDiff, $diff);
    }

    public function testGenDiffJsonToJson()
    {
        $file1 = __DIR__ . '/fixtures/1.json';
        $file2 = __DIR__ . '/fixtures/2.json';

        $diff = genDiff($file1, $file2, 'json');

        $expectedDiff = trim(file_get_contents(__DIR__ . '/fixtures/result.json'));

        $this->assertEquals($expectedDiff, $diff);
    }

    public function testGenDiffYamlToPretty()
    {
        $file1 = __DIR__ . '/fixtures/1.yml';
        $file2 = __DIR__ . '/fixtures/2.yml';

        $diff = genDiff($file1, $file2);

        $expectedDiff = trim(file_get_contents(__DIR__ . '/fixtures/result_pretty.txt'));

        $this->assertEquals($expectedDiff, $diff);
    }

    public function testGenDiffYamlToPlain()
    {
        $file1 = __DIR__ . '/fixtures/1.yml';
        $file2 = __DIR__ . '/fixtures/2.yml';

        $diff = genDiff($file1, $file2, 'plain');

        $expectedDiff = trim(file_get_contents(__DIR__ . '/fixtures/result_plain.txt'));

        $this->assertEquals($expectedDiff, $diff);
    }

    public function testGenDiffYamlToJson()
    {
        $file1 = __DIR__ . '/fixtures/1.yml';
        $file2 = __DIR__ . '/fixtures/2.yml';

        $diff = genDiff($file1, $file2, 'json');

        $expectedDiff = trim(file_get_contents(__DIR__ . '/fixtures/result.json'));

        $this->assertEquals($expectedDiff, $diff);
    }
}
