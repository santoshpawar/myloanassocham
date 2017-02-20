
<?php 
if(!empty($errormsg))
{
	echo $errormsg."<br>";
	echo $this->session->set_userdata('login_message',$errormsg);
?>
	<script>
		
		  window.setTimeout(function() {
                        location.href = '<?php echo base_url(); ?>';
                    }, 10000);  
		    var count=11;
			var counter=setInterval(timer, 1000); //1000 will  run it every 1 second
			function timer()
			{
			  count=count-1;
			  if (count <= 0)
			  {
				 clearInterval(counter);
				 return;
			  }
			  document.getElementById("timer").innerHTML=count + " secs";
			}
	</script>

<?php echo "Page will redirect automatically to home page in <span id='timer'></span>.</strong></span>";

}

?>