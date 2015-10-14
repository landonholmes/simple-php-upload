<html>
    <head>
        <title>PHP HW3</title>
        <link href="./assets/css/bootstrap.min.css" rel="stylesheet">
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
                            $img = trim($_GET["fileName"]);
                        } else{
                            $img = 'thumb.png';
                        }
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3>Uploaded file:</h3>
                        </div>
                        <div class="panel-body">
                            <img src="uploads/<?php echo"$img"; ?>" class="img-thumbnail"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <script src="./assets/js/bootstrap.min.js" type="javascript"></script>
    <script src="./assets/js/jquery.min.js" type="javascript"></script>
    </body>
</html>