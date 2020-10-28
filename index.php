<?php
	include 'convert.php';
	date_default_timezone_set("America/Chicago");
	extract($_REQUEST);

	$date = new DateTime();
	if ($km!=NULL) {
		$mm = convertKMtoMM($km);
		$history[] = array($mm, '<-', $km, $date->getTimestamp());
	} else if ($mm!=NULL) {
		$km = convertMMtoKM($mm);
		$history[] = array($mm, '->', $km, $date->getTimestamp());
	} else {
		$history = array();
	}

	$showSource = False;
	if ($source!=NULL) {
		$showSource = !$showSource;
	}

	function echoHistory($history) {
		for ($i=0; $i<count($history); $i++) {
			if ($history[$i][1] == '<-') {
				echo <<< HERE
					<a href="javascript:{}" onclick="document.getElementById('km').submit();">
				HERE;
				echo strval($history[$i][0])."mm from ".strval($history[$i][2])."km ";
			} else if ($history[$i][1] == '->') {
				echo <<< HERE
					<a href="javascript:{}" onclick="document.getElementById('mm').submit();">
				HERE;
				echo strval($history[$i][2])."km from ".strval($history[$i][0])."mm ";
			}

			echo strval(date("h:i", $history[$i][3]))."</a><br>";
		}
	}

	function serializeHistory($history) {
		foreach ($history as $key => $val) {
        	foreach ($val as $k => $v) {
            	echo <<< HERE
					<input type="hidden" name="history[$key][$k]" value="$v">
HERE;
            }
        }
	}

	echo <<< HERE
		<h1>Convert between Millimeters and Kilometers</h1><br>

		<table border="2">
			<tbody>
				<tr>
					<td>
        				<form action="index.php" method="post" id="km">
HERE;

	serializeHistory($history);
	if ($km!=NULL) {
    	echo "<p>Kilometers: <input type='text' name='km' value=$km></p>";
	} else {
    	echo "<p>Kilometers: <input type='text' name='km'></p>";
	}

	echo <<< HERE
        					<p><input type="submit"/></p>
        				</form>

        				<form action="index.php" method="post" id="mm">
HERE;

	serializeHistory($history);
	if ($mm!=NULL) {
		echo "<p>Millimeters: <input type='text' name='mm' value=$mm></p>";
	} else {
		echo "<p>Millimeters: <input type='text' name='mm'></p>";
	}

	echo <<< HERE
            				<p><input type="submit"/></p>
        				</form>

						<form action="index.php" method="post">
							<p><input type="submit" name = "source" value="Show Source"/></p>
							<input type="hidden" name="showSource" value=$showSource>
						</form>
					</td>
					<td>
						<h2>History</h2><br>
HERE;

	echoHistory($history);
	echo <<< HERE
					</td>
				</tr>
			</tbody>
		</table>
HERE;

	echo "<a href='..'>Home</a>";
	echo "<HR>";

	if ($showSource) {
		highlight_file("index.php");
	}
?>
