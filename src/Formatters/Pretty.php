<?php

namespace Differ\Formatters\Pretty;

use const Differ\Differ\ADDED;
use const Differ\Differ\CHANGED;
use const Differ\Differ\NESTED;
use const Differ\Differ\NOTCHANGED;
use const Differ\Differ\REMOVED;

const INDENT_ADDED = '+';
const INDENT_REMOVED = '-';
const INDENT_EMPTY = ' ';

function render(array $diffTree): string
{
    $diffLines = array_map(
        static function ($node) {
            $key = $node['key'];
            $diffType = $node['diffType'];
            $value1 = $node['value1'];
            $value2 = $node['value2'];
            switch ($diffType) {
                case ADDED:
                    $out = $key . ": " . stringify($value2);
                    return addIndent(INDENT_ADDED, $out);
                case REMOVED:
                    $out = $key . ": " . stringify($value1);
                    return addIndent(INDENT_REMOVED, $out);
                case CHANGED:
                    $line1 = $key . ": " . stringify($value1);
                    $line2 = $key . ": " . stringify($value2);
                    return addIndent(INDENT_ADDED, $line1)
                        . "\n"
                        . addIndent(INDENT_REMOVED, $line2);
                case NOTCHANGED:
                    $out = $key . ": " . stringify($value1);
                    return addIndent(INDENT_EMPTY, $out);
                case NESTED:
                    $out = $key . ": " . render($node['children']);
                    return addIndent(INDENT_EMPTY, $out);
                default:
                    throw new \Exception("Unknown diff type $diffType");
            }
        },
        $diffTree
    );

    return "{\n" . implode("\n", $diffLines) . "\n}";
}

function stringify($value): string
{
    if (is_array($value)) {
        return json_encode($value, JSON_PRETTY_PRINT);
    }

    return (string)$value;
}

function addIndent(string $indentType, string $text): string
{
    $lines = explode("\n", $text);
    $linesWithIndent = array_map(fn($line) => "  {$indentType} {$line}", $lines);
    return implode("\n", $linesWithIndent);
}
