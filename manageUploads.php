<?php
session_start();

if(!isset($_SESSION['loggedIn'])) {
    header("Location: login.php"); // Redirecting To Home Page
    exit;
}
?>
<html>
    <head>
        <title>Adminy Stuff</title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
    </head>
    <body>
        <div class="container">
            <br /><a href="index.php" style="float:right; margin-top: 40px;">Back</a>
            <h1>Managing Uploads</h1>
            <div class="row availableImages">
                <div class="col-md-4">

                </div>
            </div>
        </div>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>

        <script type="text/javascript">
            $('div.availableImages').on('click','span#removeImage',removeImage);
            var availablePhotos = [];
            var checkForImagesInterval = setInterval(checkForNewImages, 5000);

            $(document).ready(function(){
                checkForNewImages();
            });

            /*this is the call to get uploaded photos*/
            function checkForNewImages() {
                console.log('checking for new images...');
                $.ajax({
                    url: 'customFunctions.php'
                    ,data: {action: 'getUploadedPhotos'}
                    ,type: 'POST'
                    ,success: function(e) {
                        //console.log('success: ',e);
                        var tempPhotoArray = JSON.parse(e);
                        //console.log('availablePhotos: ',availablePhotos);
                        //console.log('tempPhotoArray: ',tempPhotoArray);

                        if (JSON.stringify(availablePhotos)!=JSON.stringify(tempPhotoArray)) { //we can compare this way because we know it is just an array of strings, not objects
                            availablePhotos = tempPhotoArray;
                            console.log('New images found. Rebuilding form..');
                            rebuildAvailableImages(availablePhotos);
                        } else {
                            console.log('No new images found. No action taken.');
                        }
                    }
                    ,error: function(e) {
                        console.log('error when checking for images: ',e);
                    }
                });
            }

            /*this is the call to remove uploaded photos*/
            function removeImage(e) {
                var currentPanel = $(this).closest(".panel-default");
                var photoName = $(this).attr('data-image-name');

                $.ajax({
                    url: 'customFunctions.php'
                    ,data: {action: 'removeUploadedPhoto',photoName:photoName}
                    ,type: 'POST'
                    ,success: function(e) {
                        console.log('success: ',e);
                        if (JSON.parse(e) == "true") {
                            checkForNewImages();
                        } else {
                            console.log('Image deletion fail.');
                        }
                    }
                    ,error: function(e) {
                        console.log('error when removing image: ',e);
                    }
                });
            }

            //rebuilds the body of the available images to delete
            function rebuildAvailableImages(availablePhotosArray) {
                var images = $('div.availableImages');
                images.empty(); //remove all of the photos from the image set

                $.each(availablePhotosArray,function(index,value){ //for each image we have
                    images.append("<div class=\"col-md-3\"><div class=\"panel panel-default\" >" +
                            "<div class=\"panel-heading\">"+value+"<span id=\"removeImage\" data-image-name="+value+" class=\"label label-danger\" style=\"float:right; cursor: hand; margin-top: 2px;\">Exterminate</span></div>" +
                            "<div class=\"panel-body text-center\" style=\"height: 191px;\"><img src=\"./uploads/"+value+"\" style=\"margin: auto auto; max-height:160px; max-width:240px;\"/></div>" +
                        "</div></div>"); //add a panel
                });
            }

        </script>
    </body>
</html>