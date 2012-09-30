<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval6",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="6">Automatic consensus criteria</a></div>
		  <div id="textinfo">
		  <p>Another approach to determine to what extent automatic methods agree among themselves on the number of assigned domains is to look at agreement among all automatic methods – i.e. automatic consensus.  The automatic methods agreed completely on 168 out of all 315 chains analyzed, or 53.3% of chains. . A large proportion of these chains are single-domain chains - out of 107 single domain chains 95 (88.8%) show complete agreement among automatic methods, or 88.8% of chains, however, agreement among automatic methods drops rapidly as the number of domains increases (out of 8 4-domain chains only 1 had complete agreement, while for 5-domain or 6-domain chains there was no agreement among automatic methods).
Most chains that are cut correctly by all methods have clearly identifiable globular domains.  Chains that are difficult for all methods are those that consist of several domains that are often small and compact, or alternatively represent very large sprawling structures.  These situations are usually more difficult for methods because parameters such as connectivity, globularity, preservation of beta-sheet structures and other characteristics used by methods are more difficult to capture (see "Algorithm description" in <a href="methods.php">Methods</a> section).

		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="150" style="background:#CCFFCC;"><b>Number of domains per chain</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Number of chains</b> for which there is consensus among automatic methods</td>
					<td width="150" style="background:#CCFFCC;"><b>Total chains</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Percent of chains</b> for which there is consensus among automatic methods</td>
				</tr>
				<tr>
					<td width="150">1</td>
					<td width="150">95</td>
					<td width="150">107</td>
					<td width="150">88.8%</td>
				</tr>
				<tr>
					<td width="150">2</td>
					<td width="150">55</td>
					<td width="150">138</td>
					<td width="150">39.9%</td>
				</tr>
				<tr>
					<td width="150">3</td>
					<td width="150">17</td>
					<td width="150">54</td>
					<td width="150">31.5%</td>
				</tr>
				<tr>
					<td width="150">4</td>
					<td width="150">1</td>
					<td width="150">8</td>
					<td width="150">12.5%</td>
				</tr>
			</table><br>
			<i>Consensus among different algorithmic methods.  The criterion is the number of assigned domains for a given chain. The evaluation is performed using Balanced_Domain_Benchmark_2</i><br><br>
		  </div>
		  </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
