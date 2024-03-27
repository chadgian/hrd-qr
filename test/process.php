<?php

require_once '../vendor/autoload.php';

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use PhpOffice\PhpWord\TemplateProcessor;

// Handle form submission
if (isset($_POST['submit'])) {
    $name = $_POST['name'];

    // Generate QR code
    $renderer = new ImageRenderer(
        new RendererStyle(400), // Adjust the size of the QR code
        new \BaconQrCode\Renderer\Image\ImagickImageBackEnd() // Adjust the size of the QR code
    );
    $writer = new Writer($renderer);
    $qrCodeImage = $writer->writeString($name);

    // header('Content-Type: image/png');
    // echo $qrCodeImage;

    // Upload and manipulate docx file
    if ($_FILES['docx_file']['error'] === UPLOAD_ERR_OK) {
        if (isset($_FILES['docx_file']) && !empty($_FILES['docx_file']['tmp_name'])) {
            // Validate file type and size (you may need to adjust the constants)
            if ($_FILES['docx_file']['type'] !== 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $_FILES['docx_file']['size'] > 1000000) {
                echo "Invalid file type or size.";
                exit();
            }
        
            // Move the uploaded file to a secure directory
            $uploadDir = 'uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $uploadedFilePath = $uploadDir . basename($_FILES['docx_file']['name']);
            if (!move_uploaded_file($_FILES['docx_file']['tmp_name'], $uploadedFilePath)) {
                echo "Failed to upload file.";
                exit();
            }
        
            // Load the docx file
            $templateProcessor = new TemplateProcessor($uploadedFilePath);
            echo "<br>1st- $name";
            // Replace placeholders with user's name and QR code
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            // $qrCodeImage = isset($_POST['qr_code_image']) ? $_POST['qr_code_image'] : '';
            echo "<br> 2nd- $name<br>";
            if (!empty($name)) {
                $templateProcessor->setValue('name', $name);
                if (!empty($qrCodeImage)){
                    $templateProcessor->setImageValue('qr_code', [
                        'path' => $qrCodeImage,
                        'width' => 150,
                        'height' => 150
                    ]);
                } else {
                    echo "Missing qr code";
                    exit();
                }
                
            } else {
                echo "Missing user's name";
                exit();
            }
        
            // Save the modified document
            $modifiedFilePath = $uploadDir . 'modified_' . basename($_FILES['docx_file']['name']);
            $templateProcessor->saveAs($modifiedFilePath);
        
            // Provide download link to the modified docx file
            echo '<a href="' . $modifiedFilePath . '" download>Download Modified Document</a>';
        } else {
            echo "No file uploaded.";
        }
    } else {
        echo "Error uploading file.";
    }
}
?>
