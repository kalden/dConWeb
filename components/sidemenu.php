<?php

function GetSideMenuItems ($cat,$selected,$structId,$chainId) {

	$m = new Menu_Class();

	if($cat == "Dataset") {	
		if($selected == "Dataset Overview") { $m->add_link("Dataset Overview","dataset.php",1);
		} else { $m->add_link("Dataset Overview","dataset.php",0); }
		/*
		if($selected == "Benchmark 1") { $m->add_link("Benchmark 1","dataset_b1.php",1);
		} else { $m->add_link("Benchmark 1","dataset_b1.php",0); }
		
		if($selected == "Benchmark 2 & 3") { $m->add_link("Benchmark 2 & 3","dataset_b2n3.php",1);
		} else { $m->add_link("Benchmark 2 & 3","dataset_b2n3.php",0); }
		*/

		if($selected == "Download Dataset") { $m->add_link("Download Dataset","dataset_download.php",1);
		} else { $m->add_link("Download Dataset","dataset_download.php",0); }	
		
	} elseif($cat == "Approach") {
		if($selected == "Consensus Approach") { $m->add_link("Consensus Approach","approach.php",1);
		} else { $m->add_link("Consensus Approach","approach.php",0); }

	} elseif($cat == "Domain Assignments") {	
		if($selected == "Assignment by Methods") { $m->add_link("Assignment by Methods","proteinform2012.php",1);
		} else { $m->add_link("Assignment by Methods","proteinform2012.php",0); }

		if($selected == "Consensus") { $m->add_link("Consensus","consensusform2012.php",1);
		} else { $m->add_link("Consensus","consensusform2012.php",0); }

		if($selected == "Download Domain Assignments") { $m->add_link("Download Domain Assignments","DownloadDomainAssignments.php",1);
		} else { $m->add_link("Download Domain Assignments","DownloadDomainAssignments.php",0); }

		if($selected == "Download Consensus Assignments") { $m->add_link("Download Consensus Assignments","DownloadConsensusAssignments.php",1);
		} else { $m->add_link("Download Consensus Assignments","DownloadConsensusAssignments.php",0); }


	} elseif($cat == "Results") {	
		if($selected == "Domain Assignment Summary") { $m->add_link("Domain Assignment Summary","proteinform2012.php?pdbId=$structId&chain=$chainId",1);
		} else { $m->add_link("Domain Assignment Summary","compareassignmentsHome.php?pdbId=$structId&chain=$chainId",0); }
		
		if($selected == "Boundary Analysis") { $m->add_link("Boundary Analysis","boundaryanalysis.php?pdbId=$structId&chain=$chainId",1);
		} else { $m->add_link("Boundary Analysis","boundaryanalysis.php?pdbId=$structId&chain=$chainId",0); }

		if($selected == "Consensus Assignment") { $m->add_link("Consensus Assignment","consensus.php?pdbId=$structId&chain=$chainId",1);
		} else { $m->add_link("Consensus Assignment","consensus.php?pdbId=$structId&chain=$chainId",0); }

		if($selected == "Modify Search") { $m->add_link("Modify Search","proteinform.php",1);
		} else { $m->add_link("Modify Search","proteinform.php",0); }

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
	}
	
	return $m;
}

?>
