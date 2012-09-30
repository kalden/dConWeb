<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("DomainParser");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Methods",GetSideMenuItems("Methods","DomainParser",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading">DomainParser method description</div>
		  <div id="textinfo">
		  <p>
		  DomainParser uses a top-down  approach to domain decomposition implemented using a graph theoretical approach. Each residue is modeled as a node and each connection between residues as an edge.  A connection between two residues exists either when a residue lies next to another in sequence or is in close proximity in 3D structure.  The spatial proximity between two residues requires that the distance between at least one atom from each residue is 4&#197; or less. The <i>strength of connection</i> (referred to as capacity) between two nodes is proportional to the strength of the interaction between two residues represented by the nodes.
		  </p>
		  <p>
		  The division of the protein into domains is done by systematically splitting a structure into two parts, which is equivalent to separating a network into two parts using a minimum cut approach.  The process of division is then repeated with each individual domain until one of the stop criteria is reached.  This constitutes the first step of the algorithm.  In the second step (a post-processing step) a number of parameters are used to evaluate the suitability of potential domains generated in step 1. The parameters include <i>compactness, radius of gyration, number of non-contiguous segments per domain and the distribution of domain sizes</i>.  The minimum length of a domain is 35 residues, and beta-strands are not cut unless they act as a narrow polypeptide segment connecting two or more domains.<br><br><a href="references_pdf/DomainParser_paper_2003.pdf" target="_blank">Publications</a>
		  </p>
		  </div><br>
		  
		  <div id="textheading"><a name="performance_analysis">DomainParser analysis of performance</a></div>
		  <div id="textinfo">
		  <p>
		  DomainParser demonstrates the highest propensity among the four automatic methods toward undercutting. That is, predicting fewer domains than predicted by experts.  The least problematic structures are large &#945;-class structures such as large orthogonal bundles and up-down bundles as well as large structures in the &#945;/&#946; class, such as complex structures, horse-shoe and 3-layer sandwiches (<a href="img/newfigs/tbl10.png" target="ref">view table</a>).  The main problem is the failure to continue successful partitioning after the first round, that is, subdividing resulting domains further.  Size and compactness of the domain appear as the over-riding factors. DomainParser can partition rather complex architectures correctly as long as the resulting domains are either large or very compact (Figure 1A, 1B).  We suspect that &#946;-strand interactions are contributing greatly to this problem (method has a good success rate for the &#945;-class structures).   We also observe that one &#946;-class architecture - that of immunoglobulin-like sandwich - is <a href="img/newfigs/tbl10.png" target="ref">particularly difficult for DomainParser</a> Figure 1C, 1D, 1E).   This rather simple architecture may epitomize the &#946;-structure issues for this method.
		  </p>
		  <p>
		  DomainParser performs the most extensive evaluation of the potential domains it assigns.  Its failure to further partition large domains may be due to a bias in the post-processing step during which small domains are evaluated and are either granted the status of domains or joined together.  Since the multiple criteria used in the post-processing step were trained using SCOP, it is likely that parameters set to favor large domains will  undercut relative to other expert methods just as SCOP tends to do. This will affect the distribution of expected sizes as well as the distribution of the number of fragments used in the post-processing step. Another issue might be improper tuning of &#946;-stand cutting; DomainParser prefers not to cut &#946;-strands between two domains; thus it often keeps large units with interacting &#946;-strands together (Figure 1C, 1D, 1F, 1G).  All this points to the possibility that multiple decision-making factors in the post-processing step are not tuned correctly.  At the same time DomainParser is the closest among the algorithms to correctly predict the level of domain fragmentation, when compared to expert methods;  it also has the most precisely assigned domain boundaries among the four algorithmic methods.
		  </p><br>
		  
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/method-fig1.png"><br>
			<i>Figure 1.  Domain assignment by DomainParser method.</i>
		  </div>
		  
		  </div><br>
		  
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
