<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval3",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="3">Domain boundaries</a></div>
		  <div id="textinfo">
		  <p>
			Evaluating the performance of a method using only the number of domains it assigns might not be sensitive enough to determine the accuracy of an automated method.  At times, methods disagree with experts on exactly where domains starts and/or end, i.e. there is disagreement on the placement of domain boundaries, while there is agreement on the number of assigned domains.
		  </p>
		  <p>
		  To address the issue of overlap between the domains assigned by experts and those assigned by automatic methods we first define a boundary consistency criterion.  A boundary consistency of 75% requires that 75% of the domain length, as defined by two domain assignment methods, is the same.  Empirically we chose boundary_consistency_90 as a definition of identical assignment by two methods: domain assignment is considered identical if domains overlap for at least 90% of the chain length.
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong>Fraction of accurately assigned domains at 90% of domain boundary accuracy</strong><br>
			<img src="img/newfigs/fig7.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="150" style="background:#CCFFCC;">&nbsp;</td>
					<td width="150" style="background:#CCFFCC;"><b>Fraction of accurate assignments</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Fraction of chains that failed domain overlap criterion</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Fraction of chains that failed domain number criterion</b></td>
				</tr>
				<tr>
					<td width="150">DPD</td>
					<td width="150">0.83</td>
					<td width="150">0.03</td>
					<td width="150">0.14</td>
				</tr>
				<tr>
					<td width="150">DomainParser</td>
					<td width="150">0.79</td>
					<td width="150">0.01</td>
					<td width="150">0.20</td>
				</tr>
				<tr>
					<td width="150">PUU</td>
					<td width="150">0.69</td>
					<td width="150">0.08</td>
					<td width="150">0.23</td>
				</tr>
				<tr>
					<td width="150">NCBI</td>
					<td width="150">0.68</td>
					<td width="150">0.14</td>
					<td width="150">0.18</td>
				</tr>
			</table>
			<br>
			<i><b>Accuracy of domain assignments – a strict assessment.</b>  90% of the domain boundary consistency is required (see discussion above).   Boundaries_consistency_90 for automatic methods evaluated using Green is accurate assignments, yellow is inaccurate domain overlapping, and red is incorrect domain numbering. The evaluation is performed using Balanced_Domain_Benchmark_3.</i><br><br>
			<strong>Fraction of mis-assigned domain boundaries at varying levels of boundary consistency</strong><br>
			<img src="img/newfigs/fig8.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;">fraction of domain overlap</td>
					<td width="120">PDP</td>
					<td width="120">DomainParser</td>
					<td width="120">PUU</td>
					<td width="120">NCBI</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.35</td>
					<td width="120">0.003774</td>
					<td width="120">0.004167</td>
					<td width="120">0.004329</td>
					<td width="120">0.042802</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.45</td>
					<td width="120">0.003774</td>
					<td width="120">0.004167</td>
					<td width="120">0.008658</td>
					<td width="120">0.054475</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.5</td>
					<td width="120">0.003774</td>
					<td width="120">0.004167</td>
					<td width="120">0.012987</td>
					<td width="120">0.081712</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.55</td>
					<td width="120">0.007547</td>
					<td width="120">0.004167</td>
					<td width="120">0.012987</td>
					<td width="120">0.085603</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.6</td>
					<td width="120">0.007547</td>
					<td width="120">0.004167</td>
					<td width="120">0.017316</td>
					<td width="120">0.089494</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.65</td>
					<td width="120">0.007547</td>
					<td width="120">0.008333</td>
					<td width="120">0.021645</td>
					<td width="120">0.101167</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.7</td>
					<td width="120">0.011321</td>
					<td width="120">0.0125</td>
					<td width="120">0.030303</td>
					<td width="120">0.116732</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.75</td>
					<td width="120">0.018868</td>
					<td width="120">0.0125</td>
					<td width="120">0.030303</td>
					<td width="120">0.128405</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.8</td>
					<td width="120">0.033962</td>
					<td width="120">0.016667</td>
					<td width="120">0.060606</td>
					<td width="120">0.136187</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.85</td>
					<td width="120">0.041509</td>
					<td width="120">0.020833</td>
					<td width="120">0.073593</td>
					<td width="120">0.151751</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.9</td>
					<td width="120">0.067925</td>
					<td width="120">0.033333</td>
					<td width="120">0.125541</td>
					<td width="120">0.225681</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.95</td>
					<td width="120">0.120755</td>
					<td width="120">0.058333</td>
					<td width="120">0.194805</td>
					<td width="120">0.287938</td>
				</tr>
			</table>
			<br>
			<i>Performance of each method is evaluated at different levels of domain boundary accuracy.  The evaluation is performed using Balanced_Domain_Benchmark_3.</i><br><br>
		  </div>
		  </div><br>
		  
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
