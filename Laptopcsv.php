<?php

// Function to fetch JSON data from a URL
function fetchJsonData($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
        return false;
    }
    
    curl_close($ch);
    return json_decode($response, true);
}

// Function to create CSV file from data
function createCsvFile($data, $filename) {
    $file = fopen($filename, 'w');
    
    // Write the header
    fputcsv($file, ['Title', 'Price', 'Brand']);
    
    // Write the data
    foreach ($data['products'] as $product) {
        fputcsv($file, [
            $product['title'],
            $product['price'],
            $product['brand']
        ]);
    }
    
    fclose($file);
    return true;
}

// URL of the JSON data
$url = 'https://dummyjson.com/products/search?q=Laptop';

// Fetch the JSON data
$jsonData = fetchJsonData($url);

if ($jsonData) {
    // Create the CSV file
    if (createCsvFile($jsonData, 'laptop.csv')) {
        echo "CSV file 'laptop.csv' has been created successfully.";
    } else {
        echo "Failed to create CSV file.";
    }
} else {
    echo "Failed to fetch JSON data.";
}

?>