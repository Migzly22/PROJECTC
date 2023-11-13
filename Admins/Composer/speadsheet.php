<?php

require("../Database.php");
require '../Composer/vendor/autoload.php';

session_start();
ob_start();

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// Define your custom headers and columns
$customHeaders = ['Date', 'Payment Method', 'Amount Paid'];
$selectedColumns = ['PaymentDate', 'PaymentMethod', 'AmountPaid'];

// Fetch data from MySQL
$sqlcode = $_GET["sqlcode"];
//$sql = "SELECT " . implode(', ', $selectedColumns) . " FROM your_table";

$sql = str_replace(":*:", implode(', ', $selectedColumns), $sqlcode);
$result = mysqli_query($conn, $sql);

// Create a new Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Add custom headers
$sheet->fromArray([$customHeaders], null, 'A1');

// Add data
$rowIndex = 2;
while ($row = mysqli_fetch_assoc($result)) {
    $rowData = [];
    foreach ($selectedColumns as $column) {
        $rowData[] = $row[$column];
    }
    $sheet->fromArray([$rowData], null, 'A' . $rowIndex);
    $rowIndex++;
}

// Save the Excel file
$writer = new Xlsx($spreadsheet);
$filename = 'exported_data.xlsx';
$writer->save($filename);

// Output headers to force the browser to download the file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');

// Clear output buffer to avoid corruption
ob_end_clean();

// Output Excel file to browser
$writer->save('php://output');

// Close the database connection
$conn->close();
?>