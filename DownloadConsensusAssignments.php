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

      structId.value = trim(structId.value);
      chainId.value = trim(chainId.value);
      return true;

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
		  PrintSideMenuBox("Method Performance",GetSideMenuItems("Domain Assignments","Download Consensus Assignments",null,null));
		  print '
		  </td>
		  <td valign="top" align="left"><div id="textheading">Download Consensus Assignment Data</div>
			<br>
			  <div id="textinfo">
			  <p>This tool provides the functionality to download the consensus assignments generated from the domain assignment algorithms, for a set of proteins. This is comprised of a CSV file.<BR><BR>
<b>NB: Please separate PDB Ids by a comma (For example: 1HTB,2Q14,9XIM)</b>


		  <FORM name="domainform" action="ConsensusDataDump.php" method="post">


			<table width=70% bgcolor="#6887C4">
			<TR>
			<TD COLSPAN=2>
				<textarea rows="5" cols="86" name="pdbIdList" wrap="soft"></textarea>
			</TD>
			</TR>
			<TR>
			<TD>
				<input type="radio" name="conMethod" value="simple" checked /> Simple
			</TD>
			<TD>
				<input type="radio" name="conMethod" value="weighted" /> Weighted
			</TD>
			</TR>

			<TR>
			<TD>
				<input type="submit" name="submit" value="Download" onClick="return checkForm();"
			</TD>

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
