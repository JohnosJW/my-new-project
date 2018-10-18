<?php

namespace  App\Exceptions;

use Log;
use Exceptions;


class HackerAlertException extends Exceptions
{
    public function report()
    {
        Log::critical('hacker tried to huck us today!');
    }

    public function render()
    {
        return response()->json([
            'message' => 'Today is not your day!'
        ]);
    }
}