<?php

namespace Differ\Formatters\Plain;

use const Differ\Differ\ADDED;
use const Differ\Differ\CHANGED;
use const Differ\Differ\NESTED;
use const Differ\Differ\NOTCHANGED;
use const Differ\Differ\REMOVED;

function render(array $diffTree, string $parentPath = ''): string
{
    $diffLines = array_map(
        static function ($node) use ($parentPath) {
            $key = $node['key'];
            $diffType = $node['diffType'];
            $value1 = $node['value1'];
            $value2 = $node['value2'];
            $propertyPath = $parentPath ? "$parentPath.$key" : $key;
            switch ($diffType) {
                case ADDED:
                    return "Property '$propertyPath' was added with value: '" . stringify($value2) . "'";
                case REMOVED:
                    return "Property '$propertyPath' was removed";
                case CHANGED:
                    $fromValue = stringify($value1);
                    $toValue = stringify($value2);
                    return "Property '$propertyPath' was changed. From '$fromValue' to '$toValue'";
                case NOTCHANGED:
                    return null;
                case NESTED:
                    return render($node['children'], $propertyPath);
                default:
                    throw new \Exception("Unknown diff type $diffType");
            }
        },
        $diffTree
    );

    // remove empty lines (when values not changed)
    $diffLines = array_filter($diffLines);

    return implode("\n", $diffLines);
}

function stringify($value): string
{
    if (is_array($value)) {
        return 'complex value';
    }

    return (string)$value;
}

function addIndent(string $indentType, string $text): string
{
    $lines = explode("\n", $text);
    $linesWithIndent = array_map(fn($line) => "  {$indentType} {$line}", $lines);
    return implode("\n", $linesWithIndent);
}
