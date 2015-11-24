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

/**
 * Popup page for editing extension data
 * 
 * tbl 'extensions'
 * 
 * @param string name 
 * @param string op - action name
 * @param string op2 - step 2 action name
 */

global $site;

$class_path = "../classes/";
include($class_path."port.inc.php");
include($class_path."adminpage.inc.php");
include($class_path."extension.class.php");


$site = new Site(array(
	on_debug => ($_COOKIE["debug"] ? 1:0),
	on_admin_keel => 1
));

if (!$site->user->allowed_adminpage(array('adminpage_id' => 86,)) ) { # adminpage_id=86 => "System > Extensions"
	############ debug
	if($site->user) { $site->user->debug->print_msg(); } # user debug
	if($site->guest) { 	$site->guest->debug->print_msg(); } 	# guest debug
	$site->debug->print_msg(); 
	exit;
}

$op = $site->fdat['op'];
$op2 = $site->fdat['op2'];


######## create EXTENSION

$extension = new extension(array(
	name => $site->fdat['name']
));
#printr($extension->all);

######################
# leida valitud keele p�hjal �ige lehe encoding,
# admin-osa keel j��b samaks

$keel_id = isset($site->fdat['flt_keel']) ? $site->fdat['flt_keel'] : $site->fdat['keel_id'];
if (!strlen($keel_id)) { $keel_id = $site->keel; }


###############################
# extension: UNINSTALL extension 
if($site->fdat['op2'] == 'uninstallconfirmed' && $site->fdat['name']) {

	$extension->uninstall();

	if(!$smth_not_deleted){
	?>
	<HTML>
	<SCRIPT language="javascript"><!--
		window.opener.location=window.opener.location;
		window.close();
	// --></SCRIPT>
	</HTML>
	<?php
	}
	exit;
}


######################
# 1. DELETE CONFIRMATION WINDOW (ENTIRE extension)
if($op == 'uninstall' && $site->fdat['name']) {
	
	?>
	<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html>
	<head>
	<title><?=$site->title?> <?= $site->admin->cms_version ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$site->encoding ?>">
	<meta http-equiv="Cache-Control" content="no-cache">
	<link rel="stylesheet" href="<?=$site->CONF['wwwroot'].$site->CONF[styles_path]?>/scms_general.css">
	<SCRIPT LANGUAGE="JavaScript" SRC="<?=$site->CONF['wwwroot'].$site->CONF[js_path]?>/yld.js"></SCRIPT>
	</head>
	<body class="popup_body">
		<form name="frmEdit" action="<?=$site->self?>" method="POST">
		<input type=hidden name=name value="<?=$site->fdat['name']?>">
		<input type=hidden name=op value="<?=$site->fdat['op']?>">
		<input type=hidden name=op2 value="">
	
	
	<table border="0" cellpadding="0" cellspacing="0" style="width:100%; height:200px">
	  <tr> 
		<td valign="top" width="100%" class="scms_confirm_delete_cell" height="100%">
	<?php	
		############ # get extension templates
		$extension->templates_arr = $extension->get_templates();
		foreach($extension->templates_arr as $templ){
			$templ_arr[] = $templ['templ_fail'];
		}
		
		# show confirmation
		echo $site->sys_sona(array(sona => "kustuta", tyyp=>"editor"))." \"<b>".$site->fdat['name']."</b>\"? ";
		echo $site->sys_sona(array(sona => "are you sure?", tyyp=>"admin"));
		$allow_delete = 1;
	
		######## show extension info:
	
	?>
		<br>
		<br><b><?=$extension->all['path']?></b>
		<?phpif(count($templ_arr)){?>
			<br><?=join(", ",$templ_arr)?>
		<?php}?>
	
		</td>
	  </tr>
	  <tr align="right"> 
	    <td valign="top" colspan=2 > 
			<?phpif($allow_delete){?>
	            <input type="button" value="<?=$site->sys_sona(array(sona => "kustuta", tyyp=>"editor")) ?>" onclick="javascript:frmEdit.op2.value='uninstallconfirmed';frmEdit.submit();">
				<?php}?>
				<input type="button" value="<?=$site->sys_sona(array(sona => "close", tyyp=>"editor")) ?>" onclick="javascript:window.close();"> 
	    </td>
	  </tr>
	</table>
	
	</form>
	</body>
	</html>
	<?php
	############ debug
	# user debug:
	if($site->user) { $site->user->debug->print_msg(); }
	# guest debug: 
	if($site->guest) { 	$site->guest->debug->print_msg(); }
	$site->debug->print_msg(); 
	exit;
}	
# / 1. DELETE CONFIRMATION WINDOW (ENTIRE extension)
######################


if($site->user) { $site->user->debug->print_msg(); }
if($site->guest) { 	$site->guest->debug->print_msg(); }
$site->debug->print_msg(); 
?>
</body>
</html>
