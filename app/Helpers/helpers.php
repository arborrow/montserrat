<?php

if (! function_exists('options_range')) {
    function options_range($start, $end): array {
    return array_combine($range = range($start, $end), $range);
    }
}