<?php
	extract($_REQUEST);

	if ($submit==NULL) {
		$guesses = array();
		$number = 0;
		$randomnumber = rand(1,1000);
	} else {
		$number++;
		$guesses[] = $guess;
	}

	function echoGuesses($guesses, $randomnumber) {
		foreach ($guesses as $g) {
			echo $g;
			if ($g > $randomnumber)
				echo " > ";
			else if ($g < $randomnumber)
				echo " < ";
			else 
				echo " is ";
			echo " the random number<br>";
		}
	}

	echo <<< HERE
		<h1>Guess a number between 1 and 1000</h1><br>

		<table border="2">
			<tbody>
				<tr>
					<td>
						<form action="index.php" method="post">
						Guess: <input type="text" name="guess">
HERE;

		for ($i=0; $i<count($guesses); $i++) {
    		echo <<< HERE
				<input type="hidden" name="guesses[$i]" value=$guesses[$i]>
HERE;
		}

	echo <<< HERE
						<input type="hidden" name="randomnumber" value=$randomnumber>
						<input type="hidden" name="number" value=$number>
						<input type="submit" name="submit" value="submit"><br>
						<input type="submit" name="startover" value="start over"><br>
						</form>

						<h2>Number of Guesses: $number</h2></td>
					</td>
					<td>
						<h2>Guesses</h2><br>
HERE;

	echoGuesses($guesses, $randomnumber);
	echo <<< HERE
					</td>
				</tr>
			</tbody>
		</table>
HERE;

	if ($guess == $randomnumber)
		echo "<h1>CORRECT</h1>";

	echo "<a href='..'>Home</a>";
	echo "<HR>";
	highlight_file("index.php");
?>
