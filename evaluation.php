<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","Evaluation Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Evaluation of algorithmic methods</div>
		<div id="textinfo">
	      <p>In order to get comprehensive picture of strength and weaknesses of algorithmic methods we evaluate their performance using <a href="dataset_b2n3.php">Balanced_Domain_Benchmark_2</a> dataset  and a broad array of criteria such as extend of domain fragmentation, extend of cuts through secondary structure, etc.  The results are presented in graphical and tabular form below.</p>
		</div><br>
		<div id="textsubheading">Methods evaluated:</div>
		<div id="textinfo">
	    <ul>
			<li><a href="domainparser.php">DomainParser</a></li>
			<li><a href="ncbi.php">NCBI method</a></li>
			<li><a href="pdp.php#PDP">PDP</a></li>
			<li><a href="puu.php">PUU</a></li>
		</ul>
		</div><br>
		<div id="textsubheading">Criteria for evaluation:</div>
		<div id="textinfo">
		<ul>
			<li><a href="eval1.php">Number of assigned domains</a></li>
			<li><a href="eval2.php">Fragmentation of domains (continuous vs. discontinuous domains)</a></li>
			<li><a href="eval3.php">Domain boundaries</a></li>
			<li><a href="eval4.php">Integrity of secondary structures</a></li>
			<li><a href="eval5.php">Topological criteria for comparison of performance</a></li>
			<li><a href="eval6.php">Automatic consensus criteria</a></li>
			<li><a href="eval7.php">Composite evaluation of the methods</a></li>
		</ul><br>
		<div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/tbl0.png"><br>
			<i>Summary of performance of each automatic method.</i>
		</div><br>
		
		<div style="padding-left: 80px; padding-top: 20px; width: 650px;">
			  <img src="img/newfigs/fig12.png"><br>
			  <i>Composite evaluation of methods.  Three characteristics are weighted as follows: fraction of correctly assigned chains: 60%, fragmentation of discontinuous domains: 20%, precision of domain overlap:20%.  The overall performance is represented in percent.</i><br><br>
		  </div>
		  
	    </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
