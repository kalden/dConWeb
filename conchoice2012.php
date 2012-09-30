<?php

	$structId = strtoupper($_GET["pdbId"]);
	$chainId = $_GET["chain"];

	$selected = $_GET["submit"];

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

	$redirect = '?pdbId='.$structId.'&CATH='.$selMeths["CATH"].'&SCOP='.$selMeths["SCOP"].'&pdp='.$selMeths["pdp"].'&chain='.$chainId.'&dp='.$selMeths["dp"].'&DHcL='.$selMeths["DHcL"].'&DDomain='.$selMeths["DDomain"].'&PUU='.$selMeths["PUU"].'&NCBI='.$selMeths["NCBI"].'&Dodis='.$selMeths["Dodis"];

	if(strcmp($selected,"Simple")==0)
	{
		header( 'Location: consensus_12_Home.php'.$redirect ) ;
	}
	else
	{
		header( 'Location: consensus2_12.php'.$redirect ) ;
	}
?>


	
