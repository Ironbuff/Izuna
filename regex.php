<?php

function extractSubstring($string) {
    $pattern = '/^.{2}(.{3})/';
    if (preg_match($pattern, $string, $matches)) {
        return $matches[1];
    }
    return null;
}

// Test the function
$string = "734rn3242";
$result = extractSubstring($string);

if ($result !== null) {
    echo "Result: $result\n";
} else {
    echo "String is too short or invalid format\n";
}

?>