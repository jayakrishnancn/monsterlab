<?php
class file
{
    private $upload_errors;
    public $fileinfo=null;
    function __construct()
    {
        $upload_errors = array(
            // http://www.php.net/manual/en/features.file-upload.errors.php
            UPLOAD_ERR_OK           => "No errors.",
            UPLOAD_ERR_INI_SIZE     => "Larger than upload_max_filesize.",
            UPLOAD_ERR_FORM_SIZE    => "Larger than form MAX_FILE_SIZE.",
            UPLOAD_ERR_PARTIAL      => "Partial upload.",
            UPLOAD_ERR_NO_FILE      => "No file.",
            UPLOAD_ERR_NO_TMP_DIR   => "No temporary directory.",
            UPLOAD_ERR_CANT_WRITE   => "Can't write to disk.",
            UPLOAD_ERR_EXTENSION    => "File upload stopped by extension."
        );
    }
    public function uploadfile($name='',$upload_dir='uploads/',$disp_error=false)
    {
        if( (!isset($name)) || (empty($name)))
        {
            $msg="form name not set";
            log_message("info",$msg.__FILE__."".__LINE__);
            return ($disp_error)?$msg:false;
        }
        // process the form data

        $tmp_file = $_FILES[$name]['tmp_name'];
        $this->fileinfo=$_FILES[$name];
        $target_file = basename($_FILES[$name]['name']);

        if(!file_exists($upload_dir))
        {
            $msg="file directory donsnt exist";

            log_message("info",$msg.__FILE__.__LINE__);

            return ($disp_error)?$msg:false;
        }


        // move_uploaded_file will return false if $tmp_file is not a valid upload file 
        // or if it cannot be moved for any other reason
        if(move_uploaded_file($tmp_file, $upload_dir.$target_file)) 
        {
            $msg="File uploaded successfully.";

            log_message("info",$msg);

            return ($disp_error)?$msg:true;

        } 
        else 
        {
            $error = $_FILES['file_upload']['error'];
            $msg=$$this->upload_errors[$error]." file upload failed ";

            log_message("error",$msg.__FILE__.__LINE__);

            return ($disp_error)?$msg:false;
        }
    
    }
}