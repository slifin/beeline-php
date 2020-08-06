<?php

/**
 * @file
 * Beeline interface for PHP.
 */

namespace slifin\beeline;

function bridge(...$arguments)
{
    $jar = sprintf('%s/jars/honeysql-1.0.444.jar', __DIR__);
    $command = sprintf('bb -f beeline.clj -cp %s', $jar);

    $descriptor = [
       0 => ['pipe', 'r'],
       1 => ["pipe", "w"],
    ];

    $process = proc_open($command, $descriptor, $pipes);

    if (!is_resource($process)) {
        throw new Exception('Failed to open process');
    }

    [$stdin, $stdout] = $pipes;
    fwrite($stdin, $arguments);
    fclose($stdin);

    $query = stream_get_contents($stdout);
    fclose($stdout);
    $return_value = proc_close($process);

    return $query;
}
