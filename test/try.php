<html>
    <head>

    </head>
    <body>
        <form action="process2.php" method="post" enctype="multipart/form-data">
            <!-- <input type="file" name="docx_file" accept=".docx" required> -->
            <input type="text" name="name" id="name" placeholder="Enter your name" required>
            <input type="submit" name="submit" value="Generate QR Code">
        </form>

        <a href="exportTable.php">Export Table</a>
    </body>
</html>