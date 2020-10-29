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
	} else if ($toDelete!=NULL) {
		foreach ($history as $key => $value) {
			foreach ($toDelete as $k => $v) {
				if ($value == $v) {
					unset($toDelete[$k]);
					unset($history[$key]);
				}
			}
		}
		
	} else if ($source!=NULL) {
		$showSource = !$showSource;
	} else if ($history == NULL) {
		$history = array();
	}

	function echoHistory($history) {
		foreach ($history as $key => $value) {
			if ($history[$key][1] !== '<-' && $history[$key][1] !== '->') {
				#continue;
			}

			$mm = $history[$key][0];
			$km = $history[$key][2];

			echo <<< HERE
				<form action="index.php" method="post" name="delete">
HERE;
			$toDelete = array();
			array_push($toDelete, $history[$key]);
			serializeHistory($toDelete, True);
			serializeHistory($history, False);
			echo <<< HERE
					<input type="submit" value="Delete">
HERE;

			if ($history[$key][1] == '<-') {
				echo <<< HERE
					<a href="#" onclick="
						document.getElementById('mm').value = '$mm';
						document.getElementById('km').value = '$km';
						document.forms['kmform'].submit();
					">
HERE;
				echo strval($history[$key][0])."mm from ".strval($history[$key][2])."km ";
			} else if ($history[$key][1] == '->') {
				echo <<< HERE
					<a href="#" onclick="
						document.getElementById('mm').value = '$mm';
						document.getElementById('km').value = '$km';
						document.forms['mmform'].submit();
					">
HERE;
				echo strval($history[$key][2])."km from ".strval($history[$key][0])."mm ";
			}

			echo strval(date("h:i", $history[$key][3]))."</a><br></form>";
		}
	}

	function serializeHistory($history, $shouldDelete) {
		foreach ($history as $key => $val) {
        	foreach ($val as $k => $v) {
				if ($shouldDelete) {
            		echo <<< HERE
						<input type="hidden" name="toDelete[$key][$k]" value="$v">
HERE;
				} else {
            		echo <<< HERE
						<input type="hidden" name="history[$key][$k]" value="$v">
HERE;
				}
            }
        }
	}

	echo <<< HERE
		<h1>Convert between Millimeters and Kilometers</h1><br>

		<table border="2">
			<tbody>
				<tr>
					<td>
        				<form action="index.php" method="post" name="kmform">
HERE;

	serializeHistory($history, False);
	if ($km!=NULL) {
    	echo "<p>Kilometers: <input type='text' id='km' name='km' value=$km></p>";
	} else {
    	echo "<p>Kilometers: <input type='text' id='km' name='km'></p>";
	}

	echo <<< HERE
        					<p><input type="submit"/></p>
        				</form>

        				<form action="index.php" method="post" name="mmform">
HERE;

	serializeHistory($history, False);
	if ($mm!=NULL) {
		echo "<p>Millimeters: <input type='text' id='mm' name='mm' value=$mm></p>";
	} else {
		echo "<p>Millimeters: <input type='text' id='mm' name='mm'></p>";
	}

	echo <<< HERE
            				<p><input type="submit"/></p>
        				</form>

						<form action="index.php" method="post">
							<p><input type="submit" name = "source" value="Show Source"/></p>
HERE;

	serializeHistory($history, False);
	echo <<< HERE
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
