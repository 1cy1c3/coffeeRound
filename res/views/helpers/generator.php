<?php
/**
 * 
 * @param int $start Start of the threshold value
 * @param int $stop End of the threshold value
 * @param double $step Step of the threshold value
 */
function range_yield($start, $stop, $step) {
	while ( $start < $stop ) {
		yield $start;
		$start += $step;
	}
}