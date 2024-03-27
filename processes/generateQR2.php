<?php
require_once 'db_connection.php';
require_once '../vendor/autoload.php';

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

if (isset($_GET['id'])) {
    $trainingID = $_GET['id'];

    $trainingTable = "training-$trainingID-1";

    $stmt = $conn->prepare("SELECT * FROM `$trainingTable`");
    if ($stmt->execute()) {
        $result = $stmt->get_result();

        // Array to store QR code images temporarily
        $qrCodeImages = [];

        while ($data = $result->fetch_assoc()) {
            // $name = str_replace('ñ', 'n', $data['participant_name']);
            $name = $data['participant_name'];

            $renderer = new ImageRenderer(
                new RendererStyle(200), // Adjust the size of the QR code
                new \BaconQrCode\Renderer\Image\ImagickImageBackEnd() // Adjust the size of the QR code
            );
            $writer = new Writer($renderer);
            $qrCodeImage = $writer->writeString($name);

            // Save the QR code image to the array
            $qrCodeImages[$name] = $qrCodeImage;
        }

        // Create a new zip archive
        $zip = new ZipArchive();
        if ($zip->open("$trainingTable-qrcodes.zip", ZipArchive::CREATE) === true) {
            foreach ($qrCodeImages as $names => $qrCodeImage) {
                // Save each QR code image to a temporary file
                $qrCodeFilename = preg_replace('/[^a-zA-Z0-9]/', '_', $names).".png";
                file_put_contents($qrCodeFilename, $qrCodeImage);

                // Add the QR code image to the zip archive
                $zip->addFile($qrCodeFilename, $qrCodeFilename);

                // Cleanup - delete the temporary QR code image file
                unlink($qrCodeFilename);
            }

            // Close the zip archive
            $zip->close();

            // Send the zip file to the client
            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . "$trainingTable-qrcodes.zip");
            header('Content-Length: ' . filesize("$trainingTable-qrcodes.zip"));
            readfile("$trainingTable-qrcodes.zip");

            // Exit the script
            exit;
        } else {
            echo "Failed to create zip archive";
        }
    } else {
        echo $stmt->error;
    }
}
?>
