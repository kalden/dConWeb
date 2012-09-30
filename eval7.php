<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval7",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="7">Composite evaluation of methods</a></div>
		  <div id="textinfo">
		  <p>Here we attempt to evaluate individual methods by combining several characteristics together.  This gives a more complex and comprehensive look at the performance of methods.<br><br>In particular, we look at:
		  <ol>
			<li><b>fraction of correct assignments</b><br>correct assignments are weighted according to the complexity of the structure: thus 1-domain proteins are given weight of 1, 2-domain proteins are given weight of 2, 3-domain proteins are given weight of 3 and 4-,5-, and 6-domain protein are given weight of 4.</li>
			<li><b>fragmentation of discontinuous domains</b><br></li>
			<li><b>precision of domain overlap</b><br>domain overlap is evaluated at the threshold of 80%: the chain is considered the be assigned correctly if the number of domains is assigned correctly and 80% of the residues in each domain are assigned correctly.</li>
		  </ol>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="150" style="background:#CCFFCC;"><b>Method</b></td>
					<td width="150" style="background:#CCFFCC;"><b>correctly assigned chains based on the number domains (in %)</b></td>
					<td width="150" style="background:#CCFFCC;"><b>correctly fragmented domains (in %)</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Precision of domain overlap (at 80% threshold)  (in %)</b></td>
				</tr>
				<tr>
					<td width="150">PDP</td>
					<td width="150">68.07</td>
					<td width="150">81.4</td>
					<td width="150">96.6</td>
				</tr>
				<tr>
					<td width="150">NCBI</td>
					<td width="150">43.31</td>
					<td width="150">86.6</td>
					<td width="150">86.4</td>
				</tr>
				<tr>
					<td width="150">DomainParser</td>
					<td width="150">33.17</td>
					<td width="150">99.2</td>
					<td width="150">98.3</td>
				</tr>
				<tr>
					<td width="150">PUU</td>
					<td width="150">38.32</td>
					<td width="150">62</td>
					<td width="150">94</td>
				</tr>
			</table><br>
			<i>Values of each of the characteristics contributing to the composite evaluation.</i><br><br>
		  </div>
		  </p>
		  
		  <p>The three features above are weighted and combine to produce the final score, which is a composite evaluation score.</p>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			  <img src="img/newfigs/fig12.png"><br>
			  <i>Composite evaluation of methods.  Three characteristics are weighted as follows: fraction of correctly assigned chains: 60%, fragmentation of discontinuous domains: 20%, precision of domain overlap:20%.  The overall performance is represented in percent.</i><br><br>
		  </div>
		  
		  <p>We varied the weighting schema and found that regardless of the placed weights, PDP method appears to be superior and PUU method is inferior.  However, DomainParser and  NCBI methods trade places depending on whether fragmentation and precision of domain overlap (strong points of DomainParser) or correct assignment of domains (strong point of NCBI method) are weighted more heavily.</p>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			  <img src="img/newfigs/fig13.png"><br><br>
			  <table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;"><b>Weighting schema</b></td>
					<td width="120" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="120" style="background:#CCFFCC;"><b>NCBI</b></td>
					<td width="120" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="120" style="background:#CCFFCC;"><b>PUU</b></td>
				</tr>
				<tr>
					<td width="120">80-10-10</td>
					<td width="120">72.28</td>
					<td width="120">51.94</td>
					<td width="120">46.31</td>
					<td width="120">46.24</td>
				</tr>
				<tr>
					<td width="120">70-10-20</td>
					<td width="120">75.3</td>
					<td width="120">56.25</td>
					<td width="120">52.82</td>
					<td width="120">51.8</td>
				</tr>
				<tr>
					<td width="120">60-20-20</td>
					<td width="120">76.4</td>
					<td width="120">60.6</td>
					<td width="120">59.4</td>
					<td width="120">54.2</td>
				</tr>
				<tr>
					<td width="120">50-20-30</td>
					<td width="120">79.31</td>
					<td width="120">64.9</td>
					<td width="120">65.93</td>
					<td width="120">59.75</td>
				</tr>
				<tr>
					<td width="120">40-30-30</td>
					<td width="120">80.64</td>
					<td width="120">69.22</td>
					<td width="120">72.57</td>
					<td width="120">62.12</td>
				</tr>
			  </table><br>
			  <i>Composite evaluation of methods under different weighting schemas. The weighting parameters are as follows: first parameter: : fraction of correctly assigned chains, second parameter: fragmentation of discontinuous domains, third parameter: precision of domain overlap.</i>
		  </div>
		  
		  </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
