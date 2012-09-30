<?php
	$structId = '1HTB';
	$chainId = 'A';

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
	
	// Query Database
	//$result = mysql_query("SELECT domain,fragmentNo,start,end,method,FIELD(method,'CATH','SCOP','pdp','DHcL','dp','DDomain','NCBI','PUU','Dodis') AS SORTER FROM automeths WHERE domain REGEXP '^".$structId.$chainId."'ORDER BY SORTER ASC,start");
	$result = mysql_query("SELECT pdbId,domain,fragmentNo,start,end,method FROM automeths2012 WHERE pdbId='".$structId."' AND chain = '".$chainId."' ORDER BY method,domain,start");


	$filename = 'results.xls';
	// Send Header
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
	xlsWriteLabel(0,1,"domain");
	xlsWriteLabel(0,2,"fragmentNo");
	xlsWriteLabel(0,3,"start");
	xlsWriteLabel(0,4,"end");
	xlsWriteLabel(0,5,"method");

	$xlsRow = 1;
	while(list($pdbId,$domain,$fragment,$start,$end,$method)=mysql_fetch_row($result))
	{	
		++$i;
		xlsWriteLabel($xlsRow,0,"$pdbId");
		xlsWriteLabel($xlsRow,1,"$domain");
		xlsWriteLabel($xlsRow,2,"$fragment");
		xlsWriteLabel($xlsRow,3,"$start");
		xlsWriteLabel($xlsRow,4,"$end");
		xlsWriteLabel($xlsRow,5,"$method");
		$xlsRow++;
	}
	xlsEOF();
	exit();

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
