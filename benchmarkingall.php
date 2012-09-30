<?php
	include("components/environment.php");
	include("components/menu.php");
	include("components/sidemenu.php");
	
	PrintHeader("Benchmarking and Basic Properties");
	
	print '
	  <table width="95%"  border="0" cellspacing="0" cellpadding="0">
		<tr align="left">
		  <td valign="top" width="242">';
		  PrintSideMenuBox("Results",GetSideMenuItems("Results","Results Overview",null,null));
		  print '
		  </td>
		  <td valign="top" align="left">
         <div id="textheading">Benchmarking and Basic Properties :</div>
		<br>
		  <div id="textsubheading">Overall comparisons of all methods. </div>
		  <div id="textinfo">
		  <p align="left">This section discusses major features of assignment methods: </p>
		  <ul>
            <li>
              <a href="benchmarkingall.php#benchmarking">Benchmarking of domain assignment methods </a>
            </li>
            <li>
              <a href="benchmarkingall.php#single%20vs%20multi-domain%20distribution">Distribution of single and multi-domain chains </a>
            </li>
            <li>
              <a href="benchmarkingall.php#continuous%20vs%20discontinuous%20domains">Ratio of continuous vs. discontinuous domains </a>
            </li>
            <li>
              <a href="benchmarkingall.php#domain%20and%20fragment%20sizes">Distribution of domain and fragment sizes </a>
            </li>
	      </ul>
		  </div>
		  <div id="textsubheading"><a name="benchmarking"></a>Benchmarking of domain assignment methods. </div>
		  <div id="textinfo">
		  <p>Relative accuracy of each domain assignment method was evaluated using AUTHORS methods as a reference. </p>
		  <p>Evaluation is done using <strong>number of domains</strong> criteria (assignments are equivalent if number of domains assigned by two methods is the same).&nbsp; Evaluation of performance using domain boundaries is reported&nbsp; in Results Domain Boundaries section. </p>
		</div>
			<div id="textsubheading"><a name="benchmarking_dom_number"> Evaluation using domain number cretiria. </a></div>
			<div id="textinfo">
		  <p><img src="results/benchmark_newSCOP.png" alt="benchmark_newSCOP.png (9703 bytes)" height="540" width="720"></p>
		  <p>Figure 1A. The analysis is performed on the 467 chains dataset (constructed as described in Material and Methods). <strong>A </strong>. Comparing performance using the number of domains as the sole criteria for assignment. Two version fo SCOP data are used in (A): SCOP (Astral) uses SCOP domains as defined by the Astral compendium, SCOP (annotations) uses augmented domain assignments derived from manual annotations provided in individual SCOP entries. Undercut: methods assigns less domains than a reference method.&nbsp; Overcut: method assigns more domains than a reference method. </p>
		  </div>
		  <div id="textsubheading"><a name="benchmarking_dom_boundaries">Evaluation using domain boundary overlap. </a></div>
		  <div id="textinfo">
		  <p><img src="results/figure1b.jpg" alt="wpeF.jpg (26854 bytes)" height="358" width="483"></p>
		  <p>Figure 1B. Benchmarking assignment methods, using AUTHORS as a reference. Methods are compared using number of domain boundaries at 75% of domain overlap as&nbsp; criteria for equivalence of assignments ( <a href="domain_boundaries.php#percent%20of%20domain%20overlap">percent of domain boundary overlap </a>). &nbsp; Total number of chains: 467.&nbsp; Undercut: methods assigns less domains than a reference method.&nbsp; Overcut: method assigns more domains than a reference method. </p>
		  </div>
		  <div id="textsubheading"><a name="single vs multi-domain distribution"></a>Single domain vs. multi-domain chains. </div>
		  <div id="textinfo">
		  <p>The fraction of single and multiple domain chains in the 467-chains dataset varies depending on the assignment method (Figure 2). Single domain proteins dominate the dataset; the percentage ranges from 69.5% for AUTHORS assignment to 81% for SCOP. The majority of multi-domain proteins contain 2- or 3-domains; the fraction of 2-domain chains ranges from 22% for AUTHORS to 12% for SCOP. The fraction of 3-domain protein chains ranges from 7.3% for AUTHORS to 3.9% for SCOP. DALI tends to create the largest number of domains – 3% for 4-domain proteins versus less than 1% for all other methods; and partitions 5 protein chains into 5 domains. <strong></strong></p>
		  <p><img src="results/figure2.jpg" width="500" height="397"></p>
		  <p>Figure 2. &nbsp; Distribution of single and multi-domain chains in each assignment method. Total number of chains: 467. </p>
		  <p><a name="continuous vs discontinuous domains"></a><strong><a name="Ratio of continuous vs discontinuous domains">Ratio of continuous vs discontinuous domains </a>. </strong></p>
		  <p>Both, continuous domains (consisting of one continuous segment of the polypeptide chain) and non-continuous domains (consisting of two or more fragments from the same polypeptide chain) are present in the dataset. The fraction of continuous domains varies significantly by assignment method.&nbsp; It is the highest in SCOP, where 97% of all tested chains consist of single fragment domains and is lowest for DALI, where 77% of chains have single domains. For each assignment method, approximately 10-15% of chains have one or more domains made out of non-continuous fragments. The exception is SCOP where only 2.6% of the chains contain domains comprising of more than one fragment. </p>
		  <p><img src="results/figure3.jpg" alt="wpe13.jpg (33045 bytes)" height="457" width="500"></p>
		  <p>Figure 3. &nbsp; Distribution of number of fragments per domain by method.&nbsp; Domains with 1 fragment are continuous domains, domains with 2 or more fragments are discontinuous domains. </p>
		  <p>The number of domains per chain combined with the number of fragments per domain affects the number of additional chain crossovers <a href="benchmarkingall.php#_ftn1" name="_ftnref1">* </a>between domains. Some methods tend to have a lower number of chain crossovers than others. The single extra crossover of the chain between domains ranges from 11.7% of the dataset in PDP to 3.2% in SCOP, the fraction of chains with two extra crossovers ranges between 4.9% of the dataset in PDP and 0.8% in DomainParser (Figure 4). Presence of 3 additional crossovers is notable in PDP (1%) and in DALI (3.9%). Some domain assignments produced by DALI and CATH result in up to 10 additional chain crossovers between domains. The fraction of assignments with an excessive number of additional chain crossovers is significantly less in CATH than in DALI. </p>
		  <p>*Consider a single chain consisting of multiple domains. We define a chain crossover as an instance in which a chain travels from one domain into another domain. If the number of crossovers is more than the number of domains minus one, then we have non-contiguous domain(s); i.e. domains(s) consisting of several polypeptide fragments which are separated by the fragments participating in other domains. </p>
		  <p><img src="results/fig5.jpg" height="489" width="600"></p>
		  <p>Figure 4. &nbsp; Distribution of number additional cross-overs per chain. . </p>
		  <p><a name="domain and fragment sizes"></a><a name="Distribution of domain and fragment sizes."><strong>Distribution of domain and fragment sizes. </strong></a></p>
		  <p>The domain sizes produced by the different assignment methods vary from 20 to 1420 residues; the distribution of sizes of fragments comprising domains (continuous domains have 1 fragment, discontinuous domains have 2 or more fragments per domain) ranges from 5 to 825 residues (Figure 5A, B). Both, the distribution of domain size and of fragment size show distinct peaks. This holds for all six assignment methods and is an unexpected result, indicating that domains prefer to have certain sizes and avoid other sizes. For domain sizes there is a peak around 60-70 residues and another peak around 120-130 residues. For fragment sizes the peaks are less distinguished, the first peak corresponds to fragments 50-70 residue long and the second peak corresponds to fragments 110-130 residue long. There is an additional peak corresponding to 15-25 residue fragments, mostly contributed by DALI (Figure 5B). The distribution of domain and fragment sizes was also tested on the dataset with lower domain/fragment redundancy (Figure 5C, D). The original dataset of 467 chains was purged so that each of the SCOP superfamilies in the original dataset was represented by only one chain; this reduction analysis was also performed at the level of SCOP folds. The resulting data still reveals peaks around 60-70 residues and 110-130 residues. The intensity of the peak corresponding to 60-70 residue long domains diminishes (due to over-representation of small proteins, SCOP class G) and the 120-130 residue peak increases in magnitude (Figure 5C). </p>
		  <p><img src="results/figure5a.jpg" height="520" width="750"><strong></strong></p>
		  <p><strong>Figure 5A. </strong>Distribution of domain sizes in the entire 467-chain dataset shown for each method . <strong></strong></p>
		  <p><strong>Figure 5. Distribution of domain and fragment sizes in the 467-chain dataset. (A) </strong>Distribution of domain sizes in the entire 467-chain dataset shown for each method <strong>(B) </strong> Distribution of fragment sizes in the entire 467-chain dataset shown for each method <strong>(C) </strong>Distribution of domain sizes in the purged dataset (purged dataset, as described in text, at the level of unique superfamilies or at the level of unique folds): shown for all chains (blue), unique SCOP superfamilies (red) and unique SCOP folds (green). Superimposed is the distribution of chain sizes (magenta). <strong>(D) </strong> distribution of fragment sizes in the purged dataset shown for all chains (blue), unique SCOP superfamilies (red) and unique SCOP folds (green). Superimposed is the distribution of chain sizes (magenta). Data are shown for AUTHORS assignment in C. and D. </p>
		  <p><img src="results/figure5b.jpg" height="525" width="750"></p>
		  <p><strong>Figure 5B . </strong>Distribution of domain sizes in the entire 467-chain dataset shown for each method . </p>
		  <p><img src="results/figure5c.jpg" height="525" width="750"></p>
		  <p><strong>Figure 5C.&nbsp; </strong>Distribution of domain sizes in the purged dataset (purged dataset, as described above) at the level of unique superfamilies or at the level of unique folds): shown for all chains (blue), unique SCOP superfamilies (red) and unique SCOP folds (green). Superimposed is the distribution of chain sizes (magenta). </p>
		  <p><img src="results/figure5d.jpg" height="465" width="750"></p>
		  <p><strong>Figure 5D.&nbsp; </strong>Distribution of fragment sizes in the purged dataset (purged dataset, as described above) at the level of unique superfamilies or at the level of unique folds): shown for all chains (blue), unique SCOP superfamilies (red) and unique SCOP folds (green). Superimposed is the distribution of chain sizes (magenta). </p>
		  <p>&nbsp;</p>
		</div>
		</td>
		</tr>
	  </table>';
	
	
	PrintFooter();
?>
