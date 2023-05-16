<?php
    include 'connect.php';
    date_default_timezone_get();

    // Enter your table Name;
    $tableName='projects';

    $array_img = [];

    $query = mysqli_query($konek, "SELECT * FROM ".$tableName." WHERE id_project = '$_POST[id_project]'");
    while($data=mysqli_fetch_array($query)){
        $tmp_img_name = $data[6];
    }
    
    if(isset($_POST)){
        $id_project = $_POST['id_project'];
        $nama       = $_POST['nama'];
        $datetime   = $_POST['datetime'];
        $price      = $_POST['price'];
        $status     = $_POST['status'];

        // Create folder
        mkdir("../assets/img/portofolio/".$nama);

        if(isset($_FILES['img_file'])){
            // Loop melalui setiap file yang diunggah
            foreach($_FILES['img_file']['tmp_name'] as $key => $tmp_name) {
                $nama_file = $_FILES['img_file']['name'][$key];
                $tipe_file = $_FILES['img_file']['type'][$key];
                $ukuran_file = $_FILES['img_file']['size'][$key];
                $data_file = file_get_contents($tmp_name);
                array_push($array_img, $nama_file);

                echo $tmp_name;

                // Memindah file ke folder
                $uploaded_path = '../assets/img/portofolio/'.$nama.'/'.$nama_file;
                move_uploaded_file($tmp_name, $uploaded_path);
            }
        }
    }

    $string_img = implode(",", $array_img);

    switch($_POST['kelola']){
        case 'tambah':
            $query = "INSERT INTO ".$tableName." VALUE('$id_project', '$nama', '$datetime', '$price', '$status', '$string_img')";
            if(mysqli_query($connect, $query)){
                // send message to table log_activities
                echo "Data Added Successfully";
            }else{
                unlink($uploaded_path);
                echo "Failed Adding Data: ".mysqli_error($konek);
            }
            header('Location: ../index.php');
            break;
        case 'edit':
            if(isset($_FILES['img_file'])){
                $array_img = explode(",",$tmp_img_name);

                // Jika nama img berbeda dengan yang didatabase, maka file sebelumnya akan dihapus
                foreach ($array_img as $img) {
                  if($img != $new_img_name){
                      $path = realpath('../assets/img/portofolio/'.$nama.'/'.$tmp_img_name);
                      unlink($path);
                  }
                }
                
                $query = "UPDATE ".$tableName." SET `id_project`='$id_project', `nama`='$nama', `datetime`='$datetime', `price`='$price', `status`='$status', `img`='' WHERE `id_project` = '$id_project'";            
            }else{
                $query = "UPDATE karyawan SET `nama`='$nama', `divisi`='$divisi', `jabatan`='$jabatan', `tipe_kar`='$tipe_kar', `tgl_masuk`='$tgl_masuk', `tgl_selesai`='$tgl_selesai', `email`='$email', `no_telp`='$no_telp', `alamat`='$alamat', `jenis_kel`='$jenis_kel', `status_kar`='$status_kar' WHERE `id_kar` = $id_kar";            
            }
            
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


