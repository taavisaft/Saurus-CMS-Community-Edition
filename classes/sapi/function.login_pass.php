<?php
/**
 * This source file is is part of Saurus CMS content management software.
 * It is licensed under MPL 1.1 (http://www.opensource.org/licenses/mozilla1.1.php).
 * Copyright (C) 2000-2010 Saurused Ltd (http://www.saurus.info/).
 * Redistribution of this file must retain the above copyright notice.
 * 
 * Please note that the original authors never thought this would turn out
 * such a great piece of software when the work started using Perl in year 2000.
 * Due to organic growth, you may find parts of the software being
 * a bit (well maybe more than a bit) old fashioned and here's where you can help.
 * Good luck and keep your open source minds open!
 * 
 * @package		SaurusCMS
 * @copyright	2000-2010 Saurused Ltd (http://www.saurus.info/)
 * @license		Mozilla Public License 1.1 (http://www.opensource.org/licenses/mozilla1.1.php)
 * 
 */


#################################
# function login_pass
#	boxstyle => default: style="width:60" class=searchbox size=3
#	fontstyle => default: <empty>
#	value => default: <empty>

function smarty_function_login_pass ($params) {
	global $site, $leht;

	##############
	# default values

	extract($params);

	##########################
	# reg.user 

	if ($site->kasutaja) {
		$login_pass = "";
	}
	else {
		if(!isset($boxstyle)) { 
			$boxstyle = 'style="width:60" class=searchbox size=3';
		}

		$login_pass = '<input type=password name=pass value="'.$value.'" '.$boxstyle.'>';
	}
	print $login_pass;
}

