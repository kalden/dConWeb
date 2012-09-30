<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Dataset Download");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Dataset",GetSideMenuItems("Dataset","Download Dataset",null,null));
		  print '
		  </td>
		  <td valign="top" align="left"><div id="textheading">Dataset Download:</div>
		  	<div id="textinfo">';

		  // PROTECT FROM CRAWLERS
		  if(preg_match('/href/',$_POST['institution'])) {
			$error = "Invalid input.";
		  }
		  if(preg_match('/href/',$_POST['fname'])) {
			$error = "Invalid input.";
		  }
		  if(preg_match('/href/',$_POST['lname'])) {
			$error = "Invalid input.";
		  }
		  if(preg_match('/href/',$_POST['country'])) {
			$error = "Invalid input.";
		  }
		  if(preg_match('/href/',$_POST['institution'])) {
			$error = "Invalid input.";
		  }

		  // Basic form validation
		  if($_POST['fname'] != "") {
			$fname = mysql_escape_string($_POST['fname']);
		  } else {
			$error = "Please supply a first name.<br>";
		  }

		  if($_POST['lname'] != "") {
			$lname = mysql_escape_string($_POST['lname']);
		  } else {
			$error .= "Please supply a last name.<br>";
		  }

		  if($_POST['institution'] != "") {
			$inst = mysql_escape_string($_POST['institution']);
		  } else {
			$error .= "Please supply the institution name.<br>";
		  }

		  if($_POST['country'] != "") {
			$country = mysql_escape_string($_POST['country']);
		  } else {
			$error .= "Please supply a country name.<br>";
		  }

		  $opt0 = 0; $opt1 = 0; $opt2 = 0; $opt3 = 0; $opt4 = 0; $opt5 = 0;

		  if($_POST['opt0'] == 1) {
			$opt0 = 1;
		  }
		  
		  if($_POST['opt1'] == 1) {
			$opt1 = 1;
		  }

		  if($_POST['opt2'] == 1) {
			$opt2 = 1;
		  }

		  if($_POST['opt3'] == 1) {
			$opt3 = 1;
		  }

		  if($_POST['opt4'] == 1) {
			$opt4 = 1;
		  }

		  if($_POST['opt5'] == 1) {
			$opt5 = 1;
		  }
		  
		  if($opt0 !=1 && $opt1 != 1 && $opt2 != 1 && $opt3 != 1 && $opt4 != 1 && $opt5 != 1) {
			$error .= "You didn't select any datasets to download.<br>";
		  }
		  
		  if($error == "") {
			// Verified, start session.
			session_start();
			$_SESSION['auth'] = "yes";
			
			// Note in database.
			$link = mysql_connect('mysql.sdsc.edu:3312','sergey','pd0mains') or die('Could not connect to database.');
			
			mysql_select_db('pdomains') or die('Unable to select database.');
			
			$query = "INSERT INTO downloads (fname,lname,institution,country,bench1c,bench1,bench2raw,bench2,bench3raw,bench3) VALUES ('$fname','$lname','$inst','$country',$opt0,$opt1,$opt2,$opt3,$opt4,$opt5)";	
			$result = mysql_query($query);
			mysql_free_result($result);
			mysql_close($link);
			
			// Render download link.
			print 'Requested materials:<br>';
			if($opt0 == 1) { print '<a href="dl.php?file=0" target="_blank">Benchmark_1_consensus (467)</a><br>'; }
			if($opt1 == 1) { print '<a href="dl.php?file=1" target="_blank">Benchmark_1 (467)</a><br>'; }
			if($opt2 == 1) { print '<a href="dl.php?file=2" target="_blank">Balanced_Domain_Benchmark_2 data (raw format) (157)</a><br>'; }
			if($opt3 == 1) { print '<a href="dl.php?file=3" target="_blank">Balanced_Domain_Benchmark_2 assignment by all methods (157)</a><br>'; }
			if($opt4 == 1) { print '<a href="dl.php?file=4" target="_blank">Balanced_Domain_Benchmark_3 data (raw format) (135)</a><br>'; }
			if($opt5 == 1) { print '<a href="dl.php?file=5" target="_blank">Balanced_Domain_Benchmark_3 assignment by all methods (135)</a><br>'; }
			
		  } else {
			// Issue error.
			print 'Error:<br>' . $error .'Please hit your browser\'s back button and fix the problem';
		  }

		  print '
		  </div></td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
