<?php

function ResultSideMenuItems ($cat,$selected,$structId,$chainId,$cath,$scop,$ddomain,$dodis,$puu,$dhcl,$dp,$pdp,$ncbi,$chains) {

	$m = new Menu_Class();

	if($cat == "Results") {	
		if($selected == "Domain Assignment Summary") { $m->add_link("Domain Assignment Summary","compareassignmentsSelChain.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Domain Assignment Summary","compareassignmentsSelChain.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		if($selected == "Boundary Analysis") { $m->add_link("Boundary Analysis","boundaryanalysis.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Boundary Analysis","boundaryanalysis.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		if($selected == "Simple Consensus") { $m->add_link("Simple Consensus","consensus_12_SelChain.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Simple Consensus","consensus_12_SelChain.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		if($selected == "Weighted Consensus") { $m->add_link("Weighted Consensus","working2.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Weighted Consensus","working2.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		if($selected == "Weighted Consensus - Calculation") { $m->add_link("Weighted Consensus - Calculation","consensus2rules.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Weighted Consensus - Calculation","consensus2rules.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		if($selected == "Documentation") { $m->add_link("Documentation","documentation.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Documentation","documentation.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		if($selected == "Modify Search") { $m->add_link("Modify Search","proteinform.php",1);
		} else { $m->add_link("Modify Search","proteinform.php",0); }

	} elseif($cat == "Error") {	
		if($selected == "Modify Search") { $m->add_link("Modify Search","proteinform.php",1);
		} else { $m->add_link("Modify Search","proteinform.php",0); }

	} elseif($cat == "RegError") {	
		if($selected == "Modify Search") { $m->add_link("Modify Search","boundaryanalysis.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
		} else { $m->add_link("Modify Search","boundaryanalysis.php?pdbId=$structId&chain=$chainId&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }

		
	} elseif($cat == "Approach") {
		if($selected == "Consensus Approach") { $m->add_link("Consensus Approach","approach.php",1);
		} else { $m->add_link("Consensus Approach","approach.php",0); }

	} elseif($cat == "Method Performance") {	
		if($selected == "Performance Analysis & Consensus") { $m->add_link("Performance Analysis & Consensus","proteinform.php",1);
		} else { $m->add_link("Performance Analysis & Consensus","proteinform.php",0); }

	} elseif($cat == "Methods") {
		if($selected == "Method Overview") { $m->add_link("Method Overview","methods.php",1);
		} else { $m->add_link("Method Overview","methods.php",0); }
		
		if($selected == "DomainParser") { $m->add_link("DomainParser","domainparser.php",1);
		} else { $m->add_link("DomainParser","domainparser.php",0); }
		
		if($selected == "NCBI") { $m->add_link("NCBI","ncbi.php",1);
		} else { $m->add_link("NCBI","ncbi.php",0); }
		
		if($selected == "PDP") { $m->add_link("PDP","pdp.php",1);
		} else { $m->add_link("PDP","pdp.php",0); }

		if($selected == "PUU") { $m->add_link("PUU","puu.php",1);
		} else { $m->add_link("PUU","puu.php",0); }
		
		
	} elseif($cat == "Evaluation") {
		if($selected == "Evaluation Overview") { $m->add_link("Evaluation Overview","evaluation.php",1);
		} else { $m->add_link("Evaluation Overview","evaluation.php",0); }
		
		if($selected == "eval1") { $m->add_link("Number of assigned domains","eval1.php",1);
		} else { $m->add_link("Number of assigned domains","eval1.php",0); }
		
		if($selected == "eval2") { $m->add_link("Fragmentation of domains","eval2.php",1);
		} else { $m->add_link("Fragmentation of domains","eval2.php",0); }
		
		if($selected == "eval3") { $m->add_link("Domain boundaries","eval3.php",1);
		} else { $m->add_link("Domain boundaries","eval3.php",0); }
		
		if($selected == "eval4") { $m->add_link("Integrity of secondary structures","eval4.php",1);
		} else { $m->add_link("Integrity of secondary structures","eval4.php",0); }
		
		if($selected == "eval5") { $m->add_link("Topological criterion","eval5.php",1);
		} else { $m->add_link("Topological criterion","eval5.php",0); }
		
		if($selected == "eval6") { $m->add_link("Automatic consensus criteria","eval6.php",1);
		} else { $m->add_link("Automatic consensus criteria","eval6.php",0); }
		
		if($selected == "eval7") { $m->add_link("Composite method evaluation","eval7.php",1);
		} else { $m->add_link("Composite method evaluation","eval7.php",0); }
		
		
	} elseif($cat == "Insights") {
		if($selected == "Insights Overview") { $m->add_link("Insights Overview","insights.php",1);
		} else { $m->add_link("Insights Overview","insights.php",0); }
	} elseif($cat == "Chains") {
		while($row = mysql_fetch_array($chains))
		{
			// check if chainstart is null - if so, the chain or protein does not exist and an error will need presenting
			$chain = $row['chain'];
			if($selected == $chain) { $m->add_link($chain,"compareassignmentsSelChain.php?pdbId=$structId&chain=$chain&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
			} else { $m->add_link($chain,"compareassignmentsSelChain.php?pdbId=$structId&chain=$chain&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }
		}
	} elseif($cat == "Consensus Chains") {
		while($row = mysql_fetch_array($chains))
		{
			// check if chainstart is null - if so, the chain or protein does not exist and an error will need presenting
			$chain = $row['chain'];
			if($selected == $chain) { $m->add_link($chain,"consensus_12_SelChain.php?pdbId=$structId&chain=$chain&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",1);
			} else { $m->add_link($chain,"consensus_12_SelChain.php?pdbId=$structId&chain=$chain&CATH=$cath&SCOP=$scop&pdp=$pdp&dp=$dp&DHcL=$dhcl&DDomain=$ddomain&PUU=$puu&NCBI=$ncbi&Dodis=$dodis",0); }
		}
	}
	
				
	
	
	
	return $m;
}

?>
