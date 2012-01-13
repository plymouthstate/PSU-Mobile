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

} // End class Utilities
