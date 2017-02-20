<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<link href="<?php echo base_url();?>theme/assets/front/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<script src="<?php echo base_url()?>assets/front/js/jquery-ui.js"></script>
<link href="<?php echo base_url()?>assets/front/css/jquery-ui.css" rel="stylesheet" type="text/css">
<style>
span.requirederror{
	puser_detailsding-left:5px;
}
</style>

<!--<script type="text/javascript" src="https://cdn.datatables.net/1.10.11/js/jquery.dataTables.min.js"></script><script>-->
<script type="text/javascript" src="<?php echo base_url()?>assets/front/js/jquery.dataTables.min.js"></script><script>
$(document).ready(function() {
    // Setup - add a text input to each footer cell
    $('#DataTable1 tfoot .filterthd th.fltcl').each( function () {
        var title = $(this).text();
        //$(this).html( '<input type="text" class="module-input" placeholder="Search '+title+'" />' );
		if(title.match('Date Applied'))
		{
        $(this).html( '<input type="text" class="module-input applied_date" placeholder="Search '+title+'" />' );
		}else {
			$(this).html( '<input type="text" class="module-input" placeholder="Search '+title+'" />' );
		}
    } );
 
    // DataTable
    //var table = $('#DataTable1').DataTable({"aaSorting": []});
	var table = $('#DataTable1').DataTable({"aaSorting": [], "columnDefs": [{ "orderable": false, "targets": [5, 6,7] }]});
 
    // Apply the search
    table.columns().every( function () {
        var that = this;
 
        $( 'input', this.footer() ).on( 'keyup change', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
	$('a#del').click(function(){
		return confirm('Are you sure you want to delete?')
	})


});
    $('#DataTable1').dataTable({
    // display everything
    "lengthMenu": [ [10, 50, 100, -1], [10, 50, 100, "All"] ],
    "iDisplayLength": -1,
    "aaSorting": [[ 0, "desc" ]] // Sort by first column descending
});

$(function() {
	  var dateToday = new Date();
	  var yrRange = '1950' + ":" + (dateToday.getFullYear() - 18).toString();
	  
    $(".applied_date").datepicker({
					dateFormat: 'dd-mm-yy',
					changeMonth: true,
					changeYear: true,
					//yearRange: yrRange
					minDate:"01-01-1900",
					maxDate: 'today', 
				});
  }); 

</script>
<style>
.dataTables_filter {
    display: none;
    float: right;
    text-align: right;
}
input{
	color: black;
}

</style>
 <script>
 $(document).ready(function(){
	 $("#add_loan").click(function(){
	 //alert("asdsd");
	 window.location.href='<?php echo base_url();?>manage/dashboard/loan_application';
 });
	 
 });
 
 
 </script>
<div class="row">
    <form role="form" class="div-margin line-height40 white-links">
		<div class="col-sm-3">Loan Application <span  class="application-counter"><?php echo count($loan_list);?></span></div>
		<div class="col-sm-6"></div>
        <div class="clear"></div>
		<table class="table table-striped table-advance table-hover dataTable" role="grid" aria-describedby="DataTable1_info" id="DataTable1">
    <thead>
      <tr>
        <th class="text-center nosort">Reference ID
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
        </th>
        <th class="text-center nosort">MSME
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
        </th>
        <th class="text-center nosort">Channel Partner
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
        </th>
        <th class="text-center nosort">Date Applied
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
        </th>
        <th class="text-center nosort" style="width:15%;">Type of Facility
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down absolute"></span></div>
        </th>
        <th class="text-center nosort">PDF</th>
        <th class="text-center nosort" style="width:15%;">Status</th>
        <th class="text-center nosort">Action</th>
      </tr>
    </thead>
	<tfoot style="display:table-row-group;">
      <tr class="filterthd">
        <th class="fltcl text-center">Reference ID
        </th>
        <th class="fltcl text-center">MSME
        </th>
        <th class="fltcl text-center">Channel Partner
        </th>
        <th class="fltcl text-center">Date Applied
        </th>
        <th class="fltcl text-center" style="width:15%;">Type of Facility
        </th>
        <th class="text-center">---</th>
        <th class="text-center">---</th>
        <th class="text-center">---</th>
      </tr>
    </tfoot>
    <tbody>
	<?php  
	  $i=1;
	  foreach($loan_list as $row){?>
	  <?php $GMT = new DateTimeZone("GMT");
	 $date_post=new DateTime($row['created_dtm'],$GMT);
	 if($row['type_of_facility']==1){
		$facility="Personal Loan";
	 }else if($row['type_of_facility']==2){
		 $facility="Housing Loan";
	 }else if($row['type_of_facility']==3){
		 $facility="Loan against Property";
	 }else if($row['type_of_facility']==4){
		 $facility="Vehicle Loan";
	 }else if($row['type_of_facility']==5){
		$facility="Education Loan"; 
	 }else if($row['type_of_facility']==6){
		$facility="Gold Loan"; 
	 }else if($row['type_of_facility']==7){
		$facility="Business Loan"; 
	 }else if($row['type_of_facility']==8){
		$facility="Others"; 
	 }else{
		 $facility="";
	 }
	 ?>
        <tr>
        <td><?php echo "#".$row['application_id'];?></td>
        <td><?php echo $row['enterprise_name'];?></td>
        <td><?php echo $row['advisor_name'];?></td>
        <td><?php echo $date_post->format('d-m-Y H:i:s');?></td>
        <td><?php echo $facility;?></td>
        <?php if($row['status']==1 || $row['status']==2 || $row['status']==0){?>
		<td><a href="<?php echo base_url();?>uploads/loan_doc/Loan-Application-ID-<?php echo $row['application_id'].".pdf";?>" target="_blank"><img src="<?php echo base_url()?>assets/front/images/pdf.png" width="25" alt=""/></a></td>
		<?php } else{?>
		<td><a href="javascript:void(0)"><img src="<?php echo base_url()?>assets/front/images/pdf.png" width="25" alt=""/></a></td>
		<?php } ?>
        <td><button id="modalbtn_<?php echo $row['application_id'];?>" onclick="open_modal(<?php echo $row['application_id'];?>);" data-app_id="<?php echo $row['application_id'];?>" type="button" id="test" class="yellow-button"><strong>STATUS</strong></button>
                <!-- Modal -->
		<div id="myModal<?php echo $row['application_id'];?>" class="modal fade" role="dialog">
				<div class="modal-dialog width400">
    <!-- Modal content-->
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h5 class="red-text">Application Status of #<?php echo $row['application_id'];?></h5>
				  </div>
					 <div class="modal-body">
						<table class="table">
							<tbody>				
								<tr class="appst">
									<td><div class="app_st">Application Status:</div></td>
									<td><div class="status-option approved"></div></td>
								</tr>
							</tbody>
							<tbody class="bnknm">
							</tbody>
						</table>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-default bn_dtls" data-dismiss="modal">Close</button>
				  </div>
				</div>
				</div>
			</div>
<!--Modal Ended-->

        </td>
		<?php if($utype_id==5){?>
		<td class="edit-delete-icons"><a href="<?php echo base_url()?>manage/dashboard/loan_application/<?php echo base64_encode($row["application_id"]); ?>" title="Edit"><i class="fa fa-pencil right-margin10"></i></a><a id="del" href="<?php echo base_url();?>manage/dashboard/delete_user/<?php echo base64_encode('5');?>/<?php echo base64_encode($row['application_id']);?>" title="Delete"><i class="fa fa-close"></i></a></td>
		<?php }else{?>
		<td class="edit-delete-icons"><a href="<?php echo base_url()?>manage/dashboard/loan_application/<?php echo base64_encode($row["application_id"]); ?>" title="Edit"><i class="fa fa-pencil right-margin10"></i></a></td>
		<?php } ?>
      </tr>
	  
	  <?php $i++; } ?> 
    </tbody>
  </table>
  <script>
			function open_modal(uid){
				var application_id=uid;				 
				$.ajax({
					 type: "POST",
					 url: "<?php echo base_url()."manage/dashboard/statusList";?>",
					 data: {application_id:+application_id},
					 success: function(data){ 
						 if(data)
						 {
							 if(data.loan_lists[0].status==0){
								$('#myModal'+uid+' .appst td .status-option').html('Incomplete');
								$('#myModal'+uid+' .bnknm').html('').hide();									
							 }
							 else if(data.loan_lists[0].status==1){
								$('#myModal'+uid+' .appst td .status-option').html('Forwarded To Analyst'); 
								$('#myModal'+uid+' .bnknm').html('').hide();	
							 }
							 else{
								if(data.bank_list.length!=0){
									$('#myModal'+uid+' .appst').hide(); 
									$('#myModal'+uid+' .bnknm').html('').show();
									for(var h=0; h<data.bank_list.length; h++){
										var bnksts='';
										if(data.bank_list[h].status==0){
											bnksts='Rejected';
										$('#myModal'+uid+' .bnknm').append('<tr><td>'+data.bank_list[h].bank_name+':</td><td><div class="status-option" style="background:#a5000e;">'+bnksts+'</div></td></tr>');	
										}
										else{
											bnksts='In-principle approved';
											$('#myModal'+uid+' .bnknm').append('<tr><td>'+data.bank_list[h].bank_name+':</td><td><div class="status-option approved">'+bnksts+'</div></td></tr>');
										}
										
									}
								} 
								else{
									$('#myModal'+uid+' .appst td .status-option').html('Forwarded to bank'); 
									$('#myModal'+uid+' .bnknm').html('').hide();
								}
							 }
							 
							 $('#myModal'+uid).modal('show');
							//$("#show").html(data);
						 }
					}
				});				
			}			
		</script>
              </form>
    </div>