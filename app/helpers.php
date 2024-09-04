<?php


use Illuminate\Contracts\Filesystem\FileNotFoundException;

function logError(Throwable $throwable, $message, $location, $details = [])
{
    \Illuminate\Support\Facades\Log::error($message, [
        'message' => $throwable->getMessage(),
        'code' => $throwable->getCode(),
        'location' => $location,
        'trace' => $throwable->getTraceAsString(),
    ]);
}

/**
 * Store Files to Storage
 *
 * @param string|object $field
 * <p>Field name from the request() for which the File has to be stored.</p>
 * @param string $path
 * <p>The path in which the file has to be stored in the S3.</p>
 * <p>If No path is specified, then it will default to 'public'.</p>
 * @return string
 * <p>Returns the FileName with $path specified to store in the DB.</p>
 * @throws FileNotFoundException
 * <p>Throws \Illuminate\Contracts\Filesystem\FileNotFoundException if the request doesn't have a File
 * mentioned in the $field parameter<p>
 */
function storeFile($field, string $path = 'public'): string
{
    if ((is_string($field) && !request()->hasFile($field)) || (!is_string($field) && !is_file($field))) {
        throw new FileNotFoundException();
    }

    $file = is_string($field) ? request()->file($field) : $field;

    $baseFilename = $file->getBasename();
    $extension = $file->getClientOriginalExtension();
    $filename = $file->getClientOriginalName();

    // Gives extra buffer length : 5 => '/', '_', '.', Buffer(2)
    $maxFileNameLength = 255 - strlen($path) - strlen($baseFilename) - strlen($extension) - 5;

    // Get only FileName
    $filename = pathinfo($filename, PATHINFO_FILENAME);

    // Trim Filename if file name exceeds the limit of 255.
    $filename = substr($filename, 0, ($maxFileNameLength));

    // Remove '/', '\' in Filename
    $filename = str_replace('/', '_', $filename);
    $filename = str_replace('\\', '_', $filename);

    $path = \Illuminate\Support\Str::endsWith($path, '/') ? $path : ($path . '/');

    // Final File name with Path to store
    $filename = $path . $filename . '_' . $baseFilename . '.' . $extension;

    // Upload File
    \Illuminate\Support\Facades\Storage::put($filename, fopen($file, 'r+'));

    return $filename;
}

/**
 * Retrieve File From Storage
 *
 * @param $filePath
 * @return string
 */
function retrieveFile($filePath)
{
    if (empty($filePath)) {
        return null;
    }

    $expiry = now()->addMinutes(config('filesystems.disks.s3.ttl'));

    $method = 'url';
    if (config('filesystems.default') == 's3') {
        $method = 'temporaryUrl';
    }

    return \Illuminate\Support\Facades\Storage::$method($filePath, $expiry);
}

