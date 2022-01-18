<?php

namespace App\Http\Traits;

use Carbon\Carbon;

trait RulesTrait
{
    public function parseDate(?string $date): ?Carbon
    {
        if ($date !== null) {
            $BRAZILLIAN_PATTERN = "/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/";

            if (preg_match($BRAZILLIAN_PATTERN, $date)) {
                $date = Carbon::createFromFormat('d/m/Y', $date);
            }

            return Carbon::parse($date);
        }

        return $date;
    }

    public function validate(object $record): bool
    {
        $isValid = true;

        if (isset($record->date_of_birth)) {
            if ($record->date_of_birth !== null) {
                $parsed = $this->parseDate($record->date_of_birth);
                if ($parsed->age < 18 || $parsed->age > 65) {
                    $isValid = false;
                }
            }
        }

        return $isValid;
    }
}
