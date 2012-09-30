<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	include("components/simplecaptcha.php");
	
	$email = "";
	$pdbid = "";
	$chain = "";
	$methods = "";
	$errors = "";
	
	if(isset($_POST['email'])){
		$email = mysql_escape_string($_POST['email']);
	}
	
	if(isset($_POST['pdbid'])){
		$pdbid = mysql_escape_string($_POST['pdbid']);
		$pdbid = strtoupper($pdbid);
		
		if(isset($_POST['chain'])){
			$chain = mysql_escape_string($_POST['chain']);
			$chain = strtoupper($chain);
		}
		
		$url = 'http://www.pdb.org/pdb/download/downloadFile.do?fileFormat=FASTA&compression=NO&structureId';
		if($contents = file("$url=$pdbid")){
			$contents = implode("",$contents);
			$contents = preg_replace('/\n/','',$contents);
			preg_match_all("/>....:(\S)/",$contents,$chains);
			$chains = $chains[1];
			sort($chains);
			if($chain == "" && sizeof($chains) == 1){
				$chain = $chains[0];
			}
			else {
				$found = 0;
				foreach($chains as $c){
					if($c == $chain){
						$found = 1;
					}
				}
				if($found == 0){
					$errors .= "You must specify a valid chain ID. For $pdbid the options are: " . $chains[0];
					for($i = 1; $i < sizeof($chains); $i++){
						$errors .= ", " . $chains[$i];
					}
				}
			}
		}
		else {
			$errors .= "Invalid PDB Id.<br>";
		}
	}
	
	if(isset($_POST['domainparser'])){
		if($_POST['domainparser'] == 1){
			$methods .= "domainparser ";
		}
	}
	if(isset($_POST['ncbi'])){
		if($_POST['ncbi'] == 1){
			$methods .= "ncbi ";
		}
	}
	if(isset($_POST['pdp'])){
		if($_POST['pdp'] == 1){
			$methods .= "pdp ";
		}
	}
	if(isset($_POST['puu'])){
		if($_POST['puu'] == 1){
			$methods .= "puu ";
		}
	}
	if(isset($_POST['scop'])){
		if($_POST['scop'] == 1){
			$methods .= "scop ";
		}
	}
	if(isset($_POST['cath'])){
		if($_POST['cath'] == 1){
			$methods .= "cath ";
		}
	}
	
	if(isset($_POST['responce']) && isset($_POST['answer'])){
		if(ValidateCaptcha($_POST['answer'],$_POST['responce'])){
			#captcha is good.
		}
		else {
			#else cry
			$errors .= "The word you entered doesn't match the filed.<br>";
		}
	}
	
	if($methods == "" || $email == "" || $pdbid == ""){
		$errors .= "All form fields must be filled out.<br>";
	}
	
	// Database hookup
	$link = mysql_connect('mysql.sdsc.edu:3312','sergey','pd0mains') or die('Could not connect to database.');
	mysql_select_db('pdomains') or die('Unable to select database.');
	
	// Check to see how many jobs this user has...
	$query = "SELECT COUNT(*) FROM jobs WHERE email = '$email' AND finished IS NULL";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	$numjobs = $row[0];
	if($numjobs >= 3 ){
		$errors .= "You've exceded the maximum number of jobs (3), please wait for some to finish.<br>";
	}
	mysql_free_result($result);
	$numjobs++;
	
	if($errors == "") {		
		$num = rand(1000000);
		$claimid = md5("$pdbid $chain $email $methods $num");

		$query = "INSERT INTO jobs (email,pdbid,methods,claimid) VALUES ('$email','$pdbid:$chain','$methods','$claimid')";	
		$result = mysql_query($query);
		mysql_free_result($result);
		$output = "Your job has been submitted. Currently, you've $numjobs job(s) in the system. You will be alerted when it is complete.<br><br>Alternatively, you can check on it's ";
		$output .= '<a href="claim.php?code='.$claimid.'">progress</a>. This page will automatically redirect to the progres page in 30 seconds.';
		PrintHeader("Run Method","http://pdomains.sdsc.edu/claim.php?code=$claimid");
	}
	else {
		PrintHeader("Run Method");
		$output = $errors;
	}
	
	mysql_close($link);
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","Job Submission",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Job Submission:</div>
		<br>
		  <div id="textinfo">
		  <p>'.$output.'</p>
		  </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
