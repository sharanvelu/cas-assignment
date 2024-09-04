<?php


function logError(Throwable $throwable, $message, $location, $details = [])
{
    \Illuminate\Support\Facades\Log::error($message, [
        'message' => $throwable->getMessage(),
        'code' => $throwable->getCode(),
        'location' => $location,
        'trace' => $throwable->getTraceAsString(),
    ]);
}
