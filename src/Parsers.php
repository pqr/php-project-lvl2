<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

function parse(string $content, string $format): array
{
    switch ($format) {
        case 'yml':
        case 'yaml':
            return Yaml::parse($content);
        case 'json':
            return json_decode($content, true, 512, JSON_THROW_ON_ERROR);

        default:
            throw new \Exception('Unknown format');
    }
}
