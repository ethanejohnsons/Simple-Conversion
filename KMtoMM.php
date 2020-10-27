<?php

extract($_REQUEST);
echo "<h3>There are " . convertKMtoMM($km) . " millimeters in $km kilometers</h3>";
echo "<a href='KMtoMM.html'>Back</a>";

function convertKMtoMM($km) {
	return $km * 1000000;
}

?>
