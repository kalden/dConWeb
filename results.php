<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Results");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",GetSideMenuItems("Results","Results Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Results:</div>
        <br>
		<div id="textsubheading"><a href="expert.php">Analysis of expert methods </a></div>
		<div id="textinfo">
	      <table width="100%" border="0" cellpadding="2" cellspacing="0" class="outlined">
            <tr bgcolor="#E8EDF7">
              <td width="300">&nbsp;&nbsp;<a href="expert.php#AUTHORS_description">AUTHORS</a></td>
              <td width="200"> <a href="expert.php#AUTHORS">detail analysis </a> </td>
              <td>all data </td>
            </tr>
            <tr bgcolor="#F5F8FC">
              <td width="300">&nbsp;&nbsp;<a href="expert.php#CATH_description">CATH </a> </td>
              <td width="200"> <a href="expert.php#CATH">detail analysis </a> </td>
              <td>all data </td>
            </tr>
            <tr bgcolor="#E8EDF7">
              <td width="300">&nbsp;&nbsp;<a href="expert.php#SCOP_descritpion">SCOP </a> </td>
              <td width="200"> <a href="expert.php#SCOP">detail analysis </a> </td>
              <td>all data </td>
            </tr>
          </table>
		</div><br>
		<div id="textsubheading"> <a href="auto.php">Analysis of automatic methods </a> </div>
		<div id="textinfo">
	      <table width="100%" border="0" cellpadding="2" cellspacing="0" class="outlined">
            <tr bgcolor="#E8EDF7">
              <td width="300">&nbsp;&nbsp;<a href="auto.php#DALI%20description">DALI </a> </td>
              <td width="200">                <a href="auto.php#DALI_analysis">detail analysis </a>  </td>
              <td>all data </td>
            </tr>
            <tr bgcolor="#F5F8FC">
              <td width="300">&nbsp;&nbsp;<a href="auto.php#DomainParser%20Description">DomainParser </a> </td>
              <td width="200">                <a href="auto.php#DomainParser_analysis">detail analysis </a>  </td>
              <td>all data </td>
            </tr>
            <tr bgcolor="#E8EDF7">
              <td width="300">&nbsp;&nbsp;<a href="auto.php#PDP%20description">PDP </a>  </td>
              <td width="200">                <a href="auto.php#pdp_analysis">detail analysis </a>  </td>
              <td>all data </td>
            </tr>
          </table>
		</div><br>
		<div id="textsubheading"> Other data </div>
		<div id="textinfo">
	      <table width="100%" border="0" cellpadding="2" cellspacing="0" class="outlined">
            <tr bgcolor="#E8EDF7">
              <td width="300">&nbsp;&nbsp;<a href="approach.php">No consensus </a>  </td>
              <td width="200"><a href="noconsensus.php">all data </a> </td>
              <td>&nbsp;</td>
            </tr>
            <tr bgcolor="#F5F8FC">
              <td width="300">&nbsp;&nbsp;<a href="approach.php">Complete consensus </a>  </td>
              <td width="200">                <a href="completeconsensus.php">all data </a> </td>
              <td>&nbsp;</td>
            </tr>
          </table>
	    </div>
		  <br>  
		  <div id="textsubheading"><a href="benchmarkingall.php">Benchmarking of methods </a> </div>
		  <div id="textinfo">
		    <ul>
              <li><a href="benchmarkingall.php#benchmarking_dom_number">using domain number </a></li>
              <li><a href="benchmarkingall.php#benchmarking_dom_boundaries">using domain boundary</a></li>
	        </ul>
	      </div>
		  <br>
          <div id="textsubheading">Basic properties of methods</div>
          <div id="textinfo">
            <ul>
              <li><a href="benchmarkingall.php#single%20vs%20multi-domain%20distribution">single vs. multi-domain structures </a> </li>
              <li><a href="benchmarkingall.php#continuous%20vs%20discontinuous%20domains">continuous vs. discontinuous domains </a></li>
              <li> <a href="benchmarkingall.php#Distribution%20of%20domain%20and%20fragment%20sizes.">distribution of domain and fragment size </a> </li>
            </ul>
          </div>
          <br>
          <div id="textsubheading"><a href="domain_boundaries.php">Domain Boundaries in Depth</a></div>
          <div id="textinfo">
            <ul>
              <li> <a href="domain_boundaries.php#percent%20of%20domain%20overlap">percent of domain overlap </a> </li>
              <li> <a href="domain_boundaries.php#What%20causes%20disagreement%20of%20domain%20boundaries">what causes disagreement</a></li>
              <li> <a href="domain_boundaries.php#Methods%20can%20disagree%20on%20the%20number%20of%20assigned%20domains%20and%20still%20meet%20the%20domain%20overlap%20requirement.">domain overlap vs number of domain criteria </a> </li>
            </ul>
          </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
