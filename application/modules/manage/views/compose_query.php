<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script>
			$(document).ready(function(){
			var v = $("#hold_frms").validate({
				rules:{
					application_id:{required:true},
					message:{required:true},
					attachment:{required:true},
					}
				});	
				});	
</script>				
<form class="inboxwrp" id="hold_frms" action="<?php echo base_url();?>manage/dashboard/save_compose_query" enctype="multipart/form-data" method="post">
<div class="content-wrapper select inboxwrp" style="border:0px;">
<?php
if($this->session->userdata('error_message')){ ?>
	<script>
		$(document).ready(function(){
			$("#search_error").show().delay(5000).fadeOut('slow');
		})
	</script>
	<span id='search_error' style='color:#1797a2; padding-left:50px;'><strong><?php echo $this->session->userdata('error_message');?></strong></span>
	<?php $this->session->set_userdata('error_message','');
	} ?>
        <div class="p100">
			<div class="col-lg-2">To</div>
			<div class="col-lg-10"><select name="application_id" id="application_id" title="To cannot be empty" class="module-select">
			<option value="">Select</option>
			<?php foreach($loan_list as $val){?>
			<!--<option value="<?php echo $val['application_id'];?>"><?php echo "Loan Application ID#".$val['application_id']. ", " .$val['type_of_facility']. ", " .$val['name_enterprise'];?></option>-->
			<option value="<?php echo $val['application_id'];?>"><?php if(!empty($val['enterprise_name'])){ echo "MSME: ".$val['enterprise_name'];}else{ echo "MSME: "."N/A";} ?>, <?php if(!empty($val['advisor_name'])){ echo "Channel Partner: ".$val['advisor_name']; }else{ echo "Channel Partner: "."N/A";}?>, <?php echo "Facility: ".$val['type_of_facility'];?>, <?php echo "Loan Application ID: ".$val['application_id'];?> </option>
			<?php }?>
			</select></div>
            <div class="clear"></div>
			<div class="col-lg-2">Message</div>
			<div class="col-lg-10"><textarea name="message" id="message" class="module-text" title="Message cannot be empty" style="height:250px;"></textarea></div>
            <div class="clear"></div>
			<div class="col-lg-2">Attachment</div>
			<div class="col-lg-3"><label class="btn btn-primary yellow-button">
    	<input type="file" name="attachment" id="attachment" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info"></span></div>
		<div class="clear"></div>
		<hr class="top-margin20 yellow-hr">
        <div class="col-sm-2"></div>
        <div class="col-sm-3 top-padding10"><button type="submit" id="submit" class="yellow-button">SEND</button></div>
        </div>
      </div>
	  </form>
   
  