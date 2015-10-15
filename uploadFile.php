<?php
/**
 * Created by IntelliJ IDEA.
 * User: Landon
 * Date: 2015.09.30
 * Time: 18:12 PM
 */
include 'customFunctions.php'; //using a custom function to display file size in a prettier way
echo "<html><head><title>Processing</title><link href=\"./assets/css/bootstrap.min.css\" rel=\"stylesheet\"><link rel=\"shortcut icon\" href=\"./assets/favicon.ico\" type=\"image/x-icon\"></head><body><div class=\"container\"><br />"; //I wanted processing to look pretty


//set up some variables we'll need
$uploadDir = "./uploads/";
$fileToUpload = $_FILES["imageUpload"];
$baseFileName = basename($fileToUpload["name"]);
$targetSave = $uploadDir . $baseFileName;
$fileToUpload_size = $_FILES["imageUpload"]["size"];
$allowedFileUploadSize = 51200; //letting them upload 50KB images
$fileToUpload_extension =  pathinfo($targetSave,PATHINFO_EXTENSION); //grab the extension from the file name
$doUpload = true; //flag for validation

//validate against large sizes
if ($fileToUpload_size > $allowedFileUploadSize) {
    echo "<p><span class=\"label label-danger\">Sorry, your file is too large (Your file is ".formatSizeUnits($fileToUpload_size).", max size allowed is ".formatSizeUnits($allowedFileUploadSize).".</span></p>";
    $doUpload = false;
}

//validate file extension
if ($fileToUpload_extension != "jpg" && $fileToUpload_extension != "png" && $fileToUpload_extension != "jpeg" && $fileToUpload_extension != "gif" ) {
    echo "<p><span class=\"label label-danger\">Your file extension (.$fileToUpload_extension) is invalid. Only JPG, JPEG, PNG and GIF files are allowed.</span></p>";
    $doUpload = false;
}

if ($doUpload) {
    echo "<p>Saving file to $targetSave </p>";
    move_uploaded_file($fileToUpload["tmp_name"], $targetSave);
}


if ($doUpload) {
    echo "<p>Upload processed.... redirecting.<p>";
    echo "<script type=\"text/javascript\">(function() {window.location = \"index.php?fileName=$baseFileName\";})();</script>"; //redirect using javascript if successful
} else {
    echo "<p>As you can see, there were some errors with your input.</p>";
    echo "<p><a class=\"btn btn-default\" href=\"index.php\">Go Back</a> and try again?</p>";
}

echo "</div></body></html>"; //end of page structure on processing page to make the short-lived page look nicer

