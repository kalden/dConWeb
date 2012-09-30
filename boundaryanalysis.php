<HTML>
<HEAD>
<script language="JavaScript">
function checkForm()
{
   var endpos, startpos;
   with(window.document.regionform)
   {
      startpos = start;
      endpos = end;
   }

   if(trim(startpos.value) == '')
   {
      alert('Please enter a start position');
      structId.focus();
      return false;
   }
   else if(trim(endpos.value) == '')
   {
      alert('Please enter an end position');
      chainId.focus();
      return false;
   }
   else
   {
      startpos.value = trim(startpos.value);
      endpos.value = trim(endpos.value);
      return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}
</script>
</head>

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

	// two arrays will be used, one to keep track of beta sheet cuts, the other helix cuts.  Key of each array is the method
	$sheetCuts = array();
	$helixCuts = array();

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

	/**
	* generateSearchString - generates a string to include in the getMethods mysql query, which ensures that the results do not contain results
	* from methods the user has deselected
	*
	* @return searchStr	The string to append to the mysql search
	*/
	function generateSearchString()
	{
		// Generates a mysql string to add to the query to exclude the methods that the user does not want considering in consensus
		global $selMeths;
		$searchStr = '';
		while ($answer = current($selMeths)) 
		{
			if ($answer == 'false')         // the user has not selected this method
			{
				$searchStr = $searchStr.' and method<>"'.key($selMeths).'"';
			}
			next($selMeths);
		}
		reset($selMeths);
		return $searchStr;    // this will be added to query in getMethods function
	}

	/**
	 * getMethods - returns a ResultSet containing all the methods that have generated domain assignments on this chain
	 * 
	 * @param structId	the pdbId of the chain being examined
	 * @param chainId	the chainId being processed
	 * @return methods	a resultset containing all the methods found in the database for this chain
	 */
	function getMethods()
	{	
		global $structId,$chainId,$selMeths,$dbname,$con;
		mysql_select_db($dbname, $con);
		// get the methods excluding CATH and SCOP and those deselected by user as these will not form part of the analysis
		$methsToIgnore = generateSearchString();		
		$methods = mysql_query("SELECT DISTINCT method FROM automeths WHERE domain REGEXP'^".$structId.$chainId."'  and method<>'CATH' and method<>'SCOP'".$methsToIgnore);
		
		return $methods;
	
	}

	function getChainCutStats()
	{
		global $structId,$chainId,$selMeths,$dbname,$con,$helixCuts,$sheetCuts;
		mysql_select_db($dbname, $con);

		// Firstly get the methods that have made domain assignment predictions
		$methods = getMethods();

		// now go through each method, checking the cuts that the algorithm has made
		while($row = mysql_fetch_array($methods))
		{
			$method = $row['method'];

			// Initialise the cuts array, so both arrays have an entry with each method as a key, pointing to an array which will contain
			// cuts made by that method
			$blankArray = array();
			$helixCuts[$method] = $blankArray;
			$sheetCuts[$method] = $blankArray;

			// Now get the domain assignment for this method
			$domains = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$method."' ORDER BY start");
			// get the number of results - needed to calculate number of cuts (if they exist)
			$resultSize = mysql_num_rows($domains);

			// Now process the cuts if there is more than one result (i.e. there are cuts in the chain
			if($resultSize>1)
			{
				// Now look at each cut made by the method - except that of the end of the chain
				$i=0;
				while($i<$resultSize-1)
				{
					$row = mysql_fetch_array($domains);
					$cutPos = $row['end'];
					// now determine if a secondary structure feature is cut at this position
					checkPosSecStruc($cutPos,$method);
					$i = $i+1;
				}
			}
		}
	}

	function checkPosSecStruc($pos,$method)
	{
		// check if a secondary structure at this position has been cut
		// Rule set to ignore a helix cut if it is the first/second or penultimate/last residue in helix
		// and ignore a beta cut if it is first or last residue in sheet
		// Therefore these results get the two residues either side of this position as well
		
		global $structId,$chainId,$selMeths,$dbname,$con,$sheetCuts,$helixCuts;
		mysql_select_db($dbname, $con);

		$lowbound = $pos-2;
		$upbound = $pos+2;

		$secStruc = mysql_query("SELECT secondaryStructure FROM dssp WHERE structId='".$structId."' and chainId='".$chainId."' and (residueNumCIF>='".$lowbound."' AND residueNumCIF<='".$upbound."')");
	
		// Now retrieve the secondary structure at this position (third row in results)
		mysql_data_seek($secStruc,2);
		$row = mysql_fetch_array($secStruc);
		$strucKey = $row['secondaryStructure'];
		mysql_data_seek($secStruc,0);
		
		// Now check if a helix has been cut or not
		if((strcmp($strucKey,"H")==0) or (strcmp($strucKey,"G")==0) or (strcmp($strucKey,"I")==0))
		{
			// this position is noted as a helix structure
			$validHelixCut = processHelix($secStruc,$pos);
			if($validHelixCut)
			{
				// get the current cuts list made by this method from the array
				$cuts = $helixCuts[$method];
				// add new position of cut
				$cuts[] = $pos;
				// remove the original list from helix cuts
				unset($helixCuts[$method]);
				// add the new list
				$helixCuts[$method] = $cuts;
				//print 'Helix Cut: Position: '.$pos.' '.$validHelixCut.' '.$method.'<BR>';
			}
			mysql_data_seek($secStruc,0);			
			
				
		}
		else if(strcmp($strucKey,"E")==0)
		{
			// this position is noted as a sheet
			$validSheetCut = processSheet($secStruc,$pos);
			if($validSheetCut)
			{
				// get the current cuts list made by this method
				$cuts = $sheetCuts[$method];
				// add new position of cut
				$cuts[] = $pos;
				// remove the original list from helix cuts
				unset($sheetCuts[$method]);
				// add the new list
				$sheetCuts[$method] = $cuts;
				//print 'Sheet Cut: Position: '.$pos.' '.$validSheetCut.' '.$method.'<BR>';
			}
			mysql_data_seek($secStruc,0);			
		}
	}
	
	function processHelix($secStruc,$pos)
	{
		// It has been determined that the residue at the third position in this set is a helix
		// Now need to determine if this is the first,second,penultimate,or last in helix - if so
		// not count this as a cut.
		
		// Therefore, if either of the two positions either side of this are not a helix, the cut can be ignored
		global $structId,$chainId,$selMeths,$dbname,$con;
		mysql_select_db($dbname, $con);

		$validCut=true;
		while(($row = mysql_fetch_array($secStruc)) && $validCut)
		{
			$struc = $row['secondaryStructure'];
			if(!(strcmp($struc,"H")==0) && !(strcmp($struc,"G")==0) && !(strcmp($struc,"I")==0))
				$validCut = false;					// return true if cut can be ignored
			

		}
		return $validCut;
	}
	
	function processSheet($secStruc,$pos)
	{
		// It has been determined that the residue at the third position in this set is a sheet
		// Now need to determine if this is the first or last in the sheet - if so
		// not count this as a cut.
		
		// Therefore, if either of the positions either side of this are not a sheet, the cut can be ignored
		global $structId,$chainId,$selMeths,$dbname,$con;
		mysql_select_db($dbname, $con);

		$validCut=true;
		// need to ignore the 1st element
		mysql_data_seek($secStruc,1);
		$i=0;
			
		while(($row = mysql_fetch_array($secStruc)) && validCut && $i<3)
		{
			$struc = $row['secondaryStructure'];
			if(!strcmp($struc,"E")==0)
				$validCut = false;
			$i=$i+1;
		}
		return $validCut;
	}
	
	

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
        <div id="textheading">Boundary Analysis</div>
        <div id="textinfo"><div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px;">';
	
	// print selected protein and chain
	print '<b>Selected Protein:</b> '.$_GET["pdbId"]. ' <b>Chain:</b> '.$_GET["chain"].'<BR>';

	print'<BR><b>Analysis - Secondary Structure </b><BR></div>

	The table below shows the number of times each method predicts a domain or fragment boundary within an alpha helix or beta sheet structure, and the positions where these occur<BR>
	The secondary structure analysis has been completed through the use of the DSSP Method (Kabsch & Sander, 1983).  The structure at and around the position at which the method predicts a domain boundary is examined.  The boundary is considered to be within an alpha helix if the position is not the
first, second, penultimate, or last element of a helix; and considered to be within a beta sheet if the position is not the first or last position in a sheet<BR><BR>';



	getChainCutStats();

	print'

	<TABLE width=95%>
	<TR bgcolor="#6887C4">
		<TH ROWSPAN=2 width="18%" align=center>Method<TH COLSPAN=2 width="41%" align=center>Boundaries within Alpha Helix<TH COLSPAN=2 width="41%" align=center>Boundaries Within Beta Sheet
	</TR>
	<TR bgcolor="#6887C4">
		<TD align=center>Number</TD><TD align=center>Position(s)</TD><TD align=center>Number</TD><TD align=center>Position(s)</TD>
	</TR>';

	$keys = array_keys($helixCuts);
	$numrecs = sizeof($keys);
	$i=0;
	while($i<$numrecs)
	{
		if($selMeths[$keys[$i]]=="true")
		{
			print '<TD align=center>'.$keys[$i].'</TD>';
			$hcuts = current($helixCuts);
			print '<TD align=center>'.sizeof($hcuts).'</TD>';

			// now print each position where there is a helix cut
			$cutstr = "";
			foreach($hcuts as $cut)
				$cutstr = $cutstr.$cut.' ';
			print '<TD align=center>'.$cutstr.'</TD>';
		
			$scuts = current($sheetCuts);		
			print '<TD align=center>'.sizeof($scuts).'</TD>';
	
			// Now complete the table with the sheet cuts found
			$cutstr = "";
			foreach($scuts as $cut)
				$cutstr = $cutstr.$cut.' ';
			print '<TD align=center>'.$cutstr.'</TD></TR>';
		}
	
		$i = $i+1;
		next($helixCuts);
		next($sheetCuts);
	}
	print '</TABLE>';

	// Now there will be a table showing the position of the cuts - the user will be able to click on the number, and be able to see the
	// secondary structure of this fragment
	// firstly need to get the methods

	print '<div id="textinfo">';
	//<div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px; width: 650px;">
	print'
	<BR><b>Analysis of Domain & Fragment Boundaries:</b><BR></div>
	This tool offers three ways to analyse where the predicted domain boundaries fall within the chains secondary structure:
	<ul>
		<li>Analysis of Individual Boundaries
		<li>View a Selection of Boundaries for Comparison
		<li>View all predicted cuts in the chain for a selected region
		
	</ul>';
	$methods = getMethods();
	

	//<div style="padding-left:40px; padding-top: 8px; padding-bottom: 8px; width: 650px;">
	print '
		<TABLE WIDTH="95%">
			<TR bgcolor="#6887C4"><TD align=center COLSPAN=30><b>A. View Individual Cuts (click on the position)</b></TD></TR>
			<TR bgcolor="#6887C4">
				<TH align=center width="18%">Method<TH align=center width="74%" colspan=20>Cut(s)
				<TD width="18%" ROWSPAN='.(mysql_num_rows($methods)+1).' align=center></TD>
			</TR><TR>';

	// now go through each method to get cuts and display
	$checkboxCount = 0;	
	//print '<FORM name="boundaryform" action="boundarySelection.php" method="get">';
	
	while($row = mysql_fetch_array($methods))
	{
		$meth = $row['method'];
		print '<TD align=center>'.$meth.'</TD>';
		// now get the assignments for this method
		$domains = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$meth."' ORDER BY end");
		$numResults = mysql_num_rows($domains);
		$i=0;
		while(($row = mysql_fetch_array($domains)) && ($i<$numResults-1))
		{
			// now generate all the cuts
			$cut = $row['end'];
			print '<TD width="8%" align=center><A HREF="boundaryView.php?pdbId='.$structId.'&chain='.$chainId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"].'&Cut='.$cut.'&Method='.$meth.'">'.$cut.' </A></TD>';
			$i=$i+1;
		}
		print '</TR><TR>';
	}
	print '<FORM name="boundaryform" action="boundarySelection.php" method="get"><TR bgcolor="#6887C4"><TD align=center COLSPAN=30><b>B. See Selection of Cuts (tick boxes and press See Selection)</b></TD></TR>
			<TR bgcolor="#6887C4">
				<TH align=center width="18%">Method<TH align=center COLSPAN=20 width="74%">Cut(s)
				<TD width="18%" ROWSPAN='.(mysql_num_rows($methods)+1).' align=center><input type="submit" value="See Selection"></TD>
			</TR><TR>
		<input type="hidden" name="pdbId" value="'.$structId.'">
		<input type="hidden" name="chain" value="'.$chainId.'">
		<input type="hidden" name="CATH" value="'.$selMeths["CATH"].'">
		<input type="hidden" name="SCOP" value="'.$selMeths["SCOP"].'">
		<input type="hidden" name="pdp" value="'.$selMeths["pdp"].'">
		<input type="hidden" name="dp" value="'.$selMeths["dp"].'">
		<input type="hidden" name="DHcL" value="'.$selMeths["DHcL"].'">
		<input type="hidden" name="Dodis" value="'.$selMeths["Dodis"].'">
		<input type="hidden" name="PUU" value="'.$selMeths["PUU"].'">
		<input type="hidden" name="DDomain" value="'.$selMeths["DDomain"].'">
		<input type="hidden" name="NCBI" value="'.$selMeths["NCBI"].'">';

	mysql_data_seek($methods,0);
	$checkboxCount = 0;
	
	while($row = mysql_fetch_array($methods))
	{
		$meth = $row['method'];
		print '<TD align=center>'.$meth.'</TD>';
		// now get the assignments for this method
		$domains = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$meth."' ORDER BY end");
		$numResults = mysql_num_rows($domains);
		$i=0;
		while(($row = mysql_fetch_array($domains)) && ($i<$numResults-1))
		{
			// now generate all the cuts
			$cut = $row['end'];
			print '<TD width="50" align=center valign=center><input type="checkbox" name="'.$checkboxCount.'" value="'.$meth.'!'.$cut.'"><BR>'.$cut.'</TD>';
			$i=$i+1;
			$checkboxCount=$checkboxCount+1;
		}
		print '</TR><TR>';
	}

	print '</FORM><FORM name="regionform" action="boundaryRegion.php" method="get"><TR bgcolor="#6887C4"><TD align=center COLSPAN=30><b>C. See All Cuts Within a Region</b></TD></TR>
	<TR>
	<TD COLSPAN=30>
	<TABLE width="100%"><TR>
		<TD width="20%" align=right>Start</TD>
		<TD width="21%"align=center><input type="text" size="7" name="start"></TD>
		<TD width="20%" align=right>End</TD>
		<TD width="21%"><input type="text" size="7" name="end"></TD>
		<TD width="18%"align=center><input type="submit" value="See Region"  onClick="return checkForm();"></TD>
	</TR></TABLE>
	<input type="hidden" name="pdbId" value="'.$structId.'">
	<input type="hidden" name="chain" value="'.$chainId.'">
	<input type="hidden" name="CATH" value="'.$selMeths["CATH"].'">
	<input type="hidden" name="SCOP" value="'.$selMeths["SCOP"].'">
	<input type="hidden" name="pdp" value="'.$selMeths["pdp"].'">
	<input type="hidden" name="dp" value="'.$selMeths["dp"].'">
	<input type="hidden" name="DHcL" value="'.$selMeths["DHcL"].'">
	<input type="hidden" name="Dodis" value="'.$selMeths["Dodis"].'">
	<input type="hidden" name="PUU" value="'.$selMeths["PUU"].'">
	<input type="hidden" name="DDomain" value="'.$selMeths["DDomain"].'">
	<input type="hidden" name="NCBI" value="'.$selMeths["NCBI"].'">
	</FORM>


	</TD></TR></TABLE>';

	print '
	<br>
	<br>
	<br>';	
	
	PrintFooter();

?>
