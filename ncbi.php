<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("NCBI");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","NCBI",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading">NCBI method description</div>
		  <div id="textinfo">
		  <p>
		  NCBI method description: There is no publication dedicated to the method itself, rather it is used as a step in a process of defining protein cores. The available information on the method is rather sparse. NCBI uses a similar approach to that of PUU. The partition of the structure into two domains is satisfactory when intra-domain contact density is at least twice as high as the inter-domain contact density.  In addition the domains are not permitted to have isolated secondary structure elements - those forming no contacts with the rest of the domain.  The domain boundaries are not allowed to go through a secondary structure element, but should be placed in the loops between the elements.  The smallest domain must contain at least 25 residues within secondary structures.<br><br><a href="references_pdf/NCBI_method_paper_1995.pdf" target="_blank">Publications</a>
		  </p>
		  </div><br>
		  
		  <div id="textheading"><a name="performance_analysis">NCBI analysis of performance</a></div>
		  <div id="textinfo">
		  <p>
		  NCBI is the most balanced method in its approach as it produces a similar number of undercut and overcut errors.  When only the number of domains is considered, its overall performance is just trailing that of PDP, the best performing method benchmarked.  Some of NCBI’s undercut errors are due to the inability of the method to cut through secondary structure, an essential feature of the algorithm.   In the cases where domains are connected within secondary structure elements (other than a loop) NCBI fails to separate domains, for example, 1c1za (Figure 2 A) and 1ds6a (Figure 2B).  In addition a rule concerning placement of domain boundaries in the middle of the loop (1wgta; Figure 2C) differs from expert methods (1wgta; Figure 2C).  The latter feature is detrimental when considering boundary consistency. It performs worst in terms of correct placement of <a href="img/newfigs/fig8.png" target="_blank">domain boundaries</a>.  Another situation of undercutting involves structures with many domains as in the case of 1d0na (Figure 2D). In addition to the need to cut through beta strands, there is the further complication of a convoluted interface.
		  </p>
		  <p>
		  While NCBI uses an approach similar to PUU (according to the authors of the method), its performance is quite different qualitatively and quantitatively from PUU. PUU nearly always errs in the direction of over-cutting, while NCBI is balanced.  Also NCBI performance is highly superior to that of PUU.  The heuristics used by NCBI are surprisingly simple compared to those used by PUU.  This may indicate that it is not the main principle of domain decomposition that is important, but rather the set of heuristics implemented in the post-processing step that affect the performance of the method.  Moreover it appears the simpler the rules the higher the success. For example, PUU easily sacrifices the integrity of secondary structures to achieve compactness of the domain, in the case of NCBI the ratio of compactness/integrity of secondary structure is better balanced.  Yet this ratio is not optimal as the method sometimes overcut large &#945;-structures  (1a6da, Figure 2E; 1bc5a,  Figure 2F) as well as large &#946;-structures (1mdah, Figure 2G; 5nn9, Figure 2H), while it undercuts smaller &#945;-structures (1b1ba, Figure 2I).  One of the rules is NCBI does not allow inclusion into a domain of a secondary structure that forms insufficient contacts with the rest of the domain.  This too causes cases of overcut as in 1ghok (1ghok, Figure 2J).
		  </p><br>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/method-fig2.png"><br>
			<i>Figure 2.  Domain assignment by NCBI  method.</i>
		  </div>
		  
		  </div><br>
		  
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
