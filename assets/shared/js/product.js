   function changeproduct(base_url){
		    var prod_id = $("#prod_id").val();
			//alert(prod_id);
			   $.post(base_url+'allproduct/productlist/', {prod_id: prod_id}, function(data){	
				     //alert(data);	
				        if(data) {
						//  $("#regflash").hide();	
  						  document.getElementById("productlist").innerHTML = data;
						  changeGroup(base_url);					
						}
 				});			

    }			

 
		function changeGroup(base_url){
		    var prod_id = $("#prod_id").val();
			var group_id = $("#group_id").val();
			//alert(prod_id);
				  $.post(base_url+'groups/grouplist/', {prod_id: prod_id,group_id: group_id}, function(data){	
					   //alert(data); 					
							if(data) {
							  $("#regflash").hide();	
							  document.getElementById("grouplist").innerHTML = data;
							 //err++;	
							}
					});	
    }			