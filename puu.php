<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("PUU");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","PUU",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading">PUU method description</div>
		  <div id="textinfo">
		  <p>
		  PUU is a recursive top-down approach which uses a hypothetical model of autonomously folding units corresponding to protein domains.  The domains are defined as groups of residues that oscillate as a single unit relative to other residue groups.  The amplitude of oscillation is determined by <i>oscillating time</i> &#964;.  A greater &#964; indicates a greater mobility and a greater probability for a given group of residues to reside in separate domains.  The oscillation time is proportional in the center of mass of the group and is inversely proportional to the so-called <i>interference strength</i>.  The interference strength is calculated by evaluating <i>pair-wise residue-residue interactions</i>, which in turn are calculated for any two atoms in two residues which are 4&#197; apart or less.  A hierarchical 5-level filtering process is applied during partitioning of the structure.  The process does not require all five conditions to be met. Rather, if the condition for applying the filter is true the lower filters are not tested.  The filters applied are: (1) the domain should have at least 80 residues to be considered for cutting; (2) highly flexible units are always cut (defined in terms of &#964;); (3) &#946;-sheets forming a network are never cut; (4) the cut is accepted if both sub-domains are compact (globularity >0.8); and (5) a cut that yields a small non-globular unit (<40 residues) is accepted on condition  that the situation is rectified in the recursive application of the filters.<br><br><a href="references_pdf/PUU_paper_1994.pdf" target="_blank">Publications</a>
		  </p>
		  </div><br>
		  
		  <div id="textheading"><a name="performance_analysis">PUU performance analysis</a></div>
		  <div id="textinfo">
		  <p>
		  PUU is the oldest method and has the worse performance among the four methods analyzed. It has a strong tendency to overcut - i.e. predict more domains than experts (Figure 4A, 4B). Striving to achieve compact domains, the method frequently assembles domains out of non-contiguous fragments.  Sometimes the number of fragment per domain, s, is <a href="img/newfigs/fig4.png" target="_blank">too large to be evolutionarily sensible</a>.  Furthermore the compactness factor appears to confer unrealistically high significance.   PUU does not have constraints to prevent splitting &#945;-helices between domains, thus it frequently cuts through helices.   However, its rules about integrity of &#946;-sheets, which form \'highly cooperative networks,\' sometimes leave PUU unable to partition all-&#946; structures or structures with a significant fraction of &#946;-sheets (Figure 4C, 4D, 4E, 4D).
		  </p><br>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/method-fig4.png"><br>
			<i>Figure 4.  Domain assignment by PUU method.</i>
		  </div>
		  
		  </div><br>
		  
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
