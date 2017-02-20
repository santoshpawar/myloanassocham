<?php //echo "rj";exit;?>
	  <div class="content-wrapper select inboxwrp" style="border:0px;">
        <div class="clear"></div>
        <div class="p100">
			<table class="table inbox-table">
            <thead>
            <tr>
            	<td>Username</td>
            	<td>Application ID</td>
            	<td>Message</td>
            	<td>Date</td>
            	<td>Time</td>
            	<td>Action</td>
            </tr>
            </thead>
            <tbody>
			<?php if(!empty($sent_own_list)){?>
            <?php foreach($sent_own_list as $val){ ?>
			<?php 
			$GMT = new DateTimeZone("GMT");
			$date_post=new DateTime($val->massage_sent_time,$GMT);
			$desc=substr(strip_tags($val->message),0,30);
			?>
            <tr>
				
				<td><?php if(isset($username)){ echo ucwords($username);}?></td>
                <td><?php echo "#".$val->application_id;?></td>
                <td><?php echo $desc;?></td>
            	<td><?php echo $date_post->format('d-m-Y');?></td>
            	<td><?php echo $date_post->format('H:i:s');?></td>
				<td><a href="<?php echo base_url();?>manage/dashboard/sent_query/<?php echo base64_encode($val->message_id);?>">Reply</a></td>
               </tr>
			<?php } }else{?>
			<tr>
            	<td>Your Sent Query is empty</td>
            </tr>
			<?php } ?>
            </tbody>
            </table>
       </div>
       </div>