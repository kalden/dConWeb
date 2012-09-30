<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Insights into automated structure partitioning");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Insights",GetSideMenuItems("Insights","Insights Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Insights into automated structure partitioning</div>
		<br>
		  <div id="textinfo">
		  <p>It appears that each of the analyzed algorithms (with the exception of PUU, which is inferior to the rest) has its strengths and weaknesses. Often strength in one area is balanced by a weakness in another area. We also observe that different methods have complementary strengths, suggesting the possibility of a <b>hybrid approach</b> to domain assignment. Thus a meta-method can be developed which uses results of several of the existing domain assignment methods. Choice of the best method in each case will depend on the size of the protein (which defines the expected number of domains) as well as the topologies involved. Additional types of information currently becoming available from the PDB, such as ligand-binding sites and protein-protein interaction data - may be added to such meta-method approach.</p>
		  <p>Main difficulty according to our analysis is finding an <b>optimal threshold for inter-/intra- domain contact densities</b>.  This difficulty is closely linked with the proportion of &#946;-strands in the structure as well as with the size of the resulting domains.  Tuning these parameters may further improve performance of existing or new algorithms.  Yet if one uses the contact density as a chief parameter in the structure decomposition, as one usually does with automatic methods, it is practically impossible to avoid structure decomposition errors.  This is because the contact density by itself is not a completely consistent parameter.  Thus if a method tries to avoid over cutting structures, it inevitably will undercut some other structures and visa versa. The same issue of inconsistency appears in the cases of discontinuous domains as well: none of the automatic methods are able to achieve correct (i.e. relatively low) level of domain fragmentation without sacrificing the accuracy of domain assignments.  This understanding further strengthens the case for development of a meta-method.</p>
		  <p>We observe that while both expert and automatic methods may disagree on the number of domains within structure (or fragments within domain), in the majority of cases the partitioning by different methods is similar with the exception that some methods partition the structure further into smaller units.  <b>Thus the basic principles on where domain partitions fall are quite clear, what is not clear is whether to apply a certain partitioning on not.</b>  Human expertise employs a myriad of algorithms integrating prior experience, common sense, topological sensibility and other features: thus it comes with consistent answers more often than the algorithms, which after all rely primarily on the contact density data.</p>
		  <p>Different levels of partitioning the structure and consequently, different sizes and complexities of the resulting domains may reflect a broader and more flexible nature of structural domains.  <b>A logical "reconciliatory" approach might be for the algorithm to provide several progressive levels of domain partitioning and allowing the user to choose the appropriate level of resolution.</b>  Such a context-dependent approach to structural domain definitions has been missing, but might prove fruitful.  . The first case of such progressive decomposition has been implemented by <a href="references_pdf/Berezovsky_domains_2003.pdf" target="ref">Berezovsky et al.</a> (unfortunately the method was not available for complete benchmarking so far) and we hope to see this approach gaining ground in the near future.</p>
		  </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
