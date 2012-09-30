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

	include("components/environment.php");
	include("components/menu.php");
	include("components/resultssidemenu.php");
	
	PrintHeader("Results: Comparison of Assigned Domains");
	
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
	
	// GET ALL THE CHAINS FOR THIS PROTEIN
	$chains = mysql_query("SELECT DISTINCT chain FROM automeths2012 WHERE pdbId='".$structId."'");	
	
	$num_results = mysql_num_rows($chains);
	$row = mysql_fetch_array($chains);
	$first_chain = $row['chain'];

	print 'Structure '.$structId.' is comprised of '.$num_results.' chains. Displaying results for chain '.$first_chain.'<BR>';

	while($row = mysql_fetch_array($chains))
	{
		// check if chainstart is null - if so, the chain or protein does not exist and an error will need presenting
		$chain = $row['chain'];
		print $chain.' ';
	}

	//if($chainId=='')
	//{
	//	print 'No Chain';
	//}
	//else
	//{
	//	print $chainId;
	//}

	/*

	

	// get the start of the chain - needed for the drawing function - ensures all the methods start at same point
	$getChainStart = mysql_query("SELECT MIN(start) FROM automeths WHERE domain REGEXP '^".$structId.$chainId."'");

	while($row = mysql_fetch_array($getChainStart))
	{
		// check if chainstart is null - if so, the chain or protein does not exist and an error will need presenting
		$chainStart = $row['MIN(start)'];
	}
	if($chainStart!=null)
	{
		print '
		  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
			<tr align="left">
			  <td valign="top" width="242">';
			  PrintSideMenuBox("Results",ResultSideMenuItems("Results","Domain Assignment Summary",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
			  print '
			  </td>
			  <td valign="top" align="left">
	        <div id="textheading">Domain Assignment by Method</div>
	
		<div id="textinfo">
		<div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px">';
	
		// print selected protein and chain
		print '<b>Selected Protein:</b> '.$structId. ' <b>Chain:</b> '.$_GET["chain"].'<BR></div>

		The applet below gives an overview of the domains and fragments assigned by each selected method<BR>';
	
		// get the end of the chain - needed for the drawing function - ensures all the methods end at same point
		$getChainEnd = mysql_query("SELECT MAX(end) FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' ORDER by end DESC");
		while($row = mysql_fetch_array($getChainEnd))
		{
			$chainEnd = $row['MAX(end)'];
		}

		// now get all the domain assignments for this chain for the graph
		// this is complex - and completed using FIELD, so that the methods are sorted by accuracy of algorithms given in brackets
		$domains = mysql_query("SELECT domain,fragmentNo,start,end,method,FIELD(method,'CATH','SCOP','pdp','DHcL','dp','DDomain','NCBI','PUU','Dodis') AS SORTER FROM automeths WHERE domain REGEXP '^".$structId.$chainId."'ORDER BY SORTER ASC,start");
				

		$num_results = mysql_num_rows($domains);

		// now get the assignments again, but this time sort differently, this is for the fragment table on the page
		$domainstoprint = mysql_query("SELECT domain,fragmentNo,start,end,method,FIELD(method,'CATH','SCOP','pdp','DHcL','dp','DDomain','NCBI','PUU','Dodis') AS SORTER FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' ORDER BY SORTER ASC,domain,fragmentNo");
			

		// add the applet and send start/end parameters
		print'
 		<APPLET ARCHIVE="Graph2.jar" CODE="pDomains/MethodGraph2.class" WIDTH="95%" HEIGHT=300>
			<PARAM NAME="pdbId" VALUE="'.$structId.$chainId.'">
			<PARAM NAME="start" VALUE="'.$chainStart.'">
			<PARAM NAME="end" VALUE="'.$chainEnd.'">';

		// now need to generate the parameters for each method to send to the display applet
		$num_rows = 1;

		while($row = mysql_fetch_array($domains))   // for each method
 		{
			$struct = $row['domain'];
			$fragment = $row['fragmentNo'];
			$start = $row['start'];
			$end = $row['end'];
			$method = $row['method'];
	
			if($selMeths[$method]=="true")      // if the user has selected this method
			{
				// create parameter tags to send required info to drawing package
				print '<PARAM NAME="domain'.($num_rows-1).'" VALUE="'.$struct.'">
			   		<PARAM NAME="fragment'.($num_rows-1).'" VALUE="'.$fragment.'">
			   		<PARAM NAME="start'.($num_rows-1).'" VALUE="'.$start.'">
			   		<PARAM NAME="end'.($num_rows-1).'" VALUE="'.$end.'">
			   		<PARAM NAME="method'.($num_rows-1).'" VALUE="'.$method.'">';

  				$num_rows = $num_rows +1;
  			}
  	
		}
		// send the number of results as this is needed by the applet
		print '<PARAM NAME="numResults" VALUE="'.($num_rows-1).'">
			</APPLET>';

		// now create a text table to display all the fragment positions

		print '
		<b>Domain Boundary Position Summary:</b>
		<table width=95%>
		<tr bgcolor="#6887C4"><th width="18%"align=center>Method<th width="18%" align=center>Domain Id<th width="74%" align=center>Fragment</tr>';
		$test = 1;
		$fragmentPrint = null;

		$row = mysql_fetch_array($domainstoprint);
		$currentMethod = $row['method'];
		$currentDomain = $row['domain'];
		$fragmentPrint = $row['start'].'-'.$row['end'];

		if($selMeths[$currentMethod]=="true")
			print'<tr><td width="18%" align=center>'.$currentMethod.'</td>';
		while($row = mysql_fetch_array($domainstoprint))
		{
			$struct = $row['domain'];
			$fragment = $row['fragmentNo'];
			$start = $row['start'];
			$end = $row['end'];
			$method = $row['method'];
	
			if($selMeths[$method]=="true")         // the user has selected the method
			{
			
				if($method==$currentMethod) 
				{	
					if($currentDomain==$struct)         // still looking at the same domain so add to string
					{
						$fragmentPrint = $fragmentPrint.' , '.$start.'-'.$end;
					}
					else      // different domain, so print string containing all fragments of last domain
					{
						print'<td width="18%" align=center>'.$currentDomain.'</td>
							<td width="74%">'.$fragmentPrint.'</td></tr>';
						$currentDomain = $struct;                          // set to start new domain
						$fragmentPrint = $start.'-'.$end;
						print'<tr><td width="18%" align=center>';
					}
				}
				else           // different method, so currentmethos needs changing & method printing
				{
					if($selMeths[$currentMethod]=="true")
					{
						print'<td width="18%" align=center>'.$currentDomain.'</td>
							<td width="74%">'.$fragmentPrint.'</td></tr>';
					}
					$currentMethod=$method;
					$currentDomain = $struct;
					$fragmentPrint = $start.'-'.$end;
					print'<tr><td colspan=3>  </td></tr><tr><td width="18%" align=center>'.$method.'</td>';
				}
			}
		}
		//print final domain that not yet output
		print'<td width="18%" align=center>'.$currentDomain.'</td>
			<td width="74%">'.$fragmentPrint.'</td></tr>';
	

		print'</table>

		</td>
		</tr>
		</table>
		<br>';

		print '<A HREF="DownloadChainResult.php?pdbId='.$structId.'&chainId='.$chainId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&chain='.$tempChain.'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"].'">Download These Results in CSV Format</A><BR><BR>';

	}
	else   // the chain could not be found
	{
		print '
		  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
			<tr align="left">
			  <td valign="top" width="242">';
			  PrintSideMenuBox("Results",ResultSideMenuItems("Error","Domain Assignment Summary",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
			  print '
			  </td>
			  <td valign="top" align="left">
	        <div id="textheading">Domain Assignment by Method</div>
	
		<div id="textinfo">
		<div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px;">';
	
		// print selected protein and chain
		print '<b>Selected Protein:</b> '.$structId. ' <b>Chain:</b> '.$_GET["chain"].'<BR></div>';

		// work out if the protein does not exist, or the chain
		// firstly, see if the protein chain has been entered as lower case.  If so, see if the upper case exists
		$tempChain = strtoupper($chainId);
		if(strcmp($chainId,$tempChain)!= 0)     // i.e. chain is lower case
		{
			// see if the uppercase chain exists in the database
			$getChainStart = mysql_query("SELECT MIN(start) FROM automeths WHERE domain REGEXP '^".$structId.$tempChain."'");
			while($row = mysql_fetch_array($getChainStart))
			{
				// check if chainstart is null - if still null, the uppercase chain does not exist either and an error will need presenting
				$chainStart = $row['MIN(start)'];
			}
			if($chainStart!=null)         // i.e. the uppercase chain exists
			{
				// the uppercase chain exists
				print '<BR><BR>The chain you have entered does not exist for this protein.  However, chain '.$tempChain.' does exist<BR>';
				print '<A HREF="http://pdomains.sdsc.edu/v2/compareassignments.php?pdbId='.$structId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&chain='.$tempChain.'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"].'">Click Here to View this Chain</A> or use the side menu to return to the form and try again<BR><BR><BR><BR><BR><BR><BR><BR>';
			}
			else       // both lowercase and uppercase chains do not exist
			{
				print '<BR><BR>The chain you have entered cannot be found for this protein.  Chain '.$tempChain.' also cannot be found<BR>';
				print '<A HREF="http://pdomains.sdsc.edu/v2/proteinform.php">Click Here to return to the form and try again</A><BR><BR><BR><BR><BR><BR><BR>';
			}
		}
		else   // the chainId was already in uppercase
		{
			print '<BR><BR>The chain you have entered cannot be found for this protein.<BR>';
			print '<A HREF="http://pdomains.sdsc.edu/v2/proteinform.php">Click Here to return to the form and try again</A><BR><BR><BR><BR><BR><BR><BR>';
		}
	}

	*/

	mysql_close($con);
	
	PrintFooter();
?>
