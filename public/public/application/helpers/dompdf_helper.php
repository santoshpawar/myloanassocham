<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_create($html, $filename='', $stream=TRUE) 
{
	//print_r($filename); die();
    require_once("dompdf/dompdf_config.inc.php");
   	$savein = 'uploads/loan_doc/';
	$filename.=".pdf";
	//die($filename);
    $dompdf = new DOMPDF();
    $dompdf->load_html($html);
    $dompdf->render();
	$canvas = $dompdf->get_canvas();
	$font = Font_Metrics::get_font("arial", "normal","12px");
	
	// the same call as in my previous example
	$canvas->page_text(540, 773, "Page {PAGE_NUM} of {PAGE_COUNT}",
					   $font, 6, array(0,0,0));
    //if ($stream) {
//        $dompdf->stream($filename.".pdf");
//    } else {
//        return $dompdf->output();
//    }
	$pdf = $dompdf->output();             // gets the PDF as a string
	//print_r($html);die("----------".$pdf);
	file_put_contents($savein.str_replace("/","-",$filename), $pdf);           // save the pdf file on server
	//$dompdf->stream($filename.".pdf");  
	unset($html); 
	unset($dompdf); 
	
}
?>