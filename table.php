<?php

// The HTML content
$html = <<<HTML
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h2>HTML Table</h2>
<table>
  <tr>
    <th>Company</th>
    <th>Contact</th>
    <th>Country</th>
  </tr>
  <tr>
    <td>Alfreds Futterkiste</td>
    <td>Maria Anders</td>
    <td>Germany</td>
  </tr>
  <tr>
    <td>Centro comercial Moctezuma</td>
    <td>Francisco Chang</td>
    <td>Mexico</td>
  </tr>
  <tr>
    <td>Ernst Handel</td>
    <td>Roland Mendel</td>
    <td>Austria</td>
  </tr>
  <tr>
    <td>Island Trading</td>
    <td>Helen Bennett</td>
    <td>UK</td>
  </tr>
  <tr>
    <td>Laughing Bacchus Winecellars</td>
    <td>Yoshi Tannamuri</td>
    <td>Canada</td>
  </tr>
  <tr>
    <td>Magazzini Alimentari Riuniti</td>
    <td>Giovanni Rovelli</td>
    <td>Italy</td>
  </tr>
</table>
</body>
</html>
HTML;

// Function to extract table data from HTML
function extractTableData($html) {
    $dom = new DOMDocument();
    @$dom->loadHTML($html);
    $table = $dom->getElementsByTagName('table')->item(0);
    $rows = $table->getElementsByTagName('tr');

    $data = [];
    $headers = [];

    foreach ($rows as $i => $row) {
        $cells = $row->getElementsByTagName($i === 0 ? 'th' : 'td');
        $rowData = [];
        
        foreach ($cells as $j => $cell) {
            if ($i === 0) {
                $headers[] = trim($cell->nodeValue);
            } else {
                $rowData[$headers[$j]] = trim($cell->nodeValue);
            }
        }
        
        if (!empty($rowData)) {
            $data[] = $rowData;
        }
    }

    return $data;
}

// Extract the data
$table_data = extractTableData($html);

// Output the result
echo "PHP array representation of the table:\n\n";
print_r($table_data);