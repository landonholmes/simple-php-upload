<html>
    <head>
        <title>PHP HW3</title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
        <link rel="shortcut icon" href="./assets/favicon.ico" type="image/x-icon">
        <link rel="stylesheet" type="text/css" href="./assets/slick/slick.css"/>
        <link rel="stylesheet" type="text/css" href="./assets/slick/slick-theme.css"/>
        <style>
            .slick-prev:before, .slick-next:before{
                color:#31b0d5;
            }

            .slick-slide {
                text-align: center;
            }

            .slick-slide::before {
                content: '';
                display: inline-block;
                height: 100%;
                vertical-align: middle;
            }

            .slick-slide img {
                vertical-align: middle;
                display: inline-block;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <br />
            <div class="row">
                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>PHP Image Upload</h3>
                        </div>
                        <div class="panel-body" style="height: 150px;">
                            <form name="uploadForm" method="POST" class="form" action="uploadFile.php" enctype="multipart/form-data">
                                <input type="file" name="imageUpload" /> <br />
                                <input class="btn btn-info" type="submit" value="Do Uploady Things" />
                            </form>
                        </div>
                        <div class="panel-footer">
                            <a href="README.html">README</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <?php
                        if(isset($_GET["fileName"])){
                            $img = "./uploads/".trim($_GET["fileName"]);
                        } else{
                            $img = './assets/thumb.png';
                        }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Your Uploaded file:</h3>
                        </div>
                        <div class="panel-body" style="height: 191px;">
                            <img src="<?php echo"$img"; ?>" class="img-thumbnail" style="max-height: 160px;"/>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <h2 style="text-align: center">Upload History:</h2>
                <div class="col-md-offset-3 col-md-6">
                    <div class="slick-gallery img-thumbnail" style="height: 400px">
                    </div>

                </div>
            </div>
            <br /><br /><br /><br /><br />
            <div style="position: fixed;bottom: 10px; right: 40px; height: 30px; width: 30px; /*border: 1px red solid;*/" id="notHere">&nbsp;</div>
        </div>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./assets/slick/slick.min.js"></script>

        <script type="text/javascript">
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
                            console.log('New images found. Rebuilding slider..');
                            rebuildSlider(availablePhotos);
                        } else {
                            console.log('No new images found. No action taken.');
                        }
                    }
                    ,error: function(e) {
                        console.log('error when checking for images: ',e);
                    }
                });
            }

            function rebuildSlider(availablePhotosArray) {
                var gallery = $('div.slick-gallery'); //find our slider element
                if ($('div.slick-initialized').length > 0) { //see if it is already intialized, if so, we need to destroy it first
                    gallery.slick('unslick'); //DESTROY!!!!!
                }
                gallery.empty(); //remove all of the photos from the slider

                $.each(availablePhotosArray,function(index,value){ //for each image we have
                    gallery.append("<div class=\"slick-slide\" ><img src=\"./uploads/"+value+"\" style=\"margin: auto auto;\"/></div>"); //add a slide
                });
                startSlider(); //then we need to start the slider

            }

            //function called that starts the slider with specific functions
            function startSlider() {
                $('.slick-gallery ').slick({
                    dots: true
                    ,speed: 500
                    ,autoplay: true
                });
            }

            $("div#notHere").on("dblclick",function(e){
                window.location = "manage.php";
            });
        </script>
    </body>
</html>