<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	include("components/simplecaptcha.php");
	
	PrintHeader("Run Method");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","Run Method",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Run Method:</div>
		<br>
		  <div id="textinfo">
		  <p>The PDomains website allows you to run domain prediction methods via this web interface. Our queueing system requires you to provide us with an e-mail address that we can use to alert you when your job is complete. We enforce a limit of 3 concurrent jobs per user.</p>
		  <form name="dl" method="post" action="jobsubmit.php">
		  <div id="highlight" style="padding:20px;">
		  <p>Your E-Mail Address:<br>
			<input type="text" name="email">
		  </p>
		  <p>PDB Id:<br>
			<input type="text" name="pdbid"> &nbsp; chain: <input type="text" name="chain" maxlength="1" size="5">
		  </p>
		  <p>Desired Method(s)<br>
			<input type="checkbox" name="domainparser" value="1">Domain Parser<br>
			<input type="checkbox" name="ncbi" value="1">NCBI<br>
			<input type="checkbox" name="pdp" value="1">PDP<br>
			<input type="checkbox" name="puu" value="1">PUU<br>
			<input type="checkbox" name="scop" value="1">SCOP<br>
			<input type="checkbox" name="cath" value="1">CATH<br>
		  </p>
		  ';
		  
		  GetCaptcha();
		  
		  print '
		  <p><input type="submit" name="Submit" value="Submit"></p>
		  </form>
		  </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
