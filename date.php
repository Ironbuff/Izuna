<?php

function generateDateRanges($startDate, $endDate, $interval, $format) {
    $result = [];
    $currentDate = new DateTime($startDate);
    $end = new DateTime($endDate);

    while ($currentDate <= $end) {
        $rangeStart = $currentDate->format($format);
        
        // Calculate the end of the current range
        $rangeEnd = (clone $currentDate)->modify("+".($interval - 1)." days");
        
        // If the range end exceeds the overall end date, use the overall end date
        if ($rangeEnd > $end) {
            $rangeEnd = $end;
        }
        
        $result[] = [$rangeStart, $rangeEnd->format($format)];
        
        // Move to the next range
        $currentDate->modify("+$interval days");
    }

    return $result;
}

// Example usage
$startDate = '2023-01-01';
$endDate = '2023-01-31';
$interval = 2;
$format = 'm/d/Y';

$dateRanges = generateDateRanges($startDate, $endDate, $interval, $format);

// Output the result
echo "Results:\n";
print_r($dateRanges);
?>