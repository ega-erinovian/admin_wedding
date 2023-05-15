<?php
    include 'connect.php';
    require_once 'file_upload.php';
    date_default_timezone_get();

    // Enter your table Name;
    $tableName='projects'; 

    // fetching files from database
    // $fetchFiles=fetch_files($tableName);

    
    if(isset($_POST)){
        $id_project = $_POST['id_project'];
        $nama       = $_POST['nama'];
        $datetime   = $_POST['datetime'];
        $price      = $_POST['price'];
        $status     = $_POST['status'];
        $img = $_FILES['img']['name'];
        // if(isset($_FILES)){
        //     echo $_FILES['img_file']['name'];
        // }
    }

    switch($_POST['kelola']){
        case 'tambah':
            $query = "INSERT INTO ".$tableName."VALUE('$id_project', '$nama', '$datetime', '$price', '$status', '')";
            // echo upload_files($tableName, $id_project);
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Added Successfully";
            }
            // header('Location: ../index.php');
            break;
        case 'ubah':
            break;
    }


