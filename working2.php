<?php

	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chain"];

	$selMeths = array();

	$selMeths["CATH"] = $_GET["CATH"];
	$selMeths["SCOP"] = $_GET["SCOP"];
	$selMeths["PUU"] = $_GET["PUU"];
	$selMeths["dp"] = $_GET["dp"];
	$selMeths["pdp"] = $_GET["pdp"];
	$selMeths["DDomain"] = $_GET["DDomain"];
	$selMeths["DHcL"] = $_GET["DHcL"];
	$selMeths["NCBI"] = $_GET["NCBI"];
	$selMeths["Dodis"] = $_GET["Dodis"];

	$redirect = 'consensus2.php?pdbId='.$structId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&chain='.$chainId.'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"];

	print '<HTML><HEAD>
		<META http-equiv="refresh" content="1;URL='.$redirect.'"> </head> ';

	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chain"];
	
	// the methods are received as true or false dependent if the box is ticked - these are put into a hash table
	// with the method as the key so these can be retrieved later
	

	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	include("components/resultssidemenu.php");
	
	PrintHeader("");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td valign="top">';
		  PrintSideMenuBox("Results",ResultSideMenuItems("Error","Domain Assignment Summary",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
		  print '
		  </td>
 		  <div id="textinfo">
		  <td>
			<TABLE WIDTH="75%">
			<TR>
			<TD align=center><p><BR><BR>Generating a Weighted Consensus from the selected methods, please wait</p></TD></TR>
		        <TR>
			<TD align=center><IMG SRC="img/wait.gif"></TD>
			</TR>
			</TABLE>
		</TD>';
	print '
	  </table>
	  	<div style="padding-left:200px; padding-top: 8px; padding-bottom: 8px;">
		<BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>';
	
	
	PrintFooter();
?>
