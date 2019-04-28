<?php
$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $res->status = "File is not an image.";
        $res->statusCode = 0;
        $uploadOk = 0;
    }
}

// Check file size
if ($_FILES["fileToUpload"]["size"] > 50000000) {
    $res->status = "Sorry, your file is too large.";
    $res->statusCode = 0;
    $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
    $res->status = "Sorry, only JPG, JPEG & PNG files are allowed.";
    $res->statusCode = 0;
    $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $res->statusCode = 0;
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        $res->status = "The file has been uploaded.";
        $res->statusCode = 1;
        $res->fileName = basename( $_FILES["fileToUpload"]["name"]);
    } else {
        $res->status = "Sorry, there was an error uploading your file.";
        $res->statusCode = 0;
    }
}
$resJSON = json_encode($res);
echo $resJSON;
?>