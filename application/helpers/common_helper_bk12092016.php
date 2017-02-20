<?php if (!defined('BASEPATH')) exit('No direct script access allowed.');
// Generate unic alfanumaric numbae
function createRandomKey(){
	$amount=4;
	$keysetAlfa = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	$keysetNum = "0123456789";
	$randkey = "";
	for ($i=0; $i<$amount; $i++){
		$randkey .= substr($keysetAlfa, rand(0, strlen($keysetAlfa)-1), 1);
	}
	for($i=0; $i<$amount; $i++){
		$randkey .=substr($keysetNum, rand(0, strlen($keysetNum)-1), 1);
	}
	return $randkey;
}

//product name
function prod($id){
	  if($id){
		$CI =& get_instance();
		$CI->load->model('product/product_model');
 		  $where = array('p.id' => $id);
		  $proRes = $CI->product_model->getProduct($where);
		//sprint_r($proRes);die(); 
		  return $proRes[0]->pro_name;
	  }else{
	    return '';
	  }		
	}
	
	
//group name
function group($id){
	  if($id){
		$CI =& get_instance();
		$CI->load->model('group/group_model');
 		  $where = array('g.id' => $id);
		  $groupRes = $CI->group_model->getGA($where);
		//print_r($groupRes);die(); 
		  return $groupRes[0]->grp_name;
	  }else{
	    return '';
	  }		
	}
	
	
	

function create_excel($headings=array(),$data=array(),$title='data',$filename='data',$ext='xls',$fhead,$fdata)
{
		 $CI =& get_instance();
		 $CI->load->helper('phpexcel');
          // Create new PHPExcel object
          $objPHPExcel = new PHPExcel();

          // Set properties
          $objPHPExcel->getProperties()->setCreator('Creator')
                            ->setLastModifiedBy('Modifier')
                            ->setTitle('Export of ' . $title);

          $sheet = $objPHPExcel->setActiveSheetIndex(0);
                    
                                //print_r($headings);
                            $rn=1; 
							$rn2=1;
							 $cell = 'A';
                              foreach($fhead as $head)
                              {
							    $sheet->setCellValue('A'.$rn++, $head);
								
                              }
							 $cell = 'B';
							 foreach($fdata as $dvalue)
                              {
							    $sheet->setCellValue('B'.$rn2++, $dvalue);
                              }
							
                              
							  $cell = 'A';
                              foreach($headings as $heading)
                              {
                               
							    $sheet->setCellValue(($cell++) . '5', $heading);
                              }
                  
                              $row_num = 5;
                              foreach($data as &$row)
                              {
                                $cell = 'A';
                                ++$row_num;
                                    
                                   // print_r($row);
                                    
                                foreach($row as $value)
                                {
                                 // echo $value;
								  $sheet->setCellValue(($cell++) . $row_num, $value);
                                }
								
                              }
        
          // Rename sheet
          $objPHPExcel->getActiveSheet()->setTitle('Data');
//echo $filename.'.'.$ext;die();
          	if($ext=='xls'){
              header('Content-Type: application/vnd.ms-excel');
			  }
			else if($ext=='csv'){
              header('Content-type: text/csv');
			  }
              header('Content-Disposition: attachment;filename="'.$filename.'.'.$ext.'"');
			  header('Cache-Control: max-age=0');
            // Save it as an excel 2003 file
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, "Excel5");
            $objWriter->save('php://output');
            exit;
      }
	  
	  
	  function create_csv($headings,$data, $filename, $attachment = false, $headers = true) 
	  {
        
        if($attachment) {
            // send response headers to the browser
            header( 'Content-Type: text/csv' );
            header( 'Content-Disposition: attachment;filename='.$filename);
            $fp = fopen('php://output', 'w');
        } else {
            $fp = fopen($filename, 'w');
        }
        
		fputcsv($fp, $headings);
		fputcsv($fp, array(""));
		
		
		foreach ($data as $fields) {
			fputcsv($fp, $fields);
		}
		
		fclose($fp);
        
    }
	
	function count_message($utype_id)
	{//echo $utype_id; exit;
		$CI = &get_instance();
		$CI->load->model('admin_model');
		$id['uid']=$CI->session->userdata('sesuserId');
		if($utype_id==1){
		$other["tables"]="TBL_MSME";	
		$users_details=$CI->admin_model->getUserDetails($id,$other);
		$opt["loan.msme_id"] = $users_details[0]->id;
		$opt["msg_inbox.utype_id IN (3,4)"] = null;
		}else if($utype_id==2){
		$id['usr.uid']=	$CI->session->userdata('sesuserId');
		$other["tables"]="TBL_CHANNEL_PARTNER";	
		$users_details=$CI->admin_model->getUserDetails($id,$other);
		unset($other["tables"]);
		$msme['ms.channel_partner_id']=$users_details[0]->id;	
		$msme_list=$CI->admin_model->getMSMEArray($msme);
		//print_r($msme_list);exit;
		if(!empty($msme_list)){
		$other["list"]="(loan.channel_partner_id=".$users_details[0]->id." or loan.msme_id in(".$msme_list."))";	
		//$opt["loan.channel_partner_id"] = $users_details[0]->id;	
		}else{
		$opt["loan.channel_partner_id"] = $users_details[0]->id;		
		}
		$opt["msg_inbox.utype_id IN (3,4)"] = null;
		}
		else if($utype_id ==3 || $utype_id ==4)
		{
			$opt["msg_inbox.utype_id IN (1,2)"] = null;
		}
		$opt["msg_inbox.is_read"] = 0;
		//$other["tables"]="TBL_MESSAGE";
		if(isset($other["list"])){	
		return $userdet["message"]=$CI->admin_model->getMessage_total($opt,$other);
		}else{
		return $userdet["message"]=$CI->admin_model->getMessage_total($opt);	
		}
		//$count = count($userdet["message"]);
		//return $count;
	}

?>