# FileUploader_Class-2.0

##to uploading multiple files by php :

your input type and name must be like this
<b>&lt; input type="file" name="photoes[]" multiple &gt;</b>

you can upload files that end with this extenssions : pdf , jpg , jpeg , png , docx , pptx .
you can add the extenssion that you want by add a new extenssion to the static array properity $allowedExtenssions like this :
<b>$allowedExtenssions[] = "mp4" ; (Note that extenssion letters must be lower case letters) .</b>
or like this :
<b>array_push($allowedExtenssions , "mp4");</b>


to start uploading the files you must use the static method 
<b>upload($File_key_from_FILES_Array , $uploading_folder_path , $prefix , $max_size = 31457280 ) </b>
where :

<b>$File_key_from_FILES_Array is like this $_FILES["photoes"]  .</b>

 <b>$uploading_folder_path is the path of uploading folder (uploaded files will be uploaded into this folder) , its value may be like "./testFolder/" or "./testFolder" .</b>
 
<b>$prefix is the piece of text that you want to add it to the files name (filename will be like this "your prefix" + uniqid) .</b>

<b>$max_size is default 30 MB ...... if you want to change it you must pass the argument to this parameter .</b>

if uploading faild you can check the uploading errors by static method : getErrorMessages()

Don't forget to Support me on :
<p>Facebook : https://www.facebook.com/MDRDevelopment</p>
<p>instagram : https://www.instagram.com/mdr_development_tr</p>
