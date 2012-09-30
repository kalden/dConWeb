<?php
	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chain"];
	
	// the methods are received as true or false dependent if the box is ticked - these are put into a hash table
	// with the method as the key so these can be retrieved later
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

	$chosenCut = $_GET["Cut"];
	$chosenMeth = $_GET["Method"];

	// connect to database
	$dbhost = '137.110.134.140:8888';
	$dbuser = 'domains';
	$dbpass = 'ucsd';
	$dbname = 'domains';

	$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db($dbname, $con);
	
	include("components/environment.php");
	include("components/menu.php");
	include("components/resultssidemenu.php");
	
	PrintHeader("Results: Boundary Analysis");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",ResultSideMenuItems("Results","Boundary Analysis",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Individual Boundary Analysis</div>

	<div id="textinfo">';
	
	// print selected protein and chain
	print '<b>Selected Protein:</b> '.$_GET["pdbId"].' <b>Chain:</b> '.$_GET["chain"].' <b>Method:</b> '.$chosenMeth.' <b>Cut Position:</b> '.$chosenCut.'</div><BR><BR>';
	
	print '<div id="aminos">';
	// Now need to recover the amino acid sequence and secondary structure for around this boundary
	$dsspdata = mysql_query("SELECT residueNumCIF,aminoAcidCode,secondaryStructure FROM dssp where structId='".$structId."' and chainId='".$chainId."' and (residueNumCIF>=".($chosenCut-20)." and residueNumCIF<=".($chosenCut+20).")");

	$aminoCode = "..";
	$secStrucCode = "";
	while($row = mysql_fetch_array($dsspdata))
	{
		// generate the amino acid and sec struc data strings
		$amacid = $row['aminoAcidCode'];
		$secstruc = $row['secondaryStructure'];
		if($secstruc!=null)
		{
			$secStrucCode = $secStrucCode.$secstruc;
		}
		else
		{
			$secStrucCode = $secStrucCode." ";
		}
		$aminoCode = $aminoCode.$amacid;
	}
	$aminoCode = $aminoCode."..";
	print '	<TABLE align=center width="95%">
	<TR>
		<TD COLSPAN=2>'.($chosenCut-20).'</TD>
		<TD COLSPAN=41></TD>
		<TD COLSPAN=2>'.($chosenCut+20).'</TD>
		
	</TR><TR>';

	$posCount = $chosenCut-22;
	$AAarray = preg_split('//', $aminoCode, -1, PREG_SPLIT_NO_EMPTY);
		
	foreach($AAarray as $char) 
	{
		if($posCount != $chosenCut)
		{
			print '<TD align=center>'.$char.'</TD>';
		}
		else        // colour code the cut position
		{
			print '<TD bgcolor="#FF0000" align=center>'.$char.'</TD>';
		}
		$posCount = $posCount+1;              // keep track of the current amino acide in order to label the position
			
	}
	print '</TR><TR>';
	print '<TD><TD>';              // as there is no ".." on the sec struc string

	$SSarray = preg_split('//', $secStrucCode, -1, PREG_SPLIT_NO_EMPTY);
		
	foreach($SSarray as $char) 
	{
		if((strcmp($char,"H")==0) or (strcmp($char,"G")==0) or (strcmp($char,"I")==0))     // structure is a helix
		{
			print '<TD bgcolor="#99CCFF" align=center>'.$char.'</TD>';
		}
		else if(strcmp($char,"E")==0)     // structure is a sheet
		{
			print '<TD bgcolor="#FF9900" align=center>'.$char.'</TD>';
		}
		else
		{
			print '<TD align=center>'.$char.'</TD>';
		}
	}
	print '<TD><TD></TR></TABLE></div><BR><BR>';            // 2 TD to replace non existant .. and complete row
	
	print '<div id="textinfo">
	<table>
	<tr>
		<td bgcolor="#FF0000"></td><td>Position in Amino Acid Chain where method predicts domain boundary</td>
	</tr>
	<tr>
		<td bgcolor="#99CCFF"></td><td>Positions in Chain noted as Helix Structures by DSSP Method<td>
	</tr>
	<tr>
		<td bgcolor="#FF9900"></td><td>Positions in Chain noted as Beta Sheet Structures by DSSP Method</td>
	</tr>
	</table></div>';
	
