<!-- <section id="banner-area" class="banner-area">
	<div class="container-fluid">
		<div class="row"> <img src="<?php echo base_url()?>assets/front/images/inner-banner.jpg" alt=""/> </div>
	</div>
</section> -->
<style type="text/css" media="screen">
	table.table tr th{background-color:#FF9900 !important; font-color:white !important;}
	
</style>
<?php $this->view('slide') ?>
<section id="inner-pages">
	<div class="container">
		<?php
		if($this->session->userdata('error_message')){ ?>
		<script>
			$(document).ready(function(){
			//$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<?php echo "<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong>Email Id exist! Please use another email.</strong></span>";
	$this->session->set_userdata('error_message','');
} 

?>
<div class="row">
	<h2 class="left-padding module-head text-center">Track Your Application</h2>
	<form id="hold_frm" method="post" action="<?php echo base_url();?>home/track_your_application" class="div-margin" style=" border-radius: 0px;">
		<div class="col-lg-6">Enter Your Application Refrance  No<br>
			<input type="text" required name="refNo" id="refNo" class="module-input" value="<?php if(isset($refNo)){ echo $refNo;}?>">
		</div>
		
		<div class="col-lg-6">Mobile No:<br> 
			<input type="text" required   name="mobileNo" id="owner_name" class="module-input" value="<?php if(isset($mobileNo)){ echo $mobileNo;} ?>">
		</div>
		<div class="col-lg-2 col-sm-6 col-xs-12 text-right" style="margin-top:15px;">
			<button type="submit" id="contact_btn" class="btn btn-default">Submit</button>
		</div>
		<div class="col-lg-2 col-sm-6 col-xs-12" style="margin-top:15px;">
			<button type="button" class="btn btn-default">Cancel</button>
		</div>
	</form>
</div>
<?php
if(!empty($status)){ ?>
<div class="row div-margin"  style="border-radius: 0px;">
	<div style=" margin: 0 auto;    width: 750px;"><div class="left-padding  text-center">Your Application Status</div>
	<div class="inner-pages">

		<table class='table table-striped'>
			<thead>
				<tr>
				<?php 
				 	 
				if(!empty($status[0]->bank_name)){ ?>
					<th>Bank</th>
					<?php } ?>
					<th>Status</th>
				</tr>
			</thead>
			<?php 
			foreach ($status as $value) { 

				if(!empty($value->bank_name)){
		 echo '<tbody>
					<tr>
						<td>'.$value->bank_name.'</td>
						<td>'.$value = ($value->bankStatus==1) ? "  In Principle Approved" : "  Rejected".'</td>
					</tr>
				</tbody>';
			}else{
				if($value->loanStatus =='0'){
					 echo '<tbody><tr><td>Forward to Analyst</td></tr></tbody>';
				}elseif ($value->loanStatus =='2') {
					 echo '<tbody><tr><td>Forward to Analyst</td></tr></tbody>';
					//echo "Forward to Analyst";
				}else{
					 echo '<tbody><tr><td>Forward to Bank</td></tr></tbody>';
					//echo "Forward to Bank";
				}
			}
		} ?>
	</table>
</div>
</div>
</div>

<?php }elseif(isset($error)){ ?>
<div class="row div-margin" >
	<div class="col-lg-4">Application not found please enter valid details<br>
	</div>
</div>
<?php } 

?>
</section>