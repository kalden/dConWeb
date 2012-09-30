<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("PDP");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","PDP",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading">PDP method description</div>
		  <div id="textinfo">
		  <p>
		  PDP is a recursive algorithm that makes either a single cut producing two contiguous domains or a double cut, where the cuts are at least 35 residues apart and result in spatially close domains.  The best cut is selected using criteria of minimum contacts between resulting domains.   The extent of the domain-domain contacts is calculated assuming spherical domains: their surface area is proportional to n2/3, where n is the number of residues.  Additionally the above contact value is normalized by the size of the domains.  The threshold on normalized domain contact is set to be 1/2 of the average contact density of the entire domain.   The algorithm continues recursively by partitioning each of the resulting domains further until stopping criteria are met. During the post-processing step, the number of contacts between resulting domains is evaluated and domains with a high level of contacts are merged together.  Very small domains (below 35 residues) are discarded.<br><br><a href="references_pdf/PDP_paper_2003.pdf" target="_blank">Publications</a>
		  </p>
		  </div><br>
		  
		  <div id="textheading"><a name="performance_analysis">PDP  analysis of performance</a></div>
		  <div id="textinfo">
		  <p>
		  PDP  has superior performance among the four analyzed methods.  Its approach is surprisingly simple, yet it is able to achieve good results overall and impressive results on structures with 3 or more domains.  Its overall tendencies are similar to those of PUU. It tends to over-cut structures in order to achieve compactness/globularity of the resulting domains and does not consider secondary structure integrity.  In fact this is the only method which does not have any rules with regards to secondary structure elements.  We speculate that not taking into account integrity of &#946;-sheets helps PDP to partition multi-domain structures so successfully (1fnma, Figure 3A; 1d0na; Figure 3B).  The flip side of disregarding secondary structure integrity is the excessive over-cutting of &#945;-helical structures (1crxa, Figure 3C; 1aoga, Figure 3D as well as splitting along highly interacting &#946;-sheets (1bc5a, Figure 3E; 2bpa, Figure 3F).   The rare cases of overcut occur in very compact structures such as 1rl2a (Figure 3G). The tendency to produce non-contiguous domains is quite moderate in spite of the lack of explicit rules.  During the post-processing step the domains are evaluated using the criteria of compactness and minimum contact between domains, If some of the resulting domains fail the criteria.  PDP attempts to join together some of the resulting domains using the compactness criteria.  This feature might contribute to the success of PDP, as it allows an excessive cutting of the structure during the early step, which helps in the case of multi-domain structures, yet it manages to curb many cases of overcuts by joining small structures into one domain during the post-processing step.
		  </p><br>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/method-fig3.png"><br>
			<i>Figure 3.  Domain assignment by PDP method.</i>
		  </div>
		  
		  </div><br>
		  
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
