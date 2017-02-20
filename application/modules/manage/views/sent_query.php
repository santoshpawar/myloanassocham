<script type="text/javascript" src="<?php echo base_url()?>assets/shared/js/jquery.validate.js"></script>
<script type="text/javascript" language="javascript">
$(document).ready(function(){
	var v = $("#hold_frm").validate({

				rules:{
						'message': {
							required: true
						},
					  }
				});	
	
});

</script>
<?php if(!empty($sent_list)) { ?>
      <div class="content-wrapper select inboxwrp">
        <div class="clear"></div>
        <div class="p100">
		<h5 class="tab-form-head">Loan Application ID #<?php if(!empty($sent_list)) { echo $sent_list[0]->application_id; } ?><?php if(!empty($user_details)) { ?>, <span class="small-text"><?php echo $user_details[0]->bank_name; ?></span><?php } else { ?> <span class="small-text"> </span><?php } ?></h5>
		<div class="col-sm-12">
        
        <div class="clear"></div>
        <!--<div class="col-lg-1"></div>-->
		 <?php foreach($sent_list as $val){ ?>
		<?php if($val->utype_id==4){
			$bankusername['uid']=$val->post_from;
			$other["tables"]="TBL_BANK_MASTER";	
			$bank_details=$this->admin_model->getUserDetails($bankusername,$other);
			//print_r($bank_details);
			unset($other["tables"]);
			$username=$bank_details[0]->bank_name;
			} else if($val->utype_id==3){
			$analystusername['uid']=$val->post_from;
			$other["tables"]="TBL_ANALYST";	
			$analyst_details=$this->admin_model->getUserDetails($analystusername,$other);
			unset($other["tables"]);
			$username=$analyst_details[0]->analyst_name;
			} else if($val->utype_id==2){
			$channelusername['uid']=$val->post_from;
			$other["tables"]="TBL_CHANNEL_PARTNER";	
			$channel_details=$this->admin_model->getUserDetails($channelusername,$other);
			unset($other["tables"]);
			$username=$channel_details[0]->advisor_name;
			}else{
			$msmeusername['uid']=$val->post_from;
			$other["tables"]="TBL_MSME";	
			$msme_details=$this->admin_model->getUserDetails($msmeusername,$other);
			unset($other["tables"]);
			$username=$msme_details[0]->enterprise_name;	
			} 
		$GMT = new DateTimeZone("GMT");
		$date_post=new DateTime($val->massage_sent_time,$GMT);
		$date_time=new DateTime($val->massage_sent_time,$GMT);
		?>
       
        <div class="col-lg-11 <?php if(isset($post_from)&& $post_from!=$val->post_from) echo "replied rightside"?> <?php if(isset($post_from) && $post_from==$val->post_from){ echo "repliedans leftside";}?>"><?php echo $val->message; ?><br><?php if($val->attachment!=''){?><a href="<?php echo base_url();?>uploads/message/<?php if($val->attachment!=''){ echo $val->attachment;} ?>" target="_blank">Attachment:<?php if($val->attachment!=''){ echo $val->attachment;;} ?></a><?php } ?>
        <span class="right-float small-text red-text"><?php if(isset($username)){echo ucwords($username);}?>, <?php echo $date_post->format('d/m/Y');?>, <?php echo $newDateTime = date('h:i A', strtotime($val->massage_sent_time)); ?></span>
			<div class="clear"></div>
        </div>
        <?php if(isset($post_from) && $post_from!=$val->post_from){?>
            <div class="clear"></div>
            <div class="col-lg-1"></div>
            <?php } ?>    
        
		<?php  } }else { ?>
        
			<div class="col-lg-11 replied rightside"><?php echo "No message found."; ?><br>
			
			</div>
			 <?php } ?>        
        <div class="clear"></div>
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
        <form name="sent_frm" id="hold_frm" enctype="multipart/form-data" method="post" action="<?php echo base_url();?>manage/dashboard/save_query">
        <div class="col-lg-12"><textarea name="message" id="message" title="Message cannot be empty" class="module-text"></textarea></div>
		<input type="hidden" name="utype_id" value="<?php echo $sent_list[0]->utype_id;  ?>" />
		<input type="hidden" name="message_id" value="<?php echo $sent_list[0]->message_id;  ?>" />
		<input type="hidden" name="post_from" value="<?php echo $sent_list[0]->post_from;  ?>" />
		<input type="hidden" name="application_id" value="<?php echo $sent_list[0]->application_id;  ?>" />
			<div class="col-lg-12"><div class="pull-right">Attachment</div><div class="clear"></div></div>
			<div class="col-lg-12"><div class="pull-right"><label class="btn btn-primary yellow-button">
    	<input type="file" name="attachment" id="attachment" style="display:none;" onchange="$('#upload-file-info').html($(this).val());">BROWSE FILE</label>
        <span class="label label-info" id="upload-file-info"></span></div><div class="clear"></div></div>
		<div class="clear"></div>
		<div class="col-sm-12 sendbuttonwrp"><div class="pull-right"><button class="yellow-button" style="margin:6px 0 10px 0;">SEND</button></div><div class="clear"></div></div>
		</form>
           
        </div>
        </div>           
      </div>
