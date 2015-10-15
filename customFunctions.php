<?php
/**
 * Created by IntelliJ IDEA.
 * User: Landon
 * Date: 2015.09.30
 * Time: 18:12 PM
 */
//helper function i'll need later
function formatSizeUnits($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

//looks for ajax call
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'getUploadedPhotos' : echo getUploadedPhotos(); break;
        case 'removeUploadedPhoto' : echo removeUploadedPhoto($_POST['photoName']); break;
    }
}

function getUploadedPhotos() {
    exec('ls ./uploads',$output,$error);
    $uploadedPhotosArr = array();
    while(list(,$row) = each($output)){
        array_push($uploadedPhotosArr,$row);
    };

    return json_encode($uploadedPhotosArr);
}

function removeUploadedPhoto($photoName) {
    exec('ls ./uploads',$output,$error); //let's get the available images
    $uploadedPhotosArr = array();
    while(list(,$row) = each($output)){
        array_push($uploadedPhotosArr,$row);
    };

    if (in_array($photoName,$uploadedPhotosArr)) { //want to make sure the image is actually available before we try to delete it
        $command = 'rm ./uploads/'.$photoName;
        exec($command);
        return json_encode('true');
    } else {
        return json_encode('false');
    }
}
