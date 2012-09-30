<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("No Consensus Dataset");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",GetSideMenuItems("Results","Results Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">No consensus dataset :</div>
        <br>

		<div id="textinfo">
		  <p>Chains is this dataset are cut differently by different domain assignment methods, so that there is no consensus neither among algorithmic methods, nor among expert methods.</p>
		  <p><img src="results/no_consensus_1.jpg" width="800" height="700"></p>
		  <p><img src="results/no_consensus_2.jpg" width="800" height="643"></p>
		  <p><img src="results/no_consensus_3.jpg" width="800" height="614"></p>
		  <p><img src="results/no_consensus_4.jpg" width="800" height="610"></p>
		  <p><img src="results/no_consensus_5.jpg" width="800" height="614"></p>
		  <p><img src="results/no_consensus_6.jpg" width="800" height="686"></p>
		  <p><img src="results/no_consensus_7.jpg" width="800" height="664"></p>
		  <p><img src="results/no_consensus_8.jpg" width="800" height="669"></p>
		  <p><img src="results/no_consensus_9.jpg" width="800" height="637"></p>
		  <p><img src="results/no_consensus_10.jpg" width="800" height="610"></p>
		  <p><img src="results/no_consensus_11.jpg" width="800" height="633"></p>
		  <p><img src="results/no_consensus_12.jpg" width="800" height="730"></p>
		  <p><img src="results/no_consensus_13.jpg" width="800" height="606"></p>
		  <p><img src="results/no_consensus_14.jpg" width="800" height="603"></p>
		  <p><img src="results/no_consensus_15.jpg" width="800" height="627"></p>
		  <p><img src="results/no_consensus_16.jpg" width="800" height="622"> </p>
		</div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
