<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td valign="top">';
		  PrintSideMenuBox("Dataset",GetSideMenuItems("Dataset","",null,null));
		  PrintSideMenuBox("Domain Assignments",GetSideMenuItems("Domain Assignments","",null,null));
		  PrintSideMenuBox("Approach",GetSideMenuItems("Approach","",null,null));
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","",null,null));
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","",null,null));
		  print '
		  </td>
		  <td valign="top"><div id="textheading"> PDOMAINS is a resource centered around definition and assignment of structural domains in proteins. </div>
			<div id="textinfo">
		  <p>pDomain resource is centered around defining structural domains from 3D coordinates.
This resource brings together current state-of-the-art algorithmic methods for partitioning proteins into domains.  Evaluation of the methods is performed using multiple parameters and the comprehensive benchmark dataset.</p>
<p>
Benchmark datasets used in evaluation of the methods are available for download to the developers on new methods of domain assignments and to the broader scientific community.
</p>
		  <p><strong> Currently this resource offers: </strong></p>
		  <ul>
			<li><a href="dataset.php">Datasets of benchmarks</a></li>
			<li><a href="proteinform.php">Tool which compares domains assigned by different algorithms and generates a consensus domain assignment
			<li><a href="approach.php">Consensus approach and the construction of benchmark datasets</a></li>
			<li><a href="methods.php">Brief description of algorithms used for domain assignments by the currently available methods</a></li>
			<li><a href="evaluation.php">Evaluation and cross-comparison of methods with comprehensive benchmarks</a></li>
			<li><a href="insights.php">Issues/insights /future directions associated with partitioning protein structure into domains</a></li>

			</ul>
		  <div id="highlight">
			<p align="center"><strong> If you are interested in benchmarking your domain assignment method, <a href="contact.php">contact us</a>.</strong></p>
		  </div>
		  <p>&nbsp;</p>
		  </div></td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
