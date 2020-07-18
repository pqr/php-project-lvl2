<?php

namespace Differ\Differ;

use function Differ\Parsers\parse;

const ADDED = 'added';
const REMOVED = 'removed';
const CHANGED = 'changed';

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $content1 = readFile($pathToFile1);
    $format1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $data1 = parse($content1, $format1);

    $content2 = readFile($pathToFile2);
    $format2 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $data2 = parse($content2, $format2);

    $diff = getDiff($data1, $data2);

    return diffToString($diff);
}

function readFile(string $pathToFile): string
{
    $content = file_get_contents($pathToFile);
    if ($content === false) {
        throw new \Exception("File $pathToFile not found");
    }

    return $content;
}

function getDiff(array $data1, array $data2): array
{
    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));

    return array_map(
        static function ($key) use ($data1, $data2) {
            $diffType = null;
            if (!array_key_exists($key, $data1)) {
                $diffType = ADDED;
            } elseif (!array_key_exists($key, $data2)) {
                $diffType = REMOVED;
            } elseif ($data1[$key] !== $data2[$key]) {
                $diffType = CHANGED;
            }

            return [
                'key' => $key,
                'diffType' => $diffType,
                'value1' => $data1[$key] ?? null,
                'value2' => $data2[$key] ?? null,
            ];
        },
        $allKeys
    );
}

function diffToString(array $diff): string
{
    $diffLines = array_map(
        static function ($keyDiff) {
            $key = $keyDiff['key'];
            $diffType = $keyDiff['diffType'];
            $value1 = $keyDiff['value1'];
            $value2 = $keyDiff['value2'];
            switch ($diffType) {
                case ADDED:
                    return "  + $key: $value2";
                case REMOVED:
                    return "  - $key: $value1";
                case CHANGED:
                    return "  + $key: $value2\n  - $key: $value1";
                default:
                    return "    $key: $value1";
            }
        },
        $diff
    );

    return "{\n" . implode("\n", $diffLines) . "\n}";
}
