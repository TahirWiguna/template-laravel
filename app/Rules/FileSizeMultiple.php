<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class FileSizeMultiple implements Rule
{
    protected $maxTotalSize; // Maximum total size in bytes
    protected $maxIndividualSize; // Maximum individual size in bytes

    /**
     * Create a new rule instance.
     *
     * @param int $maxTotalSize
     * @param int $maxIndividualSize
     * @return void
     */
    public function __construct($maxTotalSize = 2097, $maxIndividualSize = 2097)
    {
        $this->maxTotalSize = $maxTotalSize * 1000;
        $this->maxIndividualSize = $maxIndividualSize * 1000;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $totalSize = 0;

        foreach ($value as $file) {
            $totalSize += $file->getSize();

            if ($file->getSize() > $this->maxIndividualSize) {
                return false;
            }
        }

        return $totalSize <= $this->maxTotalSize;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "The :attribute size must not exceed " . $this->formatSize($this->maxTotalSize) . " in total and each image must not exceed " . $this->formatSize($this->maxIndividualSize) . ".";
    }

    /**
     * Format bytes to a human-readable size.
     *
     * @param int $size
     * @return string
     */
    protected function formatSize($size)
    {
        $units = ["B", "KB", "MB", "GB", "TB"];
        $index = 0;

        while ($size >= 1024 && $index < 4) {
            $size /= 1024;
            $index++;
        }

        return round($size, 2) . " " . $units[$index];
    }
}
