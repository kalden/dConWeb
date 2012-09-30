<?php

	// to hold the methods and protein data the user has selected
	$selMeths = array();
	$structId;
	$chainId;

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

	// hold the two weights that produce the consensus - global as needed elsewhere in script
	$maxRelWeight = 0;         // the highest weighting found in the groups
	$nextRelWeight=0;          // second highest weight
	$groupList = array();	   // holds the methods that contribute to consensus
	$methsHigh = array();	   // holds the methods that contribute to high scoring consensus on multiple options
	$methsNext = array();	   // holds the methods that contribute to second scoring consensus on multiple options
	$altGroupList = array();   // holds the methods that contribute to second consensus

	$numMethods = 0;            // holds the number of methods chosen by the user

	// Create a connection to database
	$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
	  {
	  die('Could not connect: ' . mysql_error());
	  }

	mysql_select_db($dbname, $con);
	
	/**
	* getInput - recovers the selected parameters from the input form
	*/
	function getInput()
	{
		// the methods are received as true or false dependent if the box is ticked - these are put into a hash table
		// with the method as the key so these can be retrieved later
		global $selMeths,$structId,$chainId;

		$structId = strtoupper($_GET["pdbId"]);
		$chainId = $_GET["chain"];

		$selMeths["CATH"] = $_GET["CATH"];
		countMeths($selMeths["CATH"],"CATH");
		//print $selMeths["CATH"].'<BR>';
		$selMeths["SCOP"] = $_GET["SCOP"];
		countMeths($selMeths["SCOP"],"SCOP");
		//print $selMeths["SCOP"].'<BR>';
		$selMeths["PUU"] = $_GET["PUU"];
		//print $selMeths["PUU"].'<BR>';
		countMeths($selMeths["PUU"],"PUU");
		$selMeths["dp"] = $_GET["dp"];
		//print $selMeths["dp"].'<BR>';
		countMeths($selMeths["dp"],"dp");
		$selMeths["pdp"] = $_GET["pdp"];
		//print $selMeths["pdp"].'<BR>';
		countMeths($selMeths["pdp"],"pdp");
		$selMeths["DDomain"] = $_GET["DDomain"];
		//print $selMeths["DDomain"].'<BR>';
		countMeths($selMeths["DDomain"],"DDomain");
		$selMeths["DHcL"] = $_GET["DHcL"];
		//print $selMeths["DHcL"].'<BR>';
		countMeths($selMeths["DHcL"],"DHcL");
		$selMeths["NCBI"] = $_GET["NCBI"];
		//print $selMeths["NCBI"].'<BR>';
		countMeths($selMeths["NCBI"],"NCBI");
		$selMeths["Dodis"] = $_GET["Dodis"];
		//print $selMeths["Dodis"].'<BR>';
		countMeths($selMeths["Dodis"],"Dodis");

		//$structId = "1HTB";
		//$chainId = "A";
	}

	/**
	* countMeths - increases the count of the number of methods the user has chosen if the variable for this method is set
	* to true.  Called for each method that can be selected.
	*
	* @param method - the search string variable for the method (i.e. either true or false)
	*/	
	function countMeths($method,$meth)
	{
		global $numMethods,$selMeths;

		if($method=="true" && $meth!="CATH" && $meth!="SCOP")
		{
			$numMethods = $numMethods+1;
		}
		else
		{
			if($meth!="CATH" && $meth!="SCOP")
			{
				$selMeths[$meth] = "false";
			}
		}
	}


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
		
		while($answer = current($selMeths))
		{
			if($answer!="true")
			{
				$searchStr = $searchStr.' and method<>"'.key($selMeths).'"';
	
			}
			next($selMeths);
		}

		return $searchStr;    // this will be added to query in getMethods function
	}

	/**
	* getChainLength - recovers the length of this chain from the dssp information held in the database.  This is needed to calculate the
	* boundary window allowance
	*
	* @return chainLength	Length of the chain being examined
	*/
	function getChainLength()
	{
		$chainLength = 0;
		global $dbname,$con,$structId,$chainId;
		mysql_select_db($dbname,$con);
		// get the start of the chain - needed for the drawing function - ensures all the methods start at same point
		$getChainLength = mysql_query("SELECT MAX(residueNumCIF) FROM dssp WHERE structId='".$structId."'and chainId='".$chainId."'");
		while($row = mysql_fetch_array($getChainLength))
		{
			$chainLength = $row['MAX(residueNumCIF)'];
		}	
		//print $chainLength.'<BR>';
		return $chainLength;
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
		$methods = mysql_query("SELECT DISTINCT method FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method<>'CATH' and method<>'SCOP'".$methsToIgnore);          // note added the functions that are to be excluded

		return $methods;
	}

	/**
	 * preprocessChain - takes the chain and tests whether the chain is made of continuous domains or features domains which
	 * are split.  The decision on whether to call the continuousDomains or fragmentedChain method can then be made, as both
	 * cases need to be treated differently
	 * 
	 * @param method	the algorithm whose assignment is being processed
	 * @param length	the length of the chain being examined
	 * @return null
	 */
	function preprocessChain($method,$length)
	{
		global $structId,$chainId,$dbname,$con,$selMeths;
		$percent = 20;                  // The percentage allowed as a domain boundary window
		mysql_select_db($dbname, $con);

		// First get the number of domains
		$getdomCount = mysql_query("SELECT COUNT(DISTINCT domain) FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' AND method = '".$method."'");
		$row = mysql_fetch_array($getdomCount);
		$domCount = $row['COUNT(DISTINCT domain)'];
		
		
		// Now see if any of the domains are split (a bit of a cheat, get all the fragment identifiers, scroll to end of resultset and see if this is >1)		
		$fragCount = mysql_query("SELECT fragmentNo FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' AND method = '".$method."' ORDER BY fragmentNo");

		//count num of results in fragCount, used to move the pointer to the end
		$num_results = mysql_num_rows($fragCount);
		mysql_data_seek($fragCount,$num_results-1);

		// now get the fragment number at this point
		$row = mysql_fetch_array($fragCount);
		$fragNum = $row['fragmentNo'];

		// if fragNum>1, then there are fragmented domains in this chain
		if($fragNum>1)
		{
			fragmentedChain($method,$fragNum,$domCount,$percent,$length);
		}
		else
		{
			continuousDomains($method,$domCount,$length,$percent);
		}

	}

	/**
	 * fragmentedChain - used to work out the window for a chain where domains are split.  This is then used
	 * when comparing domain assignments and grouping the methods
	 * <P> 
	 * The average fragment size is used as the window for comparing boundaries - this is calculated by dividing the length of the protein
	 * by the number of cuts in the chain, calculated by totalling the fragment number column of the query, then dividing this by 2 and adding one
	 * This is then used by the groupFragments method
	 * 
	 * @param method	Domain assignment method which produced this assignment
	 * @param fragNum	Number of Fragments in the chain
	 * @param domCount	Number of domains in the chain
	 * @param percent	The percentage with which to calculate boundary window
	 * @param length	Length of chain
	 */
	function fragmentedChain($method,$fragNum,$domCount,$percent,$length)
	{
		global $structId,$chainId,$dbname,$con,$selMeths,$splitDomMap;

		// get the domains for this chain & method
		mysql_select_db($dbname, $con);
		$domains = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$method."'");

		// Now work out the total number of cuts through the chain to calculate the window that the comparison should use
		// Add up the number of fragments found, divide this by 2 and add 1 - gives number chain has been cut into
		$cutCount = mysql_query("SELECT SUM(fragmentNo) FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$method."'");
		$row = mysql_fetch_array($cutCount);
		$cutsInChain = ((($row['SUM(fragmentNo)'])/2)+1);
		$fragmentWindow = ((($length/$cutsInChain)/100)*$percent);
		//print $cutsInChain.' '.$fragmentWindow.'<BR>';
		groupFragments($method,$domains,$cutsInChain,$fragmentWindow,"split");

	}

	/**
	 * continuousDomains - used to work out the domain window for the continuous domain chain being examined.  This is then used
	 * when comparing domain assignments and grouping the methods
	 * <P> 
	 * This is calculated by taking the chain length, diving by the number of domains, to produce an average domain length.  Then a 
	 * percentage (taken off the global variable percent) is used to create the window.  The chain assignments are then sent to groupFragments
	 * for processing
	 * 
	 * @param method	The domain assignment method being examined
	 * @param domCount	The number of domains in this chain
	 * @param percent	The percentage with which to calculate boundary window
	 * @param length	Length of chain
	 * @return none
	 */
	function continuousDomains($method,$domCount,$length,$percent)
	{
		global $structId,$chainId,$dbname,$con,$selMeths,$continuousMap;
		// Calculate the window at which the domain boundaries should lie
		$domainWindow = ((($length/$domCount)/100)*$percent);
		// get the domains for this chain & method
		mysql_select_db($dbname, $con);
		$domains = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$method."'");
		groupFragments($method,$domains,$domCount,$domainWindow,"continuous");

	}

	/**
	 * groupFragments - grouping the methods by checking that the domain boundaries they have assigned fall within a calculated window
	 * If this is a protein with continuous domains, the window is calculated by a percentage of average domain length, if noncontinuous
	 * domains, this is a percentage of the average fragment length.  
	 * <P>
	 * A map is used - where the key is the number of the group and the value a list of lists, each list containing the method and the 
	 * ResultSet attributed to that method.  This map will be used to calculate weightings and display the consensus in later methods
	 * 
	 * @param  method	 	the method which produces this assignment
	 * @param  domains 		the ResultSet containing the domain boundaries for each domain assigned by this method
	 * @param  domCount 		the number of cuts made through the chain
	 * @param  boundaryWindow	the number of positions used to determine if the boundaries fall into the same group
	 * @param  methodMap   		two separate maps are used, one for chains with no split domains, the other for chains with split domains.  This is sent in as a parameter in order that this method can be used for both types   
	 * @return null
	 *
	*/		
	function groupFragments($method,$domains,$domCount,$boundaryWindow,$methodMap)
	{
		global $structId,$chainId,$dbname,$con,$selMeths,$continuousMap,$splitDomMap;
		mysql_select_db($dbname, $con);
		
		if(strcmp($methodMap,"continuous")==0)
			$currentMap = $continuousMap;
		else
			$currentMap = $splitDomMap;


		// Now process each domain in turn
		if(empty($currentMap))
		{
			addToMap($methodMap,$method,$domains,"null");			// Add to the map as there are no methods to compare to yet
		}
		else
		{		
			// Now need to compare the results of this method with all current groups in the map
			$placedInGroup = false;             // controls the outer for loop, stopping the hunt for a suitable group
			$mapSize = sizeOf($currentMap)+1;
			for($i=0;$i<$mapSize && !$placedInGroup;$i++)        // for each group of methods
			{
				$getResult = $currentMap[$i];
			
				$refMethod = $getResult[0];
			
				$referenceMethod = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$refMethod."' order by start");
				$methodInProcess = mysql_query("SELECT * FROM automeths WHERE domain REGEXP'^".$structId.$chainId."' and method='".$method."' order by start");
				$boundsDiffer = false;                   // stops the while loop going through all domains if one domain differs
					
				// firstly make sure that this group and the new method contain the same number of domains
				$domainsInRef = mysql_num_rows($referenceMethod);         // gives the number of rows in the reference set
				if($domainsInRef==$domCount)
				{
					// now go through each domain in turn, comparing the assignment boundaries - READD BOOLEAN!
					while(($row = mysql_fetch_array($referenceMethod)) && ($domRow = mysql_fetch_array($methodInProcess)) && (!$boundsDiffer))
					{
						$refStart = $row['start'];
						$refEnd = $row['end'];
						$fragStart = $domRow['start'];
						$fragEnd = $domRow['end'];
						
						if(!($fragStart>=($refStart-$boundaryWindow/2) && $fragStart<=($refStart+$boundaryWindow/2)) or !($fragEnd>=($refEnd-$boundaryWindow/2) && $fragEnd<=($refEnd+$boundaryWindow/2)))
						{
							// The boundary for this domain is not within the set window this group falls within
							//set flag to true so no other domain is examined
							$boundsDiffer=true;							
							
						}
					}
					// Now can add to this group if the boundaries of each domain fell within the window
					if($boundsDiffer==false)
					{
						addToMap($methodMap,$method,$methodInProcess,$i);      // String used for key so null can be sent for a new group
						$placedInGroup = true;             // to stop the for loop going through further groups	
					}
				}
			}	
			// Now need to deal with the case where a group has not been found for the method - this needs to
			// be in a new group, so add this to the map
			if(!$placedInGroup)
			{
				addToMap($methodMap,$method,$methodInProcess,"null");
			}
		
		}
	}

	function addToMap($methodMap,$method,$domains,$key)
	{
		global $structId,$chainId,$dbname,$con,$selMeths,$continuousMap,$splitDomMap;
		$methodVal = array();     // will hold the value (i.e method & assignment)
		$keyVal = array();        // list of lists - holds each list of method & assignment pair
		$methodVal[] = $method;   // add the method
	
		if(strcmp($key,"null")==0)                              // i.e. adding a new key value pair
		{       
			if(strcmp($methodMap,"continuous")==0)
			{
				$continuousMap[] = $methodVal;        // add the new group to the map
			}
			else
			{
				$splitDomMap[] = $methodVal;        // add the new group to the map
			}
			
		}
		else
		{	
			if(strcmp($methodMap,"continuous")==0)
			{
				$currentVal = $continuousMap[$key];
				$currentVal[] = $method;
				unset($continuousMap[$key]);	
				$continuousMap[$key] = $currentVal;
			}
			else
			{
				$currentVal = $splitDomMap[$key];
				$currentVal[] = $method;
				unset($splitDomMap[$key]);	
				$splitDomMap[$key] = $currentVal;
				
			}
		}

	}
	
	/**
	 * joinMaps - up to now, to solve confusion over domain and fragment numbers, and where they could possibly be equal though the
	 * number of assigned domains may differ - two maps have been used to keep things simple.  This method joins them into one to aid
	 * generation of weights and finding the consensus.  As the number of entries is on a small scale and the map will never get to a large
	 * size, this is not a real problem - maybe not the best method but good for simplicities sake
	 * 
	 * @param none
	 * @return none
	 */
	function joinMaps()
	{
		global $structId,$chainId,$dbname,$con,$selMeths,$continuousMap,$splitDomMap,$finalMap;
		
		foreach ($continuousMap as $value) 
		{
			$finalMap[] = $value;
		}
		foreach ($splitDomMap as $value) 
		{
			$finalMap[] = $value;
		}
	}

	/**
	 * generateWeights - goes through each key in the joined map and assigns a weight for that groups domain assignment. This is
	 * determined as the number of methods that produces this assignment divided by the total number of methods for which an
	 * assignment is available.  This is also stored in a map (weights) which is used later to generate a consensus.  Note the key
	 * for the weights map is the same as the group map, in order for easy recovery of the methods later on
	 * 
	 * @param numMethods	The number of methods that have generated an assignment for this chain
	 * @return null
	 */
	function generateWeights()
	{
		global $finalMap,$weights,$numMethods;

		foreach ($finalMap as $value)
		{
			$groupSize = sizeof($value);
			$weight = $groupSize/$numMethods;
			$weights[] = $weight;
			
		} 
	}

	
	function generateConsensus()
	{
		global $weights,$finalMap,$dbname,$con,$structId,$chainId,$maxRelWeight,$nextRelWeight,$groupList,$altGroupList;
		$groupHighWeight = 0;       // holds the key generating the highest weight

		// rule set that If relative weight of two groups is close (within 0.1 of each other) 
		//and the relative weight of at least one of them is >=0.4, then no clear consensus can 
		//be decided, but both solutions should be displayed, therefore, also store those that are
		//0.1 close to max solution to solve going through the list twice
		$nextHighWeight = 0;

		// hold the keys for the weights map - this will be used to recover the group list that produced this weight
		$keys = array_keys($weights);
		//print_r($weights);		

		$j=0;    // keep count of weights processed
		foreach ($weights as $value)
		{
			if($value>$maxRelWeight)		// there is a new maximum weight
			{
				if($nextRelWeight!=0)        // i.e. there was a next closest to the max so this needs changing to the old max
				{
					$nextRelWeight = $maxRelWeight;
					$nextHighWeight = $groupHighWeight;
				}
				// now set the maximum to be the new found maximum
				$maxRelWeight = $value;
				// recover the key for the group that produces this weight
				$groupHighWeight = $keys[$j];
			}
			else
			{
				if(($maxRelWeight-$value)<=0.1)        // i.e. the weight is close to the maximum
				{
					$nextRelWeight = $value;
					$nextHighWeight = $keys[$j];
				}
			}	
			$j = $j+1;
		}

		mysql_select_db($dbname, $con);
			
		if(($maxRelWeight>=0.4) && (($maxRelWeight-$nextRelWeight)>0.1))           // this will be the consensus
		{
			// Now find the method to set boundaries - dp preferable, then pdp, then NCBI, else other
			$groupList = $finalMap[$groupHighWeight];
			if(in_array("dp",$groupList))
			{
				$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and method='dp' ORDER BY start");
			}
			else if(in_array("pdp",$groupList))
			{
				$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and method='pdp' ORDER BY start");
			}
			else if(in_array("NCBI",$groupList))
			{
				$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and method='NCBI' ORDER BY start");
			}
			else
			{
				$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and method='".$groupList[0]."' ORDER BY start");
			}

		}
		else if($maxRelWeight>=0.4 && $nextHighWeight!=0)     // there are two options and no strong consensus, so display both options
		{
			// Two options for consensus:
			$groupList = $finalMap[$nextHighWeight];
			$altGroupList = $finalMap[$groupHighWeight];
			// swapped as labels did not match consensus - will investigate further but works as temporary fix

			// now get the two best algorithm results to display as the double consensus option:
			if(in_array("dp",$groupList))
			{
				if(in_array("pdp",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='dp' or method='pdp')ORDER BY method,start");
				}
				else if(in_array("NCBI",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='dp' or method='NCBI')ORDER BY method,start");
				}
				else
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='dp' or method='".$altGroupList[0]."') ORDER BY method,start");
				}
			}

			else if(in_array("pdp",$groupList))
			{
				if(in_array("dp",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='pdp' or method='dp')ORDER BY method,start");
				}
				else if(in_array("NCBI",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='pdp' or method='NCBI')ORDER BY method,start");
				}
				else
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='pdp' or method='".$altGroupList[0]."') ORDER BY method,start");
				}
			}
			
			else if(in_array("NCBI",$groupList))
			{
				if(in_array("dp",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='NCBI' or method='dp')ORDER BY method,start");
				}
				else if(in_array("pdp",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='pdp' or method='NCBI')ORDER BY method,start");
				}
				else
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='NCBI' or method='".$altGroupList[0]."') ORDER BY method,start");
				}
			}

			else
			{
				if(in_array("dp",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='".$groupList[0]."' or method='dp')ORDER BY method,start");
				}
				else if(in_array("pdp",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='".$groupList[0]."' or method='pdp')ORDER BY method,start");
				}
				else if(in_array("NCBI",$altGroupList))
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='".$groupList[0]."' or method='NCBI')ORDER BY method,start");
				}
				else
				{
					$consensus = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='".$groupList[0]."' or method='".$altGroupList[0]."') ORDER BY method,start");
				}
			}
		}
		else         // no viable consensus
		{
			$consensus = null;
		}

		return $consensus;
	
	}

	function getConsensus()
	{
		global $dbname,$con,$continuousMap,$splitDomMap,$numMethods;
		mysql_select_db($dbname, $con);

		//Calculate window needs the length of the chain - taken from the dssp data
		getInput();
		$length=getChainLength();
		$consensus=null;

		if($length>0)           // a length result was returned
		{
			// get the list of methods - excluding CATH and SCOP as these will not be part of consensus
			$methods=getMethods($dbname,$con,$structId,$chainId,$selMeths);
			$numMethods = 0;
			while($row = mysql_fetch_array($methods))
			{
				$method = $row['method'];
				preprocessChain($method,$length);
				$numMethods = $numMethods+1;		
			}
			joinMaps();
			generateWeights();
			$consensus = generateConsensus();
			//viewConsensus($consensus);
		}	
		return $consensus;	
	}

	function viewConsensus($consensus)
	{
		if($consensus!=null)
		{

			while($row = mysql_fetch_array($consensus))
			{        // i.e. for each domain found in the database
				$domain = $row['domain'];
				$fragment = $row['fragmentNo'];
				$start = $row['start'];
				$end = $row['end'];
				$method = $row['method'];
				print $domain." ".$fragment." ".$start." ".$end." ".$method;
			}
		}
		else
			print 'None';
	}


	
	include("components/environment.php");
	include("components/menu.php");
	include("components/resultssidemenu.php");
	
	PrintHeader("Results: Consensus Assignment");

	
	$consensus = getConsensus();
	//print mysql_num_rows($consensus);

	// get the start of the chain - used in this case to check the chain exists (as used in compareassignments.php - bit daft,
	// maybe another way will soon be found).  This was implemented as a quick fix to ensure the correct message is displayed
	// (i.e. chain does not exist, not that no consensus exists)
	$getChainStart = mysql_query("SELECT MIN(start) FROM automeths WHERE domain REGEXP '^".$structId.$chainId."'");
	while($row = mysql_fetch_array($getChainStart))
	{
		// check if chainstart is null - if so, the chain or protein does not exist and an error will need presenting
		$chainStart = $row['MIN(start)'];
	}

	// Now get consensus if the chian exists
	if($chainStart!=null)
	{
		print '
		  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
			<tr align="left">
			  <td valign="top" width="242">';
			  PrintSideMenuBox("Results",ResultSideMenuItems("Results","Simple Consensus",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
			  print '
			  </td>
			  <td valign="top" align="left">
        	<div id="textheading">Simple Consensus</div>

		<div id="textinfo">
		<div style="padding-left:20px; padding-top: 8px; padding-bottom: 8px;">';
		
		// print selected protein and chain
		print '<b>Selected Protein:</b> '.$_GET["pdbId"]. ' <b>Chain:</b> '.$_GET["chain"].'<BR><BR>';
		print '<b>Result:</b><BR>';

		if($consensus!=null)
		{
			$num_results = mysql_num_rows($consensus);

			// get the start of the chain - needed for the drawing function - ensures all the methods start at same point
			$getChainStart = mysql_query("SELECT MIN(start) FROM automeths WHERE domain REGEXP '^".$structId.$chainId."'");
			while($row = mysql_fetch_array($getChainStart))
			{
				$chainStart = $row['MIN(start)'];
			}	
	
			// get the end of the chain - needed for the drawing function - ensures all the methods end at same point
			$getChainEnd = mysql_query("SELECT MAX(end) FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' ORDER by end DESC");
			while($row = mysql_fetch_array($getChainEnd))
			{
				$chainEnd = $row['MAX(end)'];
			}
	
			// get the CATH and SCOP definitions to compare the consensus with
			$cathscop = mysql_query("SELECT * FROM automeths WHERE domain REGEXP '^".$structId.$chainId."' and (method='SCOP' or method='CATH') ORDER BY method,start");

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
				$struct = $row['domain'];
				$fragment = $row['fragmentNo'];
				$start = $row['start'];
				$end = $row['end'];
				$method = $row['method'];
	
				print '<PARAM NAME="domain'.($num_rows-1).'" VALUE="'.$struct.'">
						<PARAM NAME="fragment'.($num_rows-1).'" VALUE="'.$fragment.'">
				   		<PARAM NAME="start'.($num_rows-1).'" VALUE="'.$start.'">
				   		<PARAM NAME="end'.($num_rows-1).'" VALUE="'.$end.'">
				   		<PARAM NAME="method'.($num_rows-1).'" VALUE="'.$method.'">';
				$num_rows = $num_rows +1;
			}
	
			// now add the consensus to the display
			
			$conNum = 0;
			while($row = mysql_fetch_array($consensus))   // for each method
 			{
				$struct = $row['domain'];
				$fragment = $row['fragmentNo'];
				$start = $row['start'];
				$end = $row['end'];
				$method = $row['method'];
	
				// Consensus will be labelled "Consensus:", and if second option "Consensus Option 2" therefore if a different method representing 
				// a consensus is encountered, this counter needs increasing
			
				if(strcmp($method,$currentMethod)!=0)      
				{
					$currentMethod = $method;
					$methCount = $methCount+1;
					if($conNum==0)
					{
						$label = "Consensus";
					}
					else
					{
						$label = "Consensus Option 2";
					}
					$conNum=$conNum+1;
				}
				//$label = "Consensus".$methCount;			
			
	
				print '<PARAM NAME="domain'.($num_rows-1).'" VALUE="'.$struct.'">
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



			print '
				<TABLE WIDTH="95%">
				<TR><TH WIDTH="50%" ALIGN=CENTER>Scores<TH WIDTH="20%"><TH WIDTH="30%" ALIGN=CENTER>Key</TR>
				<TR><TD><b>Consensus Reliability:</b> ';
				printf ("%01.2f", $maxRelWeight*100);

				// print a label next to the consensus to judge it's strength
				if($maxRelWeight*100>39 && $maxRelWeight*100<60)
				{
					print ' (Weak)';
				}
				else if($maxRelWeight*100>=60 && $maxRelWeight*100<85)
				{
					print ' (Reasonable)';
				}
				else if($maxRelWeight*100>=85)
				{
					print ' (Strong)';
				}
			

				print '</TD><TD></TD><TD>[0-39]: No Consensus</TD></TR>
				
				<TR><TD>';
				if(($maxRelWeight-$nextRelWeight)<=0.1)
				{
					print '<b>Consensus Option 2 Reliability:</b> ';
					printf ("%01.2f", $nextRelWeight*100);
	
					if($nextRelWeight*100>39 && $nextRelWeight*100<60)
					{
						print ' (Weak)';
					}
					else if($nextRelWeight*100>=60 && $nextRelWeight*100<85)
					{
						print ' (Reasonable)';
					}
					else if($nextRelWeight*100>=85)
					{
						print ' (Strong)';
					}
				}
				print '</TD><TD></TD><TD>[40-59]: Weak Consensus</TD></TR>
				<TR><TD></TD><TD></TD><TD>[60-84]: Reasonable Consensus</TD></TR>
				<TR VALIGN=TOP><TD>';
				
				// PRINT METHODS THAT CONTRIBUTE TO CONSENSUS
				print '<TABLE><TR><TD><b>Methods Contributing to Consensus:</b></TD>';
				$i = 0;
				while($i<sizeof($groupList))
				{
					print '<TD>'.$groupList[$i].'</TD></TR><TR><TD></TD>';
					$i=$i+1;
				}
				
				print '</TR></TABLE></TD><TD></TD><TD>[60-85]: Strong Consensus</TD></TR>
				<TR><TD>';
	
	
				// PRINT METHODS THAT MAY CONTRIBUTE TO A SECOND CONSENSUS OPTION IF EXISTS
				if(($maxRelWeight-$nextRelWeight)<=0.1)
				{
					print '<TABLE><TR><TD><b>Methods Contributing to Alternative Consensus:</b></TD> ';
					$i = 0;
					while($i<sizeof($altGroupList))
					{
						print '<TD>'.$altGroupList[$i].'</TD></TR><TR><TD></TD>';
						$i=$i+1;
					}
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
			$row = mysql_fetch_array($cathscop);
			$currentMethod = $row['method'];
			$currentDomain = $row['domain'];
			$fragmentPrint = $row['start'].'-'.$row['end'];

			print'<tr><td width="18%" align=center>'.$currentMethod.'</td>';

			while($row = mysql_fetch_array($cathscop))
			{
				$struct = $row['domain'];
				$fragment = $row['fragmentNo'];
				$start = $row['start'];
				$end = $row['end'];
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
	
			// now add the consensus
			mysql_data_seek($consensus,0);
	
			$row = mysql_fetch_array($consensus);
			$consensusCount=1;
			$currentMethod = $row['method'];
			$currentDomain = $row['domain'];
			$fragmentPrint = $row['start'].'-'.$row['end'];
	
			print'<tr><td colspan=3>  </td></tr><tr><td width="18%" align=center>Consensus</td>';
	
			while($row = mysql_fetch_array($consensus))
			{
				$struct = $row['domain'];
				$fragment = $row['fragmentNo'];
				$start = $row['start'];
				$end = $row['end'];
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
					$consensusCount = $consensusCount+1;
					print'<td width="18%" align=center>'.$currentDomain.'</td>
							<td width="74%">'.$fragmentPrint.'</td></tr>';
				
					$currentMethod=$method;
					$currentDomain = $struct;
					$fragmentPrint = $start.'-'.$end;
					print'<tr><td width="18%" align=center>Consensus Option 2</td>';
				
				}
			}
			//print final domain that not yet output
			print'<td width="18%" align=center>'.$currentDomain.'</td>
				<td width="74%">'.$fragmentPrint.'</td></tr>';
		
	
			print'</table>';

		}
		else
		{
			print '<p align=center><b>No Consensus could be generated for this chain using this approach</b><BR>No grouping of methods could be found that met the set threshold score of 40<BR>Highest scoring group was ';
			printf ("%01.2f", $maxRelWeight*100);
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
			  PrintSideMenuBox("Results",ResultSideMenuItems("Error","Domain Assignment Summary",$structId,$_GET["chain"],$selMeths["CATH"],$selMeths["SCOP"],$selMeths["DDomain"],$selMeths["Dodis"],$selMeths["PUU"],$selMeths["DHcL"],$selMeths["dp"],$selMeths["pdp"],$selMeths["NCBI"]));
			  print '
			  </td>
			  <td valign="top" align="left">
	        <div id="textheading">Generate a Consensus Domain Assignment</div>
	
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
				print '<A HREF="http://pdomains.sdsc.edu/v2/working.php?pdbId='.$structId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&chain='.$tempChain.'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"].'">Click Here to View this Chain</A> or use the side menu to return to the form and try again<BR><BR><BR><BR><BR><BR><BR><BR>';
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
	
	mysql_close($con);

	print'	<br>
	<br>
	<br>';	




	
	PrintFooter();
?>
	
