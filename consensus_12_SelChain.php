<?php

	// to hold the methods and protein data the user has selected
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
	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chain"];

	// array maps to hold the groups, weights
	$continuousMap = array();
	$splitDomMap = array();
	$finalMap = array();
	$weights = array();

	// connect to database
	$dbhost = '137.110.134.140:8888';
	$dbuser = 'domains';
	$dbpass = 'ucsd';
	$dbname = 'domains';

	$assignmentsTable = "automeths2012";
	$simpleConsensusTable = "simpleconsensus";
	$consensusStatsTable = "consensusscores";

	$numMethods = 0;            // holds the number of methods chosen by the user

	// Create a connection to database
	$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
	{
	  die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($dbname, $con);

	include("components/environment.php");
	include("components/menu.php");
	include("components/resultssidemenu.php");
	
	PrintHeader("Results: Consensus Assignment");

	// First check that the PDBId exists
	$chains = mysql_query("SELECT DISTINCT chain FROM ".$assignmentsTable." WHERE pdbId='".$structId."'");	

	if(mysql_num_rows($chains))
	{
		// Get the first chain
		//$row = mysql_fetch_array($chains);
		//$first_chain = $row['chain'];

		// GET ALL THE CHAINS FOR THIS PROTEIN
		// NOTE THE QUERY IS IN HERE TWICE TO RESET THE RESULT SET - THIS COULD POTENTIALLY BE DONE ANOTHER WAY
		$chainsForMenu = mysql_query("SELECT DISTINCT chain FROM ".$assignmentsTable." WHERE pdbId='".$structId."'");	

		// Set the layout up
		print '
		  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
			<tr align="left">
			  <td valign="top" width="242">';
			  PrintSideMenuBox("Results",ResultSideMenuItems("Results","Simple Consensus",$structId,$chainId,$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"],$chainsForMenu));
			 PrintSideMenuBox("Chains",ResultSideMenuItems("Consensus Chains",$chainId,$structId,$chainId,$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"],$chainsForMenu));
			  print '
			  </td>
			  <td valign="top" align="left">
        	<div id="textheading">Simple Consensus</div>

		<div id="textinfo">
		<div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px;">';
		
		// print selected protein and chain
		print '<b>Selected Protein:</b> '.$_GET["pdbId"]. ' <b>Chain:</b> '.$chainId.'<BR><BR>';
		print '<b>Result:</b><BR>';
		
		// GET THE CONSENSUS
		$consensus = mysql_query("SELECT * FROM ".$simpleConsensusTable." WHERE pdbId='".$structId."' AND chain='".$chainId."' ORDER BY consensusNumber,domainStart ASC");	
		
		if($consensus!=null)
		{
			$num_results = mysql_num_rows($consensus);

			// get the start of the chain - needed for the drawing function - ensures all the methods start at same point
			$getChainStart = mysql_query("SELECT MIN(startPDB) FROM ".$assignmentsTable." WHERE pdbId='".$structId."' AND chain='".$chainId."'");
			while($row = mysql_fetch_array($getChainStart))
			{
				$chainStart = $row['MIN(startPDB)'];
			}	
	
			// get the end of the chain - needed for the drawing function - ensures all the methods end at same point
			$getChainEnd = mysql_query("SELECT MAX(endPDB) FROM ".$assignmentsTable." WHERE pdbId='".$structId."' AND chain='".$chainId."'");
			while($row = mysql_fetch_array($getChainEnd))
			{
				$chainEnd = $row['MAX(endPDB)'];
			}
	
			// get the CATH and SCOP definitions to compare the consensus with
			$cathscop = mysql_query("SELECT * FROM ".$assignmentsTable." WHERE pdbId='".$structId."' AND chain='".$chainId."' and (method='SCOP' or method='CATH') ORDER BY method,start");

			print'
 			<APPLET ARCHIVE="Graph2.jar" CODE="pDomains/MethodGraph2.class" WIDTH="95%" HEIGHT=130>
				<PARAM NAME="pdbId" VALUE="'.$structId.$chainId.'">
				<PARAM NAME="start" VALUE="'.$chainStart.'">
				<PARAM NAME="end" VALUE="'.$chainEnd.'">';
		
			// now need to generate the parameters for each method to send to the display applet
			$num_rows = 1;
			$currentMethod = null;
			$methCount = 0;
	
			// firstly add CATH and SCOP definitions to the display
			while($row = mysql_fetch_array($cathscop))
			{	
				$pdbId = $row['pdbId'];
				$pdbChain = $row['chain'];
				$domain = $row['domain'];
				$combined = $pdbId.$pdbChain.$domain;
				$fragment = $row['fragmentNo'];
				$start = $row['startPDB'];
				$end = $row['endPDB'];
				$method = $row['method'];
	
				print '<PARAM NAME="domain'.($num_rows-1).'" VALUE="'.$combined.'">
						<PARAM NAME="fragment'.($num_rows-1).'" VALUE="'.$fragment.'">
				   		<PARAM NAME="start'.($num_rows-1).'" VALUE="'.$start.'">
				   		<PARAM NAME="end'.($num_rows-1).'" VALUE="'.$end.'">
				   		<PARAM NAME="method'.($num_rows-1).'" VALUE="'.$method.'">';
				$num_rows = $num_rows +1;
			}
	
			// now add the consensus to the display
			// First work out how many consensus options there are
			$consensusNumCheck = mysql_query("SELECT MAX(consensusNumber) FROM ".$simpleConsensusTable." WHERE pdbId='".$structId."' AND chain='".$chainId."'");
			$row = mysql_fetch_array($consensusNumCheck);
			$numberOfConsensus = $row['MAX(consensusNumber)'];
	
			while($row = mysql_fetch_array($consensus))
 			{
				$pdbId = $row['pdbId'];
				$pdbChain = $row['chain'];
				$consensusNumber = $row['consensusNumber'];
				$domain = $row['domain'];
				$combined = $pdbId.$pdbChain.$domain;
				$fragment = $row['fragmentNo'];
				$start = $row['domainStart'];
				$end = $row['domainEnd'];
	
				// Consensus will be labelled "Consensus:", and if second option "Consensus Option 2" therefore if a different method representing 
				// a consensus is encountered, this counter needs increasing
			
				if($consensusNumber == 1)
				{			
					$label = "Consensus";
				}
				else
				{
					$label = "Consensus Option 2";
				}
		
				print '<PARAM NAME="domain'.($num_rows-1).'" VALUE="'.$combined.'">
						<PARAM NAME="fragment'.($num_rows-1).'" VALUE="'.$fragment.'">
				   		<PARAM NAME="start'.($num_rows-1).'" VALUE="'.$start.'">
				  		<PARAM NAME="end'.($num_rows-1).'" VALUE="'.$end.'">
				  		<PARAM NAME="method'.($num_rows-1).'" VALUE="'.$label.'">';
	
  				$num_rows = $num_rows +1;

			}
			// send the number of results as this is needed by the applet
			print '<PARAM NAME="numResults" VALUE="'.($num_rows-1).'">
				</APPLET><BR>';
	
			/// RESULTS SECTION! (COMES UNDER APPLET)


			
			// Now need to recover the scores and methods from the consensus stats table
			$consensusStats = mysql_query("SELECT * FROM ".$consensusStatsTable." WHERE pdbId='".$structId."' AND chain='".$chainId."' ORDER BY consensusNumber ASC");
			
						
			$row = mysql_fetch_array($consensusStats);
			$highConsensusScore = $row['score'];
			$highConsensusMethods = $row['algorithms'];
			
			if($consensusNumber>1)
			{
				$row = mysql_fetch_array($consensusStats);
				$nextConsensusScore = $row['score'];
				$nextConsensusMethods = $row['algorithms'];
			}

			
			print '
				<TABLE WIDTH="95%">
				<TR><TH WIDTH="50%" ALIGN=CENTER>Scores<TH WIDTH="20%"><TH WIDTH="30%" ALIGN=CENTER>Key</TR>
				<TR><TD><b>Consensus Reliability:</b> ';
				printf ("%01.2f", $highConsensusScore);

				// print a label next to the consensus to judge it's strength
				if($highConsensusScore>39 && $highConsensusScore<60)
				{
					print ' (Weak)';
				}
				else if($highConsensusScore>=60 && $highConsensusScore<85)
				{
					print ' (Reasonable)';
				}
				else if($highConsensusScore>=85)
				{
					print ' (Strong)';
				}
			

				print '</TD><TD></TD><TD>[0-39]: No Consensus</TD></TR>
				
				<TR><TD>';
				
				if($consensusNumber>1)
				{
					print '<b>Consensus Option 2 Reliability:</b> ';
					printf ("%01.2f", $nextConsensusScore);
	
					if($nextConsensusScore>39 && $nextConsensusScore<60)
					{
						print ' (Weak)';
					}
					else if($nextConsensusScore>=60 && $nextConsensusScore<85)
					{
						print ' (Reasonable)';
					}
					else if($nextConsensusScore>=85)
					{
						print ' (Strong)';
					}
				}
				print '</TD><TD></TD><TD>[40-59]: Weak Consensus</TD></TR>
				<TR><TD></TD><TD></TD><TD>[60-84]: Reasonable Consensus</TD></TR>
				<TR VALIGN=TOP><TD>';
				
				// PRINT METHODS THAT CONTRIBUTE TO CONSENSUS
				print '<TABLE><TR><TD><b>Methods Contributing to Consensus: </b>'.$highConsensusMethods.'</TD>';
				
				print '</TR></TABLE></TD><TD></TD><TD>[85-100]: Strong Consensus</TD></TR>
				<TR><TD>';
	
	
				// PRINT METHODS THAT MAY CONTRIBUTE TO A SECOND CONSENSUS OPTION IF EXISTS
				if($consensusNumber>1)
				{
					print '<TABLE><TR><TD><b>Methods Contributing to Alternative Consensus: </b>'.$nextConsensusMethods.'</TD> ';
					print '</TR></TABLE>';
				}
				print '</TD><TD></TD><TD></TD></TR></TABLE>';
		
			
			print '<BR>';
			
		
	
			// now create a text table to display all the fragment positions

			print '
			<b>Consensus Boundary Position Summary:</b>
			<table width=95%>
			<tr bgcolor="#6887C4"><th width="18%" align=center>Method<th width="18%" align=center>Domain Id<th width="74%" align=center>Fragment</tr>';
			
			

			$test = 1;
			$fragmentPrint = null;
	
			// firstly do CATH & SCOP
			

			mysql_data_seek($cathscop,0);

			if(mysql_num_rows($cathscop))
			{
				$row = mysql_fetch_array($cathscop);
				$currentMethod = $row['method'];
				$currentDomain = $structId.$chainId.$row['domain'];
				$fragmentPrint = $row['startPDB'].'-'.$row['endPDB'];

				print'<tr><td width="18%" align=center>'.$currentMethod.'</td>';

				while($row = mysql_fetch_array($cathscop))
				{
					$struct = $structId.$chainId.$row['domain'];
					$fragment = $row['fragmentNo'];
					$start = $row['startPDB'];
					$end = $row['endPDB'];
					$method = $row['method'];
		
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
						print'<td width="18%" align=center>'.$currentDomain.'</td>
								<td width="74%">'.$fragmentPrint.'</td></tr>';
						$currentMethod=$method;
						$currentDomain = $struct;
						$fragmentPrint = $start.'-'.$end;
						print'<tr><td colspan=3>  </td></tr><tr><td width="18%" align=center>'.$method.'</td>';
					}
				}
		
				//print final domain that not yet output
				print'<td width="18%" align=center>'.$currentDomain.'</td>
					<td width="74%">'.$fragmentPrint.'</td></tr>';
				print '</tr>';
			}
			
			// now add the consensus
			mysql_data_seek($consensus,0);
			
			$row = mysql_fetch_array($consensus);
			$currentConsensus = 1;
			$currentDomain = $structId.$chainId.$row['domain'];
			$fragmentPrint = $row['domainStart'].'-'.$row['domainEnd'];
	
			print'<tr><td colspan=3>  </td></tr><tr><td width="18%" align=center>Consensus</td>';
	
			
			while($row = mysql_fetch_array($consensus))
			{
				$struct = $structId.$chainId.$row['domain'];
				$fragment = $row['fragmentNo'];
				$start = $row['domainStart'];
				$end = $row['domainEnd'];
				$conNum = $row['consensusNumber'];
	
				if($conNum==$currentConsensus) 
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
					$currentConsensus = $conNum;
					print'<td width="18%" align=center>'.$currentDomain.'</td>
							<td width="74%">'.$fragmentPrint.'</td></tr>';
				
					$currentDomain = $struct;
					$fragmentPrint = $start.'-'.$end;
					print'<tr><td width="18%" align=center>Consensus Option 2</td>';
				
				}
			}

			//print final domain that not yet output
			print'<td width="18%" align=center>'.$currentDomain.'</td>
				<td width="74%">'.$fragmentPrint.'</td></tr>';
			print'</table><BR>';

			print '<P ALIGN="CENTER"><A HREF="DownloadSimpleConsensusResult.php?pdbId='.$structId.'&chainId='.$chainId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&chain='.$tempChain.'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"].'&ConsensusNumber='.$consensusNumber.'&highWeight='.$highConsensusScore.'&nextWeight='.$nextConsensusScore.'&highMeths='.$highConsensusMethods.'&nextMeths='.$nextConsensusMethods.'">Download These Results in CSV Format</A></P><BR><BR>';
			

		}
		
		else
		{
			print '<p align=center><b>No Consensus could be generated for this chain using this approach</b><BR>No grouping of methods could be found that met the set threshold score of 40';
			print '</p>';
		}

		print '<BR><b>Explanation of Simple Consensus Process</b><BR><BR>

		The above shows the result gained through adopting the Simple Consensus Approach in order to generate a consensus domain assignment for this chain using the results of each automatic algorithms prediction.  How this compares with CATH and SCOP is also shown.  
		<BR><BR>
		This consensus has been generated through grouping the methods by similarity of domain and fragment boundaries.  Methods are placed in the same group if all the domain and fragment boundaries are within a window of 20% of the average domain or fragment length.  This is calculated during the process by comparing the method with the first method in each group, or the Reference Method.  Should any boundaries not fall within the window, the method falls into a different group
		<BR><BR>
		Once the methods are in groups, a score is calculated for the group.  In this case, the score is the number of methods in the group deivided by the total number of methods that make an assignment.  The group that has the highest score over 0.4 is recognised as the consensus.  Should any group have a score within 0.1 of the highest group, this is also presented as a potential consensus.
		<BR><BR>
	In some cases, no group of methods scores over 0.4.  In these cases, it is deemed that no consensus domain assignment can be produced for this chain
		<BR><BR>';

	}


	
	else         // PDB & Chain Combination was not found in database
	{
		print '
		  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
			<tr align="left">
			  <td valign="top" width="242">';
			  PrintSideMenuBox("Results",ResultSideMenuItems("Error","Simple Consensus",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
			  print '
			  </td>
			  <td valign="top" align="left">
	        <div id="textheading">Simple Consensus</div>
	
		<div id="textinfo">
		<div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px;">';

		print '<BR><BR>The protein you have entered cannot be found in the dConsensus Database.<BR>';
			print '<A HREF="consensusform2012.php">Click Here to return to the form and try again</A><BR><BR><BR><BR><BR><BR><BR>';

		PrintFooter();
	}

?>
