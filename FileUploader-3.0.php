<?php

// FileUploader v3.0 For single and multi file uploading --- it has been developed By MDR Development (whatsapp : +905375453731)
class FileUploader{

    static private  $fileName;  // File name that will be taken from $_FILES["key"]["name"]
    static private  $file_extenssion; // file Extenssion
    static private  $tmp_name; // file temporary path
    static private  $size; // file size by bit
    static private  $FileFinalName;  // file final name after changing ( you will need this name to save it in database)
    static private  $FileFinalpath;  //file final path (where it will be moved)
    static private $FileFinalName_after_changing_name = array(); // array of FileFinalpath (that will be returned if upload function has succeeded)    static private  $maxSizeByByte ; // (default 30 MB and it take its value from set) .... Not : 1 KB = 1024 Byte , 1 MB = 1024 KB 
    static public  $allowedExtenssions = array("pdf" , "jpg" , "jpeg" , "png", "docx" , "pptx");
    static private  $maxSizeByByte ; // (default 30 MB and it take its value from set) .... Not : 1 KB = 1024 Byte , 1 MB = 1024 KB 
  
    ///////////////////////////////////////////////////////////////////////////////////////
    //use this static method to upload single file or multi files
    //
    // $File_key_from_FILES_Array : is the key that will come from $_FILES (like this : $_FILES["photo"])
    // $uploading_folder_path : This is the folder to which the files will be transferred (argument must be path string)
    // $multipleUploading : for multiple or single file uploading  (argument must be booleean)
    // $sameFileName : if true the FileFinalName will be the same name that comes from $_FILES 
    // $newFileNameWithoutExtenssion : if $sameFileName == false you can give thiis parameter an argument (defaul value is empty) to set a new name for file (if you are uploading multi files dont't use it)
    // $prefix : if $sameFileName == false you can give thiis parameter an argument to concatination a text with file name 
    //$max_size = 31457280 : max file size that can be uploaded (by dit)
    //
    //
    //
    // this methos will return array of FileFinalName those have been uploaded
    // if an error is found (folder not found , or extenssion error) : will return the Exception that you can write it
    ///////////////////////////////////////////////////////////////////////////////////////
    static public function upload($File_key_from_FILES_Array , $uploading_folder_path , $multipleUploading = false , $sameFileName = true , $newFileNameWithoutExtenssion = "" , $prefix = "" , $max_size = 31457280 ){
        try{
            $countOfIteration = !$multipleUploading ? 1 : count($File_key_from_FILES_Array["name"]);
            for($i=0;$i<$countOfIteration;$i++){
                //set file informations to check extenssion and size then file name will be changed to $FileFinalName
                $fileName = !$multipleUploading ? $File_key_from_FILES_Array["name"] : $File_key_from_FILES_Array["name"][$i];
                $file_tmp_name = !$multipleUploading ?  $File_key_from_FILES_Array["tmp_name"] : $File_key_from_FILES_Array["tmp_name"][$i];
                $file_size = !$multipleUploading ? $File_key_from_FILES_Array["size"] : $File_key_from_FILES_Array["size"][$i];

                if(self::setFileInfo($fileName , $file_tmp_name , $file_size , $max_size)){
                    if(!self::checkExtenssionStatus()){throw new Exception("About : " . self::$fileName . " , File 's Extenssion is invalid ");}
                    if(!self::checkSize()){throw new Exception("About : " . self::$fileName . " , File 's Size is more than " . self::$maxSizeByByte);}

                    $setFinalFileName_proccesing = self::getSet_FileFinalName($uploading_folder_path , $sameFileName , $newFileNameWithoutExtenssion   , $prefix );
                    if(!$setFinalFileName_proccesing){
                        throw new Exception($setFinalFileName_proccesing);
                    }
                }
        
                if(@move_uploaded_file(self::$tmp_name , self::$FileFinalpath) == true){ 
                    continue;
                }else{
                    throw new Exception("About : " . self::$fileName . " , Upload is failed! ... Please try again");
                }
            }
            if(!empty(self::$FileFinalName_after_changing_name)){
                return self::$FileFinalName_after_changing_name;
            }
            throw new Exception("Uploading is failed! ... Please try again");
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    //this method will be used  to set that file's information for each file
    /////////////////////////////////////////////////////////////////////////////////////////
    static private function setFileInfo($fileName , $file_tmp_name , $file_size , $max_size){
        self::$fileName = $fileName;
        self::$tmp_name =$file_tmp_name;
        self::$size =$file_size;
        self::$maxSizeByByte = $max_size;
        return true;
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    //this method will be used to check extenssion for each file
    /////////////////////////////////////////////////////////////////////////////////////////
    static private function checkExtenssionStatus(){
        $file_name_array = explode("." , self::$fileName);
        if(count($file_name_array) > 2){return false;}
        $file_extenssion = end($file_name_array);
        self::$file_extenssion = strtolower($file_extenssion);

        if(in_array(self::$file_extenssion , self::$allowedExtenssions)){
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    //this method will be used to check ths file's size  for each file
    /////////////////////////////////////////////////////////////////////////////////////////
    static private function checkSize(){
        if(self::$size <= self::$maxSizeByByte){
            return true;
        }
        return false;
    }
    /////////////////////////////////////////////////////////////////////////////////////////
    //this method will be used to Handle each file ' name and fail final path where be moved
    /////////////////////////////////////////////////////////////////////////////////////////
    static private function getSet_FileFinalName($folder_path , $sameFileName = true , $newFileNameWithoutExtenssion = "" , $prefix = "" ){
        try{
            $folder_path = $folder_path[strlen($folder_path) - 1] == "/" ? $folder_path : $folder_path . "/";
            if(!self::IsFolderNotFoundCreateIt($folder_path)){ throw new Exception("Folder is not found and didn't create it");}
            
                self::$FileFinalName = self::$fileName;
                if(!$sameFileName){
                    if($newFileNameWithoutExtenssion != ""){
                        $newFileNameWithoutExtenssion = explode("." , $newFileNameWithoutExtenssion)[0];
                        self::$FileFinalName = $prefix . $newFileNameWithoutExtenssion . "." . self::$file_extenssion;
                    }else{
                        self::$FileFinalName = uniqid($prefix , true) . "." . self::$file_extenssion;
                    } 
                }
                
                self::$FileFinalpath = $folder_path . self::$FileFinalName;
                self::$FileFinalName_after_changing_name[] = self::$FileFinalName;
                return true;
        }
        catch(Exception $e){
            return $e->getMessage();
        }
    }
 
    static private function IsFolderNotFoundCreateIt($folder_path){
        if(!file_exists($folder_path)){
                if(@mkdir($folder_path)){return true;}
                return false;
        }
        return true;
    }
}
