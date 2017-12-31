<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1); 

	header('Content-Type: application/json');
 

	if ( !(isset($_GET['username'])) || $_GET['username'] == ""   ) {

		print "{}";
		exit;

	}

//echo "<pre>";

	// export TIME_STYLE=long-iso; : Pone el formato fecha en modo extendido
	$sal = shell_exec('export TIME_STYLE=long-iso; ls -lt /home/ubuntu/scrap/home-depot/download/' . $_GET['username'] . '.*.csv'  );




	$ROWS = explode("\n", $sal  );

	//print_r( $ROWS) ;


	$FILES = [];

	$i=0;
	foreach ($ROWS as &$str) {

		if ($str != ""){


	    	 preg_match('/^\s*[\-rwx]+\s+\d+\s+[^\s]+\s+[^\s]+\s+\d+\s+(\d+\-\d+-\d+ \d+:\d+)\s+[^\s]+\/([^\s\/]+)$/', $str, $file);
			//print_r($file);

	    	 preg_match('/[^\.]+.[^\.]*.(\d+_\d+_\d+)\-(\d+-\d+)\-\d+.csv/' , $file[2] , $requested);

	    	 

			$FILES[$i]['file'] = $file[2];
			$FILES[$i]['finished'] = $file[1];
			$FILES[$i]['requested'] = $requested[1] . " " . $requested[2];
			$FILES[$i]['requested'] = str_replace("-", ":", $FILES[$i]['requested']);
			$FILES[$i]['requested'] = str_replace("_", "-", $FILES[$i]['requested']);
			$i++;

		}

	}

	//print_r( $FILES) ;

 

 

print json_encode($FILES);

 

exit;

?>
