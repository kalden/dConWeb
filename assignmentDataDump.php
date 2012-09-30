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

	$assignmentsTable = "automeths2012";

	$selMeths = array();
	$methodString = "";

	$selMeths["CATH"] = $_POST["CATH"];
	if($selMeths["CATH"]=="false") { $methodString=$methodString."method<>'CATH' AND "; }
	$selMeths["SCOP"] = $_POST["SCOP"];
	if($selMeths["SCOP"]==false) { $methodString=$methodString."method<>'SCOP' AND "; }
	$selMeths["PUU"] = $_POST["PUU"];
	if($selMeths["PUU"]==false) {$methodString=$methodString."method<>'PUU' AND "; }
	$selMeths["dp"] = $_POST["dp"];
	if($selMeths["dp"]==false) {$methodString=$methodString."method<>'dp' AND "; }
	$selMeths["pdp"] = $_POST["pdp"];
	if($selMeths["pdp"]==false) {$methodString=$methodString."method<>'pdp' AND "; }
	$selMeths["DDomain"] = $_POST["DDomain"];
	if($selMeths["DDomain"]==false) {$methodString=$methodString."method<>'DDomain' AND "; }
	$selMeths["DHcL"] = $_POST["DHcL"];
	if($selMeths["DhCL"]==false) {$methodString=$methodString."method<>'DhCL' AND "; }
	$selMeths["NCBI"] = $_POST["NCBI"];
	if($selMeths["NCBI"]==false) {$methodString=$methodString."method<>'NCBI' AND "; }
	$selMeths["Dodis"] = $_POST["Dodis"];
	if($selMeths["Dodis"]==false) {$methodString=$methodString."method<>'Dodis' AND "; }

	// TAKE THE FINAL AND OFF THE METHOD STRING
	$methodString = substr($methodString,0,-4);

	$pdbsRequested = $_POST["pdbIdList"];
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
	$queryString = "SELECT * FROM ".$assignmentsTable." WHERE ".$pdbQueryString." AND ".$methodString." ORDER BY pdbId,chain,method,startPDB";
	$domainOutput = mysql_query($queryString);

	$dateOfRequest=Date("dmy");
	// SPECIFY THE OUTPUT FILE NAME
	$filename = "dConsensus_DB_Request_".$dateOfRequest.".xls";

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
	xlsWriteLabel(0,2,"domain");
	xlsWriteLabel(0,3,"fragmentNo");
	xlsWriteLabel(0,4,"startPDB");
	xlsWriteLabel(0,5,"endPDB");
	xlsWriteLabel(0,6,"method");

	$xlsRow = 1;
	while(list($pdbId,$chain,$domain,$fragment,$start,$end,$method)=mysql_fetch_row($domainOutput))
	{	
		++$i;
		xlsWriteLabel($xlsRow,0,"$pdbId");
		xlsWriteLabel($xlsRow,1,"$chain");
		xlsWriteLabel($xlsRow,2,"$domain");
		xlsWriteLabel($xlsRow,3,"$fragment");
		xlsWriteLabel($xlsRow,4,"$start");
		xlsWriteLabel($xlsRow,5,"$end");
		xlsWriteLabel($xlsRow,6,"$method");
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
