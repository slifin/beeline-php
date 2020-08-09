<?php

/**
 * @file
 * Beeline interface for PHP.
 */

namespace slifin;

use transit\Map;
use transit\Keyword;
use transit\JSONReader;
use transit\JSONWriter;
use transit\Transit;

class Beeline
{
    public static function bridge(string $transit)
    {
        $jar = sprintf('%s/jars/honeysql-1.0.444.jar', __DIR__);
        $command = sprintf('bb -f %s/beeline.clj -cp %s', __DIR__, $jar);

        $descriptor = [
           0 => ['pipe', 'r'],
           1 => ['pipe', 'w'],
        ];

        $process = proc_open($command, $descriptor, $pipes);

        if (!is_resource($process)) {
            throw new Exception('Failed to open process');
        }

        [$stdin, $stdout] = $pipes;
        fwrite($stdin, $transit);
        fclose($stdin);

        $query = stream_get_contents($stdout);
        fclose($stdout);
        $return_value = proc_close($process);

        return [trim($query), $return_value];
    }

    public static function format($query, ...$args)
    {
        self::walk($query);
        $transit = new Transit(new JSONReader(), new JSONWriter());
        $msg = $transit->write([$query, ...$args]);
        $response = self::bridge($msg)[0];
        return $transit->read($response);
    }

    public static function walk(&$query)
    {
        if (!is_array($query)) {
            return;
        }

        $is_map = is_string(array_key_first($query));

        $new = [];

        foreach ($query as $k => $v) {
            self::walk($v);
            $new[$k] = $v;
        }

        if ($is_map) {
            $map = new Map([]);
            foreach ($new as $k => $v) {
                $map->offsetSet(
                    self::parse($k),
                    self::parse($v)
                );
            }
            $query = $map;
        } else {
            $query = array_map([self::class, 'parse'], $new);
        }
    }

    public static function parse($input)
    {
        switch (true) {
            case is_string($input):
                return new Keyword($input);
        }

        return $input;
    }
}
