<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Method Evaluation");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Evaluation",GetSideMenuItems("Evaluation","Evaluation Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
        <div id="textheading">Evaluation of algorithmic methods</div>
		<div id="textinfo">
	      <p>In order to get comprehensive picture of strength and weaknesses of algorithmic methods we evaluate their performance using <a href="dataset_b2n3.php">Balanced_Domain_Benchmark_2</a> dataset  and a broad array of criteria such as extend of domain fragmentation, extend of cuts through secondary structure, etc.  The results are presented in graphical and tabular form below.</p>
		</div><br>
		<div id="textsubheading">Methods evaluated:</div>
		<div id="textinfo">
	    <ul>
			<li><a href="methods.php#DomainParser">DomainParser</a></li>
			<li><a href="methods.php#NCBI">NCBI method</a></li>
			<li><a href="methods.php#PDP">PDP</a></li>
			<li><a href="methods.php">PUU</a></li>
		</ul>
		</div><br>
		<div id="textsubheading">Criteria for evaluation:</div>
		<div id="textinfo">
		<ul>
			<li><a href="#1">Number of assigned domains</a></li>
			<li><a href="#2">Fragmentation of domains (continuous vs. discontinuous domains)</a></li>
			<li><a href="#3">Domain boundaries</a></li>
			<li><a href="#4">Integrity of secondary structures</a></li>
			<li><a href="#5">Topological criteria for comparison of performance</a></li>
			<li><a href="#6">Automatic consensus criteria</a></li>
		</ul>
	    </div><br>
		
		  <br>  
		  <div id="textsubheading"><a name="1">Number of assigned domains</a></div>
		  <div id="textinfo">
		  <p>
		  The simplest criterion is the number of domains assigned by a given method.  Errors in assignments of domains can be further classified as over-cuts (assigning more domains than the benchmark) or under-cuts (assigned fewer domains than the benchmark).  Evaluation using three of the above criteria is performed for the entire Benchmark_2 dataset .  This is somewhat rough estimation of method\'s correctness, as the correspondence between the domains assigned by an algorithmic method and that of expert consensus is not evaluated here (for more precise evaluation see <a href="#3">Domain boundaries below</a>).  This type of evaluation is presented in three different ways: a fraction of correctly/incorrectly assigned domains <a href="#1-1">overall</a>, a fraction of correctly/incorrectly assigned domains <a href="#1-2">grouped by number of domains</a>, and an assignment of domains <a href="#1-3">by each method</a>
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="1-1">1. Fraction of correct/incorrect assignments domains overall</a></strong><br>
			<img src="img/newfigs/fig1.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;">Methods</td>
					<td width="120" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="120" style="background:#CCFFCC;"><b>NCBI</b></td>
					<td width="120" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="120" style="background:#CCFFCC;"><b>PUU</b></td>
				</tr>
				<tr>
					<td width="120">correct assignment</td>
					<td width="120">85.03</td>
					<td width="120">82.48</td>
					<td width="120">77.07</td>
					<td width="120">74.2</td>
				</tr>
				<tr>
					<td width="120">over-cut</td>
					<td width="120">11.15</td>
					<td width="120">9.87</td>
					<td width="120">4.46</td>
					<td width="120">18.47</td>
				</tr>
				<tr>
					<td width="120">under-cut</td>
					<td width="120">3.82</td>
					<td width="120">7.64</td>
					<td width="120">18.48</td>
					<td width="120">7.33</td>
				</tr>
			</table>
			<br>
			<i>Evaluation of domain assignment methods using number of domains as a sole criteria.  The evaluation is performed using Balanced_Domain_Benchmark_2.</i>
		  </div><br>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="1-2">2. Fraction of correct/incorrect assignments (grouped by number of domains)</a></strong><br>
			<img src="img/newfigs/fig2.png"><br>
			Tabular data for the figure<br>
			<img src="img/newfigs/tbl2.png"><br>
			<br>
			<i>Performance of automatic methods using the multi-domain performance criterion.  For each number of domains subset, the correct assignment, over- and under-cutting rate is shown in green, red, and blue, respectively. The evaluation is performed using Balanced_Domain_Benchmark_2</i>
		  </div><br>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="1-3">3. An assiagnment of domains by each method (breakdown by number of domains)</a></strong><br>
			<img src="img/newfigs/fig3.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="100" style="background:#CCFFCC;"><b>Number of domains<b></td>
					<td width="100" style="background:#CCFFCC;"><b>Expert consensus</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="100" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="100" style="background:#CCFFCC;"><b>NCBI</b></td>
				</tr>
				<tr>
					<td width="100">1 domain</td>
					<td width="100" style="background:#CCFFCC;">33.7</td>
					<td width="100">35.2</td>
					<td width="100">44.8</td>
					<td width="100">38.4</td>
					<td width="100">37.1</td>
				</tr>
				<tr>
					<td width="100">2 domains</td>
					<td width="100" style="background:#CCFFCC;">43.8</td>
					<td width="100">39.1</td>
					<td width="100">37.5</td>
					<td width="100">32.7</td>
					<td width="100">36.5</td>
				</tr>
				<tr>
					<td width="100">3 domains</td>
					<td width="100" style="background:#CCFFCC;">17.5</td>
					<td width="100">17.8</td>
					<td width="100">14.3</td>
					<td width="100">14.6</td>
					<td width="100">18.4</td>
				</tr>
				<tr>
					<td width="100">4 domains</td>
					<td width="100" style="background:#CCFFCC;">2.5</td>
					<td width="100">3.8</td>
					<td width="100">1.6</td>
					<td width="100">9.8</td>
					<td width="100">4.4</td>
				</tr>
				<tr>
					<td width="100">5 domains</td>
					<td width="100" style="background:#CCFFCC;">1.6</td>
					<td width="100">3.8</td>
					<td width="100">1.9</td>
					<td width="100">2.2</td>
					<td width="100">1.9</td>
				</tr>
				<tr>
					<td width="100">6 domains</td>
					<td width="100" style="background:#CCFFCC;">0.6</td>
					<td width="100">0.3</td>
					<td width="100">0</td>
					<td width="100">1.9</td>
					<td width="100">1</td>
				</tr>
				<tr>
					<td width="100">7 domains</td>
					<td width="100" style="background:#CCFFCC;">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">0.3</td>
					<td width="100">0</td>
				</tr>
				<tr>
					<td width="100">8 domains</td>
					<td width="100" style="background:#CCFFCC;">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">0.6</td>
				</tr>
			</table>
			<br>
			<i>Comparison of overall number of domains assigned by each automatic method and by expert consensus (in percent) . The evaluation is performed using Balanced_Domain_Benchmark_2</i>
		  </div><br>
          </div>
		  
		  <div id="textsubheading"><a name="2">Fragmentation of domains (continuous vs. discontinuous domains)</a></div>
		  <div id="textinfo">
		  <p>
		  The partitioning of the structure into domains may result in domains consisting of contiguous stretches of polypeptide chain – one stretch per domain (contiguous domains).   Frequently, however, regions of the polypeptide chain that are distant in sequence, are close together in 3D structure, thus a domain may consist of two or more segments of the chain which are non-contiguous in sequence (non-contiguous domains).  We note that the average fragmentation of domains correlates with the average number of domains assigned by each method: if an automatic method assigns on average more domains it also assigns on average more fragments per domain. The fragmentation of domains is presented from three perspectives: <a href="#2-1">a fraction of correctly/incorrectly fragmented domains</a>, <a href="#2-2">partitioning of domains into discontinuous fragments  by each method</a>, and <a href="#2-3">correlation between partitioning protein into domains and the fragmentation of domains</a>.
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong><a name="2-1">1. Fraction of correct/incorrect fragmented domains</a></strong><br>
			<img src="img/newfigs/fig4.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="100" style="background:#CCFFCC;"><b>Number of fragments/per domain<b></td>
					<td width="100" style="background:#CCFFCC;"><b>Expert consensus</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="100" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="100" style="background:#CCFFCC;"><b>NCBI</b></td>
				</tr>
				<tr>
					<td width="100">1</td>
					<td width="100" style="background:#CCFFCC;">91.7</td>
					<td width="100">82.4</td>
					<td width="100">91.3</td>
					<td width="100">72.2</td>
					<td width="100">85</td>
				</tr>
				<tr>
					<td width="100">2</td>
					<td width="100" style="background:#CCFFCC;">7.6</td>
					<td width="100">14.9</td>
					<td width="100">8</td>
					<td width="100">18.1</td>
					<td width="100">13.1</td>
				</tr>
				<tr>
					<td width="100">3</td>
					<td width="100" style="background:#CCFFCC;">0.7</td>
					<td width="100">2.7</td>
					<td width="100">0.7</td>
					<td width="100">7.2</td>
					<td width="100">1.9</td>
				</tr>
				<tr>
					<td width="100">4+</td>
					<td width="100" style="background:#CCFFCC;">0</td>
					<td width="100">0</td>
					<td width="100">0</td>
					<td width="100">2</td>
					<td width="100">0</td>
				</tr>
			</table>
			<br>
			<i>Evaluation of domain assignment methods using using fragmentation of domains.  The evaluation is performed using Balanced_Domain_Benchmark_2.</i><br><br>
			
			<strong><a name="2-2">2. Partitioning of domains into discontinuous fragments by each method </a></strong><br>
			<img src="img/newfigs/fig5.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;"><b>Number of fragments<b></td>
					<td width="120" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="120" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="120" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="120" style="background:#CCFFCC;"><b>NCBI</b></td>
				</tr>
				<tr>
					<td width="120">1 fragment</td>
					<td width="120">-9.3</td>
					<td width="120">-0.4</td>
					<td width="120">-19</td>
					<td width="120">-6.7</td>
				</tr>
				<tr>
					<td width="120">2 fragments</td>
					<td width="120">7.3</td>
					<td width="120">0.4</td>
					<td width="120">10.5</td>
					<td width="120">5.5</td>
				</tr>
				<tr>
					<td width="120">3 fragments</td>
					<td width="120">2</td>
					<td width="120">0</td>
					<td width="120">6.5</td>
					<td width="120">1.2</td>
				</tr>
				<tr>
					<td width="120">4+ fragments</td>
					<td width="120">0</td>
					<td width="120">0</td>
					<td width="120">2</td>
					<td width="120">0</td>
				</tr>
			</table><br>
			<i>Fraction of continuous and discontinuous domains assigned by each method and binned by number of fragments per domain.  The evaluation is performed using Balanced_Domain_Benchmark_2.</i><br><br>
			<strong><a name="2-3">3. Comparing tendency toward correct assignment on the level of protein vs. the level of domain</a></strong><br>
			<img src="img/newfigs/fig6.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="100" style="background:#CCFFCC;">&nbsp;</td>
					<td width="100" style="background:#CCFFCC;"><b>PDP</b></td>
					<td width="100" style="background:#CCFFCC;"><b>DomainParser</b></td>
					<td width="100" style="background:#CCFFCC;"><b>PUU</b></td>
					<td width="100" style="background:#CCFFCC;"><b>NCBI</b></td>
					<td width="100" style="background:#CCFFCC;"><b>Expert consensus</b></td>
				</tr>
				<tr>
					<td width="100">average # of domains per chain</td>
					<td width="100">2.03</td>
					<td width="100">1.78</td>
					<td width="100">2.11</td>
					<td width="100">2.03</td>
					<td width="100" style="background:#CCFFCC;">1.95</td>
				</tr>
				<tr>
					<td width="100">average # of fragments per chain</td>
					<td width="100">1.20</td>
					<td width="100">1.09</td>
					<td width="100">1.49</td>
					<td width="100">1.30</td>
					<td width="100" style="background:#CCFFCC;">1.09</td>
				</tr>
			</table><br>
			<i>Side-by-side comparison of the average number of fragments per domain and average number of domains per chain as assigned by each method.  The left Y-axis scale refers to the average number of fragments per domain and the right Y-axis scale refers to the average number of domains per chain.  The average number of fragments per domain is calculated using Y / X, where Y is the sum of all fragments assigned for each domain and X is the total number of domains assigned.  The average number of domains per chain is calculated using A / B, where A is the sum of all domains assigned for each chain and B is the total number of chains.  The proportion between average fragments and average number of domains is 1:1.65. The evaluation is performed using Balanced_Domain_Benchmark_2.</i><br><br>
		  </div>
		  </div><br>
		  
		  <div id="textsubheading"><a name="3">Domain boundaries</a></div>
		  <div id="textinfo">
		  <p>
			Evaluating the performance of a method using only the number of domains it assigns might not be sensitive enough to determine the accuracy of an automated method.  At times, methods disagree with experts on exactly where domains starts and/or end, i.e. there is disagreement on the placement of domain boundaries, while there is agreement on the number of assigned domains.
		  </p>
		  <p>
		  To address the issue of overlap between the domains assigned by experts and those assigned by automatic methods we first define a boundary consistency criterion.  A boundary consistency of 75% requires that 75% of the domain length, as defined by two domain assignment methods, is the same.  Empirically we chose boundary_consistency_90 as a definition of identical assignment by two methods: domain assignment is considered identical if domains overlap for at least 90% of the chain length.
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<strong>Fraction of accurately assigned domains at 90% of domain boundary accuracy</strong><br>
			<img src="img/newfigs/fig7.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="150" style="background:#CCFFCC;">&nbsp;</td>
					<td width="150" style="background:#CCFFCC;"><b>Fraction of accurate assignments</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Fraction of chains that failed domain overlap criterion</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Fraction of chains that failed domain number criterion</b></td>
				</tr>
				<tr>
					<td width="150">DPD</td>
					<td width="150">0.83</td>
					<td width="150">0.03</td>
					<td width="150">0.14</td>
				</tr>
				<tr>
					<td width="150">DomainParser</td>
					<td width="150">0.79</td>
					<td width="150">0.01</td>
					<td width="150">0.20</td>
				</tr>
				<tr>
					<td width="150">PUU</td>
					<td width="150">0.69</td>
					<td width="150">0.08</td>
					<td width="150">0.23</td>
				</tr>
				<tr>
					<td width="150">NCBI</td>
					<td width="150">0.68</td>
					<td width="150">0.14</td>
					<td width="150">0.18</td>
				</tr>
			</table>
			<br>
			<i><b>Accuracy of domain assignments – a strict assessment.</b>  90% of the domain boundary consistency is required (see discussion above).   Boundaries_consistency_90 for automatic methods evaluated using Green is accurate assignments, yellow is inaccurate domain overlapping, and red is incorrect domain numbering. The evaluation is performed using Balanced_Domain_Benchmark_3.</i><br><br>
			<strong>Fraction of accurately assigned domains at 90% of domain boundary accuracy</strong><br>
			<img src="img/newfigs/fig8.png"><br>
			Tabular data for the figure<br>
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="120" style="background:#CCFFCC;">fraction of domain overlap</td>
					<td width="120">PDP</td>
					<td width="120">DomainParser</td>
					<td width="120">PUU</td>
					<td width="120">NCBI</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.35</td>
					<td width="120">0.003774</td>
					<td width="120">0.004167</td>
					<td width="120">0.004329</td>
					<td width="120">0.042802</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.45</td>
					<td width="120">0.003774</td>
					<td width="120">0.004167</td>
					<td width="120">0.008658</td>
					<td width="120">0.054475</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.5</td>
					<td width="120">0.003774</td>
					<td width="120">0.004167</td>
					<td width="120">0.012987</td>
					<td width="120">0.081712</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.55</td>
					<td width="120">0.007547</td>
					<td width="120">0.004167</td>
					<td width="120">0.012987</td>
					<td width="120">0.085603</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.6</td>
					<td width="120">0.007547</td>
					<td width="120">0.004167</td>
					<td width="120">0.017316</td>
					<td width="120">0.089494</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.65</td>
					<td width="120">0.007547</td>
					<td width="120">0.008333</td>
					<td width="120">0.021645</td>
					<td width="120">0.101167</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.7</td>
					<td width="120">0.011321</td>
					<td width="120">0.0125</td>
					<td width="120">0.030303</td>
					<td width="120">0.116732</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.75</td>
					<td width="120">0.018868</td>
					<td width="120">0.0125</td>
					<td width="120">0.030303</td>
					<td width="120">0.128405</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.8</td>
					<td width="120">0.033962</td>
					<td width="120">0.016667</td>
					<td width="120">0.060606</td>
					<td width="120">0.136187</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.85</td>
					<td width="120">0.041509</td>
					<td width="120">0.020833</td>
					<td width="120">0.073593</td>
					<td width="120">0.151751</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.9</td>
					<td width="120">0.067925</td>
					<td width="120">0.033333</td>
					<td width="120">0.125541</td>
					<td width="120">0.225681</td>
				</tr>
				<tr>
					<td width="120" style="background:#CCFFCC;">0.95</td>
					<td width="120">0.120755</td>
					<td width="120">0.058333</td>
					<td width="120">0.194805</td>
					<td width="120">0.287938</td>
				</tr>
			</table>
			<br>
			<i>Performance of each method is evaluated at different levels of domain boundary accuracy.  The evaluation is performed using Balanced_Domain_Benchmark_3.</i><br><br>
		  </div>
		  </div><br>
		  <div id="textsubheading"><a name="4">Integrity of secondary structures</a></div>
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
					<td width="85">&#946;-helix</td>
					<td width="85">1.0</td>
					<td width="85">7.6</td>
					<td width="85">0</td>
					<td width="85">0</td>
					<td width="85">2.4</td>
					<td width="85">4.3</td>
				</tr>
			</table><br>
			<i><b>Tendency toward integrity of secondary structures.</b>  Propencity to split individual secondary structure between two domains is measured.  An a-helix is considered to be split between two domains if two or more of its residues reside in a different domain from the rest.  A ß-strand is considered to be split if 30% of its residues reside in a different domain from the rest.</i><br><br>
		  </div>
		  </div><br>
		  <div id="textsubheading"><a name="5">Topological criteria for comparison of performance</a></div>
		  <div id="textinfo">
		  <p>The tendency of each method to err during structure partitioning is explored by analyzing the performance of each method on different types of architectures and topologies.   Table below systematically presents all topologies from Balanced_Domain_Benchmark_2 using CATH nomenclature for Class, Architecture and Topology of the domains. For each domain assignment method we provide two adjacent columns – one for overcuts, one for undercuts – to get a so-called ‘topological fingerprint’ of each method.  Remarkably, fingerprints are specific to each method, reflecting method-specific strengths and weaknesses in determining domains for different topologies.  
		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<img src="img/newfigs/tbl10.png"><br>
			<i>Performance of four automatic methods using topological criteria. The first columns represents CATH topology under evaluation, the second column represents number of occurrences of a given topology in the dataset.  Each of the four automatic methods is presented in two adjacent columns. The first column indicates cases of overcut, the second column cases of undercut.  The number in the cell indicates the number of cases for which miss-assignment (over cut or undercut) occurs.  A thick frame around a cell indicates that a given miss-assignment is unique to a corresponding method.  A red background for a given CATH topology indicates that a given topology is problematic to most/all of the methods.  A black background for a given CATH topology indicates that it is easy for most/all methods.</i><br><br>
		  </div>
		  </div><br>
		  <div id="textsubheading"><a name="6">Automatic consensus criteria</a></div>
		  <div id="textinfo">
		  <p>Another approach to determine to what extent automatic methods agree among themselves on the number of assigned domains is to look at agreement among all automatic methods – i.e. automatic consensus.  The automatic methods agreed completely on 168 out of all 315 chains analyzed, or 53.3% of chains. . A large proportion of these chains are single-domain chains - out of 107 single domain chains 95 (88.8%) show complete agreement among automatic methods, or 88.8% of chains, however, agreement among automatic methods drops rapidly as the number of domains increases (out of 8 4-domain chains only 1 had complete agreement, while for 5-domain or 6-domain chains there was no agreement among automatic methods).
Most chains that are cut correctly by all methods have clearly identifiable globular domains.  Chains that are difficult for all methods are those that consist of several domains that are often small and compact, or alternatively represent very large sprawling structures.  These situations are usually more difficult for methods because parameters such as connectivity, globularity, preservation of beta-sheet structures and other characteristics used by methods are more difficult to capture (<a href="methods.php">see Methods </a>).

		  </p>
		  <div style="padding-left:80px; padding-top: 20px; width: 650px;">
			<table width="600" style="line-height: 16px;" cellspacing="0">
				<tr>
					<td width="150" style="background:#CCFFCC;"><b>Number of domains per chain</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Number of chains</b> for which there is consensus among automatic methods</td>
					<td width="150" style="background:#CCFFCC;"><b>Total chains</b></td>
					<td width="150" style="background:#CCFFCC;"><b>Percent of chains</b> for which there is consensus among automatic methods</td>
				</tr>
				<tr>
					<td width="150">1</td>
					<td width="150">95</td>
					<td width="150">107</td>
					<td width="150">88.8%</td>
				</tr>
				<tr>
					<td width="150">2</td>
					<td width="150">55</td>
					<td width="150">138</td>
					<td width="150">39.9%</td>
				</tr>
				<tr>
					<td width="150">3</td>
					<td width="150">17</td>
					<td width="150">54</td>
					<td width="150">31.5%</td>
				</tr>
				<tr>
					<td width="150">4</td>
					<td width="150">1</td>
					<td width="150">8</td>
					<td width="150">12.5%</td>
				</tr>
			</table><br>
			<i>Consensus among different algorithmic methods.  The criterion is the number of assigned domains for a given chain. The evaluation is performed using Balanced_Domain_Benchmark_2</i><br><br>
		  </div>
		  </div><br>
		</td>
		</tr>
	  </table>
	  ';
	
	PrintFooter();
?>
