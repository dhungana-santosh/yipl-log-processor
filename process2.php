	<?php
	$handle=fopen('example.log', 'r') or die('File Could not be opened !!');
	$line=fgets($handle);

	while(! feof($handle))
	{		
			$requestsCount = 1;
			$warningCounter=0;
			$errorCounter=0;
			$prevParts=explode(' ', $line);
			$prevDate=explode('-', $prevParts[0]);
			$prevDay=substr($prevParts[0],9,2);
			$message=substr($prevParts[7], 0,10);
			if(checkWarning($message)) $warningCounter++;
			if(checkError($message)) $errorCounter++;

			sameDay:

			$nextLine=fgets($handle);
			$nextPart=explode(' ', $nextLine);
			$nextDate=explode('-', $nextPart[0]);
			
			$nextDay=substr($nextPart[0],9,2);

			if($prevDay==$nextDay){
				$requestsCount = 0;
				$message=substr($nextPart[7], 0,10);
				if(checkWarning($message)) $warningCounter++;
				if(checkError($message)) $errorCounter++;
				Goto sameDay;
			}

	 	echo($prevParts[0] . " warning:" . $warningCounter . " error:" . $errorCounter . "<br><br>");

		$line=$nextLine;
		


	}

	fclose($handle);

	function checkWarning($msg){
		if(preg_match('/warning/', $msg))
			return true;
	}

	function checkError($msg){
		if(preg_match('/error/', $msg))
			return true;
	}







	?>