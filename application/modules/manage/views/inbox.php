      <?php if($utype_id==1){?>
	  <div class="content-wrapper select inboxwrp" style="border:0px;">
        <div class="clear"></div>
        <div class="p100">
			<table class="table inbox-table">
            <thead>
            <tr>
            	<td>Username</td>
            	<td>Application ID</td>
            	<td>Date</td>
            	<td>Time</td>
            	<td>Action</td>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($inbox_list)){?>
            <?php foreach($inbox_list as $val){ ?>
			<?php //print_r($val);?>
			<?php 
			$GMT = new DateTimeZone("GMT");
			$date_post=new DateTime($val['massage_sent_time'],$GMT);
			$date_time=new DateTime($val['massage_sent_time'],$GMT);
			?>
			<?php if($val['utype_id']==4){
			$usernames['uid']=$val['post_from'];
			$other["tables"]="TBL_BANK_MASTER";	
			$bank_details=$this->admin_model->getUserDetails($usernames,$other);
			//print_r($bank_details);
			unset($other["tables"]);
			$username=$bank_details[0]->bank_name;
			?>
			<?php } else{
			$analystusername['uid']=$val['post_from'];	
			$other["tables"]="TBL_ANALYST";	
			$analyst_details=$this->admin_model->getUserDetails($analystusername,$other);
			unset($other["tables"]);
			$username=$analyst_details[0]->analyst_name;
			} ?>
			
            <tr>
				
				<td><?php if(isset($username)){ echo ucwords($username);}?></td>
                <td><?php echo "#".$val['application_id'];?></td>
            	<td><?php echo $date_post->format('d-m-Y');?></td>
            	<td><?php echo $date_time->format('H:i:s');?></td>
            	<!--<td><a href="<?php //echo base_url();?>manage/dashboard/sent_query/<?php echo $val['msg_id'];?>">Reply</a></td>-->
            	<td><a href="<?php echo base_url();?>manage/dashboard/sent_query/<?php echo base64_encode($val['msg_id']);?>">Reply</a> <?php if($val['is_read']==0){?><span class="new_txt">New</span><?php }?></td>
            </tr>
			<?php } }else{?>
			<tr>
            	<td>Your Inbox is empty</td>
            </tr>
			<?php } ?>
            </tbody>
            </table>
       </div>
       </div>
<?php } else if($utype_id==2){?>
	  <div class="content-wrapper select inboxwrp" style="border:0px;">
        <div class="clear"></div>
        <div class="p100">
			<table class="table inbox-table">
            <thead>
            <tr>
            	<td>Username</td>
				<td>MSME/Channel Partner</td>
            	<td>Application ID</td>
            	<td>Date</td>
            	<td>Time</td>
            	<td>Action</td>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($inbox_list)){?>
            <?php foreach($inbox_list as $val){ ?>
			<?php 
			$GMT = new DateTimeZone("GMT");
			$date_post=new DateTime($val['massage_sent_time'],$GMT);
			$date_time=new DateTime($val['massage_sent_time'],$GMT);
			?>
			<?php if($val['utype_id']==4){
			$usernames['uid']=$val['post_from'];
			$other["tables"]="TBL_BANK_MASTER";	
			$bank_details=$this->admin_model->getUserDetails($usernames,$other);
			//print_r($bank_details);
			unset($other["tables"]);
			$username=$bank_details[0]->bank_name;
			?>
			<?php } else{
			$analystusername['uid']=$val['post_from'];	
			$other["tables"]="TBL_ANALYST";	
			$analyst_details=$this->admin_model->getUserDetails($analystusername,$other);
			unset($other["tables"]);
			$username=$analyst_details[0]->analyst_name;
			}
			if($val['channel_partner_id']==0){
			$msme_id['uid']=	$val['msme_id'];
			$other["tables"]="TBL_MSME";	
			$msme_details=$this->admin_model->getUserDetails($msme_id,$other);	
			unset($other["tables"]);
			$msme_name=$msme_details[0]->enterprise_name;
			}else{
			$channels_id['uid']=	$val['channel_partner_id'];	
			$other["tables"]="TBL_CHANNEL_PARTNER";	
			$channel_detailss=$this->admin_model->getUserDetails($channels_id,$other);	
			@$msme_name=$channel_detailss[0]->advisor_name;
			unset($other["tables"]);	
			}
			?>
            <tr>
            	<td><?php if(isset($username)){ echo ucwords($username);}?></td>
            	<td><?php if(isset($msme_name)){ echo ucwords($msme_name);}?></td>
                <td><?php echo "#".$val['application_id'];?></td>
            	<td><?php echo $date_post->format('d-m-Y');?></td>
            	<td><?php echo $date_time->format('H:i:s');?></td>
            	<td><a href="<?php echo base_url();?>manage/dashboard/sent_query/<?php echo base64_encode($val['msg_id']);?>">Reply</a> <?php if($val['is_read']==0){?><span class="new_txt">New</span><?php }?></td>
            </tr>
			<?php } }else{?>
			<tr>
            	<td>Your Inbox is empty</td>
            </tr>
			<?php } ?>
            </tbody>
            </table>
       </div>
       </div>
<?php } else if($utype_id==3){?>	 
	  <div class="content-wrapper select inboxwrp" style="border:0px;">
        <div class="clear"></div>
        <div class="p100">
			<table class="table inbox-table">
            <thead>
			<tr>
            	<td>MSME</td>
            	<td>Channel Partner</td>
            	<td>Application ID</td>
            	<td>Date</td>
            	<td>Time</td>
            	<td>Action</td>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($inbox_list)){?>
			<?php foreach($inbox_list as $val){ ?>
			<?php 
			$GMT = new DateTimeZone("GMT");
			$date_post=new DateTime($val['massage_sent_time'],$GMT);
			$date_time=new DateTime($val['massage_sent_time'],$GMT);
			
			
			$msme_id['uid']=	$val['msme_id'];
			$other["tables"]="TBL_MSME";	
			$msme_details=$this->admin_model->getUserDetails($msme_id,$other);	
			unset($other["tables"]);
			if(!empty($msme_details)){
			@$msme_name=$msme_details[0]->enterprise_name;
			}
			if(!empty($msme_details) && $msme_details[0]->channel_partner_id!=0){
			$channel_id['uid']=	$msme_details[0]->channel_partner_id;
			$other["tables"]="TBL_CHANNEL_PARTNER";	
			$channel_details=$this->admin_model->getUserDetails($channel_id,$other);	
			$channel_name=$channel_details[0]->advisor_name;
			unset($other["tables"]);
			}else{
			$channels_id['uid']=	$val['channel_partner_id'];	
			$other["tables"]="TBL_CHANNEL_PARTNER";	
			$channel_detailss=$this->admin_model->getUserDetails($channels_id,$other);	
			@$channel_name=$channel_detailss[0]->advisor_name;
			unset($other["tables"]);	
			}
			?>
            <tr>
            	<td><?php if(isset($msme_name)){echo ucwords($msme_name);}?></td>
            	<td><?php if(isset($channel_name)){echo ucwords($channel_name);}?></td>
            	<td><?php echo "#".$val['application_id'];?></td>
            	<td><?php echo $date_post->format('d-m-Y');?></td>
            	<td><?php echo $date_time->format('H:i:s');?></td>
            	<td><a href="<?php echo base_url();?>manage/dashboard/sent_query/<?php echo base64_encode($val['msg_id']);?>">Reply</a> <?php if($val['is_read']==0){?><span class="new_txt">New</span><?php }?></td>
            </tr>
			<?php } }else{?>
			<tr>
            	<td>Your Inbox is empty</td>
            </tr>
			<?php } ?>
            </tbody>
            </table>
       </div>
       </div>
<?php } else{?>
	  <div class="content-wrapper select inboxwrp" style="border:0px;">
        <div class="clear"></div>
        <div class="p100">
			<table class="table inbox-table">
            <thead>
            <tr>
            	<td>MSME</td>
            	<td>Channel Partner</td>
            	<td>Application ID</td>
            	<td>Date</td>
            	<td>Time</td>
            	<td>Action</td>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($inbox_list)){?>
            <?php foreach($inbox_list as $val){ ?>
			<?php 
			$GMT = new DateTimeZone("GMT");
			$date_post=new DateTime($val['massage_sent_time'],$GMT);
			$date_time=new DateTime($val['massage_sent_time'],$GMT);
			
			
			$msme_id['uid']=	$val['msme_id'];
			$other["tables"]="TBL_MSME";	
			$msme_details=$this->admin_model->getUserDetails($msme_id,$other);	
			unset($other["tables"]);
			@$msme_name=$msme_details[0]->enterprise_name;
			if(!empty($msme_details)&& $msme_details[0]->channel_partner_id!=0){
			$channel_id['uid']=	$msme_details[0]->channel_partner_id;
			$other["tables"]="TBL_CHANNEL_PARTNER";	
			$channel_details=$this->admin_model->getUserDetails($channel_id,$other);	
			@$channel_name=$channel_details[0]->advisor_name;
			unset($other["tables"]);
			}else{
			$channels_id['uid']=	$val['channel_partner_id'];	
			$other["tables"]="TBL_CHANNEL_PARTNER";	
			$channel_detailss=$this->admin_model->getUserDetails($channels_id,$other);	
			@$channel_name=$channel_detailss[0]->advisor_name;
			unset($other["tables"]);	
			}
			?>
            <tr>
            	<td><?php if(isset($msme_name)){echo ucwords($msme_name);}?></td>
            	<td><?php if(isset($channel_name)){echo ucwords($channel_name);}?></td>
            	<td><?php echo "#".$val['application_id'];?></td>
            	<td><?php echo $date_post->format('d-m-Y');?></td>
            	<td><?php echo $date_time->format('H:i:s');?></td>
            	<td><a href="<?php echo base_url();?>manage/dashboard/sent_query/<?php echo base64_encode($val['msg_id']);?>">Reply</a> <?php if($val['is_read']==0){?><span class="new_txt">New</span><?php }?></td>
            </tr>
			<?php } }else{?>
			<tr>
            	<td>Your Inbox is empty</td>
            </tr>
			<?php } ?>
            
            </tbody>
            </table>
       </div>
       </div>
<?php } ?>	   