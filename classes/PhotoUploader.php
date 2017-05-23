<?php

class PhotoUploader
{
    private $max_img_size = 2000000;

    function uploadImg($file, $target_dir = "./fotos_carnet/")
    {
        $file_name = $file['name'];
        $file_type_browser = $file['type'];
        $file_size = $file['size'];
        $file_tmp_name = $file['tmp_name'];
        $file_error = $file['error'];
        $target_file = $target_dir . basename($file_name);
        $file_type = pathinfo($target_file, PATHINFO_EXTENSION);

        if (!$this->checkImg($file_tmp_name))
            return false;
        if (!$this->exists($target_file))
            return false;
        if (!$this->checkSize($file_size))
            return false;
        if (!$this->isValidType($file_type))
            return false;

        if (move_uploaded_file($file_tmp_name, $target_file)) {
            echo "The file " . basename($file_name) . " has been uploaded.";
            return [true, $target_file];
        } else {
            echo "Sorry, there was an error uploading your file.";
            return false;
        }
    }

    function checkImg($file_tmp_name)
    {
        $check = getimagesize($file_tmp_name);
        if ($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            return true;
        } else {
            echo "File is not an image.";
            return false;
        }
    }

    function exists($target_file)
    {
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            return false;
        } else
            return true;
    }

    function checkSize($file_size)
    {
        if ($file_size > $this->max_img_size) {
            echo "Sorry, your file is too large.";
            return false;
        } else
            return true;
    }

    function isValidType($file_type)
    {
        $file_type = strtolower($file_type);
        if ($file_type != "jpg" && $file_type != "png" && $file_type != "jpeg" && $file_type != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            return false;
        } else
            return true;
    }
}

/*
   $file_name = $_FILES['fichero_usuario']['name']

   $file_type $_FILES['fichero_usuario']['type']

   $file_size $_FILES['fichero_usuario']['size']

   $file_tmp_name = $_FILES['fichero_usuario']['tmp_name']

   $file_error = $_FILES['fichero_usuario']['error']

   $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
 */