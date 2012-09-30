<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Publications");
	
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
		  <td valign="top"><div id="textheading">Publications</div>
			<div id="textinfo">
			<p>Relevant papers published by those contributing to pDomains and dConsensus:</p>
			<p>Veretnik S, Bourne PE, Alexandrov NN, Shindyalov IN: <A HREF="/v2/references_pdf/Veretnik_domain_paper_2003.pdf">Towards consistent assignment of structural domains in proteins.</A> <i>J. Mol. Biol.</i> 2004,<b> 339</b>:647-678</p>
			<p>Holland TA, Veretnik S, Shindyalov IN, Bourne PE: <A HREF="/v2/references_pdf/Holland_domain_paper_2005.pdf">Partitioning protein structures into domains: why is it so difficult?</A> <i>J. Mol. Biol.</i> 2006,<b> 361</b>:562-590</p>
			<p>Veretnik S, Shindyalov IN: <A HREF="/v2/references_pdf/domain_chapter_2005.pdf">Computational methods for domain partitioning in protein structures.</A> In <i>Computational Methods for Structure Prediction and Modelling.</i> Volume 1. Edited by Xu Y, Xu D, and Liang J.  New York:Springer: 125-145</p>

		  </div>
		  </td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
