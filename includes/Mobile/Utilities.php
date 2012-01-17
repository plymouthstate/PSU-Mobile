<?php

namespace Mobile;

class Utilities {

	/**
	 * Function to return a 'pretty' relative date, such as '3 days ago'
	 * SOURCE: http://www.php.net/manual/en/function.time.php#91864
	 */
	public static function time_ago( $tm, $rcs = 0 ) {
		$cur_tm = time(); $dif = $cur_tm-$tm;
		$pds = array('second','minute','hour','day','week','month','year','decade');
		$lngh = array(1,60,3600,86400,604800,2630880,31570560,315705600);
		for($v = sizeof($lngh)-1; ($v >= 0)&&(($no = $dif/$lngh[$v])<=1); $v--); if($v < 0) $v = 0; $_tm = $cur_tm-($dif%$lngh[$v]);

		$no = floor($no); if($no <> 1) $pds[$v] .='s'; $x=sprintf("%d %s ",$no,$pds[$v]);
		if(($rcs == 1)&&($v >= 1)&&(($cur_tm-$_tm) > 0)) $x .= time_ago($_tm);

		return $x;
	} // End time_ago

	/**
	 * Function to return a properly formatted date in the HTML5 datetime attribute machine-readable format
	 * SOURCE: http://www.php.net/manual/en/function.date.php#99807
	 */
	public static function datetime( $intDate = null ) {
		$strFormat = 'Y-m-d\TH:i:s.uP';
		$strDate = $intDate ? date( $strFormat, $intDate ) : date( $strFormat ) ; 

		return $strDate;
	} // End datetime

	/**
	 * Function to strip out strange unicode characters, such as smart-quotes
	 * SOURCE: http://stackoverflow.com/a/4583465
	 */
	public static function html_all_entities($str){
		$res = '';
		$strlen = strlen($str);
		for($i=0; $i<$strlen; $i++){
			$byte = ord($str[$i]);
			if($byte < 128) // 1-byte char
				$res .= $str[$i];
			elseif($byte < 192); // invalid utf8
			elseif($byte < 224) // 2-byte char
				$res .= '&#'.((63&$byte)*64 + (63&ord($str[++$i]))).';';
			elseif($byte < 240) // 3-byte char
				$res .= '&#'.((15&$byte)*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
			elseif($byte < 248) // 4-byte char
				$res .= '&#'.((15&$byte)*262144 + (63&ord($str[++$i]))*4096 + (63&ord($str[++$i]))*64 + (63&ord($str[++$i]))).';';
		}
		return $res;
	} // End html_all_entities

} // End class Utilities
