<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","eval4",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
		  <div id="textheading"><a name="4">Integrity of secondary structures</a></div>
		  <div id="textinfo">
		  <p>At first glance we would expect the individual domain to be a complete and independent structure within itself, ideally connected by a flexible linker to other domain(s).  Thus we would expect secondary structure elements not to be shared between/among domains.  However it appears that a certain fraction of structures has domains in which a secondary structure element spans more than one domain.  Automatic methods vary in their approach to splitting a secondary structure between domains.  Here we measure each automated method’s tendency to split alpha helices and beta strands between domains.  We compare the propensity toward integrity of secondary structures between automatic methods and those of  expert methods CATH and SCOP (AUTHORS does not lend itself easily for this analysis because it is not present in PDB or other computer parseable form).
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="85" style="background:#CCFFCC;"><b>Secondary structure element</b></td>
					<td width="85" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="85" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="85" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="85" style="background:#CCFFCC;"><b>NCBI</b></td>
					<td width="85" style="background:#CCFFCC;"><b>SCOP</b></td>
					<td width="85" style="background:#CCFFCC;"><b>CATH</b></td>
				</tr>
				<tr>
					<td width="85">&#945;-helix</td>
					<td width="85">3.3</td>
					<td width="85">40.5</td>
					<td width="85">25.7</td>
					<td width="85">0</td>
					<td width="85">4.3</td>
					<td width="85">16.6</td>
				</tr>
				<tr>
					<td width="85">&#946;-sheet</td>
					<td width="85">1.0</td>
					<td width="85">7.6</td>
					<td width="85">0</td>
					<td width="85">0</td>
					<td width="85">2.4</td>
					<td width="85">4.3</td>
				</tr>
			</table><br>
			<i><b>Tendency toward integrity of secondary structures.</b>  Propencity to split individual secondary structure between two domains is measured.  An a-helix is considered to be split between two domains if two or more of its residues reside in a different domain from the rest.  A &#946;-strand is considered to be split if 30% of its residues reside in a different domain from the rest.</i><br><br>
		  </div>
		  </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
