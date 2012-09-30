<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	include("components/simplecaptcha.php");
	
	$email = "";
	$pdbid = "";
	$methods = "";
	$errors = "";
	
	if(isset($_REQUEST['code'])){
		$claimid = mysql_escape_string($_REQUEST['code']);
	}
	else {
		exit();
	}
	
	
	// Database hookup
	$link = mysql_connect('mysql.sdsc.edu:3312','sergey','pd0mains') or die('Could not connect to database.');
	mysql_select_db('pdomains') or die('Unable to select database.');
	
	// Check to see how many jobs this user has...
	$query = "SELECT finished FROM jobs WHERE claimid = '$claimid' AND finished IS NOT NULL";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) == 1){
		$row = mysql_fetch_array($result);
		$output = $row[0];
		PrintHeader("Job Status");
	}
	else {
		PrintHeader("Job Status","http://pdomains.sdsc.edu/claim.php?code=$claimid");
		$output = "Job is still in queue.<br>This page will automatically refresh in <b>30</b> seconds.";
	}
	
	mysql_free_result($result);
	mysql_close($link);
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","Job Status"));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Job Status:</div>
		<br>
		  <div id="textinfo">
		  <p>'.$output.'</p>
		  </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>