<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
	  
	  <script type="text/javascript">
function calculateEMI(obj) {                                               
 // Formula: 
 // EMI = (P * R/12) * [ (1+R/12)^N] / [ (1+R/12)^N-1]                               
                
 // isNaN(isNotaNumber): Check whether the value is Number or Not                
    if (!isNaN(obj.value) && obj.value.length !== 0) {
                    
    var emi = 0;
    var P = 0;
    var n = 1;
    var r = 0;                                       
                    
   // parseFloat: This function parses a string 
  // and returns a floating point number
    if($("#outstanding_principle").val() !== "")
       P = parseFloat($("#outstanding_principle").val());
                   
                        
    if ($("#interest_rate").val() !== "") 
      r = parseFloat(parseFloat($("#interest_rate").val()) / 100);

    if ($("#tenure").val() !== "")
        n = parseFloat($("#tenure").val());
                    
    // Math.pow(): This function returns the value of x to power of y 
    // Example: (5^2)
                    
    // toFixed: Convert a number into string by keeping desired decimals                   
                    
    if (P !== 0 && n !== 0 && r !== 0)
    emi = parseFloat((P * r / 12) * [Math.pow((1 + r / 12), n)] / [Math.pow((1 + r / 12), n) - 1]);
              
    $("#emi").val(emi.toFixed(2));
                
  }
}
</script>

<!-- <section id="banner-area" class="banner-area">
  <div class="container-fluid">
    <div class="row"> <img src="<?php echo base_url()?>assets/front/images/inner-banner.jpg" alt=""/> </div>
  </div>
</section> -->
<?php $this->view('slide') ?>
<section id="inner-pages">
  <div class="container">
    <div class="row">
      <h2>EMI Calculator</h2>	  



<!--<table>  
   <tr>
    <td>Outstanding Principle</td>
     <td>
       <input type="text" id="outstanding_principle" onkeyup="calculateEMI(this);">
     </td>
	</tr>
	<tr>
	<td>Interest Rate (%)</td>
     <td>
       <input type="text" id="interest_rate" onkeyup="calculateEMI(this);">
     </td>
	 </tr>
	 <tr>
	 <td>Tenure (in Months)</td>
     <td>
       <input type="text" id="tenure" onkeyup="calculateEMI(this);">
     </td>
	 </tr>
	 <tr>
	 <td>EMI</td>
     <td>
       <input type="text" readonly="true" id="emi">
     </td>
	</tr>                
</table>-->

<!-- EMI Calculator Widget START --><script src="<?php echo base_url()?>assets/front/js/emicalc-loader.min.js"></script><div id="ecww-widgetwrapper" style="min-width:250px;width:100%;"><div id="ecww-widget" style="position:relative;padding-top:0;padding-bottom:280px;height:0;overflow:hidden;"></div><div id="ecww-more" style="background:#333;font:normal 13px/1 Helvetica, Arial, Verdana, Sans-serif;padding:10px 0;color:#FFF;text-align:center;width:100%;clear:both;margin:0;clear:both;float:left;"></div></div><!-- EMI Calculator Widget END -->





      
    </div>
  </div>
  
  
</section>