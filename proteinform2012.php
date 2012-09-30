<HTML>
<head>
<script language="JavaScript">
function checkForm()
{
   var structId, chainId;
   with(window.document.proteinform)
   {
      structId = pdbId;
      chainId = chain;
   }

   if(trim(structId.value) == '')
   {
      alert('Please enter a protein pdbId');
      structId.focus();
      return false;
   }
	// New version of pDomains will make the chain optional
   //else if(trim(chainId.value) == '')
   {
    //  alert('Please enter a chain Id');
      //chainId.focus();
      //return false;
   //}
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
		  PrintSideMenuBox("Method Performance",GetSideMenuItems("Domain Assignments","Assignment by Methods",null,null));
		  print '
		  </td>
		  <td valign="top" align="left"><div id="textheading">Domain Assignment by Methods</div>
			<br>
			  <div id="textinfo">
			  <p>This tool compares the performance of each domain assignment algorithm for a chosen protein chain. A 			     comparison is made between the assignment results, as well as the domain assignments made by CATH and SCOP<BR><BR>

			Using these results, the tool attempts to generate a consensus between the domain assignment predictions 
        	  made by the automatic methods.  Where a domain assignment cuts a secondary structure feature within the 
        	  chain, this is noted and displayed for comparison of performance. 
		  <br>
		  <br>

		  Should you only wish to see the consensus domain assignment, click on <b><i>Consensus</i></b> on the left hand menu<BR><BR>
		  Enter the protein PDB Id of the protein you wish to examine in the form below, and select the domain assignment algorithms that you 				wish to include in your analysis

		  <FORM name="proteinform" action="compareassignmentsHome.php" method="get">
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
				<TD align=right></TD>
				<TD></TD>
				<TD>dp</TD>
				<TD><input type="checkbox" checked="yes" name="dp" value="true"></TD>
				<TD>DHcL</TD>
				<TD><input type="checkbox" checked="yes" name="DHcL" value="true"></TD>
				<TD>DDomain</TD>
				<TD><input type="checkbox" checked="yes" name="DDomain" value="true"></TD>
			</TR>
			<TR>
				<TD></TD><TD><input type="submit" value="Submit" onClick="return checkForm();"></TD>
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
