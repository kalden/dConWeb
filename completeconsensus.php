<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Complete Consensus");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",GetSideMenuItems("Results","Results Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Complete consensus:</div>
        <br>

		<div id="textinfo">
		  <p>These chains are representative of 328 chains which have same domain assignments by all six domain assiagnment methods (i.e. a complete consensus among methods)</p>
		  <p><img src="results/complete_consensus_1a.png" width="720" height="540"></p>
		  <p><img src="results/complete_consensus_2.png" width="720" height="540"></p>
		  <p><img src="results/complete_consensus_3.png" width="720" height="540"></p>
		  <p><img src="results/complete_consensus_4.png" width="720" height="540"></p>
		  <p><img src="results/complete_consensus_5.png" width="720" height="540"></p>
		</div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
