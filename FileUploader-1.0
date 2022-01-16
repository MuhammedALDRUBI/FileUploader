<?php


class FileUploader{

    public  $file_extenssion;
    public  $fileFullName;
    public  $type;
    public  $tmp_name; // Dosya geçici yer
    public  $size;
    public  $fianlFileName; //Dosyanin ismi son hali (veritabanda kaydetmek iÇin lazımdır )
    public  $fianlFilepath; //Dosya Alınacak yer

    private $file_uploading_hatalari = array();
    private bool $exentenssionStatus = false;

    const allowedExtenssions = array("pdf" , "jpg" , "jpeg" , "docx" , "pptx");

    public  function __construct($file)
    {
        $this->type =  $file["type"];
        $this->tmp_name =  $file["tmp_name"];
        $this->size =  $file["size"];
        $this->fileFullName =  $file["name"];
        $this->checkExtenssionStatus();     
        return $this;
    } 

    public function getErrorMessages(){
        return  $this->file_uploading_hatalari;
    } 

    public function uploadFile(){
        if($this->exentenssionStatus == true ){
            if(move_uploaded_file($this->tmp_name , $this->fianlFilepath) == true){
                return true;
            }else{
                $this->file_uploading_hatalari[] = "File hasn't been uploaded ... please try again !";
                return false;
            }
        }
        $this->file_uploading_hatalari[] = "File hasn't been uploaded ... please try again !";
        return false;
    }

   
 
    private function checkExtenssionStatus(){
        $file_name_array = explode("." , $this->fileFullName);
        if(count($file_name_array) > 2){
            $this->file_uploading_hatalari[] = "Invalid File Extenssion !";
            $this->exentenssionStatus = false;
            return false;
        }
        $file_extenssion = end($file_name_array);
        $this->file_extenssion = strtolower($file_extenssion);

        if(in_array($this->file_extenssion , self::allowedExtenssions)){
            $this->exentenssionStatus = true;
            return true;
        }
        $this->file_uploading_hatalari[] = "Invalid File Extenssion !";
        $this->exentenssionStatus = false;
        return false;
    }
 
    public function getSet_fianlFileName($folder_path , $prefix){
        $folder_path = $folder_path[strlen($folder_path) - 1] == "/" ? $folder_path : $folder_path . "/";

        if($this->exentenssionStatus == true ){   
            $this->fianlFileName = uniqid($prefix , true) . "." . $this->file_extenssion;
            $this->fianlFilepath = $folder_path . $this->fianlFileName;
            return $this->fianlFileName;
        }
        $this->file_uploading_hatalari[] = "File Name hasn't been changed !";
        return null;
    }
}
