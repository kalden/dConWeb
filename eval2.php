<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval2",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="2">Fragmentation of domains (continuous vs. discontinuous domains)</a></div>
		  <div id="textinfo">
		  <p>
		  The partitioning of the structure into domains may result in domains consisting of contiguous stretches of polypeptide chain – one stretch per domain (contiguous domains).   Frequently, however, regions of the polypeptide chain that are distant in sequence, are close together in 3D structure, thus a domain may consist of two or more segments of the chain which are non-contiguous in sequence (non-contiguous domains).  We note that the average fragmentation of domains correlates with the average number of domains assigned by each method: if an automatic method assigns on average more domains it also assigns on average more fragments per domain. The fragmentation of domains is presented from three perspectives: <a href="#2-1">a fraction of correctly/incorrectly fragmented domains</a>, <a href="#2-2">partitioning of domains into discontinuous fragments  by each method</a>, and <a href="#2-3">correlation between partitioning protein into domains and the fragmentation of domains</a>.
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="2-1">1. Fraction of correct/incorrect fragmented domains</a></strong><br>
			<img src="img/newfigs/fig4.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="100" style="background:#CCFFCC;"><b>Number of fragments/per domain<b></td>
					<td width="100" style="background:#CCFFCC;"><b>Expert consensus</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="100" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="100" style="background:#CCFFCC;"><b>NCBI</b></td>
				</tr>
				<tr>
					<td width="100">1</td>
					<td width="100" style="background:#CCFFCC;">91.7</td>
					<td width="100">82.4</td>
					<td width="100">91.3</td>
					<td width="100">72.2</td>
					<td width="100">85</td>
				</tr>
				<tr>
					<td width="100">2</td>
					<td width="100" style="background:#CCFFCC;">7.6</td>
					<td width="100">14.9</td>
					<td width="100">8</td>
					<td width="100">18.1</td>
					<td width="100">13.1</td>
				</tr>
				<tr>
					<td width="100">3</td>
					<td width="100" style="background:#CCFFCC;">0.7</td>
					<td width="100">2.7</td>
					<td width="100">0.7</td>
					<td width="100">7.2</td>
					<td width="100">1.9</td>
				</tr>
				<tr>
					<td width="100">4+</td>
					<td width="100" style="background:#CCFFCC;">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">2</td>
					<td width="100">0</td>
				</tr>
			</table>
			<br>
			<i>Evaluation of domain assignment methods using using fragmentation of domains.  The evaluation is performed using Balanced_Domain_Benchmark_2.</i><br><br>
			
			<strong><a name="2-2">2. Partitioning of domains into discontinuous fragments by each method </a></strong><br>
			<img src="img/newfigs/fig5.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;"><b>Number of fragments<b></td>
					<td width="120" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="120" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="120" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="120" style="background:#CCFFCC;"><b>NCBI</b></td>
				</tr>
				<tr>
					<td width="120">1 fragment</td>
					<td width="120">-9.3</td>
					<td width="120">-0.4</td>
					<td width="120">-19</td>
					<td width="120">-6.7</td>
				</tr>
				<tr>
					<td width="120">2 fragments</td>
					<td width="120">7.3</td>
					<td width="120">0.4</td>
					<td width="120">10.5</td>
					<td width="120">5.5</td>
				</tr>
				<tr>
					<td width="120">3 fragments</td>
					<td width="120">2</td>
					<td width="120">0</td>
					<td width="120">6.5</td>
					<td width="120">1.2</td>
				</tr>
				<tr>
					<td width="120">4+ fragments</td>
					<td width="120">0</td>
					<td width="120">0</td>
					<td width="120">2</td>
					<td width="120">0</td>
				</tr>
			</table><br>
			<i>Fraction of continuous and discontinuous domains mis-assigned by each method and binned by number of fragments per domain.  The evaluation is performed using Balanced_Domain_Benchmark_2.</i><br><br>
			<strong><a name="2-3">3. Comparing tendency toward correct assignment on the level of protein vs. the level of domain</a></strong><br>
			<img src="img/newfigs/fig6.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="100" style="background:#CCFFCC;">&nbsp;</td>
					<td width="100" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="100" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="100" style="background:#CCFFCC;"><b>NCBI</b></td>
					<td width="100" style="background:#CCFFCC;"><b>Expert consensus</b></td>
				</tr>
				<tr>
					<td width="100">average # of domains per chain</td>
					<td width="100">2.03</td>
					<td width="100">1.78</td>
					<td width="100">2.11</td>
					<td width="100">2.03</td>
					<td width="100" style="background:#CCFFCC;">1.95</td>
				</tr>
				<tr>
					<td width="100">average # of fragments per chain</td>
					<td width="100">1.20</td>
					<td width="100">1.09</td>
					<td width="100">1.49</td>
					<td width="100">1.30</td>
					<td width="100" style="background:#CCFFCC;">1.09</td>
				</tr>
			</table><br>
			<i>Side-by-side comparison of the average number of fragments per domain and average number of domains per chain as assigned by each method.  The left Y-axis scale refers to the average number of fragments per domain and the right Y-axis scale refers to the average number of domains per chain.  The average number of fragments per domain is calculated using Y / X, where Y is the sum of all fragments assigned for each domain and X is the total number of domains assigned.  The average number of domains per chain is calculated using A / B, where A is the sum of all domains assigned for each chain and B is the total number of chains.  The proportion between average fragments and average number of domains is 1:1.65. The evaluation is performed using Balanced_Domain_Benchmark_2.</i><br><br>
		  </div>
		  </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
