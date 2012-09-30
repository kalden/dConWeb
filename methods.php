<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Algorithmic methods for assignment of structural domains");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","Method Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Algorithmic methods for assignment of structural domains</div>
		<br>
		  <div id="textinfo">
		  <p>Algorithmic methods are completely automated - no human/expert intervention occurs during the process of protein decomposition.  First algorithmic method for decomposition of the structure into domains appeared in 1974 (Rossman and Liljas). Over 20 different methods have appeared since; the approaches to domain definition as well as techniques applied vary widely (for a comprehensive overview of methods see "<a href="references_pdf/domain_chapter_2005.pdf" target="_blank">Computational Methods for Domain Partitioning of protein structures</a>".</p>
		  <p>Several recent methods are described below.  The choice of methods is based chiefly on the availability of the method for local implementation or ability to test method remotely. If you are interested to have your method on this site, please <a href="contact.php">contact us</a>.</p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
		  <p>
			  <strong>Domain Parser:</strong>
			  <ul>
				<li><a href="domainparser.php">Algorithm description</a></li>
				<li><a href="domainparser.php#performance_analysis">Analysis of performance</a></li>
				<li><a href="references_pdf/DomainParser_paper_2003.pdf" target="_blank">Publications</a></li>
			  </ul>
		  </p>
		  <p>
			  <strong>NCBI:</strong>
			  <ul>
				<li><a href="ncbi.php">Algorithm description</a></li>
				<li><a href="ncbi.php#performance_analysis">Analysis of performance</a></li>
				<li><a href="references_pdf/NCBI_method_paper_1995.pdf" target="_blank">Publications</a></li>
			  </ul>
		  </p>
		  <p>
			  <strong>PDP:</strong>
			  <ul>
				<li><a href="pdp.php">Algorithm description</a></li>
				<li><a href="pdp.php#performance_analysis">Analysis of performance</a></li>
				<li><a href="references_pdf/PDP_paper_2003.pdf" target="_blank">Publications</a></li>
			  </ul>
		  </p>
		  <p>
			  <strong>PUU:</strong>
			  <ul>
				<li><a href="puu.php">Algorithm description</a></li>
				<li><a href="puu.php#performance_analysis">Analysis of performance</a></li>
				<li><a href="references_pdf/PUU_paper_1994.pdf" target="_blank">Publications</a></li>
			  </ul>
		  </p>
		  </div>
		  </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
