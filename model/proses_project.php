<?php
    include 'connect.php';
    date_default_timezone_get();

    // Enter your table Name;
    $tableName='projects';

    $array_img = [];

    $query = mysqli_query($connect, "SELECT * FROM ".$tableName." WHERE id_project = '$_POST[id_project]'");
    while($data=mysqli_fetch_array($query)){
        $tmp_img_name = $data[5];
    }
    
    if(isset($_POST)){
        $id_project = $_POST['id_project'];
        $nama       = $_POST['nama'];
        $datetime   = strtotime($_POST['datetime']);
        $price      = $_POST['price'];
        $status     = $_POST['status'];

        if(isset($_POST['delete_img'])){
            $delete_img = $_POST['delete_img'];
        }

        // Membuat folder baru untuk menyimpan gambar
        if(!file_exists("../assets/img/portofolio/".$id_project)){
            mkdir("../assets/img/portofolio/".$id_project);
        }

        
        if(isset($_FILES['img_file'])){
            $originalArray = explode(',', $tmp_img_name);

            // Loop melalui setiap file yang diunggah
            foreach($_FILES['img_file']['tmp_name'] as $key => $tmp_name) {
                $nama_file = $_FILES['img_file']['name'][$key];
                $tipe_file = $_FILES['img_file']['type'][$key];
                $ukuran_file = $_FILES['img_file']['size'][$key];

                if($nama_file != ""){
                    $data_file = file_get_contents($tmp_name);
                    if($_POST['kelola'] == 'edit'){
                        array_push($originalArray, $nama_file);
                    }else{
                        array_push($array_img, $nama_file);
                    }
                    
                    // Memindah file ke folder
                    $uploaded_path = '../assets/img/portofolio/'.$id_project.'/'.$nama_file;
                    move_uploaded_file($tmp_name, $uploaded_path);
                }
            }

            if($_POST['kelola'] == 'edit'){
                $string_img = implode(",", $originalArray);
            }else{
                $string_img = implode(",", $array_img);
            }
            
        }else{
            $string_img = "";
        }
    }

    switch($_POST['kelola']){
        case 'tambah':
            $query = "INSERT INTO ".$tableName." VALUE('$id_project', '$nama', '$datetime', '$price', '$status', '$string_img')";
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Added Successfully";
            }else{
                unlink($uploaded_path);
                echo "Failed Adding Data: ".mysqli_error($connect);
            }
            header('Location: ../projects/tabel_project.php');
            break;
        case 'edit':
            // Hapus gambar yang dicentang di kelola_project
            if(isset($delete_img)){
                $originalArray = explode(',', $tmp_img_name);
                foreach($delete_img as $img){
                    $path = realpath('../assets/img/portofolio/'.$id_project.'/'.$img);
                    unlink($path);

                    // Menghapus nilai pada array
                    foreach ($originalArray as $key => $value) {
                        if ($value == $img) {
                            unset($originalArray[$key]);
                        }
                    }
                }

                $string_img = implode(",", $originalArray);
            }

            if(empty($string_img) == 0){
                $query = "UPDATE ".$tableName." SET `id_project`='$id_project', `name`='$nama', `timestamp`='$datetime', `price`='$price', `status`='$status', `img`='$string_img' WHERE `id_project` = '$id_project'";
            }else{
                $query = "UPDATE ".$tableName." SET `id_project`='$id_project', `name`='$nama', `timestamp`='$datetime', `price`='$price', `status`='$status' WHERE `id_project` = '$id_project'";
            }
            
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Edited Successfully";
            }else{
                echo mysqli_error($connect);
            }
            header('Location: ../projects/tabel_project.php');
            break;

        case 'hapus':
            $query = "DELETE FROM ".$tableName." WHERE `id_project` = '$_POST[id_project]'";
            $path = realpath('../assets/img/portofolio/'.$id_project);

            if(mysqli_query($connect, $query)){
                // Hapus folder gambar
                array_map('unlink', glob("$path/*.*"));
                rmdir($path);

                // send message to table log_activities
                echo "Data Deleted Successfully";
            }
            header('Location: ../projects/tabel_project.php');
            break;
    }


