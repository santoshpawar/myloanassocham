<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css">
<link href="<?php echo base_url();?>theme/assets/front/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
<style>
span.requirederror{
	puser_detailsding-left:5px;
}
</style>

<script type="text/javascript" src="<?php echo base_url()?>assets/front/js/jquery.dataTables.min.js"></script><script>
$(document).ready(function() {
	
	$("#add_bank").click(function(){
	 //alert("asdsd");
	 window.location.href='<?php echo base_url();?>manage/dashboard/add_bank';
	});
    // Setup - add a text input to each footer cell
    $('#DataTable1 tfoot .filterthd th.fltcl').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" class="module-input" placeholder="Search '+title+'" />' );
    } );
 
    // DataTable
    var table = $('#DataTable1').DataTable({"aaSorting": []});
 
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
	
<div class="row">
    <form role="form" class="div-margin line-height40">
		<div class="col-sm-3">Bank <span  class="application-counter"><?php echo count($bank_list);?></span></div>
		<div class="col-sm-6"></div>
		<div class="col-sm-3"><button type="button" id="add_bank" class="yellow-button new_loan_mp"><strong>ADD NEW BANK</strong></button>
        </div>
        <div class="clear"></div>
		<table class="table table-striped table-advance table-hover dataTable" role="grid" aria-describedby="DataTable1_info" id="DataTable1">
    <thead>
      <tr>
        <th class="text-center nosort">ID
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down"></span></div>
        </th>
        <th class="text-center nosort">Bank Name
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down"></span></div>
        </th>
        <th class="text-center nosort">1st Point of Contact
        <br>
        <div class="text-center up-down-arrows"><span class="arrow-up"></span><span class="arrow-down"></span></div>
        </th>
        <!--<th class="text-center">PDF</th>-->
           <th class="text-center nosort">Action</th>
      </tr>
    </thead>
	<tfoot style="display:table-row-group;">
      <tr class="filterthd">
        <th class="fltcl text-center">ID
        </th>
        <th class="fltcl text-center">Bank Name
        </th>
        <th class="fltcl text-center">1st Point of Contact
        </th>
          <th class="text-center">---</th>
		</tr>
    </tfoot>
    <tbody>
	 <?php  
	  $i=1;
	  foreach($bank_list as $row){?>
        <tr>
        <td><?php echo "#".$i?></td>
        <td><?php echo $row['bank_name'];?></td>
        <td><?php echo $row['person_name'];?></td>
		 
		<td class="edit-delete-icons"><a href="<?php echo base_url();?>manage/dashboard/edit_users/<?php echo base64_encode('4');?>/<?php echo base64_encode($row['bank_id']);?>" title="Edit"><i class="fa fa-pencil right-margin10"></i></a><a id="del" href="<?php echo base_url();?>manage/dashboard/delete_user/<?php echo base64_encode('4');?>/<?php echo base64_encode($row['bank_id']);?>" title="Delete"><i class="fa fa-close"></i></a></td>
      </tr>
	  <?php $i++; } ?> 
    </tbody>
  </table>
              </form>
    </div>
	
	
	

