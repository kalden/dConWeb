<?php

function PrintHeader ($title,$refreshlink="") {
	if(isset($title)) {
		if($title != "") { $title = ": $title"; } 
	} else {
		$title = "";
	}
	
	if($refreshlink != ""){
		$meta = "<meta http-equiv='refresh' content='30;url=$refreshlink' />";
	}
	
	print '
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	"http://www.w3.org/TR/html4/loose.dtd">
	<html>
	<head>
	<title>pDomains '.$title.'</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	'.$meta.'
	<link href="img/main.css" rel="stylesheet" type="text/css">
	</head>
	<body>
	<div align="center">
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td width="246"><A HREF="http://pdomains.sdsc.edu/v2/"><img src="img/banner/1.png" width="246" height="62" border="0"></A></td>
		  <td align="right"><img src="img/banner/4.png" width="482" height="62"></td>
		</tr>
		<tr>
		  <td width="246"><A HREF="http://pdomains.sdsc.edu/v2/"><img src="img/banner/2.png" width="246" height="25" border="0"></A></td>
		  <td align="right" background="img/banner/bar.png">
		  <div id="nav">
			<a href="index.php">Home</a> | 
			<a href="proteinform2012.php">Domain Assignments (dConsensus)</a> |
			<a href="dataset.php">Dataset</a> | 
			<a href="approach.php">Approach</a> | 
			<a href="methods.php">Methods</a> | 
			<a href="evaluation.php">Evaluation</a> | 
			<a href="insights.php">Insights</a> | 
			<a href="publications.php">Publications</a> |
			<a href="contact.php">Contact</a> &nbsp;&nbsp;
		  </div>
		  </td>
		</tr>
		<tr>
		  <td width="246"><A HREF="http://pdomains.sdsc.edu/v2/"><img src="img/banner/3.png" width="246" height="30" border="0"></A></td>
		  <td>&nbsp;</td>
		</tr>
	  </table>';
}

function PrintSideMenuBox ($menu_name,$menu_items) {

	print '
    <table width="242" border="0" cellspacing="0" cellpadding="3" class="leftindex">
        <tr>
          <td bgcolor="#6887C4" class="catindexheading">&nbsp;&nbsp;'.$menu_name.'</td>
        </tr>
        <tr>
          <td bgcolor="#BAC8E4">';
          for($i = 0; $i < $menu_items->list_length(); $i++) {
			if($menu_items->is_selected[$i] == "1") {
				$item_style = "highlight";
			} else {
				$item_style = "sidebar";
			}
			print '<div id="'.$item_style.'">&nbsp;&nbsp;<a href="'.$menu_items->link[$i].'">'.$menu_items->label[$i].'</a></div>';
          }
     print '
        </tr>
      </table>
	  <br>';
}

function PrintFooter() {
	print '<p align="center" style="font-size:11px; color:gray;">This work is sponsored by the National Institutes of Heath (NIH)  Grant Number GM63208 (NIH/NIGMS)</p>';
	print '
<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-2301748-1";
urchinTracker();
</script>
	';
	print '</body></html>';
}
?>
