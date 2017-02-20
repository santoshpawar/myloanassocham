var xmlHttp;


function div_next_page(str,str1)
{ //alert("fff");alert(str);alert(str1)
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null)
  	{
  		alert ("Your browser does not support AJAX!");
  		return;
  	} 
	var url="ajax_page.php";
	url=url+"?page="+str;
	
	url=url+"&sid="+Math.random();
	xmlHttp.onreadystatechange=function()
	{
		if(xmlHttp.readyState==4)
		{ //alert(xmlHttp.responseText);
			document.getElementById("ref_div").innerHTML=xmlHttp.responseText;
			//alert(document.getElementById("ref_div").innerHTML);
		}
	};
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
}



function GetXmlHttpObject()
{
	var xmlHttp=null;
	try
  	{
  		// Firefox, Opera 8.0+, Safari
  		xmlHttp=new XMLHttpRequest();
  	}
	catch (e)
  	{
  		// Internet Explorer
  	try
    {
    	xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  	catch (e)
    {
    	xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}