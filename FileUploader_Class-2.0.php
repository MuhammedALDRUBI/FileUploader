<?php


class FileUploader{

    static public  $fileName; 
    static public  $file_extenssion;
    static public  $tmp_name;
    static public  $size;
    static public  $FileFinalName; 
    static public  $FileFinalpath; 

     
    static private  $maxSizeByByte ; // (default 30 MB and it take its value from set) .... Not : 1 KB = 1024 Byte , 1 MB = 1024 KB 

    static private  $file_uploading_errors = array();
    static private  $ExentenssionStatus = false;
    static private  $SizeStatus = false;

    static public  $allowedExtenssions = array("pdf" , "jpg" , "jpeg" , "png", "docx" , "pptx");


    static public function getErrorMessages(){
        return  self::$file_uploading_errors;
    }
  

    static public function upload($File_key_from_FILES_Array , $uploading_folder_path , $prefix , $max_size = 31457280 ){
        for($i=0;$i<count($File_key_from_FILES_Array["name"]);$i++){
             
            //set file informations to check extenssion and size then file name will be changed to $FileFinalName
            $fileName = $File_key_from_FILES_Array["name"][$i];
            $file_tmp_name = $File_key_from_FILES_Array["tmp_name"][$i];
            $file_size = $File_key_from_FILES_Array["size"][$i];

            if(self::setFileInfo($fileName , $file_tmp_name , $file_size , $max_size)){
                
                self::checkExtenssionStatus(); 
                self::checkSize();
                self::Set_FileFinalName($uploading_folder_path , $prefix);
            }
 
            if(self::$ExentenssionStatus == true && self::$SizeStatus == true ){
                
                if(move_uploaded_file(self::$tmp_name , self::$FileFinalpath) == true){ 
                    continue;
                }else{
                    self::$file_uploading_errors[] = "About : " . self::$fileName . " , Upload is failed! ... Please try again";
                    continue;
                }
            }
            
            self::$file_uploading_errors[] = "About : " . self::$fileName . " , Upload is failed! ... Please try again";
            continue;
        }
    }

    static private function setFileInfo($fileName , $file_tmp_name , $file_size , $max_size){
        self::$fileName =$fileName;
        self::$tmp_name =$file_tmp_name;
        self::$size =$file_size;
        self::$maxSizeByByte = $max_size;
        return true;

    }
    static private function checkExtenssionStatus(){
        $file_name_array = explode("." , self::$fileName);
        if(count($file_name_array) > 2){self::$ExentenssionStatus = false; return false;}
        $file_extenssion = end($file_name_array);
        self::$file_extenssion = strtolower($file_extenssion);

        if(in_array(self::$file_extenssion , self::$allowedExtenssions)){
            self::$ExentenssionStatus = true;
            return true;
        }
        self::$file_uploading_errors[] = "About : " . self::$fileName . " , File 's Extenssion is invalid ";
        self::$ExentenssionStatus = false;
        return false;
    }
 
    static private function checkSize(){
        if(self::$size <= self::$maxSizeByByte){
            self::$SizeStatus = true;
            return true;
        }
        self::$file_uploading_errors[] = "About : " . self::$fileName . " , File 's Size is more than " . self::$maxSizeByByte;
        self::$SizeStatus = false;
        return true;
    }

    static private function Set_FileFinalName($FolderPath , $prefix){
        
        //checking if folder path has / or not .... if not it will be fixed
        $FolderPath = $FolderPath[strlen($FolderPath) - 1] == "/" ? $FolderPath :$FolderPath . "/";
        
        if(self::$ExentenssionStatus == true && self::$SizeStatus == true){   
            self::$FileFinalName = uniqid($prefix , true) .  "." . self::$file_extenssion;
            self::$FileFinalpath = $FolderPath  . self::$FileFinalName;
            return self::$FileFinalName;
        }
        return null;
    }

}
