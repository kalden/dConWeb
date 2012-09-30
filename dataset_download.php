<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Dataset Download");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Dataset",GetSideMenuItems("Dataset","Download Dataset",null,null));
		  print '
		  </td>
		  <td valign="top" align="left"><div id="textheading">Dataset Download:</div>
		    <form name="dl" method="post" action="grant.php">
			<div id="textinfo">
			<div id="highlight" style="padding:20px;">
		  <p>First Name:<br>
			<input type="text" name="fname">
		  </p>
		  <p>Last Name:<br>
		    <input type="text" name="lname">
		  </p>
		  <p>Institution:<br>
		    <input type="text" name="institution">
		  </p>
		  <p>Country:<br>
		    <input type="text" name="country">
		  </p>
		  <p>Select desired datasets:<br>
		    <input type="checkbox" name="opt0" value="1">Benchmark_1_consensus (375)<br>
		    <input type="checkbox" name="opt1" value="1">Benchmark_1 (467)<br>
			<input type="checkbox" name="opt2" value="1">Balanced_Domain_Benchmark_2 data (raw format) (157)<br>
		    <input type="checkbox" name="opt3" value="1">Balanced_Domain_Benchmark_2 assignment by all methods (157)<br>
		    <input type="checkbox" name="opt4" value="1">Balanced_Domain_Benchmark_3 data (raw format) (135)<br>
		    <input type="checkbox" name="opt5" value="1">Balanced_Domain_Benchmark_3 assignment by all methods (135)<br>
		  </p>
		  <p><input type="submit" name="Submit" value="Submit"></p>
		  </form>
		  </div>
		  </div></td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
