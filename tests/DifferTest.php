<?php

namespace tests;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class DifferTest extends TestCase
{
    /**
     * @dataProvider fixturesProvider
     */
    public function testGenDiff($sourceFilename1, $sourceFilename2, $format, $resultFilename)
    {
        $sourceFilepath1 = $this->getFixtureFilepath($sourceFilename1);
        $sourceFilepath2 = $this->getFixtureFilepath($sourceFilename2);

        $diff = genDiff($sourceFilepath1, $sourceFilepath2, $format);

        $resultFilepath = $this->getFixtureFilepath($resultFilename);
        $expectedDiff = trim(file_get_contents($resultFilepath));

        $this->assertEquals($expectedDiff, $diff);
    }

    protected function getFixtureFilepath($filename)
    {
        return __DIR__ . "/fixtures/$filename";
    }

    public function fixturesProvider()
    {
        return [
            ['1.json', '2.json', 'pretty', 'result_pretty.txt'],
            ['1.json', '2.json', 'plain', 'result_plain.txt'],
            ['1.json', '2.json', 'json', 'result.json'],
            ['1.yml', '2.yml', 'pretty', 'result_pretty.txt'],
            ['1.yml', '2.yml', 'plain', 'result_plain.txt'],
            ['1.yml', '2.yml', 'json', 'result.json'],
        ];
    }
}
