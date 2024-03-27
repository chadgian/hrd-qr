<?php
    // Load the image
    $image = imagecreatefrompng('uploads/source.png');
    $participantID = 126;
    // $agency = "Municipal Treasurer's Office - Municipality of San Jose, Antique";
    $text = "Palmon, Jose Jr.";
    $firstName =  "Jose";
    $trainingDate = "March 21-22, 2024";
    $trainingName = "Conversations with Public Sector Unions";
    $trainingVenue = "Grand Ballroom, Zuri Hotel, Iloilo City";

    // ----------------- FOR NAME --------------------------

    // Define the text to be added
    $image = imagecreatefrompng('../sources/id-source.png');

    // ----------------- FOR NAME --------------------------

    
    // Define the font and color for the text
    $font = '../fonts/Poppins/Poppins-ExtraLight.otf'; // Path to your font file
    $color = imagecolorallocate($image, 0, 0, 0); // Black font color
    $fontSize = 50; //initial font size

    $textBox = imagettfbbox($fontSize, 0, $font, $text); // Do this so you can get the width that the text will take up
    $textWidth = abs($textBox[4] - $textBox[6]); // Here is the text width
    $textHeight = abs($textBox[5] - $textBox[3]); // And this is the height

    // This if-else statement will reduce the font size of the name if it doesn't fit the image
    if ($textWidth > (imagesx($image)-(imagesx($image)/8))){
        while ($textWidth > (imagesx($image)-(imagesx($image)/8))){
            $fontSize = $fontSize-10;
            $textBox = imagettfbbox($fontSize, 0, $font, $text);
            $textWidth = abs($textBox[4] - $textBox[6]);
        }
    }
    
    $textX = (imagesx($image)-$textWidth)/2; // Center the text horizontally
    $textY = imagesy($image) - 50; // Adjust the Y position as needed

    // Add the text to the image
    imagettftext($image, $fontSize, 0, $textX, $textY, $color, $font, $text);
    
    // ----------------------- FOR FIRST NAME -------------------------

    if (strpos($firstName, "Jr.") !== false){
        $firstName = str_replace("Jr.", "", $firstName);
    }

    // Define the font and color for the text
    $font1 = '../fonts/Poppins/Poppins-Regular.otf'; // Path to your font file
    $color = imagecolorallocate($image, 0, 0, 0); // Black font color
    $fontSize = 170; //initial font size

    $textBox = imagettfbbox($fontSize, 0, $font1, $firstName); // Do this so you can get the width that the text will take up
    $textWidth = abs($textBox[4] - $textBox[6]); // Here is the text width

    // This if-else statement will reduce the font size of the name if it doesn't fit the image
    if ($textWidth > (imagesx($image)-(imagesx($image)/12))){
        while ($textWidth > (imagesx($image)-(imagesx($image)/12))){
            $fontSize = $fontSize-10;
            $textBox = imagettfbbox($fontSize, 0, $font1, $firstName);
            $textWidth = abs($textBox[4] - $textBox[6]);
        }
    }
    
    $fnameX = (imagesx($image)-$textWidth)/2; // Center the text horizontally
    $fnameY = imagesy($image) - 180; // Adjust the Y position as needed

    // Add the text to the image
    imagettftext($image, $fontSize, 0, $fnameX, $fnameY, $color, $font1, $firstName);

    // --------------------- FOR PARTICIPANT ID --------------------

    $idx = imagesx($image)*0.09;
    $idy = imagesy($image) - 50;

    $idBox = imagettfbbox(30, 0, $font, $participantID);
    $idBoxWidth = abs($idBox[2] - $idBox[0]);

    imagettftext($image, 30, 0, $idx, $idy, $color, $font, $participantID);

    // ----------------------- FOR TRAINING DETAILS --------------------

    $nameFont = '../fonts/CooperHewitt/CooperHewitt-HeavyItalic.otf';
    $dateFont = '../fonts/CooperHewitt/CooperHewitt-Bold.otf';
    $venueFont = '../fonts/CooperHewitt/CooperHewitt-Medium.otf';

    $nameColor  = imagecolorallocate($image, 0, 74, 173);
    $dateColor = imagecolorallocate($image, 255, 44, 47);
    $venueColor = imagecolorallocate($image, 0, 0, 0);

    // NOTE:
    // width of training name should be $imagesx($image)*0.5579 (only 55.79% of the total width)
    // the left border of the training details box should be $imagesx($image)*0.0632 (Only 6.32% of the total width)
    // top border of the training name should be $imagesy($image)*0.2479 (Only 24.79% of the total height)
    $trainingDetailW = imagesx($image)*0.5579;

    // Training Venue
    $trainingVenueFontSize = 20;
    $trainingVenueBox = imagettfbbox($trainingVenueFontSize, 0, $venueFont, $trainingVenue);
    $trainingVenueWidth  = abs($trainingVenueBox[2] - $trainingVenueBox[0]);

    while ($trainingVenueWidth > $trainingDetailW){
        $trainingVenueFontSize--;
        $trainingVenueBox = imagettfbbox($trainingVenueFontSize, 0, $venueFont, $trainingVenue);
        $trainingVenueWidth  = abs($trainingVenueBox[2] - $trainingVenueBox[0]);
    }

    $trainingVenueX = (imagesx($image)*0.07)+($trainingDetailW/2)-($trainingVenueWidth/2);
    $trainingVenueY = imagesy($image)*0.49;

    imagettftext($image, $trainingVenueFontSize, 0, $trainingVenueX, $trainingVenueY, $venueColor, $venueFont, $trainingVenue);

    // Training Name
    $trainingNameWordCount = str_word_count($trainingName);

    if ($trainingNameWordCount > 3){
        $words = explode(" ", $trainingName);
        $midpoint = ceil(count($words) / 2);

        // SECOND PART OF THE TRAINING NAME
        $secondPart = implode(" ", array_slice($words, $midpoint));
        $firstPart = implode(" ", array_slice($words, 0, $midpoint));
        echo "First Midpoint: $midpoint";

        while (strlen($secondPart) < strlen($firstPart)){
            $midpoint--;
            echo "Midpoint: $midpoint";
            $secondPart = implode(" ", array_slice($words, $midpoint));
            $firstPart = implode(" ", array_slice($words, 0, $midpoint));
        }

        $trainingNameFontSize = 60;
        $trainingNameW = imagesx($image)*0.5579; //  55.79% of the total width
        
        $trainingNameBox2 = imagettfbbox($trainingNameFontSize, 0, $nameFont, $secondPart);
        $actualNameWidth2 = abs($trainingNameBox2[2] - $trainingNameBox2[0]);
        $actualNameHeight2 = abs($trainingNameBox2[7] - $trainingNameBox2[1]);
        

        while ($actualNameWidth2 > $trainingNameW){
            $trainingNameFontSize--;
            $trainingNameBox2 = imagettfbbox($trainingNameFontSize, 0, $nameFont, $secondPart);
            $actualNameWidth2 = abs($trainingNameBox2[2] - $trainingNameBox2[0]);
        }

        $trainingNameX = (imagesx($image)*0.07)+($trainingDetailW/2)-($actualNameWidth2/2); // 6.32% from left side
        $trainingNameY = imagesy($image)*0.40; // 24.79% of the total height

        // Training Name to image
        imagettftext($image, $trainingNameFontSize, 0, $trainingNameX, $trainingNameY, $nameColor, $nameFont, $secondPart);


        // FIRST PART OF THE TRAINING NAME

        $trainingNameFontSize = 60;
        $trainingNameW = imagesx($image)*0.5579; //  55.79% of the total width
        
        $trainingNameBox = imagettfbbox($trainingNameFontSize, 0, $nameFont, $firstPart);
        $actualNameWidth = abs($trainingNameBox[2] - $trainingNameBox[0]);

        while ($actualNameWidth > $trainingNameW){
            $trainingNameFontSize--;
            $trainingNameBox = imagettfbbox($trainingNameFontSize, 0, $nameFont, $firstPart);
            $actualNameWidth = abs($trainingNameBox[2] - $trainingNameBox[0]);
        }

        $trainingNameX = (imagesx($image)*0.07)+($trainingDetailW/2)-($actualNameWidth/2); // 6.32% from left side
        $trainingNameY = (imagesy($image)*0.40)-$actualNameHeight2; // 24.79% of the total height

        // Training Name to image
        imagettftext($image, $trainingNameFontSize, 0, $trainingNameX, $trainingNameY, $nameColor, $nameFont, $firstPart);

        // Training Date
        $trainingDateFontSize = 25;
        $trainingDateBox = imagettfbbox($trainingDateFontSize, 0, $dateFont, $trainingDate);
        $trainingDateBoxWidth = abs($trainingDateBox[2] - $trainingDateBox[0]); //
        $trainingDateX = (imagesx($image)*0.07)+($trainingDetailW/2)-($trainingDateBoxWidth/2);
        $trainingDateY = imagesy($image)*0.45;

        imagettftext($image, $trainingDateFontSize, 0, $trainingDateX, $trainingDateY, $dateColor, $dateFont, $trainingDate);

    } else {
        $trainingNameFontSize = 60;
        $trainingNameW = imagesx($image)*0.5579; //  55.79% of the total width
        
        $trainingNameBox = imagettfbbox($trainingNameFontSize, 0, $nameFont, $trainingName);
        $actualNameWidth = abs($trainingNameBox[2] - $trainingNameBox[0]);

        while ($actualNameWidth > $trainingNameW){
            $trainingNameFontSize--;
            $trainingNameBox = imagettfbbox($trainingNameFontSize, 0, $nameFont, $trainingName);
            $actualNameWidth = abs($trainingNameBox[2] - $trainingNameBox[0]);
        }

        $trainingNameX = (imagesx($image)*0.07)+($trainingDetailW/2)-($actualNameWidth/2); // 6.32% from left side
        $trainingNameY = imagesy($image)*0.36; // 24.79% of the total height

        // Training Name to image
        imagettftext($image, $trainingNameFontSize, 0, $trainingNameX, $trainingNameY, $nameColor, $nameFont, $trainingName);

        // Training Date
        $trainingDateFontSize = 25;
        $trainingDateBox = imagettfbbox($trainingDateFontSize, 0, $dateFont, $trainingDate);
        $trainingDateBoxWidth = abs($trainingDateBox[2] - $trainingDateBox[0]); //
        $trainingDateX = (imagesx($image)*0.07)+($trainingDetailW/2)-($trainingDateBoxWidth/2);
        $trainingDateY = imagesy($image)*0.43;

        imagettftext($image, $trainingDateFontSize, 0, $trainingDateX, $trainingDateY, $dateColor, $dateFont, $trainingDate);
    }

    //---------------------- FOR AGENCY ------------------------------
    // $agencyFontSize = 30;

    // $agencyBox = imagettfbbox($agencyFontSize, 0, $font, ucwords(strtolower($agency)));
    // $actualAgencyBoxWidth = abs($agencyBox[2] - $agencyBox[0]);

    // while ($actualAgencyBoxWidth > (imagesx($image)-(imagesx($image)/6))){
    //     $agencyFontSize--;
    //     $agencyBox = imagettfbbox($agencyFontSize, 0, $font, ucwords(strtolower($agency)));
    //     $actualAgencyBoxWidth = abs($agencyBox[2] - $agencyBox[0]);
    // }

    // $agencyx = (imagesx($image)-$actualAgencyBoxWidth)/2;
    // $agencyy = imagesy($image)*0.57;

    // imagettftext($image, $agencyFontSize, 0, $agencyx, $agencyy, $color, $font, ucwords(strtolower($agency)));


    //  ---------------- FOR QR Code ----------------------

    // $result = Builder::create()
    //     ->writer(new PngWriter())
    //     ->writerOptions([])
    //     ->data($id.':'.$text)
    //     ->encoding(new Encoding('UTF-8'))
    //     ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
    //     ->size(370)
    //     ->margin(10)
    //     ->roundBlockSizeMode(new RoundBlockSizeModeMargin())
    //     ->logoPath('../img/logo2.png')
    //     ->logoResizeToWidth(50)
    //     ->logoPunchoutBackground(true)
    //     ->labelText('CSC RO VI')
    //     ->labelFont(new NotoSans(20))
    //     ->labelAlignment(new LabelAlignmentCenter())
    //     ->validateResult(false)
    //     ->build();
    // // Get the dimensions of the QR code image
    // $result->save('qrcode.png');
    // $qrcode = imagecreatefrompng('qrcode.png');

    // $qrWidth = imagesx($qrcode);
    // $qrHeight = imagesy($qrcode);

    // // Define the position for the QR code (upper right corner with a margin)
    // $qrX = imagesx($image) - $qrWidth - 130;
    // $qrY = 50;

    // // Merge the QR code onto the main image
    // imagecopy($image, $qrcode, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

    // $outputFilePath = "$folderName/$IDfilename"; // save it to local folder
    // imagejpeg($image, $outputFilePath);

    // // Free up memory
    // imagedestroy($image);
    // imagedestroy($qrcode);
    // unlink('qrcode.png');

    // Generate the QR code
    $qrText = urlencode("$participantID:$text"); // URL or any other data you want to encode
    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?data=$qrText&size=370x370";
    // $qrImage = imagecreatefrompng();

    try {
        $qrImageData = file_get_contents($qrUrl);

        if ($qrImageData === false) {
            echo "Failed to fetch QR code image <br>";
        } else {
            $qrImage = imagecreatefromstring($qrImageData);
            if ($qrImage === false) {
                // Handle error
                echo "Failed to create image from QR code data <br>";
            } else {    
                // Get the dimensions of the QR code image
                $qrWidth = imagesx($qrImage);
                $qrHeight = imagesy($qrImage);

                // Define the position for the QR code (upper right corner with a margin)
                $qrX = imagesx($image) - $qrWidth - 130;
                $qrY = 50;

                // Merge the QR code onto the main image
                imagecopy($image, $qrImage, $qrX, $qrY, 0, 0, $qrWidth, $qrHeight);

                // Output or save the modified image
                // header('Content-Type: image/jpeg');
                // imagejpeg($image);

                //should automatically download but failed
                // header('Content-Type: image/jpeg');
                // header('Content-Disposition: attachment; filename="' . $participantID . ":" .$participantName . '.jpg"');

                // ob_start();
                // imagejpeg($image);
                // $imageData = ob_get_clean();

                // $zipFileNameInZip = "$participantID-$text.jpg";
                // $zip->addFromString($zipFileNameInZip, $imageData);

                $outputFilePath = "uploads/$text.jpg"; // save it to local folder
                imagejpeg($image, $outputFilePath);

                // Free up memory
                imagedestroy($image);
                imagedestroy($qrImage);
            }   
        }
    } catch (Exception $e) {
        echo "Error getting QR Code from the url: ".$e->getMessage()."<br>";
    }
?>
