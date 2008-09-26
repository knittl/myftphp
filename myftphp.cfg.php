<?
// myftphp config file
// ===================

defined('IN_MFP') && IN_MFP || die('.');

// user accounts,
// must exist, but if array is empty *no* authentification happens
// user => (sha1(password), home-dir[w/o ending slash], language name, theme name)
$accounts = array(
	'myftphp' => array(
		// sha1('myftphp'):
		'pass'  => '6ea7af35060f7f9306e61c5529e69df6ddb6b3d9',
		'home'  => '.',
		'lang'  => 'english',
		'theme' => 'light',
	),
);

// image files
$cfg['imglist'] = array(
	'bullet'   => 'bullet_black.png',
	'clip'     => 'report.png',
	'clipadd'  => 'report_add.png',
	'clipsub'  => 'report_delete.png',
	'cancel'   => 'cancel.png',
	'compress' => 'compress.png',
	'copy'     => 'page_white_copy.png',
	'del'      => 'page_delete.png',
	'dir'      => 'folder.png',
	'dirup'    => 'folder_go.png',
	'download' => 'arrow_down.png',
	'drive'    => 'drive_web.png',
	'edit'     => 'page_edit.png',
	'enter'    => 'door_in.png',
	// 'error' must be png
	'error'    => 'exclamation.png',
	'exit'     => 'door_out.png',
	'explore'  => 'folder_explore.png',
	'file'     => 'page.png',
	'find'     => 'find.png',
	'group'    => 'group.png',
	'help'     => 'help.png',
	'home'     => 'house.png',
	'images'   => 'images.png',
	'info'     => 'information.png',
	'kbd'      => 'keyboard.png',
	'link'     => 'link.png',
	'move'     => 'page_white_go.png',
	'newdir'   => 'folder_add.png',
	'newfile'  => 'page_white_add.png',
	'ok'       => 'accept.png',
	'others'   => 'world.png',
	'perms'    => 'lock_edit.png',
	'pwd'      => 'key.png',
	'reload'   => 'arrow_refresh_small.png',
	'rem'      => 'folder_delete.png',
	'ren'      => 'link_edit.png',
	'src'      => 'page_code.png',
	'thumbs'   => 'application_view_tile.png',
	'tree'     => 'application_side_contract.png',
	'txtarea'  => 'comment.png',
	'upload'   => 'attach.png',
	'user'     => 'user.png',
	'water'    => '../water.gif',
	'warn'     => 'error.png',

	'asc'  => 'bullet_arrow_up.png',
	'desc' => 'bullet_arrow_down.png',
);
//filetypes and extensions - all lowercase
$cfg['ftypes'] = array(
	'acrobat' => array('pdf'),
	'as'      => array('as'),
	'c#'      => array('cs'),
	'c'       => array('c'),
	'c++'     => array('cpp'),
	'cf'      => array('cfm'),
	'code'    => array('css', 'js'),
	'db'      => array('sql', 'mdb', 'mde'),
	'doc'     => array('doc', 'dot'),
	'fh'      => array('fh'),
	'fla'     => array('fla', 'swf'),
	'h'       => array('h'),
	'html'    => array('htm','html','shtml'),
	#'img'     => array('jpg','jpeg','jpe', 'png'),
	'iso'     => array('iso'),
	'msvs'    => array(),
	'office'  => array(),
	'php'     => array('php', 'php3'),
	'ppt'     => array('ppt', 'pps', 'pot'),
	'rb'      => array('rb'),
	'svg'     => array('svg'),
	'txt'     => array('txt', 'rtf', 'ini'),
	'xls'     => array('xls', 'xlt'),
	'zip'     => array('zip'),
	'zipped'  => array('rar', 'gz', 'bz2', '7zip'),
);

//filetype images
$cfg['icons'] = array(
	'no'      => 'page_white.png',
	'acrobat' => 'page_white_acrobat.png',
	'as'      => 'page_white_actionscript.png',
	'c#'      => 'page_white_csharp.png',
	'c'       => 'page_white_c.png',
	'c++'     => 'page_white_cplusplus.png',
	'cf'      => 'page_white_coldfusion.png',
	'code'    => 'page_white_code.png',
	'db'      => 'page_white_database.png',
	'doc'     => 'page_white_word.png',
	'fh'      => 'page_white_freehand.png',
	'fla'     => 'page_white_flash.png',
	'h'       => 'page_white_h.png',
	'html'    => 'page_white_world.png',
	'iso'     => 'page_white_cd.png',
	'msvs'    => 'page_white_visualstudio.png',
	'office'  => 'page_white_office.png',
	'php'     => 'page_white_php.png',
	'ppt'     => 'page_white_powerpoint.png',
	'rb'      => 'page_white_ruby.png',
	'svg'     => 'page_white_vector.png',
	'txt'     => 'page_white_text.png',
	'xls'     => 'page_white_excel.png',
	'zip'     => 'page_white_compressed.png',
	'zipped'  => 'page_white_zip.png',
);

// try to set max upload size
@ini_set('upload_max_filesize', '256MB');
@ini_set('post_max_size', '256M');

@ini_set('magic_quotes_gpc', 0);
set_magic_quotes_runtime(0);
@set_time_limit(60);


//___main script____
//__configuration__
// include dirs, w/o slash
$cfg['dirs'] = array(
	'langs'  => 'myftphp_lang',
	'imgs'   => 'myftphp_img/silk',
	'icons'  => 'myftphp_img/silk/icons',
	'themes' => 'myftphp_themes',
	'libs'   => 'myftphp_libs',
	'classes' => 'myftphp_classes',
	'cache' => '/tmp/myftphp_cache'
);

$cfg['files'] = array(
	'log' => 'mfp.log'
);

// tree settings
$cfg['tree'] = array(
	// if directoy tree takes too many resources to read > set to FALSE or decrease depth
	'enabled' => TRUE,
	// depth of recursion for tree
	// 0: infinite recursion, ATTENTION: may crash server or make script unusable
	// please consider recursive symbolic links *still* as a problem // TODO
	// default: 2
	'depth' => 2
);

// thumbnailing config
// maxw & maxh are pixel values
$cfg['thumbs'] = array(
	'max' => array(
		'w' => 65,
		'h' => 65
	),
	'resizeall' => FALSE,
	// caching
	'cache' => array(
		'enabled' => TRUE,
		'fullmd5' => FALSE // not used atm
	)
);

// preview length in properties dialog
// in bytes/chars
$cfg['previewlen'] = 512;

// hashkey for session
// changing for higher security is recommended
$cfg['hashkey'] = 'myFtPhp';

// charset for html output and form input
$cfg['charset'] = 'utf-8';
?>
