<?php
session_start ();
/*
 * Include the classes (data, draw and image) to create chart
 */
require ("../../../libs/pChart2.1.3/class/pData.class.php"); 
require ("../../../libs/pChart2.1.3/class/pDraw.class.php");
require ("../../../libs/pChart2.1.3/class/pImage.class.php");

try {
	$chartData = $_SESSION ["chartData"];
	if (! isset ( $_SESSION ["chartData"] )) {
		throw new Exception ( "There are no data for the chart" );
	}
	session_destroy ();
	$pData = new pData (); // Initialize the data-object
	$pData->addPoints ( $chartData, "Average" );
	$pData->setPalette ( "Average", array (
			"R" => 0,
			"G" => 153,
			"B" => 204,
			"Alpha" => 100 
	) );
	$pImage = new pImage ( 585, 300, $pData ); // Initialize the image-object
	$pImage->setGraphArea ( 25, 25, 875, 275 );
	$pImage->setFontProperties ( array (
			"FontName" => "../../../libs/pChart2.1.3/fonts/verdana.ttf",
			"FontSize" => 11 
	) );
	$pImage->drawScale ();
	$pImage->drawText ( 150, 50, "Correlation: x = alpha and y = average", array (
			"R" => 0,
			"G" => 102,
			"B" => 104,
			"FontSize" => 16 
	) );
	$pImage->drawLegend ( 70, 100, array (
			"R" => 220,
			"G" => 220,
			"B" => 220,
			"FontR" => 0,
			"FontG" => 153,
			"FontB" => 204,
			"BorderR" => 80,
			"BorderG" => 80,
			"BorderB" => 80,
			"FontSize" => 12,
			"Family" => LEGEND_FAMILY_CIRCLE 
	) );
	$pImage->drawLineChart (); // Draw the chart
	header ( "Content-Type: image/png" ); // Modify header
	$pImage->stroke (); // (Output) of the chart
} catch ( Exception $e ) {
	echo $e->getMessage ();
}	