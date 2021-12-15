<?php

namespace Bamboo\ImportData\Helpers\Traits;

use Carbon\Carbon;
use Throwable;

trait ParseDateTrait
{
    public function parseDate(?string $date, string $format = Carbon::DEFAULT_TO_STRING_FORMAT)
    {
        try {
            return Carbon::createFromFormat($format, $date);
        } catch (Throwable $throwable) {
            return Carbon::now();
        }
    }
}
