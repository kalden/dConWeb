<?php
	// DOWNLOADS THE RESULTS OF ONE CHAIN TO THE USERS PC AS A CSV FILE

	// PDBID AND CHAIN SPECIFIED ON INPUT FORM
	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chainId"];
	$numConsensus = $_GET["ConsensusNumber"];
	$highWeight = $_GET["highWeight"];
	$nextWeight = $_GET["nextWeight"];
	$highMeths = $_GET["highMeths"];
	$nextMeths = $_GET["nextMeths"];

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

	// CONNECT TO THE DATABASE
	$dbhost = '137.110.134.140:8888';
	$dbuser = 'domains';
	$dbpass = 'ucsd';
	$dbname = 'domains';

	$assignmentsTable = "automeths2012";
	$simpleConsensusTable = "simpleconsensus";
	$consensusStatsTable = "consensusscores";

	$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($dbname, $con);
	
	// PERFORM THE QUERIES
	$cathscop = mysql_query("SELECT * FROM ".$assignmentsTable." WHERE pdbId='".$structId."' AND chain='".$chainId."' and (method='SCOP' or method='CATH') ORDER BY method,start");
	$consensus = mysql_query("SELECT * FROM ".$simpleConsensusTable." WHERE pdbId='".$structId."' AND chain='".$chainId."' ORDER BY consensusNumber,domainStart ASC");

	// SPECIFY THE OUTPUT FILE NAME
	$filename = $structId.$chainId.'_SimpleConsensus.xls';

	// SET THE FILE UP
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Type: application/octet-stream");
	header("Content-Type: application/download");;
	header("Content-Disposition: attachment;filename=$filename");
	header("Content-Transfer-Encoding: binary ");
	// XLS Data Cell
	xlsBOF();

	xlsWriteLabel(0,0,"pdbId: ");
	xlsWriteLabel(0,1,$structId);
	xlsWriteLabel(1,0,"chain: ");
	xlsWriteLabel(1,1,$chainId);

	xlsWriteLabel(3,0,"Consensus Score: ");
	xlsWriteLabel(3,1,number_format($highWeight, 2, '.', ''));
	xlsWriteLabel(3,3,"Comprising Methods ".$highMeths);

	if($numConsensus>1)
	{
		xlsWriteLabel(4,0,"Alternative Consensus Score: ");
		xlsWriteLabel(4,1,number_format($nextWeight, 2, '.', ''));
		xlsWriteLabel(4,3,"Comprising Methods ".$nextMeths);
	}
	
	xlsWriteLabel(6,0,"domain");
	xlsWriteLabel(6,1,"fragment#");
	xlsWriteLabel(6,2,"start");
	xlsWriteLabel(6,3,"end");
	xlsWriteLabel(6,4,"method");

	// WRITE THE RESULTS TO THE FILE
	$xlsRow = 7;
	while(list($pdbId,$chain,$domain,$fragment,$start,$end,$method)=mysql_fetch_row($cathscop))
	{	
		++$i;
		xlsWriteLabel($xlsRow,0,"$domain");
		xlsWriteLabel($xlsRow,1,"$fragment");
		xlsWriteLabel($xlsRow,2,"$start");
		xlsWriteLabel($xlsRow,3,"$end");
		xlsWriteLabel($xlsRow,4,"$method");
		$xlsRow++;
		
	}

	while(list($pdbId,$chainId,$consensusNumber,$domain,$fragment,$start,$end)=mysql_fetch_row($consensus))
	{	
		++$i;
		xlsWriteLabel($xlsRow,0,"$domain");
		xlsWriteLabel($xlsRow,1,"$fragment");
		xlsWriteLabel($xlsRow,2,"$start");
		xlsWriteLabel($xlsRow,3,"$end");
		if($consensusNumber==1)
		{
			xlsWriteLabel($xlsRow,4,"Consensus");
		}
		else
		{
			xlsWriteLabel($xlsRow,4,"Alternative Consensus");
		}
			$xlsRow++;
	}

	xlsEOF();
	exit();

	// FUNCTIONS TO DO ALL THIS STUFF:

	function xlsBOF() {
		echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
		return;
	}

	function xlsEOF() {
		echo pack("ss", 0x0A, 0x00);
		return;
	}

	function xlsWriteNumber($Row, $Col, $Value) {
		echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
		echo pack("d", $Value);
		return;
	}

	function xlsWriteLabel($Row, $Col, $Value ) {
		$L = strlen($Value);
		echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
		echo $Value;
		return;
	}
?>
