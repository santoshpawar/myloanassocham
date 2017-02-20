<?php

class Asset_controller extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}
	
	function index(){
	
		$this->load->config("assets");
		$asset_folder = $this->config->item("assets_path");
		$type = $this->uri->segment(2);
		$level = $this->uri->segment(3);
		$files_path = "$asset_folder/$level/$type/";
		$ext = ".$type";
		$file = $this->uri->segment(4);
		if($type == 'js'){
			Header("Content-type: text/javascript");
			}elseif($type == 'css'){
				Header ("Content-type: text/css");
			}
			 ob_start();
			 require_once($files_path.$file.$ext);
			 $output=ob_get_contents();
			 ob_end_clean()	;
			 //echo  str_replace("<PATH_IMG>",base_url()."assets/$level/images/",$output);
			 echo  str_replace(array("<PATH_IMG>","<PATH_CSS>","<PATH_FONT>"),array(base_url()."assets/$level/images/",base_url()."assets/$level/css/",base_url()."assets/$level/font/"),$output);
			
		}
	}

?>