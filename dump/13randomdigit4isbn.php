<?php
				$token=getRandomString(13);
				echo $token;
				function getRandomString($length) {
			    $validCharacters = "0123456789";
			    $validCharNumber = strlen($validCharacters);
			    $result = "";

			    for ($i = 0; $i < $length; $i++) {
			        $index = mt_rand(0, $validCharNumber - 1);
			        $result .= $validCharacters[$index];
			    }
				return $result;
				}
?>

