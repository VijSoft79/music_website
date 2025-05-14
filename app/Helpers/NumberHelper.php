<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Extract and convert a number from a string
     * 
     * @param string $value The string containing the number
     * @param bool $asInteger Whether to return as integer (default: false, returns as double)
     * @return float|int The extracted number
     */
    public static function extractNumber($value, $asInteger = false)
    {
        // Remove all non-numeric characters except decimal point
        $number = preg_replace('/[^0-9.]/', '', $value);
        
        // If no number found, return 0
        if (empty($number)) {
            return $asInteger ? 0 : 0.0;
        }
        
        // Convert to appropriate type
        return $asInteger ? (int) $number : (double) $number;
    }
} 