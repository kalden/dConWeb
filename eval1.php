<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval1",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="1">Number of assigned domains</a></div>
		  <div id="textinfo">
		  <p>
		  The simplest criterion is the number of domains assigned by a given method.  Errors in assignments of domains can be further classified as over-cuts (assigning more domains than the benchmark) or under-cuts (assigned fewer domains than the benchmark).  Evaluation using three of the above criteria is performed for the entire Benchmark_2 dataset .  This is somewhat rough estimation of method\'s correctness, as the correspondence between the domains assigned by an algorithmic method and that of expert consensus is not evaluated here (for more precise evaluation see <a href="eval3.php">Domain boundaries</a>).  This type of evaluation is presented in three different ways: a fraction of correctly/incorrectly assigned domains <a href="#1-1">overall</a>, a fraction of correctly/incorrectly assigned domains <a href="#1-2">grouped by number of domains</a>, and an assignment of domains <a href="#1-3">by each method</a>
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="1-1">1. Fraction of correct/incorrect assignments domains overall</a></strong><br>
			<img src="img/newfigs/fig1.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;">Methods</td>
					<td width="120" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="120" style="background:#CCFFCC;"><b>NCBI</b></td>
					<td width="120" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="120" style="background:#CCFFCC;"><b>PUU</b></td>
				</tr>
				<tr>
					<td width="120">correct assignment</td>
					<td width="120">85.03</td>
					<td width="120">82.48</td>
					<td width="120">77.07</td>
					<td width="120">74.2</td>
				</tr>
				<tr>
					<td width="120">over-cut</td>
					<td width="120">11.15</td>
					<td width="120">9.87</td>
					<td width="120">4.46</td>
					<td width="120">18.47</td>
				</tr>
				<tr>
					<td width="120">under-cut</td>
					<td width="120">3.82</td>
					<td width="120">7.64</td>
					<td width="120">18.48</td>
					<td width="120">7.33</td>
				</tr>
			</table>
			<br>
			<i>Evaluation of domain assignment methods using number of domains as a sole criteria.  The evaluation is performed using Balanced_Domain_Benchmark_2.</i>
		  </div><br>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="1-2">2. Fraction of correct/incorrect assignments (grouped by number of domains)</a></strong><br>
			<img src="img/newfigs/fig2.png"><br>
			Tabular data for the figure<br>
			<img src="img/newfigs/tbl2.png"><br>
			<br>
			<i>Performance of automatic methods using the multi-domain performance criterion.  For each number of domains subset, the correct assignment, over- and under-cutting rate is shown in green, red, and blue, respectively. The evaluation is performed using Balanced_Domain_Benchmark_2</i>
		  </div><br>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="1-3">3. An assiagnment of domains by each method (breakdown by number of domains)</a></strong><br>
			<img src="img/newfigs/fig3.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="100" style="background:#CCFFCC;"><b>Number of domains<b></td>
					<td width="100" style="background:#CCFFCC;"><b>Expert consensus</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="100" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="100" style="background:#CCFFCC;"><b>NCBI</b></td>
				</tr>
				<tr>
					<td width="100">1 domain</td>
					<td width="100" style="background:#CCFFCC;">33.7</td>
					<td width="100">35.2</td>
					<td width="100">44.8</td>
					<td width="100">38.4</td>
					<td width="100">37.1</td>
				</tr>
				<tr>
					<td width="100">2 domains</td>
					<td width="100" style="background:#CCFFCC;">43.8</td>
					<td width="100">39.1</td>
					<td width="100">37.5</td>
					<td width="100">32.7</td>
					<td width="100">36.5</td>
				</tr>
				<tr>
					<td width="100">3 domains</td>
					<td width="100" style="background:#CCFFCC;">17.5</td>
					<td width="100">17.8</td>
					<td width="100">14.3</td>
					<td width="100">14.6</td>
					<td width="100">18.4</td>
				</tr>
				<tr>
					<td width="100">4 domains</td>
					<td width="100" style="background:#CCFFCC;">2.5</td>
					<td width="100">3.8</td>
					<td width="100">1.6</td>
					<td width="100">9.8</td>
					<td width="100">4.4</td>
				</tr>
				<tr>
					<td width="100">5 domains</td>
					<td width="100" style="background:#CCFFCC;">1.6</td>
					<td width="100">3.8</td>
					<td width="100">1.9</td>
					<td width="100">2.2</td>
					<td width="100">1.9</td>
				</tr>
				<tr>
					<td width="100">6 domains</td>
					<td width="100" style="background:#CCFFCC;">0.6</td>
					<td width="100">0.3</td>
					<td width="100">0</td>
					<td width="100">1.9</td>
					<td width="100">1</td>
				</tr>
				<tr>
					<td width="100">7 domains</td>
					<td width="100" style="background:#CCFFCC;">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">0.3</td>
					<td width="100">0</td>
				</tr>
				<tr>
					<td width="100">8 domains</td>
					<td width="100" style="background:#CCFFCC;">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">0.6</td>
				</tr>
			</table>
			<br>
			<i>Comparison of overall number of domains assigned by each automatic method and by expert consensus (in percent) . The evaluation is performed using Balanced_Domain_Benchmark_2</i>
		  </div><br>
          </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
