<?php
	// DOWNLOADS THE RESULTS OF ONE CHAIN TO THE USERS PC AS A CSV FILE

	// PDBID AND CHAIN SPECIFIED ON INPUT FORM
	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chainId"];

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

	$con = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}

	mysql_select_db($dbname, $con);
	
	// PERFORM THE QUERY
	$result = mysql_query("SELECT pdbId,domain,fragmentNo,startPDB,endPDB,method FROM automeths2012 WHERE pdbId='".$structId."' AND chain = '".$chainId."' ORDER BY method,domain,startPDB");

	// SPECIFY THE OUTPUT FILE NAME
	$filename = $structId.$chainId.'.xls';

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

	xlsWriteLabel(3,0,"domain");
	xlsWriteLabel(3,1,"fragmentNo");
	xlsWriteLabel(3,2,"start");
	xlsWriteLabel(3,3,"end");
	xlsWriteLabel(3,4,"method");

	// WRITE THE RESULTS TO THE FILE
	$xlsRow = 4;
	while(list($pdbId,$domain,$fragment,$start,$end,$method)=mysql_fetch_row($result))
	{	
		if($selMeths[$method]=="true")      // if the user has selected this method
		{
			++$i;
			xlsWriteLabel($xlsRow,0,"$domain");
			xlsWriteLabel($xlsRow,1,"$fragment");
			xlsWriteLabel($xlsRow,2,"$start");
			xlsWriteLabel($xlsRow,3,"$end");
			xlsWriteLabel($xlsRow,4,"$method");
			$xlsRow++;
		}
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
