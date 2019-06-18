<?php

/**
 * @file
 * Beeline interface for PHP.
 */

namespace slifin\beeline;

/**
 * Accepts a HoneySQL formatted data structure.
 *
 * @param array $sql The data structure to represent SQL.
 *
 * @throws \Exception Will throw if the current OS is unsupported.
 *
 * @return array An array of [$sql_string, ...$sql_parameters].
 */
function format(array $sql) : array
{
    switch (php_uname('s')) {
        case 'Darwin':
            $binary =
                __DIR__ . '/resources/darwin-beeline';
            break;
        case 'Linux':
            $binary =
                __DIR__ . '/resources/linux-beeline';
            break;
        default:
            throw new \Exception('Currently unsupported platform');
    }

    $output = exec(
        $binary
        . ' "'
        . addslashes(json_encode($sql))
        . '"',
        $out1,
        $out2
    );

    return json_decode($out1[0]);
}
