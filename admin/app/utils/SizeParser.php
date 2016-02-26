<?php

namespace App\Utils;

/**
 * Class SizeParser
 * @package App\Utils
 * @author: Matěj Račinský
 */
class SizeParser {

	/**
	 * @param $size
	 * @return float
	 */
	static function parse_size($size) {
		$unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
		$size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
		if ($unit) {
			// Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
			return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
		}
		else {
			return round($size);
		}
	}
} 