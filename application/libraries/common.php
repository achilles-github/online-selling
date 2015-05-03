<?php

/**
 * Layout management library based on:
 * http://codeigniter.com/wiki/layout_library/ *
 * Extended layout placeholders and javascript and css files inclussion.
 */
class Common
{
    function send_mail($to=NULL, $from=NULL, $subject=NULL,$body=NULL,$from_name=NULL,$bcc="") {
        if($from_name == NULL)
        {
            $name = "Minddna Team";
        }
        else
        {
            $name = $from_name;
        }
		$headers = "";
		$headers .= 'From: '.$name.' <'.$from.'>' . "\n";
		$headers .= 'MIME-Version: 1.0'. "\n";
		$headers .= "Content-Type: text/HTML; charset=ISO-8859-1\n";
		if($bcc != "")
		{
		    $headers .= 'Bcc: '.$bcc."\n";
		}
		mail($to,$subject,$body,$headers);      
    }
    function upload_image($filename = NULL)
	{
		if($filename)
		{
			$image_name = str_replace(" ","",$filename);
			$image_name = time().$image_name;
			$this->load->library('upload');
			$config['upload_path'] = './upload/products/';
			$config['file_name'] = $image_name;
			$config['allowed_types'] = 'gif|jpg|jpeg|png|PNG|JPEG|JPG|GIF';
			$config['max_width'] = '5000';
			$config['max_height'] = '5000';
			//echo (1920*1280)/1024/1024;
			$this->upload->initialize($config);
			if (!$this->upload->do_upload("image")){
				$error = $this->upload->display_errors(); 
				
				return array('error' => "<span class='error_block'>".$error."</span>", 'status' => false);
				//echo $error;
			} 
			else 
			{
				$uploadedDetails    = $this->upload->data();
				$image['image'] = $uploadedDetails['file_name'];
			  
				$this->load->library('image_lib');
				$configThumb = array();  
				$configThumb['maintain_ratio'] = FALSE;
				$configThumb['image_library']   = 'gd2';  
				$configThumb['source_image']    = $uploadedDetails['full_path'];
				$configThumb['quality'] = "100%";	
				$configThumb['new_image'] = "./upload/products/thumb/".$uploadedDetails['file_name'];
				$configThumb['width']           = 150;  
				$configThumb['height']          = 150;  
				$this->image_lib->initialize($configThumb);
				$this->image_lib->resize();
				return array('error' => "", 'status' => $uploadedDetails['file_name']);
			}
		}
		else
		{
			return array('error' => "", 'status' => false);
		}
       }
       function remove_file($folder,$image_name) 
       { 
		$folder_url = $folder;
		if(file_exists($folder_url.$image_name)) 
		{
			@unlink($folder_url.$image_name);
		}
	}
}

?>
