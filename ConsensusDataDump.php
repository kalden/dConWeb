<?php
	// CONNECT TO THE DATABASE
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

	$simpleConsensusTable = "simpleconsensus";
	$weightedConsensusTable = "weightedconsensus";

	$pdbsRequested = $_POST["pdbIdList"];
	$method = $_POST["conMethod"];
	// CREATE AN ARRAY FROM THE PDBIDS, SEPARATE EACH BY A COMMA
	$pdbs = explode(",", $pdbsRequested);

	// CREATE THE SQL QUERY STRING FOR EACH OF THESE PDBIDS
	$pdbQueryString = "";

	foreach ($pdbs as &$value) 
	{
		$pdbQueryString = $pdbQueryString."pdbId='".$value."' OR ";
	}

	// TAKE OFF THE FINAL OR
	$pdbQueryString = substr($pdbQueryString,0,-3);

	// NOW RUN THE QUERY
	if($method=="simple")
	{
		$queryString = "SELECT * FROM ".$simpleConsensusTable." WHERE ".$pdbQueryString." ORDER BY pdbId,chain,consensusNumber,domainStart";
	}
	else
	{
		$queryString = "SELECT * FROM ".$weightedConsensusTable." WHERE ".$pdbQueryString." ORDER BY pdbId,chain,consensusNumber,domainStart";
	}

	$consensusOutput = mysql_query($queryString);
	
	$dateOfRequest=Date("dmy");
	// SPECIFY THE OUTPUT FILE NAME
	$filename = "dConsensus_DB_".$method."Con_".$dateOfRequest.".xls";

	// NOW OUTPUT THE QUERY RESULTS TO FILE
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

	xlsWriteLabel(0,0,"pdbId");
	xlsWriteLabel(0,1,"chain");
	xlsWriteLabel(0,2,"consensus#");
	xlsWriteLabel(0,3,"domain");
	xlsWriteLabel(0,4,"fragment#");
	xlsWriteLabel(0,5,"domainStart");
	xlsWriteLabel(0,6,"domainEnd");

	$xlsRow = 1;
	while(list($pdbId,$chain,$consensusNum,$domain,$fragment,$start,$end)=mysql_fetch_row($consensusOutput))
	{	
		++$i;
		xlsWriteLabel($xlsRow,0,"$pdbId");
		xlsWriteLabel($xlsRow,1,"$chain");
		xlsWriteLabel($xlsRow,2,"$consensusNum");
		xlsWriteLabel($xlsRow,3,"$domain");
		xlsWriteLabel($xlsRow,4,"$fragment");
		xlsWriteLabel($xlsRow,5,"$start");
		xlsWriteLabel($xlsRow,6,"$end");
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
