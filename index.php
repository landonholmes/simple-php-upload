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
                        <div class="panel-body">
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
                            $img = "./uploads./".trim($_GET["fileName"]);
                        } else{
                            $img = './assets/thumb.png';
                        }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Your Uploaded file:</h3>
                        </div>
                        <div class="panel-body">
                            <img src="<?php echo"$img"; ?>" class="img-thumbnail"/>
                        </div>
                    </div>
                </div>
            </div>
            <hr />
            <div class="row">
                <h2 style="text-align: center">Upload History:</h2>
                <?php  $row = exec('ls ./uploads',$output,$error); ?>
                <div class="col-md-offset-3 col-md-6">
                    <div class="slick-gallery img-thumbnail" style="height: 400px">
                        <?php
                            while(list(,$row) = each($output)){
                                echo "<div class=\"slick-slide\" >
                                        <img src=\"./uploads/$row\" style=\"margin: auto auto;\"/>
                                    </div>";
                            };
                        ?>
                    </div>

                </div>
            </div>
            <br /><br /><br /><br /><br />
        </div>
        <script src="./assets/js/jquery.min.js"></script>
        <script src="./assets/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="./assets/slick/slick.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            /*$('.carousel').carousel();*/
            $('.slick-gallery ').slick({
                dots: true
                ,speed: 500
                ,autoplay: true
                ,onAfterChange: afterChange
            });
        });

        var afterChange = function(slider,i) {
            var slideHeight = jQuery(slider.$slides[i] ).height();
            jQuery(slider.$slider ).height( slideHeight);
        };
    </script>
    </body>
</html>