<?php

// Include the Composer autoload file to load PhpSpreadsheet
require '../vendor/autoload.php';
include '../processes/db_connection.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$tableName = 'training-21-1';

$stmt = $conn->prepare("SELECT * FROM `$tableName`");
$stmt->execute();
$result = $stmt->get_result();

if ($result -> num_rows > 0){

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'No.');
    $sheet->setCellValue('B1', 'Name');
    $sheet->setCellValue('C1', 'Agency');
    $sheet->setCellValue('D1', 'Position');
    $sheet->setCellValue('E1', 'Login');
    $sheet->setCellValue('F1', 'Logout');

    $rowCount = 2;

    while($data = $result->fetch_assoc()){
        $sheet->setCellValue('A'.$rowCount, $data['participant_id']);
        $sheet->setCellValue('B'.$rowCount, $data['participant_name']);
        $sheet->setCellValue('C'.$rowCount, $data['agency']);
        $sheet->setCellValue('D'.$rowCount, $data['position']);
        $sheet->setCellValue('E'.$rowCount, $data['login']);
        $sheet->setCellValue('F'.$rowCount, $data['logout']);
        $rowCount++;
    }

    $writer = new Xlsx($spreadsheet);
    $final_filename = $tableName.'.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attactment; filename="'.urlencode($final_filename).'"');
    $writer->save('php://output');
} else {
    echo "No data found in the table";
    exit();
}

?>
