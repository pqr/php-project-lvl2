<?php

namespace Differ\Differ;

const ADDED = 'added';
const REMOVED = 'removed';
const CHANGED = 'changed';

function genDiff(string $pathToFile1, string $pathToFile2): string
{
    $data1 = readJsonFile($pathToFile1);
    $data2 = readJsonFile($pathToFile2);

    $diff = getDiff($data1, $data2);

    return diffToString($diff);
}

function readJsonFile(string $pathToFile): array
{
    $content = file_get_contents($pathToFile);
    if ($content === false) {
        throw new \Exception("File $pathToFile not found");
    }

    return json_decode($content, true, 512, JSON_THROW_ON_ERROR);
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
