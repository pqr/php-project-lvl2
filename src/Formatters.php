<?php

declare(strict_types=1);

namespace Differ\Formatters;

const FORMATTERS = [
    'pretty' => '\Differ\Formatters\Pretty\render',
    'plain' => '\Differ\Formatters\Plain\render',
    'json' => '\Differ\Formatters\Json\render',
];

function getFormatter(string $format): callable
{
    if (!isset(FORMATTERS[$format])) {
        throw new \Exception("Unknown format $format");
    }

    return FORMATTERS[$format];
}
