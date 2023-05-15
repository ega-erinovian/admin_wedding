<?php
    function upload_files($tableName, $id_project){
        $uploadTo = "../uploads/porto/".$id_project."/"; 
        $allowFileExt = array('jpg','png','jpeg');
        $fileName = array_filter($_FILES['file_name']['name']);
        $fileTempName=$_FILES["file_name"]["tmp_name"];
        $tableName= trim($tableName);

        if(empty($fileName)){ 
           $error="Please Select files..";
           return $error;
         }else if(empty($tableName)){
           $error="You must declare table name";
           return $error;
         }else{
            $error=$storeFilesBasename='';

            foreach($fileName as $index=>$file){     
                $fileBasename = basename($fileName[$index]);
                $filePath = $uploadTo.$fileBasename; 
                $fileExt = pathinfo($filePath, PATHINFO_EXTENSION); 
                if(in_array($fileExt, $allowFileExt)){ 
                    // Upload file to server 
                    if(move_uploaded_file($fileTempName[$index],$filePath)){ 
                        // Store Files into database table
                        $storeFilesBasename .= "('".$fileBasename."'),";     
                    }else{ 
                        $error = 'File Not uploaded ! try again';
                    } 
                 }else{
                   $error .= $_FILES['file_name']['name'][$index].' - file extensions not allowed<br> ';
                 }
            }
            store_files($storeFilesBasename, $tableName, $id_project);
        }
        return $error;
    }

    // File upload configuration 
    function store_files($storeFilesBasename, $tableName, $id_project){
        global $db;
        if(!empty($storeFilesBasename)){
            $value = trim($storeFilesBasename, ',');
            $store="INSERT INTO ".$tableName." (file_name) VALUES('', '', '', '','', '".$value."') WHERE id_project='".$id_project."'";
      
            $exec= $db->query($store);
            if($exec){
                echo "files are uploaded successfully";
            }else{
                echo  "Error: " .  $store . "<br>" . $db->error;
            }
        }
    }
             
    // fetching padination data
    function fetch_files($tableName){
        global $db;
        $tableName= trim($tableName);
        if(!empty($tableName)){
            $query = "SELECT * FROM ".$tableName." ORDER BY id_project DESC";
            $result = $db->query($query);
            if ($result->num_rows > 0) {
                $row= $result->fetch_all(MYSQLI_ASSOC);
                return $row;       
            }else{
                echo "No files are stored in database";
            }
        }else{
            echo "you must declare table name to fetch files";
        }
    }