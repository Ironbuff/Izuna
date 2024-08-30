<?php

function processProducts($products, $category = '') {
    foreach ($products as $key => $value) {
        if ($key === 'items') {
            foreach ($value as $item) {
                $output = [
                    'title' => $item['title'],
                    'price' => $item['price'],
                    'category' => trim($category, ' > ')
                ];
                print_r($output);
            }
        } elseif (is_array($value)) {
            processProducts($value, $category . $key . ' > ');
        }
    }
}

// Sample data
$products = array(
    'Home' => array(
        'Electronics & Accessories' => array(
            'items' => array(
                array(
                    'title' => 'SanDisk 256',
                    'price' => '24.45'
                ),
                array(
                    'title' => 'Jabra Wireless Headset',
                    'price' => '55.12'
                )
            ),
            'Accessories' => array(
                'items' => array(
                    array (
                        'title' => 'DJI OM 5 Smartphone Gimbal Stabilizer',
                        'price' => '129.99'
                    ),
                    array (
                        'title' => 'SAMSUNG Galaxy SmartTag',
                        'price' => '30.00'
                    )
                )
            )
        )
    )
);

// Process and print the products
processProducts($products);

?>