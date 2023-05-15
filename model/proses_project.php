<?php
    include 'connect.php';
    // require_once 'file_upload.php';
    date_default_timezone_get();

    // Enter your table Name;
    $tableName='projects'; 

    // fetching files from database
    // $fetchFiles=fetch_files($tableName);

    $array_img = [];
    
    if(isset($_POST)){
        $id_project = $_POST['id_project'];
        $nama       = $_POST['nama'];
        $datetime   = $_POST['datetime'];
        $price      = $_POST['price'];
        $status     = $_POST['status'];
        if(isset($_FILES['img_file'])){
             // Loop melalui setiap file yang diunggah
            foreach($_FILES['img_file']['tmp_name'] as $key => $tmp_name) {
                $nama_file = $_FILES['img_file']['name'][$key];
                $tipe_file = $_FILES['img_file']['type'][$key];
                $ukuran_file = $_FILES['img_file']['size'][$key];
                $data_file = file_get_contents($tmp_name);
                array_push($array_img, $nama_file);
            }
        }
    }

    $string_img = implode(",", $array_img);

    switch($_POST['kelola']){
        case 'tambah':
            $query = "INSERT INTO ".$tableName." VALUE('$id_project', '$nama', '$datetime', '$price', '$status', '$string_img')";
            // echo upload_files($tableName, $id_project);
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Added Successfully";
            }
            // header('Location: ../index.php');
            break;
        case 'ubah':
            $query = "UPDATE ".$tableName." SET `id_project`='$id_project', `nama`='$nama', `datetime`='$datetime', `price`='$price', `status`='$status', `img`='' WHERE `id_project` = '$id_project'";
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Edited Successfully";
            }
            break;

        case 'hapus':
            $query = "DELETE FROM ".$tableName." WHERE `id_project` = '$_POST[id_project]'";
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Deleted Successfully";
            }
            break;
    }


