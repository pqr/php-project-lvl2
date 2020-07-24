<?php

namespace Differ\Differ;

use function Differ\Formatters\getFormatter;
use function Differ\Parsers\parse;

const ADDED = 'added';
const REMOVED = 'removed';
const CHANGED = 'changed';
const NOTCHANGED = 'notchanged';
const NESTED = 'nested';

function genDiff(string $pathToFile1, string $pathToFile2, string $format = 'pretty'): string
{
    $content1 = readFile($pathToFile1);
    $format1 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $data1 = parse($content1, $format1);

    $content2 = readFile($pathToFile2);
    $format2 = pathinfo($pathToFile1, PATHINFO_EXTENSION);
    $data2 = parse($content2, $format2);

    $diffTree = getDiffTree($data1, $data2);

    $render = getFormatter($format);
    return $render($diffTree);
}

function readFile(string $pathToFile): string
{
    if (!file_exists($pathToFile)) {
        throw new \Exception("File $pathToFile not found");
    }

    $content = file_get_contents($pathToFile);
    if ($content === false) {
        throw new \Exception("Can't read file $pathToFile");
    }

    return $content;
}

function getDiffTree(array $data1, array $data2): array
{
    $allKeys = array_unique(array_merge(array_keys($data1), array_keys($data2)));

    return array_map(
        static function ($key) use ($data1, $data2) {
            $diffType = null;
            $children = null;
            if (!array_key_exists($key, $data1)) {
                $diffType = ADDED;
                $value1 = null;
                $value2 = $data2[$key];
            } elseif (!array_key_exists($key, $data2)) {
                $diffType = REMOVED;
                $value1 = $data1[$key];
                $value2 = null;
            } else {
                $value1 = $data1[$key];
                $value2 = $data2[$key];
                if (is_array($value1) && is_array($value2)) {
                    $diffType = NESTED;
                    $children = getDiffTree($value1, $value2);
                } else {
                    $diffType = ($value1 === $value2) ? NOTCHANGED : CHANGED;
                }
            }

            return [
                'key' => $key,
                'diffType' => $diffType,
                'value1' => $value1,
                'value2' => $value2,
                'children' => $children,
            ];
        },
        $allKeys
    );
}
