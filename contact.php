<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Contact");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Dataset",GetSideMenuItems("Dataset","",null,null));
		  PrintSideMenuBox("Approach",GetSideMenuItems("Approach","",null,null));
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","",null,null));
		  PrintSideMenuBox("Results",GetSideMenuItems("Results","",null,null));
		  print '
		  </td>
		  <td valign="top" align="left"><div id="textheading">Contact Information:</div>
			<div id="textinfo">
		  <p><img src="img/address.gif"></p>
		  </p>
		  </div></td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
