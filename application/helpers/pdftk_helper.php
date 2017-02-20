<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdf_merge($pdf1 = NULL, $pdf2 = NULL, $output_pdf = NULL) 
{
    require_once("pdftk.php");

	$oTmp = new pdftk_inputfile(array("filename" => $pdf1));
	//die($pdf1."----".$oTmp);
	$oPDFTk = new pdftk();
	$oPDFTk ->setInputFile($oTmp)
			->setInputFile(array("filename" => $pdf2))
			->setOutputFile($output_pdf);
		   
	$oPDFTk->_renderPdf();
	
}
?>