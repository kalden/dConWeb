<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Benchmark Dataset");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
		  <td valign="top">';
		  PrintSideMenuBox("Dataset",GetSideMenuItems("Dataset","Dataset Overview",null,null));
		  print '
		  </td>
		  <td valign="top"><div id="textheading">Benchmark Dataset</div>
			<div id="textinfo">
			<p>Several benchmark datasets of protein structures were constructed in the process of this work  for the evaluation of algorithms for domain assignments.  All of the datasets are based on consensus principle – i.e. agreement among several experts methodson how the structure is partitioned into domains (see <a href="approach.php">Expert consensus approach</a>).</p>
			<p><b>Benchmark_1</b> known as "set of  467 chains" in <a href="references_pdf/Veretnik_domain_paper_2003.pdf" tagert="ref">Veretnik et al.</a>. This is the largest set of structures that for which agreement between CATH, SCOP and AUTHORS methods was available at the time. Not all of 467 chains have an expert consensus for domain assignments as can be <a href="img/newfigs/ven_diagram.jpg" target="ref">seen in the analysis</a>. The expert consensus is achieved in 375 chains (80% of all the chains). This dataset is now called Benchmark_1_consensus. While this is the largest consensus benchmark dataset, it is severely biased toward single-domain chains: 318 (85%) are one-domain chains, 40 (10.7%) two-domain chains, 15 (4%) three-domain chains, 1 (0.3) four-domain chains. The original Benchmark_1 dataset is still available.<br><a href="dataset_download.php"><img src="img/newfigs/download.png" border="0"></a></p>
			<p>Balanced_Domain_Benchmark_2 known as Benchmark_2 in <a href="references_pdf/Holland_domain_paper_2005.pdf" target="ref">Holland et al.</a> is based on the same principle as Benchmark_1_consensus dataset.  However in order to construct a comprehensive benchmark in which majority of the structures are multi-domain proteins and each combination of structural topologies is represented only once, the AUTHORS assignments dataset was dramatically expanded to include structures with every type of domain combinations.  This resulted in 315 protein structures in which over 66% of the structures are multi-domain proteins (see <a href="img/newfigs/b2-3.table.gif" target="ref">Table 1</a> for the detailed breakdown). Furthermore this is a non-redundant set of structures in which each combination of topologies is represent only once in each of the 2-, 3-,...,6-domain subsets (see <a href="img/newfigs/b2-3.table.gif" target="ref">Table 1</a>).<br>
<i>Half of this dataset is available for the download, while the other half is reserved for independent evaluation of the domain assignment methods.</i><br><a href="dataset_download.php"><img src="img/newfigs/download.png" border="0"></a></p>
			<p><b>Balanced_Domain_Benchmark_3</b> known as Benchmark_3 in <a href="references_pdf/Holland_domain_paper_2005.pdf" target="ref">Holland et al</a>.  It is based on a more stringent definition of consensus among <a href="approach.php">expert methods</a> which requires significant match between boundaries of assigned domains. Fourty four chains were removed from the Balanced_Domain_Benchmark_3, as the overlap between the domains was below 90%. The entire Balanced_Domain_Benchmark_3 consist of 271 chains (see <a href="img/newfigs/b2-3.table.gif" target="ref">Table 1</a> for details). <br><i>Half of this dataset is available for the download, while the other half is reserved for independent evaluation of the domain assignment methods.</i><br><a href="dataset_download.php"><img src="img/newfigs/download.png" border="0"></a></p>
			<p>
			<img src="img/newfigs/b2-3.table.gif">
			</p>
		  </div>
		  </td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
