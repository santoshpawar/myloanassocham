<?php  if (!defined('BASEPATH')) exit('No direct script access allowed.');
/*-----------------------------function for making pagination-----------------------------------------------*/
function div_pagination($total_pages,$page,$search_condition)
{
	$out="";
	$out.='<div style="float:left;">Displaying Pages '.($page).' of '.$total_pages.'</div>';
	$out.='<div style="float:right;">';
	if($total_pages!=0)
	{
		$out.="Pages :";
	}
	$page_set=3;
	$str="";
	$diff=$total_pages-$page_set;
	if($diff>0)
	{
		$start=$page-($page_set/2);
		if($start<=0)
		{
			$start=1;
			$end=$start+$page_set-1;
		}
		else
		{
			$start=$page-floor($page_set/2);
			$end=$start+$page_set-1;
			if($end>$total_pages)
			{
				$end=$total_pages;
				$start=$end-$page_set+1;
			}
		}
	}
	else
	{
		$start=1;
		$end=$total_pages;
	}
	if($page>1)
	{
		$para="page=".($page-1);
		$cond=$para.$search_condition;
		$p=$page-1;
		$str="&nbsp;<b><a href='javascript:div_next_page(\"$p\",\"$search_condition\");' onclick='' class=''>back</a></b>";
	}
	for($x=$start;$x<=$end;$x++)
	{
		$para="page=".($x);
		$cond=$para.$search_condition;
		$str.="&nbsp;<b><a href='javascript:div_next_page(\"$x\",\"$search_condition\");' class=''>".$x."</a></b>";
	}
	if($page<$total_pages)
	{
		$para=($page+1);
		$cond=$para.$search_condition;
		$str.="&nbsp;<b><a href='javascript:div_next_page(\"$para\",\"$search_condition\");' onclick='' class=''>next</a></b>";
	}
	$out.=$str;
	$out.='</div>';
	return $out;
}
?>