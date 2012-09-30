<?php
	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chain"];

	$start = $_GET["start"];
	$end = $_GET["end"];
	
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
		return $searchStr;    // this will be added to query in getMethods function
	}

	/**
	 * getMethods - returns a ResultSet containing all the methods that have generated domain assignments on this chain.  Also ensures that
	 * the search only includes the methods that the user has selected
	 * 
	 * @return methods	a resultset containing all the methods found in the database for this chain
	 */
	function getMethods()
	{
		global $structId,$chainId,$dbname,$con,$selMeths;
		mysql_select_db($dbname, $con);
		// firstly make sure the methods that the user has selected to ignore are not included
		$methsToIgnore = generateSearchString();
		$methods = mysql_query("SELECT DISTINCT method,FIELD(method,'CATH','SCOP','pdp','DHcL','dp','DDomain','NCBI','PUU','Dodis') AS SORTER FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method<>'CATH' and method<>'SCOP'".$methsToIgnore." ORDER BY SORTER ASC");          // note added the functions that are to be excluded

		return $methods;
	}

	// set a colour for each of the algorithms
	// as the display iterates through methods, store these in an array, so these can be accessed when needed with method as key
	$methcols = array();  
	$methcols["PUU"] = "#F7F9D0"; 
	$methcols["dp"] = "#E6DBFF";
	$methcols["pdp"] = "#EAFFEF";
	$methcols["DDomain"] = "#C9DECB";
	$methcols["DHcL"] = "#F4D2F4";
	$methcols["NCBI"] = "#FFDFDF";
	$methcols["Dodis"] = "#C9EAF3";

	include("components/environment.php");
	include("components/menu.php");
	include("components/resultssidemenu.php");
	
	PrintHeader("Results: Boundary Analysis");

	// Now need to recover the amino acid sequence and secondary structure for around this region
	$dsspdata = mysql_query("SELECT residueNumCIF,aminoAcidCode,secondaryStructure FROM dssp where structId='".$structId."' and chainId='".$chainId."' and (residueNumCIF>=".$start." and residueNumCIF<=".$end.")");

	if($dsspdata!=null)    // start and end were valid
	{
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",ResultSideMenuItems("Results","Boundary Analysis",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Protein Chain Region Analysis</div>

	<div id="textinfo">';
	
	// print selected protein and chain
	print '<b>Selected Protein:</b> '.$_GET["pdbId"].' <b>Chain:</b> '.$_GET["chain"].' <b>Start of Region:</b> '.$start.' <b>End of Region:</b> '.$end.'</div><BR><BR>';
	
	print '<div id="aminos">';

	

	$SSFrags = array();
	$AAFrags = array();
	// now generate the amino acid and secondary structure strings
	$aminoCode = "";
	$secStrucCode = "";
	$length = mysql_num_rows($dsspdata);
	$arrayPos=1;
	$curPos=0;                   // used to format rows, i.e. if reaches 50, goes onto next row
	
	while($row = mysql_fetch_array($dsspdata))
	{
		// generate the amino acid and sec struc data strings
		//broken into fragments of 20 if over 50 to make display look better
		$amacid = $row['aminoAcidCode'];
		$secstruc = $row['secondaryStructure'];
		if($secstruc==null)                          // no sec structure so assign a space
		{
			$secstruc = " ";
		}

		if($curPos<50)                                           // still room on string
		{
			$secStrucCode = $secStrucCode.$secstruc;
			$aminoCode = $aminoCode.$amacid;
			$curPos=$curPos+1;
		}	
		else                                                   // line is 50 long, store in array, then start new split of chain
		{
			$SSFrags[$arrayPos] = $secStrucCode;
			$AAFrags[$arrayPos] = $aminoCode;
			$curPos = 0;
			$arrayPos = $arrayPos+1;
			$secStrucCode = $secstruc;
			$aminoCode = $amacid;
		}
	}
	if((strcmp($secStrucCode,"")!=0) && (strcmp($aminoCode,"")!=0))          // i.e. the rest has not been added to the array yet as not over 50
	{
		$SSFrags[$arrayPos] = $secStrucCode;
		$AAFrags[$arrayPos] = $aminoCode;
	}
		
	print '<BR>';
	$methods = getMethods();               // get the methods which have made an assignment for this chain, in the order of reliability
	$methsFrags = array();                       // array to hold display string for each methid
	while($row = mysql_fetch_array($methods))     // for each method
	{
		// for each method, build the string which will be displayed to show where the boundaries are
		$method = $row["method"];
		$cuts = mysql_query("SELECT * FROM domains.automeths where domain REGEXP'^".$structId.$chainId."' and (end>='".$start."' and end<='".$end."') and method='".$method."'order by end");
		$cuttracker=$start;                         // keeps track of what point in generation of string we are at
		$methString = "";                             // will hold the generated string showing the cuts

		while($cutsrow = mysql_fetch_array($cuts))          // i.e. for each cut in the chain
		{
			$cut = $cutsrow["end"].'<BR>';
			while($cuttracker<$cut)                 // string of 1s until cut is reached
			{
				$methString = $methString."1";
				$cuttracker = $cuttracker+1;
			}
			$methString = $methString."2";           // add a 2 to signify there is a cut
			$cuttracker = $cuttracker+1;
		}
		if($cuttracker!=$end)
		{
			while($cuttracker<=$end)                    // complete to end of length asked for by user
			{
				$methString = $methString."1";
				$cuttracker = $cuttracker+1;
			}
		}
		// add the generated string to an array - this is used later on to split the length into groups of 50 incase a long string is
		// specified
		$methsFrags[$method] = $methString;
	}

	
	//$aminoCode = $aminoCode."..";

	// Now print these to the screen - table used row 1 amino acids, row 2 is DSSP method, each letter is in its own column
	print '	<TABLE align=center width="95%" border=0>';
	$i=1;
	while($i<=sizeof($AAFrags))
	{
		mysql_data_seek($methods,0);    // reset methods as used for display each time the loop goes round
		print '<TR border=0><TD>AA Code</TD>';
		$AAarray = preg_split('//', $AAFrags[$i], -1, PREG_SPLIT_NO_EMPTY);
		foreach($AAarray as $char) 
		{
			print '<TD align=center>'.$char.'</TD>';	
		}
		print '</TR><TR><TD>DSSP</TD>';
		$SSarray = preg_split('//', $SSFrags[$i], -1, PREG_SPLIT_NO_EMPTY);
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
		print '</TR>';
		// spacer row
		print '<TR><TD colspan=51><p> </p> </TD></TR>';

	
		// Now display the method line for each method
		while($row = mysql_fetch_array($methods))
		{
			$method = $row["method"];
			print '<TR>';
			print '<TD>'.$method.'</TD>';
			$endoff = $i*50;
			$methArray = preg_split('//', substr($methsFrags[$method],($endoff-50),$endoff), -1, PREG_SPLIT_NO_EMPTY);
			foreach($methArray as $char)
			{
				if($char == "1")             // not a cut
				{
					print '<TD bgcolor="'.$methcols[$method].'" align=center></TD>';	
				}
				else                         // a cut
				{
					print '<TD bgcolor="#FF0000" align=center></TD>';	
				}
			}
			print '</TR>';
		}
		// spacer row
		print '<TR><TD colspan=51><p> </p> </TD></TR>';

		$i = $i+1;
	}
	print '</TABLE></div>
	       <div id="textinfo">
		<table width="95%">
		<tr>
			<td width="3%" bgcolor="#FF0000"></td><td width="97%">Position in Amino Acid Chain where method predicts domain boundary</td>
		</tr>
		<tr>
			<td width="3%" bgcolor="#99CCFF"></td><td width="97%">Positions in Chain noted as Helix Structures by DSSP Method<td>
		</tr>
		<tr>
			<td width="3%" bgcolor="#FF9900"></td><td width="97%">Positions in Chain noted as Beta Sheet Structures by DSSP Method</td>
		</tr>
		</table></div>';
		
	}	
	else
	{
		print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",ResultSideMenuItems("RegError","Boundary Analysis",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
		  print '
		  </td>
		  <td valign="top" align="left">';

		print '<div id="textinfo"><p align=center>
			There was a problem processing the start and end positions you have entered<BR>
			<A HREF="boundaryanalysis.php?pdbId='.$structId.'&chain='.$chainId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"].'">Click Here to Return to the Selection Form
			</p></div>';
	}
	

	//<TR>
	//	<TD COLSPAN=2>'.$start.'</TD>
	///	<TD COLSPAN=41></TD>
	//	<TD COLSPAN=2>'.$end.'</TD>
	//	
	//</TR><TR>';

	//$AAarray = preg_split('//', $aminoCode, -1, PREG_SPLIT_NO_EMPTY);
		
	//foreach($AAarray as $char) 
	//{
	//	print '<TD align=center>'.$char.'</TD>';	
	//}
	//print '</TR><TR>';
	//print '<TD><TD>';              // as there is no ".." on the sec struc string

	//$SSarray = preg_split('//', $secStrucCode, -1, PREG_SPLIT_NO_EMPTY);
		
	//foreach($SSarray as $char) 
	//{
	//	if((strcmp($char,"H")==0) or (strcmp($char,"G")==0) or (strcmp($char,"I")==0))     // structure is a helix
	//	{
	//		print '<TD bgcolor="#99CCFF" align=center>'.$char.'</TD>';
	//	}
	//	else if(strcmp($char,"E")==0)     // structure is a sheet
	//	{
	//		print '<TD bgcolor="#FF9900" align=center>'.$char.'</TD>';
	//	}
	//	else
	//	{
	//		print '<TD align=center>'.$char.'</TD>';
	//	}
	//}
	//print '<TD><TD></TR></TABLE></div><BR><BR>';            // 2 TD to replace non existant .. and complete row





