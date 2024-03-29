<HTML>
<head>
<script language="JavaScript">
function checkForm()
{
   var structId, chainId,cathx,scopx,pdpx,ncbix,dpx,dhclx,ddomainx,puux,dodisx
   with(window.document.proteinform)
   {
      structId = pdbId;
      chainId = chain;
      cathx = CATH;
      scopx = SCOP;
      pdpx = pdp;
      ncbix = NCBI;
      dpx = dp;
      dhclx = DHcL;
      ddomainx = DDomain;
      puux = PUU;
      dodisx = Dodis;
   }

   if(trim(structId.value) == '')
   {
      alert('Please enter a protein pdbId');
      structId.focus();
      return false;
   }
   else if(trim(chainId.value) == '')
   {
      alert('Please enter a chain Id');
      chainId.focus();
      return false;
   }
   else
   {
      structId.value = trim(structId.value);
      chainId.value = trim(chainId.value);
      return true;
   }
}

function trim(str)
{
   return str.replace(/^\s+|\s+$/g,'');
}
</script>
</head>
<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Compare Performance of Domain Assignment Algorithms & Generate a Consensus");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Domain Assignments",GetSideMenuItems("Domain Assignments","Consensus",null,null));
		  print '
		  </td>
		  <td valign="top" align="left"><div id="textheading">Generate a Consensus Domain Assignment</div>
			<br>
			  <div id="textinfo">
			  <p>This tool uses the domain assignments generated by each of the methods and attempts to find the most likely domain partitioning of the selected chain.  This can be achieved by either a "Simple" approach grouping the methods by domain boundary, or through a Weighted approach which considers the strength of each method and the secondary structure.  A consensus is found if a grouping of methods is found with a reliability score of 40% or more.  Any generated consensus is also compared with the assignments made by the CATH and SCOP expert methods
		  <br>
		  <br>
		  Enter the protein PDB Id and the chain you wish to examine in the form below. <b><i>Note the Chain Id is Case Sensitive:</b></i>

		  <FORM name="proteinform" action="conchoice.php" method="get">
			<table width=95% bgcolor="#6887C4">
			<TR>
				<TD align=right>Protein PDB Id:</TD>
				<TD><input type="text" size="7" name="pdbId"></TD>
				<TD>CATH</TD>
				<TD><input type="checkbox" checked="yes" name="CATH" value="true"></TD>
				<TD>SCOP</TD>
				<TD><input type="checkbox" checked="yes" name="SCOP" value="true"></TD>
				<TD>pdp</TD>
				<TD><input type="checkbox" checked="yes" name="pdp" value="true"></TD>
			</TR>
			<TR>
				<TD align=right>Chain to Analyse:</TD>
				<TD><input type="text" size="7" name="chain"></TD>
				<TD>dp</TD>
				<TD><input type="checkbox" checked="yes" name="dp" value="true"></TD>
				<TD>DHcL</TD>
				<TD><input type="checkbox" checked="yes" name="DHcL" value="true"></TD>
				<TD>DDomain</TD>
				<TD><input type="checkbox" checked="yes" name="DDomain" value="true"></TD>
			</TR>
			<TR>
				<TD align=right><input type="submit" name="submit" value="Simple" onClick="return checkForm();"</TD>
				<TD><input type="submit" name="submit" value="Weighted" onClick="return checkForm();"></TD>
				<TD>PUU</TD>
				<TD><input type="checkbox" checked="yes" name="PUU" value="true"></TD>
				<TD>NCBI</TD>
				<TD><input type="checkbox" checked="yes" name="NCBI" value="true"></TD>
				<TD>Dodis</TD>
				<TD><input type="checkbox" checked="yes" name="Dodis" value="true"></TD>
			</TR>
			</table>
		  </FORM>
		
		
</div>



		</td>
		</tr>
	  </table>
	<br>
	<br>
	<br>';	
	
	PrintFooter();
?>
