<?php

namespace Illuminate\Queue\Jobs;

use Illuminate\Support\Arr;

class JobName
{
    /**
     * Parse the given job name into a class / method array.
     *
     * @param  string  $job
     * @return array
     */
    public static function parse($job)
    {
        $segments = explode('@', $job);

        return count($segments) > 1 ? $segments : [$segments[0], 'fire'];
    }

    /**
     * Get the resolved name of the queued job class.
     *
     * @param  string  $name
     * @param  array  $payload
     * @return string
     */
    public static function resolve($name, $payload)
    {
        if ($name === 'Illuminate\Queue\CallQueuedHandler@call') {
            return Arr::get($payload, 'data.commandName', $name);
        }

        if ($name === 'Illuminate\Events\CallQueuedHandler@call') {
            return $payload['data']['class'].'@'.$payload['data']['method'];
        }

        return $name;
    }
}
