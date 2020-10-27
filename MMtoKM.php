<?php

extract($_REQUEST);
echo "<h3>There are " . convertMMtoKM($mm) . " kilometers in $mm millimeters</h3>";
echo "<a href='MMtoKM.html'>Back</a>";

function convertMMtoKM($mm) {
	return $mm / 1000000;
}

?>
