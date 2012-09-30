<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval5",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="5">Topological criteria for comparison of performance</a></div>
		  <div id="textinfo">
		  <p>The tendency of each method to err during structure partitioning is explored by analyzing the performance of each method on different types of architectures and topologies.   Table below systematically presents all topologies from Balanced_Domain_Benchmark_2 using CATH nomenclature for Class, Architecture and Topology of the domains. For each domain assignment method we provide two adjacent columns - one for overcuts, one for undercuts - to get a so-called \'topological fingerprint\' of each method.  Remarkably, fingerprints are specific to each method, reflecting method-specific strengths and weaknesses in determining domains for different topologies.  
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/tbl10.png"><br>
			<b><a href="img/newfigs/Table_10.pdf" target="ref">Larger View</a></b><br>
			<i>Performance of four automatic methods using topological criteria. The first columns represents CATH topology under evaluation, the second column represents number of occurrences of a given topology in the dataset.  Each of the four automatic methods is presented in two adjacent columns. The first column indicates cases of overcut, the second column cases of undercut.  The number in the cell indicates the number of cases for which miss-assignment (over cut or undercut) occurs.  A thick frame around a cell indicates that a given miss-assignment is unique to a corresponding method.  A red background for a given CATH topology indicates that a given topology is problematic to most/all of the methods.  A black background for a given CATH topology indicates that it is easy for most/all methods.</i><br><br>
		  </div>
		  </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
