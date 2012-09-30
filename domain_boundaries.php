<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Domain Boundaries In-Depth");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",GetSideMenuItems("Results","Results Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Domain Boundaries In-Depth  :</div>
		<br>
		  <div id="textsubheading">Comparisons of all methods using domain boundaries</div>
		  <div id="textinfo">
		  <p align="left">Performance of method can be evaluated simply by comparing number of domains assigned by two methods or it can consider the boundaries of domains as well. This section investigates how consideration of domain boundaries ( in addition to the number of domains) affects the performance of the methods. </p>
		  <ul>
            <li>
              <a href="domain_boundaries.php#percent%20of%20domain%20overlap">Percent of domain overlap </a>
            </li>
            <li>
              <a href="domain_boundaries.php#What%20cases">What causes disagreement on domain boundaries </a>
            </li>
            <li>
              <a href="domain_boundaries.php#methods%20can%20disagree">Methods can disagree on the number of domains and still meet domain overlap requirement. </a>
            </li>
		    </ul>
		</div>
		  <div id="textsubheading"><a name="benchmarking"></a><a name="percent of domain overlap"></a><a name="Percent of domain overlap">Percent of domain overlap </a></div>
		  <div id="textinfo">
		  <p>The correspondence between domain boundaries is measured in percent of domain overlap across the entire chain - a domain overlap of 80% indicates that 80% of residues in the chain are assigned identically by two methods. Note, that this does not require 80% of residues of each of the domains to be assigned correctly. Rather it is the combination of all domains in the chain that should meet the 80% threshold. One implication of this definition of domain overlap is that a correct percent of domain overlap can be reached even in the cases where the number of domains is not the same, as discussed later. The analysis is reported for each assignment method as it compares to the AUTHORS assignment and for each consensus dataset at different thresholds of domain overlap ranging from 35% to 95% (Figure1). These data are compiled by analyzing the domain overlap in chains with the same number of domains. The domain overlap analysis is performed at increments of 5% which, therefore, defines the level of accuracy. In our analysis we refer to the lower end of the threshold range. </p>
		  <p>As the percent of domain overlap increases, the number of chains that can meet this threshold decreases. The decrease is smooth throughout most of the range of thresholds, however, when the threshold reaches 90% or 95%, the drop in the number of chains that can meet it becomes more dramatic (Figures 1 and 2A). This may indicate that a reasonable threshold for domain overlap should be set close to, but below 90%. </p>
		  <p><img src="results/domain1.jpg" height="425" width="600"></p>
		  <p>Figure 1. Fraction of chains that passes a given domain overlap threshold (between 0.25 and 0.95). </p>
		  </div>
		  <div id="textsubheading"><a name="benchmarking"></a><a name="What cases"></a><a name="What causes disagreement of domain boundaries">What causes disagreement of domain boundaries </a>. </div>
		  <div id="textinfo">
		  <p>We observe three major causes of domain boundary disagreement (Table 1): (1) assigning less than an entire chain to a domain in the case of single domain chains, (2) different number of fragments per domain assigned by two methods; and (3) everything else, that is, disagreements in multi-domain chains with continuous domains or non-continuous domains with identical numbers of fragments. This last type of disagreement is caused by a mismatch in the domain/fragment boundaries. The situation is similar for single domain chains where the N-terminal and/or C-terminal boundary of the domain does not match the beginning and the end of the polypeptide chain. When the number of fragments per domain differs between given method and the reference method, we record whether it is caused by assigning too many or too few fragments relative to the reference method. Different assignment methods vary significantly in both: (1) the number of chains that do not pass a given level of domain overlap threshold; and (2) the type of misassignment (Table 1 and Figure 2B). We also notice that as the stringency of domain overlap decreases from 95% to 80%, the number of chains that passes the threshold increases dramatically, indicating that the majority of disagreements are minor. Exceptions are groups of single domain chains assigned by PDP and DALI. </p>
		  <p><img src="results/domain2.jpg" width="700" height="284"></p>
		  <p>Figure 2. ( A ). Distribution of chains that do not pass domain overlap consensusat a given threshold. ( B ). Fraction of chains lost between the lowest (35%) and the highest (95%) thresholds of domain overlap; presented for each method as well as consensus subsets. </p>
		  <p><strong></strong></p>
		  <table border="1" cellpadding="7" cellspacing="1" width="744">
  <tbody><tr>
    <td rowspan="2" valign="top" width="17%"><p align="center">&nbsp;</p>
    <font size="4"></font><p align="center"><font size="4"><font color="#0000a0">Assignment method</font></font></p></td>
    <td rowspan="2" valign="top" width="12%"><font size="4"></font><p align="center"><font size="4"><font color="#0000a0">Number of chains (total)</font></font></p></td>
    <td rowspan="2" valign="top" width="13%"><font size="4"></font><p align="left"><font size="4"><font color="#0000a0">Single domain</font></font></p>

<font size="4">    </font><p align="left"><font size="4"><font color="#0000a0">chains</font></font></p></td>
    <td colspan="2" valign="top" width="31%"><font size="5"><p align="center"><font color="#0000a0">Multi-domain</font></p>
    <p align="center"><font color="#0000a0">chains</font></p>
    </font><font size="4"></font><p align="center"><font size="4"><font color="#0000a0">(identical number of
    fragments/domain)</font></font></p></td>
    <td colspan="2" valign="top" width="27%"><font size="5"><p align="center"><font color="#0000a0">Multi-domain chains</font></p>
    </font><font size="4"></font><p align="center"><font size="4"><font color="#0000a0">(different number of
    fragments/domain)</font></font></p></td>

  </tr>
  <tr>
    <td valign="top" width="14%"><p align="center"><font color="#0000a0">Continuous domains</font></p></td>
    <td valign="top" width="16%"><p align="center"><font color="#0000a0">Non-continuous
    domains</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">More than reference</font></p></td>
    <td valign="top" width="15%"><p align="center"><font color="#0000a0">Less than reference</font></p></td>
  </tr>

  <tr>
    <td valign="top" width="17%"><p align="center"><font color="#0000a0">PDP</font></p></td>
    <td valign="top" width="12%"><p align="center"><font color="#0000a0">47 (20)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">20 (11)</font></p></td>
    <td valign="top" width="14%"><p align="center"><font color="#0000a0">2 (1)</font></p></td>
    <td valign="top" width="16%"><p align="center"><font color="#0000a0">7 (2)</font></p></td>

    <td valign="top" width="13%"><p align="center"><font color="#0000a0">15 (4)</font></p></td>
    <td valign="top" width="15%"><p align="center"><font color="#0000a0">3 (2)</font></p></td>
  </tr>
  <tr>
    <td valign="top" width="17%"><p align="center"><font color="#0000a0">Domain Parser</font></p></td>
    <td valign="top" width="12%"><p align="center"><font color="#0000a0">14 (2)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">0 (0)</font></p></td>

    <td valign="top" width="14%"><p align="center"><font color="#0000a0">4 (1)</font></p></td>
    <td valign="top" width="16%"><p align="center"><font color="#0000a0">2 (0)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">3 (0)</font></p></td>
    <td valign="top" width="15%"><p align="center"><font color="#0000a0">5 (1)</font></p></td>
  </tr>
  <tr>
    <td valign="top" width="17%"><p align="center"><font color="#0000a0">DALI</font></p></td>

    <td valign="top" width="12%"><p align="center"><font color="#0000a0">52 (22)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">30 (16)</font></p></td>
    <td valign="top" width="14%"><p align="center"><font color="#0000a0">5 (1)</font></p></td>
    <td valign="top" width="16%"><p align="center"><font color="#0000a0">6 (0)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">10 (4)</font></p></td>
    <td valign="top" width="15%"><p align="center"><font color="#0000a0">1 (1)</font></p></td>

  </tr>
  <tr>
    <td valign="top" width="17%"><p align="center"><font color="#0000a0">CATH</font></p></td>
    <td valign="top" width="12%"><p align="center"><font color="#0000a0">24 (5)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">1 (1)</font></p></td>
    <td valign="top" width="14%"><p align="center"><font color="#0000a0">8 (1)</font></p></td>
    <td valign="top" width="16%"><p align="center"><font color="#0000a0">4 (0)</font></p></td>

    <td valign="top" width="13%"><p align="center"><font color="#0000a0">11 (3)</font></p></td>
    <td valign="top" width="15%"><p align="center"><font color="#0000a0">0 (0)</font></p></td>
  </tr>
  <tr>
    <td valign="top" width="17%"><p align="center"><font color="#0000a0">SCOP</font></p></td>
    <td valign="top" width="12%"><p align="center"><font color="#0000a0">9 (2)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">1 (1)</font></p></td>

    <td valign="top" width="14%"><p align="center"><font color="#0000a0">2 (0) </font></p></td>
    <td valign="top" width="16%"><p align="center"><font color="#0000a0">0 (0)</font></p></td>
    <td valign="top" width="13%"><p align="center"><font color="#0000a0">1 (0)</font></p></td>
    <td valign="top" width="15%"><p align="center"><font color="#0000a0">5 (1)</font></p></td>
  </tr>
</tbody></table>


		  <p align="left">Table1. Assignment of domain boundaries by each method using AUTHORS assignment as a reference. Values represent the number of chains that do not agree on domain boundaries. Values are given for two thresholds: 95% domain overlap threshold (first value) and 80% domain overlap threshold (value in parenthesis). Analysis is limited to the chains for which a given method and the reference method agree on the number of domains. <strong></strong></p>
		  </div>
		  <div id="textsubheading"><a name="methods can disagree"></a><a name="Methods can disagree on the number of assigned domains and still meet the domain overlap requirement.">Methods can disagree on the number of assigned domains and still meet the domain overlap requirement. </a></div>
		  <div id="textinfo">
		  <p>The above analysis was performed for chains in which there was agreement between the number of assigned domains. However, if one or more of the assigned domains represents a small fraction of the entire chain, then domain overlap requirement can be attained even when the number of domains assigned by methods differs. We find 12 cases in which number of domain differs, but the domain overlap still meets the 85% threshold (Table 2). In 7 cases the reference (AUTHORS) has one more domain than the other method(s); in 5 cases one less. (4 DALI, 1 PDP). The additional domains are small and usually recruited in two ways: (1) from a fragment of an existing discontinuous domain (Figure 3A, B); and (2) from a part of a continuous domain (and/or unassigned region; Figure 3C, D) that is promoted to a full domain. In the latter case, the part of a domain is always taken from the end of the domain, not by generating additional discontinuities within the domain. The new domain can appear at the ends of a polypeptide chain or in the middle. </p>
		  <p align="left"><img src="results/domain4.jpg" height="404" width="700"></p>
		  <p align="left">Figure 3. &nbsp; Examples of chains with different number of domains that can still meet the domain overlap threshold. </p>
		  <table border="1" cellpadding="7" cellspacing="1">
            <tr>
              <td valign="top" width="25%"><em></em>
                  <p align="center"><em>Type of domain number mismatch </em></p></td>
              <td valign="top" width="75%"><em></em>
                  <p align="center"><em>Chains that pass 85% domain overlap threshold, </em></p>
                  <em></em>
                  <p align="center"><em>but have different number of domains </em></p></td>
            </tr>
            <tr>
              <td valign="top" width="25%"><p align="left">Reference method (AUTHORS) have more domains than current method </p></td>
              <td valign="top" width="75%"><em><strong></strong></em>
                  <p align="left"><em><strong>3gly </strong></em>(AUTHORS:2, DomainParser, CATH, SCOP:1) ; <em><strong>4icd </strong></em>(AUTHORS:3, DomainParser, DALI: 2) ; <em><strong>2mnr </strong></em> ( AUTHORS:3, DomainParser, DALI, CATH, SCOP:2 ); <em><strong>1hex </strong></em> ( AUTHORS:3, DomainParser, PDP: 2 ); <em><strong>2dkb </strong></em> ( AUTHORS:3, CATH:2 ), <em><strong>1tpla </strong></em> ( AUTHORS:3, CATH:2 ); <em><strong>1chra </strong></em> ( AUTHORS:3, CATH, SCOP:2 ) </p></td>
            </tr>
            <tr>
              <td valign="top" width="25%"><p align="left">Current method has more domains than reference method (AUTHORS) </p></td>
              <td valign="top" width="75%"><em><strong></strong></em>
                  <p align="left"><em><strong>1xima </strong></em> ( AUTHORS:1, DALI, PDP:2 ); <em><strong>1ddt </strong></em> ( AUTHORS:3, DALI:4 ), <em><strong>1phh </strong></em> ( AUTHORS:2, DALI:3 ); <em><strong>1aoza </strong></em> ( AUTHORS:3, DALI:4 ); <em><strong>2pcdm </strong></em> ( AUTHORS:1, DALI:2 ) </p></td>
            </tr>
          </table>
		  <strong></strong>
          <p align="left">Table 2.&nbsp; Enumeration of chains in the 467-chain dataset for which 85% of residues are assigned to correct domains even in the absence of agreement on the number of domains. </p>
	    </div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
