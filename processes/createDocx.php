
<?php

    require_once '../vendor/autoload.php';
    
    $phpWord = new \PhpOffice\PhpWord\PhpWord();

    $folderName = "../generated_ids/training-21/";
    $width = 3.5*72;
    $height = 2*72;

    // Get the list of files and directories in the folder
    $files = scandir($folderName);

    // $margin = 0.25*72;

    $section = $phpWord->addSection();
    

    // Loop through each item in the files array
    foreach ($files as $file) {
        // Exclude "." and ".." which represent the current and parent directory
        if ($file != "." && $file != "..") {
            // Check if the current item is a file (not a directory) and ends with ".jpg"
            // && pathinfo($file, PATHINFO_EXTENSION) === 'jpg'
            if (is_file($folderName . $file) && pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
                // Increment the JPG file counter
                $filepath = "$folderName$file";
                //echo "<img src='$filepath'> <br><hr>";

                $section->addImage($filepath, array('width' => $width, 'height' => $height));//, 'wrappingStyle' => 'inline', 'positioning' => 'relative'
            }
            // $jpgFileCount++;
        }
    }

    $filename = "sample.docx";
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
    $objWriter->save("../generated_ids/$filename");


?>
