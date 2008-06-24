<?php
/*
 *      myft.php
 *
 *      Copyright 2008 Daniel Knittl-Frank <knittl89@yahoo.de>
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 2 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 * 
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */

/********_________________some_note____________________********/
/*****////////////////////////////////////////////////////*****/
/***                                                        ***/
/***  http://myftphp.sf.net                                 ***/
/***                                                        ***/
/***  alright, my file manager:                             ***/
/***      multiple users                                    ***/
/***      tree view                                         ***/
/***      thumbnail galleries                               ***/
/***      multi-lingual support                             ***/
/***      famfamfam icons                                   ***/
/***      clipboard                                         ***/
/***      archive download                                  ***/
/***      minimalistic use of javascript                    ***/
/***         to make it work in almost every browser        ***/
/***                                                        ***/
/***  mail me on questions, hints and requests              ***/
/***                                                        ***/
/***  knittl <knittl89@yahoo.de>                            ***/
/***      <http://knittl.net.tf>                            ***/
/***                                                        ***/
/*****====================================================*****/
/***                                                        ***/
/***  Silk icon set 1.3                                     ***/
/***  by Mark James <mjames@gmail.com>                      ***/
/***     <http://www.famfamfam.com/lab/icons/silk/>         ***/
/***                                                        ***/
/*****////////////////////////////////////////////////////*****/

// _known issues:_
//   - there are still some issues using the dir-up link,
//   - if you are in a parent dir of the myftphp-dir
//     - didn't figure out a function that works the way i want
//  - so far FIXED
//  - [done]
//
//   - the user limitations for dirs should work now [done]
//     - limited to home dir now
//
//
// _tasks atm:_
//   * implementing checkboxes > multiple file operations [done]
//   * archive support (down & upload): zip[done for files], tar.gz/bz2, rar
//   * sorting view list: name, size, modified [single sort done]
//   * packing all colors into a single array for central color definition [done]
//   * login with forwarding to requested page: should be fixed within one minute [done]
//   * showing icons of filetype either in dirview or galleryview
//   * translations
//     * french
//     * italian
//     * spanish
//     * finnish
//     * russian
//     * swedish
//     * dutch
//     * ...
//

// _tasks in the future:_
//   * refactoring/oop recode: class based
//     * exception handler to log errors [done]
//   * better themeability
//


// user accounts,
// must exist, but if array is empty *no* authentification happens
// user => (md5(password), home-dir[w/o ending slash], language name, theme name)
$accounts = array(
	'myftphp' => array(
		// sha1('myftphp'):
		'pass'  => '6ea7af35060f7f9306e61c5529e69df6ddb6b3d9',
		'home'  => '.',
		'lang'  => 'english',
		'theme' => 'light',
	),

	'knittl' => array(
		'pass'  => 'b5da57b53d53b8bebfb7fd88b02c0e768059470f',
		'home'  => '..',
		'lang'  => 'english',
		'theme' => 'light',
	),
	'music' => array(
		'pass' => sha1('music'),
		'home' => '/home/knittl/MusicNTFS',
		'lang' => 'english',
		'theme' => 'light',
	),
	'videos' => array(
		'pass' => sha1('videos'),
		'home' => '/media/trekstorE/videos',
		'lang' => 'english',
		'theme' => 'light',
	),

);

// image files
$imglist = array(
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
	'error'    => 'error.png',
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

	'asc'  => 'bullet_arrow_up.png',
	'desc' => 'bullet_arrow_down.png',
);
//filetypes and extensions - all lowercase
$ftypes = array(
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
$icons = array(
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

@ini_set('post_max_size', '256M');
@ini_set('magic_quotes_gpc', 0);
set_magic_quotes_runtime(0);
@set_time_limit(60);


//___main script____
//__configuration__
// include dirs, w/o slash
$langdir  = 'myftphp_lang';
$imgdir   = 'myftphp_img/silk';
#$imgdir  = 'nocvs/gfx/old_images';
$icondir  = 'myftphp_img/silk/icons';
$themedir = 'myftphp_themes';
$libdir   = 'myftphp_libs';
$classdir = 'myftphp_classes';
$cachedir  = '/tmp/myftphp_cache';

$logfile  = 'mfp.log';

// file-tree, bool
// if directoy tree takes too many resources to read > set to zero or decrease the value of $depth
$tree = 1;
// depth of recursion in treeview > 1
// 0: infinite recursion, ATTENTION: may crash server or make script not useable anymore
// please consider recursive symbolic links as a problem
// default: 2
$treeDepth = 2;

// thumbnailing config
// maxw & maxh are pixel values
$maxw       = 65;
$maxh       = 65;
$perline    = 5;
$resizeall  = FALSE;
// caching
$caching = TRUE;
$fullmd5 = FALSE; // not used atm

// preview length in properties dialog
// in bytes/chars
$previewlen = 512;

// hashkey for session
// changing for higher security is recommended
$hashkey = 'myFtPhp';

// charset for html output and form input
$charset = 'utf-8';

//^^configuration^^





// donotchange
///////////////////////
error_reporting(E_ALL | E_STRICT);
set_error_handler('mfp_errorHandler');
#@date_default_timezone_set('Europe/Vienna');

// init debug buffer
$debug = '';
$errmsg = '';
$allok  = FALSE;

$mfp_starttime = microtime(TRUE);

function mfp_errorHandler($errLvl, $errMsg, $errFile, $errLine, $errContext) {
	static $errno = 0;
	$errno++;

	$levels = array(
		E_ERROR           => 'FATAL ERROR',
		E_WARNING         => 'WARNING',
		E_PARSE           => 'PARSE ERROR',
		E_NOTICE          => 'NOTICE',
		E_CORE_ERROR      => 'CORE ERROR',
		E_CORE_WARNING    => 'CORE WARNING',
		E_COMPILE_ERROR   => 'COMPILE ERROR',
		E_COMPILE_WARNING => 'COMPILE WARNING',
		E_USER_ERROR      => 'USER ERROR',
		E_USER_WARNING    => 'USER WARNING',
		E_USER_NOTICE     => 'USER NOTICE',
		E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR',
		E_STRICT          => 'STRICT WARNING',
		E_ALL             => 'E_ALL'
	);

	$error_reporting = error_reporting();
	#if($errLvl != E_STRICT) {
	// log all except @errors
	if($error_reporting != 0) {
		$logstr = $levels[$errLvl].': '.$errMsg. ' in '.$errFile.' on line '.$errLine;
		#$logstr .= "\n".print_r($errContext);
		mfp_log($logstr);
	}

}



// classes
// autoload function
function __autoload($class) {
	require_once($GLOBALS['classdir'].'/'.$class.'.php');
}


// dir/filelist classes
class mfp_dirs extends mfp_list {

	public function printout() {
		//print directories as table with alternating colored lines
		global $l;

		$i = 0;
		foreach($this->items as $dir) {
			$i++;
			$inclip = in_array(HOME . pathTo($dir['path']), $_SESSION['mfp_clipboard']);

			$class = ($i % 2) ? 'o' : 'e';
			$clipped = $inclip? 'clip': '';
			$url_path = urlencode($dir['path']);
			$url_name = htmlspecialchars($dir['name']);
			$date     = @date($l['fulldate'], $dir['mtime']);
		?>
		<tr class="l <?=$class?> <?=$clipped?>">
		<td></td>
		<td></td>
		<td><a href="<?=dosid(SELF.'?a=props&amp;path='.$url_path)?>" title="<?=$l['props']?>" onClick="popUp(this.href, 'propswin', 'width=400,height=500'); return false;"><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['props']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=rem&amp;dir='.$url_path)?>" title="<?=$l['removedir']?>" onClick="popUp(this.href, 'remwin'); return false;"><img src="<?=img('rem')?>" width="16" height="16" alt="<?=$l['removedir']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=ren&amp;path='.$url_path)?>" title="<?=$l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['renamedir']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=gallery&amp;dir='.$url_path)?>" title="<?=$l['viewgallery']?>"><img src="<?=img('thumbs')?>" width="16" height="16" alt="<?=$l['thumb']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=tree&amp;dir='.$url_path)?>" title="<?=$l['viewdir']?>" target="tree"><img src="<?=img('tree')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a></td>
<?##?>
		<td><a href="<?=dosid(SELF.'?a=view&amp;dir='.$url_path)?>" title="<?=$l['changedir']?>" class="rnd"><?=$url_name?></a></td>
		<td></td>
		<td></td>
		<td><a href="<?=dosid(SELF.'?a=mod&amp;path='.$url_path)?>" title="<?=$l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><?printf('%o', $dir['perm'])?><img src="<?=img('perms')?>" width="16" height="16" alt=""></a></td>
		<td><?=$date?></td></tr>

<?
		}
	}
}

class mfp_files extends mfp_list {
	private $size = 0;

	public function printout() {
		//print files and alternate lines
		global $l;

		$i = 0;
		foreach($this->items as $file) {
			$i++;
			$inclip = in_array(HOME . pathTo($file['path']), $_SESSION['mfp_clipboard']);

			$size = getfsize($file['size'], TRUE);
			$sizedesc = $size[1];
			$size     = $size[0];

			$class = ($i % 2) ? 'o' : 'e';
			$clipped = $inclip? 'clip': '';
			$url_path   = urlencode($file['path']);
			$directlink = htmlspecialchars(directLink($file['path']));
			$url_name   = htmlspecialchars($file['name']);
			$date       = @date($l['fulldate'], $file['mtime']);
		?>
		<tr class="l <?=$class?> <?=$clipped?>">
		<td><input type="checkbox" name="chks[]" id="chk<?=$i?>" value="<?=htmlspecialchars($file['name'])?>"></td>
		<td><a href="<?=dosid(SELF.'?a=down&amp;file='.$url_path)?>" title="<?=$l['download']?>"><img src="<?=img('download')?>" width="16" height="16" alt="<?=$l['download']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=props&amp;path='.$url_path)?>" title="<?=$l['props']?>" onClick="popUp(this.href, 'propswin', 'width=400,height=500'); return false;"><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['props']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=del&amp;file='.$url_path)?>" title="<?=$l['deletefile']?>" onClick="popUp(this.href, 'delwin'); return false;"><img src="<?=img('del')?>" width="16" height="16" alt="<?=$l['delete']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=ren&amp;path='.$url_path)?>" title="<?=$l['renamefile']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=edit&amp;file='.$url_path)?>" title="<?=$l['editcode']?>" onClick="popUp(this.href, 'editwin', 'width=640,height=480'); return false;"><img src="<?=img('edit')?>" width="16" height="16" alt="<?=$l['edit']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=src&amp;file='.$url_path)?>" title="<?=$l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['src']?>"></a></td>
		<td><a href="<?=$directlink?>" title="<?=$l['viewfile']?>" target="_blank" class="rnd"><?=$url_name?></a></td>
		<td><?=$size?></td>
		<td><?=$sizedesc?></td>
		<td><a href="<?=dosid(SELF.'?a=mod&amp;path='.$url_path)?>" title="<?=$l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><?printf('%o', $file['perm'])?><img src="<?=img('perms')?>" width="16" height="16" alt=""></a></td>
		<td><?=$date?></td>
		</tr>
		<?}
	}

	public function size() { return $this->size; }
}

// activate buffering
#header('X-ob_mode: 1');
// 2buffers: compression buffer + content buffer
if(function_exists('ob_gzhandler')) {
	// probs with url rewriter and ob_gzhandler...
	#@ini_set('url_rewriter.tags', '');
	ob_start('ob_gzhandler');
	#ob_start();
} else { ob_start(); }
ob_start();

// sessions class sucked
session_name('myftphp');
session_start();
$user = &$_SESSION['mfp_user'];
$on = isset($_SESSION['mfp_hash']) && $_SESSION['mfp_hash'] == md5($user. $hashkey .$_SESSION['mfp_pass']);

// CONSTANTS
// dir delimiter, only because of win servers
// on *nix systems the first char of an absolute path is always a slash
define('DEL', substr(realpath('.'), 0,1) == '/' ? '/' : '\\');
// gets magicquotes, scriptlink, and browser
define('MQUOTES', get_magic_quotes_gpc()); #!!!
define('SELF', $_SERVER['PHP_SELF']);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('URI', $_SERVER['REQUEST_URI']);
define('AGENT', $_SERVER['HTTP_USER_AGENT']);
// check or internet explorer
define('IE', stripos(AGENT, 'MSIE'));
//check for windows
define('WIN', stripos(AGENT, 'win'));

// filesize constants
define('K', 1024);
define('M', K*1024);
define('G', M*1024);
define('T', G*1024);
define('P', T*1024);
define('E', P*1024);

// create HUGE array merged of GET and POST ////////////////////////////////////
// works as access API, variables should always be accessed via this array
$MFP = array_merge($_GET, $_POST);
// unescape if magic_quotes_gpc is set
if(MQUOTES)
  array_walk_recursive($MFP, create_function('&$item, $key', '$item = stripslashes($item);'));
#mfp_log(print_r($MFP, true));

// language initiation
$l = array();
$l['login']           = 'login';
$l['err']['badlang']  = 'Language (%s) does not exist!';
$l['err']['badtheme'] = 'Theme (%s) does not exist!';
$l['err']['baduser']  = 'User (%s) does not exist!';
$l['err']['home']     = 'Home-Directory "%s" does not exist!';

// quickhack ** testing / don't include sessions !!!
if(isset($_SESSION['mfp_lang'])) $accounts[$user]['lang'] = $_SESSION['mfp_lang'];

$lang = isset($accounts[$user]['lang']) ? $accounts[$user]['lang'] : 'english';
@include('./' . $langdir . '/english.ini.php');
if(!@include('./' . $langdir . '/' . $lang . '.ini.php')) {
	die(sprintf($l['err']['badlang'], $lang));
}

//colors #RGB, #RRGGBB, rgb(rrr,ggg,bbb), color name
$c = array();
$c['txt']        = '#111';
$c['bg']['main'] = '#EFF';

// quickhack ** testing / don't include sessions !!!
if(isset($_SESSION['mfp_theme'])) $accounts[$user]['theme'] = $_SESSION['mfp_theme'];

$theme = isset($accounts[$user]['theme']) ? $accounts[$user]['theme'] : 'light';
if(!@include('./' . $themedir . '/' . $theme . '.ini.php')) {
	die(sprintf($l['err']['badtheme'], $theme));
}


// some helper functions, alphabetical order

// checks for subdir
function allowed($path) {
	#echo '<br>path: ', realpath($path);
	#echo '<br>home: ', REALHOME;
	return strpos(realpath($path), REALHOME) === 0;
}

// returns either post or get
function API($var) {
	if(isset($_POST[$var])) return $_POST[$var];
	elseif(isset($_GET[$var])) return $_GET[$var];
	return NULL;
}

// backslash to slash conversion
function b2slash($bstr) {
	return str_replace(DEL, '/', $bstr);
}

// creates full url ( http://www.domainname.tld/path/to/file )
function directlink($path) {
	// thx to vizzy
	$path = b2slash(pathTo($path, ROOT));
	return 'http://' . $_SERVER['HTTP_HOST'] . $path;
}

// adds session id
function dosid($uri, $amp = '&amp;') {
	$sid = SID;
	if(!empty($sid) && !preg_match('#'.session_name().'=#', $uri))
		$uri .= (strpos($uri, '?') !== FALSE ? $amp : '?'). $sid;
	return $uri;
}

// returns css class file|dir|link
function getCssClass($path) {
	if(is_link($path)) return 'link';
	if(is_file($path)) return 'file';
	if(is_dir($path))  return 'dir';
	return 'error';
}

// formats filesize to a readable number
function getfsize($size, $array = FALSE) {
	$byte = &$GLOBALS['l']['byte'];

	$factor = 1;
	$sizedesc = '';

	//convert to kilo, mega, giga, tera, peta und exa ;)
	if($size > K) {
		$factor = K;
		$sizedesc = $byte['k'];  }
	if($size > M) {
		$factor = M;
		$sizedesc = $byte['m'];  }
	if($size > G) {
		$factor = G;
		$sizedesc = $byte['g'];  }
	if($size > T) {
		$factor = T;
		$sizedesc = $byte['t'];  }
	if($size > P) {
		$factor = P;
		$sizedesc = $byte['p'];  }
	if($size > E) {
		$factor = E;
		$sizedesc = $byte['e'];  }

	$size /= $factor;

	if($array) {
		return array(sprintf('%02.2f', $size), $sizedesc . $byte['b']);
	}
	// float number with a precision of two
	return sprintf('%02.2f', $size) .'&nbsp;'. $sizedesc . $byte['b'];
}

// returns full way to dir
function getTrack($to, $from = HOME) {
	$pathToDir = pathTo($to, $from);
	$tmpTo = $pathToDir;
	$toDirArray = array();

	// filling array in reversed order
	while($tmpTo = substr($tmpTo, 0, strrpos($tmpTo, DEL))) {
		array_unshift($toDirArray, $tmpTo);
	}

	return $toDirArray;
}

// inserts image links
function img($img) {
	return $GLOBALS['imgdir'] .'/'. $GLOBALS['imglist'][$img];
}

// returns ip as hex
function ip2hex($ip) {
	return vsprintf('%02x%02x%02x%02x', explode('.', $ip));
}

// error_log() wrapper
function mfp_log($message, $file = '', $type = 3, $extra_headers = '') {
	static $lastlogged = '';

	$file = $file ? $file : $GLOBALS['logfile'];

	// "group" error logs on a per file and run basis
	if($lastlogged != __FILE__) {
		// heading format: ":timestamp:uri:IP"
		$heading = ':'.time().':'.URI.':'.ip2hex($_SERVER['REMOTE_ADDR'])."\n";
		error_log($heading, $type, $file, $extra_headers);

		$lastlogged = __FILE__;
	}

	$message = "\t$message\n";
	error_log($message, $type, $file, $extra_headers);
}

// shows relative path from $home
function pathTo($path, $home = HOME) {
	// needs benchmarking - and security tests
	#return str_replace(realpath($home), '', realpath($path));
	$realpath = @realpath($path);
	if(strpos($realpath, realpath($home)) === 0)
		return substr($realpath, strlen(realpath($home)));
	return FALSE;
}

// translates octal permission bits to string representation
function perm2str($mode) {
	// special bits
	if($mode > 0700) { // only if they are present
		if(($mode & 0140000) == 0140000) $str = 's';     // socket
		elseif(($mode & 0120000) == 0120000) $str = 'l'; // link
		elseif(($mode & 0100000) == 0100000) $str = '-'; // regular
		elseif(($mode & 060000) == 060000) $str = 'b';   // block
		elseif(($mode & 040000) == 040000) $str = 'd';   // dir
		elseif(($mode & 020000) == 020000) $str = 'c';   // char
		elseif(($mode & 010000) == 010000) $str = 'p';   // pipe
		else $str = 'u';
	} else $str = '';

	// owner
	$str .= (($mode & 0400) ? 'r' : '-');
	$str .= (($mode & 0200) ? 'w' : '-');
	$str .= (($mode & 0100) ?
						(($mode & 04000) ? 's' : 'x' ) :
						(($mode & 04000) ? 'S' : '-'));

	// group
	$str .= (($mode & 0040) ? 'r' : '-');
	$str .= (($mode & 0020) ? 'w' : '-');
	$str .= (($mode & 0010) ?
						(($mode & 02000) ? 's' : 'x' ) :
						(($mode & 02000) ? 'S' : '-'));

	// others
	$str .= (($mode & 0004) ? 'r' : '-');
	$str .= (($mode & 0002) ? 'w' : '-');
	$str .= (($mode & 0001) ?
							(($mode & 01000) ? 't' : 'x' ) :
							(($mode & 01000) ? 'T' : '-'));

	return $str;
}

// wraps long strings
function wrap($str, $at = 30, $del = '-<br>') {
	// remove extra split at end
	#return substr(chunk_split($str, $at, $del), 0,-strlen($del));
	return wordwrap($str, $at, $del, TRUE);
}

// emu-functions for non-posix systems
function _posix_getpwuid($uid) {
	return function_exists('posix_getpwuid') ? posix_getpwuid($uid) : $uid;
}
function _posix_getgrgid($gid) {
	return function_exists('posix_getgrgid') ? posix_getgrgid($gid) : $gid;
}




// action -> todo?
$a = &$MFP['a'];

// cases available without login
// (bout,css,logout)
switch($a) {
	//__logout__
	case 'logout':
		#unset($_SESSION['mfp_on']); #unset($_SESSION['mfp_hash']);
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		header('Location: '. dosid(SELF, '&'));
		exit();
	break;
	//^^logout^^

	//__bout__
	case 'bout':
		$title = $l['title']['bout'];
		?>
		<style type="text/css">
		<!--
			body { background-repeat:repeat; }
		-->
		</style>
		<div id="fix">
		<center><a href="http://myftphp.sf.net" target="_blank">myFtPhp</a>, 2007 </center>
		</div>

		<div id="scroll" class="about">

		Code and idea: Knittl<br>
		<a href="http://sourceforge.net/projects/myftphp">&lt; sourceforge.net/projects/myftphp &gt;</a><br>
		<a href="mailto:knittl89@yahoo.de">&gt; knittl89@yahoo.de &lt;</a>

		<hr>
		<a href="http://www.famfamfam.com/lab/icons/silk/">Silk icon set 1.3</a> by	<u>Mark James</u>
		<br>
		His work is licensed under a
		<a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a><br>
		<hr>

		Thanks further goes to:
		<ul class="credits">
			<li><a href="http://tellmatic.de" target="_blank">Vizzy</a>, for his support, testing and critics</li>
			<li><a href="http://edysoft.de/" target="_blank">Edy</a>, for help and motivation</li>
			<li><u>Horny</u>, for his mental support and for hunting bugs</li>
			<li><u>Squirrel</u>, for testing and using myFtPhp</li>
			<li><u>Alberto Torres</u>, for some nice ideas</li>
			<li><u>Eliasp</u>, for pointing out <a href="http://chrispederick.com/work/webdeveloper/" target="_blank">Web Developer Tool</a></li>
		</ul>
		</div>
	<?break;
	//^^bout^^

	//__css__
	case 'css':
	//set filetype to css
	header('Content-Type: text/css');
	?>
	* { margin:0; padding:0; }
	body {
		<?#http://css-discuss.incutio.com/?page=UsingEms?>
		font-size:95%;
		/*font-size:75%;
		font-family:Verdana;*/

		color:<?=$c['txt']?>;
		background-color:<?=$c['bg']['main']?>;
		background-image:url(<?=img('water')?>);
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:bottom right;

		margin:<?=IE? '0': '6'?>px;

		<?if(IE) { // only works in ie?>
			scrollbar-face-color:<?=$c['scrollbars']['face']?>;
			scrollbar-highlight-color:<?=$c['scrollbars']['highlight']?>;
			scrollbar-shadow-color:<?=$c['scrollbars']['shadow']?>;
			scrollbar-3dlight-color:<?=$c['scrollbars']['3dlight']?>;
			scrollbar-arrow-color:<?=$c['scrollbars']['arrow']?>;
			scrollbar-track-color:<?=$c['scrollbars']['track']?>;
			scrollbar-darkshadow-color:<?=$c['scrollbars']['darkshadow']?>;
		<?}?>
	}
	iframe { border:none; margin:0px; }

 /* form styling */
	form { padding:0; margin:0; }
	input, textarea, button {
		background-color:<?=$c['bg']['input']?>;
		background-position:left center;
		border:1px solid;
		border-color:<?=$c['border']['light']?> <?=$c['border']['dark']?> <?=$c['border']['dark']?> <?=$c['border']['light']?>;
		color:<?=$c['txt']?>;
		padding:0.3em;
		-moz-border-radius:4px;
		vertical-align:middle;
	}
	* html input, button { display:inline; } /* IE */
	textarea {
		background-color:<?=$c['bg']['inputlite']?>;
		background-image:url(<?=img('txtarea')?>);
		background-repeat:repeat-y;
		padding-left:18px;
		font-family:monospace; -moz-border-radius:1em 0 0 1em; }
	textarea.full { padding-left:18px; height:85%; margin-top:5px; }
	input { padding:0px; text-indent:2px; }
	button { padding:0px; -moz-border-radius:0.3em; background-color:transparent; cursor:pointer; }

	label { padding:0px 0.5ex; -moz-border-radius:0.5em; cursor:pointer; }
	label:hover { background-color:<?=$c['bg']['inputhover']?>; }

	select, option {
		color:<?=$c['txt']?>;
		background-repeat: no-repeat;
	}
	select {
		border:1px solid <?=$c['border']['dark']?>;
		background-color:<?=$c['bg']['input']?>;
		background-image:url(<?=img('desc')?>);
		padding-left:12px;
		/*-moz-border-radius:4px;*/
	}
	select:hover { background-color:<?=$c['bg']['inputhover']?>; }
	select:focus { background-color:<?=$c['bg']['inputlite']?>; }
	option {
		background-color:<?=$c['bg']['inputlite']?>;
		background-image:url(<?=img('bullet')?>);
		padding-left:16px;
	}
	option:hover { /*text-indent:5px;*/ text-decoration:underline; color:<?=$c['a']['hover']?>; background-color:<?=$c['bg']['inputhover']?>; }

	input[type=text], input[type=password] {
		background-image:url(<?=img('kbd')?>);
		background-repeat:no-repeat;
		border:1px solid <?=$c['border']['lite']?>;
		border-bottom:1px solid <?=$c['border']['dark']?>;
		<?#personal flavour?>
		text-indent:5px;
		-moz-border-radius:0.6em 0.6em 0 0;
	}
	input[type=password] { background-image:url(<?=img('pwd')?>); border-color:<?=$c['border']['dark']?>; -moz-border-radius:0.5em; }

	input:hover { background-color:<?=$c['bg']['inputhover']?>; text-decoration:underline; }
	input[type=text]:focus, input[type=password]:focus {
		background-image:url();
		background-color:<?=$c['bg']['inputlite']?>;
		text-decoration:none;
	}

	input[type=submit] {
		font-weight:bold;
		background-image:url(<?=img('ok')?>);
		background-repeat:no-repeat;
		background-position:left center;
		/*text-indent:16px;*/
		padding-left:16px;
	}
	<?=!IE ? 'input#quicktext { width:24px; background-position:center; }
	input#quicktext:focus { width:25em; }' : ''?>

 /* anchors, links */
	a { color:<?=$c['a']['link']?>; text-decoration:none; font-weight:<?=(!WIN)? 'bold': 'normal'?>; font-size:<?=(!WIN)? '13px': '11px'?>; font-family:<?=(WIN)? 'system': 'Courier New,monospace'?>; }
	a:hover { color:<?=$c['a']['hover']?>; background-color:<?=$c['a']['bghover']?>; text-decoration:underline; }
	a.rnd { padding:0px 0.5em; }
	a.rnd:hover { -moz-border-radius:0.5em; }
	a.lrnd:hover { -moz-border-radius:0.5em 0 0 0.5em; }

	a img { border:1px solid <?=IE ? $c['bg']['main'] : 'transparent'; ?>;
	opacity:1; } /* opacity other than 1 breaks FF3, check back when released !!! */
	a:hover img {
		border:1px solid <?=$c['border']['img']['shade']?>;
		border-top-color:<?=$c['border']['img']['light']?>;
		border-left-color:<?=$c['border']['img']['light']?>;
		opacity:1;
	}

	a .out { display:inline; }
	a:hover .out { display:none; }
	a .over { display:none; }
	a:hover .over { display:inline; }


	/*a img { border:none; opacity:0.6; }
	a:hover img {	opacity:1; }*/

 /* headerdiv */
	#fix {
		position:fixed;
		top:0px; left:0px;
		display:block;
		width:100%;
		margin:0px;
		/*margin-right:-1.1em; /* 2x padding + border*/
		margin-right:auto;

		color:<?=$c['fixtxt']?>;
		background-color:<?=$c['bg']['fix']?>;
		border:1px solid <?=$c['border']['fix']?>;
		border-top:none;
		-moz-border-radius:0 0 4em 2em;

		padding:1px 0.5em;
		overflow:hidden;
		/* -moz-opacity:0.9; isn't needed */
		<?= IE ? 'filter:alpha(opacity=90);' : null?> opacity:0.9;
	}
	#scroll { clear:both; }
	<?if(!IE) echo '#fix + #scroll { margin-top:2.5em; }'?>

 /* tables */
	table { border:none; border-collapse:collapse; border-spacing:0px; padding:0; }
	tr { vertical-align:middle; }
	tr.vtop { vertical-align:top; }
	tr.toprnd td { -moz-border-radius:1em 1em 0 0; }
	td, th { padding:0px 2px; text-align:left; }
	tr.c td, tr.c th { text-align:center; }

	/* hovered table rows */
	table tr.e:hover td,
	table tr.o:hover td,
	table tr.hover td /* for later IE js */ {
		background-color:<?=$c['bg']['tablehover']?>;
	}

	tr.o td, tr.o th { background-color:<?=$c['o']?>; }
	tr.clip td a { font-style:italic; }

	tbody, thead, tfoot { border-color:<?=$c['border']['ruler']?>; }
	tbody { margin-bottom:1em; }

	tr.l { white-space:nowrap; }
	tr.l a { display:block; white-space:pre; }

	.marked { background-color:<?=$c['o']?>; }

 /* gallery floating tiles, mostly lists */
	.gallery .dirlist, .gallery .filelist { text-align:left; clear:both; }
	.gallery ul.dirlist, .gallery ul.filelist { list-style-image:url(); }

	.tile {
		float:left; /*display:inline;*/
		padding:5px; margin:5px;
		border:1px solid <?=$c['border']['img']['light']?>;
		background-color:<?=$c['bg']['fix']?>;
	}

	.tile a { font-weight:normal; text-decoration:none; }
	.tile a img { margin-right:1ex; vertical-align:middle; }
	.gallery .filelist .tile * { float:left; }

	 /* gallery lists */
		.breadcrumbs {  } /* separate for gallery??? */
		ul.dirlist, ul.filelist { list-style-type:none; }

 /* selection, rulers */
	::-moz-selection { color:<?=$c['a']['hover']?>; background:<?=$c['bg']['inputhover']?>; }
	/* needs checking for safari or others
	::selection { color:<?=$c['a']['hover']?>; background:<?=$c['bg']['inputhover']?>; }*/

 /* BOXES, fake windows */
	.box {
		min-width:150px;
		max-width:400px;
		/*-moz-border-radius:0 0 6px 6px;*/

		margin:0px auto 1em;
		padding:0px 10px 5px;

		border:1px solid <?=$c['border']['ruler']?>;
		text-align:left;
	}

	div.box { -moz-border-radius:0 0 6px 6px; }
	.box h1 img, .box h2 img, .box h3 img,
	.box h4 img, .box h5 img, .box h6 img { vertical-align:text-bottom; }

	fieldset.box { padding:10px 0px; }
	fieldset.box legend { padding:0px 10px; margin:0 20px; text-decoration:underline; }

	/* all headings get the same style */
	.box h1, .box h2, 
	.box h3, .box h4, 
	.box h5, .box h6 {
		cursor:default;
		display:block;
		margin:0px -10px 1em; /* -10 to compensate padding of box */
		padding:1px 5px;

		text-indent:3px;
		font-size:1em;
		font-weight:bold;

		color:<?=$c['fixtxt']?>;
		background-color:<?=$c['bg']['fix']?>;
		border-bottom:1px solid <?=$c['border']['fix']?>;
	}
	/* now w/o .container class thanks to negative margins */
	.box .footer {
		margin:1ex -10px -5px; /* compensate padding */
		padding:2px 3px 3px;

		display:block;
		text-align:right;

		border-top:1px solid <?=$c['border']['fix']?>;
	}

	.box a { display:inline !important; }

	.full { height:100%; min-width:100%; max-width:100%; margin:-2px 0px -1px; padding:0; }
	/* reset/clear h-margins */
	.full h1, .full h2, .full h3, 
	.full h4, .full h5, .full h6 { margin-left:0; margin-right:0; }
	.full .footer { margin-left:0; margin-right:0; }

	.login { width:182px; margin:2em auto; padding-bottom:10px; }
	html > body .login { width:162px; }
	/* .login div { margin-left:auto; margin-right:auto; } */
	.login input { width:140px; }

	.center { margin-left:auto; margin-right:auto; } /* width needs to be set */

 /* lists */
	ul {
		list-style-position:outside;
		list-style-type:square;
		list-style-image:url(<?=img('bullet')?>); /* ??? not sure yet */
		text-align:left;
		margin-left:24px;
	} /* !!! have a look at -position:inside */

	dl { margin-bottom:1ex; }
	dt { clear:left; float:left; margin-right:1ex; overflow:hidden; }
	dl.aligned dt { width:40%; }
	dl.login dt { margin-right:0ex; }
	dd { vertical-align:top; }
	/* html>body dd { float:left; } /* -moz-only :) */

	 /* special lists */
		.breadcrumbs {  }
		.breadcrumbs img { vertical-align:text-bottom; }
		.breadcrumbs li { display:inline; }

	 /* tree */
		ul.tree { overflow:hidden; }
		ul.tree { padding-top:4px; padding-left:24px; }
		/* ul.tree > li { margin-top:2px; margin-left:24px; } /* need a hack for NS !!! */
		ul.tree ul { padding-left:0; margin-left:12px; } /* nested lists indentation: IE only works with margin as recursive indentation */
		
		/* saves lots of markup: only IE borks with hover :-$ */
		ul.tree li { white-space:nowrap; list-style-image:url(<?=img('dir')?>); }
		ul.tree li a { white-space:pre; }
		ul.tree li.home { list-style-image:url(<?=img('home')?>); }
		ul.tree li:hover { list-style-image:url(<?=img('explore')?>); }

		ul.tree a { display:block; }
		ul.tree a:hover { background-color:<?=$c['bg']['tablehover']?>; }

		/* first item of nested lists, 2nd level up */
		li li:first-child { border-top:1px dotted <?=$c['border']['ruler']?>; } /* check thoroughly in more browsers!!! */
		/* IE hacks. IT SUCKS */
		* html ul.tree li a { display:inline; padding-left:1ex; }

	 /* file/dir list items */
		li.dir   { list-style-image:url(<?=img('dir')?>); }
		li.file  { list-style-image:url(<?=img('file')?>); }
		li.link  { list-style-image:url(<?=img('link')?>); }
		li.error { list-style-image:url(<?=img('error')?>); }

/* other stuff */
	 /* nice helper classes :) */
		.b { font-weight:bold; }
		.i { font-style:italic; }

	* html p { padding:4px; } /*IE*/
	img { vertical-align:middle; border:0px none; }
	hr {
		color:<?=$c['border']['ruler']?>;
		background-color:<?=$c['bg']['fix']?>;
		width:80%; height:1px;
		border-top:1px solid <?=$c['border']['ruler']?>;
		text-align:center;
		margin:1ex auto 1em;
	}
	.enum { padding-left:5px; }
	.enum code em {
		background-color:<?=$c['bg']['inputhover']?>;
		font-weight:bold;
		font-style:normal;
	}
	code { display:block; }
	var a { padding-right:0.6ex; padding-left:0.1ex; }

	/* display of paths */
	/* and user input */
	var.dir, var.file, var.link, kbd { padding-left:18px; background-repeat:no-repeat; }
	var.dir  { background-image:url(<?=img('dir')?>); }
	var.file { background-image:url(<?=img('file')?>); }
	var.link { background-image:url(<?=img('link')?>); }
	kbd { background-image:url(<?=img('kbd')?>); }

	.about { background-color:<?=$c['bg']['main']?>; -moz-border-radius:2.5em; padding:1em; <?if(IE) echo 'filter:alpha(opacity=80)'?> opacity:0.8; }
	
	<?
	// omit further output
	return;
	break;
	//^^css^^

	//__default__
	default:


// only auth users
//logged in or empty user array
if(($on && isset($accounts[$user])) || (empty($accounts) && isset($accounts))) {

	// home: at least read permissions are needed
	$home = &$accounts[$user]['home'];

	// is home existing?
	if(is_dir($home) && define('HOME', $home)) {
		define('REALHOME', realpath(HOME));
		define('RELHOME', pathTo(HOME, ROOT));
	} else {
		unset($_SESSION['mfp_user']);
		die(sprintf($l['err']['home'], '<var class="dir">'.$home.'</var>'));
		#die('Bad home');
	}


//what to do?
switch($a) {
//a(ction) = [clip,del,down,edit,find,gallery,info,mod,new,rem,ren,props,src,thumb,tree,up,user,view,'default']


//__clip__
case 'clip':
	$dir = &$MFP['dir'];
	$clipboard = &$_SESSION['mfp_clipboard'];

	if(isset($MFP['copy']) || isset($MFP['move'])) { ?>
	<script type="text/javascript" language="JavaScript">
	<!--
			opener.location.reload();
	//-->
	</script>
	<? }

	// #copy, move, list, free
	if(isset($MFP['copy'])) {

		if(count($clipboard)) {
			if(allowed($dir)) {
				if(is_dir($dir)) {
					foreach($clipboard as $entry) {
						$oldpath = HOME . pathTo($entry);
						$newpath = $dir.'/'.basename($oldpath);
						if(!file_exists($newpath)) {
							if(copy($oldpath, $newpath)) {
								echo '<br>succesfully copied: ', $oldpath;
								unset($clipboard[array_search($oldpath, $clipboard)]);
							} else {
								echo '<br>error copying';
							}
						} else { printf($l['err']['fileexists'], '<var class="file">'.wrap(htmlspecialchars($newpath)).'</var>', getfsize(filesize($newpath))); }
					}
				} else { printf($l['err']['baddir'], '<var class="dir">'.wrap(htmlspecialchars($dir)).'</var>'); }
			} else { printf($l['err']['forbidden'], '<var class="dir">'.wrap(htmlspecialchars($dir)).'</var>'); }
		} else { echo 'no files in clipboard'; }

	} elseif(isset($MFP['move'])) {

		// security issues, no allowed() check !!!
		if(count($clipboard)) {
			if(allowed($dir)) {
				if(is_dir($dir)) {
					foreach($clipboard as $entry) {
						$oldpath = HOME . pathTo($entry);
						$newpath = $dir.'/'.basename($oldpath);
						if(!file_exists($newpath)) {
							if(rename($oldpath, $newpath)) {
								echo '<br>succesfully moved: ', $oldpath;
								unset($clipboard[array_search($oldpath, $clipboard)]);
							} else {
								echo '<br>error moving';
							}
						} else { printf($l['err']['fileexists'], '<var class="file">'.wrap(htmlspecialchars($newpath)).'</var>', getfsize(filesize($newpath))); }
					}
				} else { printf($l['err']['baddir'], '<var class="dir">'.wrap(htmlspecialchars($dir)).'</var>'); }
			} else { printf($l['err']['forbidden'], '<var class="dir">'.wrap(htmlspecialchars($dir)).'</var>'); }
		} else { echo 'no files in clipboard'; }

	} elseif(isset($MFP['free'])) {
		$clipboard = array();
		header('Location: '. dosid(SELF.'?a=clip&list', '&'));
	} elseif(isset($MFP['list'])) { ?>

		<form name="form" method="post" action="<?=dosid(SELF.'?a=multi&amp;dir='.urlencode(HOME))?>" accept-charset="<?=$charset?>">
		<div class="box">
		<h3><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']?>"> clipboard</h3>
		<?
			if(count($clipboard)) {
				$i = 0;
				?>

				<table>
				<thead>
				<tr>
				<th><input type="checkbox" name="toggle_top" onClick="toggleAll(this, 'chks');"></th>
				<th><?=$l['file']?></th>
				<th><?=$l['dir']?></th>
				</tr>
				</thead>
				<tbody>
				<?
				foreach($clipboard as $entry) {
					$i++;
					
					$class = ($i % 2) ? 'o' : 'e';
					$path = htmlspecialchars(pathTo($entry));
					$directlink = htmlspecialchars(directLink($entry));
					$basename = basename($entry);
					$dir = pathTo(dirname($entry)).'/';
					?>
					<tr class="l <?=$class?>">
						<td><input type="checkbox" name="chks[]" id="chk<?=$i?>" value="<?=$path?>"></td>
						<td><a href="<?=$directlink?>" title="<?=$l['viewfile']?>" target="_blank" class="rnd"><?=$basename?></a></td>
						<td><?=$dir?></td>
					</tr>
				<?
				}
				echo '</tbody></table>';
			} else {
				echo $l['err']['nofiles'];
			}
		?>
		<div class="footer">
			<button type="submit" name="sub"><img src="<?=img('clipsub')?>" alt="<?#=$l['clipsub']?>"></button>
			<a href="<?=dosid(SELF.'?a=clip&amp;free')?>" title="free clipboard">free clipboard</a>
		</div>
		</div>
		</form>

	<? } else {

	}

break;
//^^clip^^

//__del__
case 'del':
//delete file
$title = $l['title']['del'];
?>

<div class="box">
<h3><img src="<?=img('del')?>" width="16" height="16" alt="<?=$l['delete']?>"> <?=$title?></h3>
<?
if(isset($MFP['delete'])) {
	echo '<ul>';
	$dir = &$MFP['dir'];
	$paths = unserialize(base64_decode($MFP['paths']));

	foreach($paths as $file) {
		$directlink = htmlspecialchars(directLink($file));
		$wrappedpath = wrap(htmlspecialchars($file));

		echo '<li class="file">';
		try {
			$path = new mfp_file($dir.'/'.$file);

			if(!$path->unlink()) throw new Exception(sprintf($l['err']['deletefile'], '<var><a href="'.$directlink.'" target="_blank">'.$wrappedpath.'</a></var>'));

			printf($l['ok']['deletefile'], '<var>'.$wrappedpath.'</var>');
		} catch(Exception $e) {
			echo $e->getMessage();
		}
		echo "</li>\n";
	}

?>
	</ul>
	<form name="mfp_form" action="javascript:window.close()" class="footer">
	<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
	<script type="text/javascript" language="JavaScript">
	<!--
			opener.location.reload();

			document.mfp_form.closebut.focus();
	//-->
	</script>
	</form>

<?
} else {
	$directlink = htmlspecialchars(directLink($MFP['file']));
	$wrappedpath = wrap(htmlspecialchars(pathTo($MFP['file'])));
?>
<center>
	<?printf($l['warn']['reallydel'],
				'<var class="file"><a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a></var>')?><br>

<form method="post" action="<?=dosid(SELF.'?a=del&amp;dir=.')?>" class="footer">
	<input type="hidden" name="paths" value='<?=base64_encode(serialize(array($MFP['file'])))?>'>
	<input type="submit" name="delete" value="  <?=$l['delete']?>  ">&nbsp;
	<input type="button" name="cancel" value="  <?=$l['cancel']?>  " onClick="window.close()">
</form>
</center>
<? } ?>
</div>

<?
break;
//^^del^^


//__down__
case 'down':
//download
$title = $l['title']['down'];

$file = &$MFP['file'];

try {
	//filename passed?
	if(!isset($file)) throw new Exception($l['err']['nofile']);
	if(!file_exists($file)) throw new Exception(sprintf($l['err']['badfile'], '<var class="file">'.htmlspecialchars($file).'</var>'));

	$file = new mfp_file($file);
	// clean output buffer
	ob_end_clean();

	// from linux mag special edition :)
	header('Content-type: application/octet_stream');

	// set filename for download
	header('Content-length: ' . $file->filesize());
	header('Content-Disposition: attachment; filename="' . $file->basename() . '"');
	// read and print file content
	print $file->file_get_contents();

	exit();
} catch (Exception $e) {
	echo $e->getMessage();
}
break;
//^^down^^


//__edit__
case 'edit':
$title = $l['title']['edit'];
	try {
		$file = new mfp_file($MFP['file']);
//fixed line
		$directlink = htmlspecialchars(directLink($file));
		$basename   = wrap(htmlspecialchars($file->basename()));
		$filesize   = getfsize(filesize($file));
?>
	<form method="post" action="<?=dosid(SELF.'?a=edit&amp;file='.urlencode($file))?>" name="form" onSubmit="return confirm('<?(addslashes(printf($l['warn']['reallysave'], addslashes(htmlspecialchars($file)))))?>'); return false;" accept-charset="<?=$charset?>">
	<div id="fix">
		<input type="submit" name="save" value="<?=$l['save']?>">&nbsp;
		<input type="reset" name="reset" value="<?=$l['reset']?>">&nbsp;
		<input type="button" name="reload" value="<?=$l['reload']?>" onClick="window.location.reload()">&nbsp;
		<input type="button" name="cancel" value="<?=$l['close']?>" onClick="window.close()">&nbsp;
		<var class="file"><a href="<?=$directlink?>" target="_blank"><?=$basename?></a>
		(<?=$filesize?>)</var>
	</div>

<?	try { ?>
	<div id="scroll">
<?		if(isset($MFP['save'])) {

				$wrappedpath = wrap(htmlspecialchars(pathTo($file)));

				if(($bytes = $file->file_put_contents($MFP['source'])) === FALSE) throw new Exception(sprintf($l['err']['writefile'], '<var class="file">'.$wrappedpath.'</var>'));

				$filesize = getfsize($bytes);
				printf($l['ok']['writefile'], '<var class="file">'.$wrappedpath.'</var>', $filesize);
				?>
				<script type="text/javascript" language="JavaScript">
				<!--
					opener.location.reload();
				//-->
				</script>
				<?
				echo '<br>';
			}# else {
				if(($source = $file->file_get_contents()) === FALSE) throw new Exception(sprintf($l['err']['readfile'], '<var class="file">'.$wrappedpath.'</var>'));
			?>

		<textarea name="source" class="full" cols="10" rows="20" wrap="off"><?=htmlspecialchars($source);?></textarea>
<?	} catch (Exception $e) {
			echo $e->getMessage();
		}
?>
	</div>
	</form>

<? #}
	} catch (Exception $e) {
		echo $e->getMessage();
	}
break;
//^^edit^^

//__find__
case 'find':
$title = $l['title']['find'];
	// find files recursive
	$dir   = &$MFP['dir'];
	$term  = &$MFP['term'];
	$realdir = pathTo($dir);

		$adv = isset($MFP['adv'])? $MFP['adv']: array();
		$case  = in_array('case', $adv);
		$exact = in_array('exact', $adv);
		$rec   = in_array('rec', $adv);
		$dirs  = in_array('dirs', $adv);

	if(isset($MFP['find'])) {
		//save checkboxes to session
		//to remember status for current session
		$_SESSION['mfp_find'] = array(
			'case'  => $case,
			'exact' => $exact,
			'rec'   => $rec
		);
	}

	$url_dir = urlencode($dir);

	if(!allowed($dir)) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.htmlspecialchars($dir).'</var>'));
	?>
<div id="fix">
<form method="post" name="quickform" action="<?=dosid(SELF.'?a=find&amp;dir='.$url_dir)?>" accept-charset="<?=$charset?>">
	<input type="hidden" name="dir" value="<?=htmlspecialchars($dir)?>">
	<div>
		<a href="<?=dosid(SELF.'?a=view&amp;dir='.$url_dir);?>" title="<?=$l['viewdir']?>"><img src="<?=img('explore')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a>
		<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.$url_dir);?>" title="<?=$l['viewgallery']?>"><img src="<?=img('thumbs')?>" width="16" height="16" alt="<?=$l['thumb']?>"></a>
		<a href="<?=dosid(htmlspecialchars(URI));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
		<?#printf($l['searchfor'], $realdir)?>
		<input type="text" name="term" value="<?=isset($term)?$term:''?>" maxlength="255" size="50" style="width:25em;">&nbsp;&nbsp;
		<input type="submit" name="find" value=" <?=$l['find']?> ">
	</div>
	<div style="margin-left:62px;">
		<label for="case"><input type="checkbox" name="adv[]" value="case" id="case" <?=$case? 'checked': ''?>> <?=$l['casesensitive']?></label>
		<label for="exact"><input type="checkbox" name="adv[]" value="exact" id="exact" <?=$exact? 'checked': ''?>> <?=$l['exactmatch']?></label>
		<label for="rec"><input type="checkbox" name="adv[]" value="rec" id="rec" <?=$rec? 'checked': ''?>> <?=$l['findsubdirs']?></label>
		<label for="dirs"><input type="checkbox" name="adv[]" value="dirs" id="dirs" <?=$dirs? 'checked': ''?>> <?=$l['onlydirs']?></label>
	</div>
</form>
</div>

<div id="scroll" style="margin-top:3.5em;">
<?
if(isset($MFP['find'])) {
try {

	if(empty($term)) throw new Exception($l['err']['emptyfield']);
	if(!isset($dir)) throw new Exception(sprintf($l['err']['baddir'], '<var class="dir">'.$dir.'</var>'));

	$realdir = wrap(htmlspecialchars(pathTo($dir)));

	$matches['dirs'] = new mfp_dirs();
	$matches['files'] = new mfp_files();

	function match($haystack, $needle) {
		global $case, $exact;

		if($exact) {
			return ($haystack === $needle);
		} else {
			if($case) {
				return (strpos($haystack, $needle) !== FALSE);
			} else {
				return (stripos($haystack, $needle) !== FALSE);
			}
		}
		return FALSE;
	}

	function recursiveFind($dir) {
		global $term, $matches;
		global $rec, $dirs;

		if(is_readable($dir)) {
			$handle = opendir($dir);
			while($file = readdir($handle)) {
				$path = $dir.'/'.$file;
				$name = pathTo($path, $GLOBALS['dir']);
				$stat = @lstat($path);

				// one can't check too much
				if(allowed($path)) {
					if(is_dir($path)) {
						if($file != '.' && $file != '..') {
							if(match($file, $term)) {
								$matches['dirs']->add(array(
									'name' => $name,
									'path' => $path,
									'mtime' => $stat[9],
									'perm' => fileperms($path)%01000
								));
							}

							//recursion
							if($rec) {
								recursiveFind($path);
							}
						}
					} else if(!$dirs) {
						if(match($file, $term)) {

							$matches['files']->add(array(
								'name' => $name,
								'path' => $path,

								'size'  => $stat[7],
								'mtime'  => $stat[9],
								'perm'  => fileperms($path)%01000
							));
						}
					}
				}
			}
			closedir($handle);
		}
		return TRUE;
	}


	//recursion
	if(!recursiveFind($dir)) throw new Exception(sprintf($l['err']['find'], '<var class="dir">'.$realdir.'</var>')); ?>
	<form name="findform" method="post" action="<?=dosid(SELF.'?a=multi&amp;dir='.urlencode($dir))?>" onSubmit="popUp(this.action, 'multiwin');" target="multiwin" accept-charset="<?=$charset?>">
	<table rules="groups">
	<? if($matches['dirs']->count() + $matches['files']->count() > 0) {?>
	<tfoot>
	<tr>
		<td><input type="checkbox" name="toggle" onclick="toggleAll(this, 'chks', 'findform');"></td>
		<td colspan="11">
		<button type="submit" name="add"><img src="<?=img('clipadd')?>" width="16" height="16" alt="<?=$l['clip']['add']?>"></button>
		<button type="submit" name="sub"><img src="<?=img('clipsub')?>" width="16" height="16" alt="<?=$l['clip']['sub']?>"></button>
		<a href="<?=dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['clip']['list']?>"><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']?>"> list</a>
	</tr>
	</tfoot>
	<? } ?>
	<tbody>
		<? //dirs
		if($matches['dirs']->count()>0) {
			$matches['dirs']->printout();
		} else {	?>
			<tr>
				<td colspan="11"><?=$l['err']['nodirs']?></td>
			</tr>
		<? } ?>
	</tbody>

	<tbody>
		<? //files
		if($matches['files']->count()>0) {
			$matches['files']->printout();
		} elseif(!$dirs) {	?>
			<tr>
				<td colspan="11"><?=$l['err']['nofiles']?></td>
			</tr>
		<? } ?>
	</tbody>

	</table>
	</form>
<?
} catch(Exception $e) {
	echo $e->getMessage();
}
?>
</div>
<?
}
break;
//^^find^^

//__gallery__
case 'gallery':
// thumbnail gallery
$title = $l['title']['thumbs'];

try {

	$dir = new mfp_dir($MFP['dir']);
	//init
	$thumbdirs = new mfp_list();
	$thumbfiles = new mfp_files();

	$dir->opendir();
	while($file = $dir->readdir()) {
		if($file != '.' && $file != '..'){
			
			$path = $dir.'/'.$file;
			if(allowed($path)) {
				if(is_dir($path)) {
					$thumbdirs->add(array(
						'name' => $file,
						'path' => $path,

						'mtime' => getlastmod($path)
					));
				} elseif(is_file($path)) {
					$thumbfiles->add(array(
						'name' => $file,
						'path' => $path,

						'size' => filesize($path),
						'mtime' => getlastmod($path),

						#'hash' => md5(realpath($path)).filemtime($path) // not used atm
					));
				}
			}
		}
	}
	$dir->closedir();

	// sort listings
	$thumbdirs->sort('+name');
	$thumbfiles->sort('+name');

	$nowdir = HOME . pathTo($dir);
	$thisdir = ($nowdir);

	// see --view--
	$realupdir = @realpath($thisdir.'/..');
	$updir = HOME . pathTo($realupdir);

	$breadcrumbs = $dir->breadcrumbs();
	if(realpath($dir) != REALHOME) { array_push($breadcrumbs, $dir->getCleanPath()); }
	// grid output
	?>

	<!-- quick access panel, fixed -->
	<div id="fix">
		<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir));?>" title="<?=$l['viewdir']?>"><img src="<?=img('explore')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a>
		<a href="<?=dosid(SELF.'?a=find&amp;dir='.urlencode($dir));?>" title="<?=$l['find']?>"><img src="<?=img('find')?>" width="16" height="16" alt="<?=$l['find']?>"></a>
		<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
		<img src="<?=img('images')?>" width="16" height="16" alt="<?=$l['img']?>">
		[<?=$thumbfiles->count()?> | <?=getfsize($thumbfiles->size())?>]&nbsp;

		<img src="<?=img('dir')?>" width="16" height="16" alt="<?=$l['dir']?>">
		[<?=$thumbdirs->count()?>]
		<?='&nbsp;&nbsp;'.htmlspecialchars(basename(pathTo($dir)))?>
	</form>
	</div>

	<div id="scroll" class="gallery">
	<div class="breadcrumbs">
		<img src="<?=img('dir')?>" width="16" height="16" alt="/">&nbsp;
		<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode(HOME))?>" title="<?=$l['changedir']?>"><?=htmlspecialchars(basename(REALHOME))?>/</a>
	<?
	foreach($breadcrumbs as $path) {
		$path = HOME . $path;
	?>
		<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($path))?>" title="<?=$l['changedir']?>"><?=htmlspecialchars(basename($path))?>/</a>
	<? } ?>
	</div>

	<ul class="dirlist">
	<?	//dirs
	foreach($thumbdirs as $dir) {
		?>
		<li class="tile">
		<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['changedir']?>">
			<img src="<?=img('dir')?>" width="<?=$maxw?>" height="<?=$maxh?>" alt="/">
			<span><?=(htmlspecialchars($dir['name']))?></span>
		</a>
		</li>
<?} ?>
	</ul>

	<ul class="filelist">
	<? //files
	foreach($thumbfiles as $file) {
	$imgpath = $file['path'];
	$isimage = TRUE;

	// get extension - and corresponding imagepath
	$ext = strtolower(substr(strrchr($imgpath,'.'),1));
	foreach($ftypes as $key => $val) {
		if(in_array($ext, $val)) {
			$imgpath = $icondir.'/'.$icons[$key];
			$isimage = FALSE;
			// ends loop:
			break;
		}
	}

	if($isimage == FALSE) {
		$srclink = $imgpath;
	} else {
		$srclink = SELF.'?a=thumb&amp;img='.urlencode($imgpath);
	}
	?>
		<li class="tile">
		<a href="<?=htmlspecialchars($file['path'])?>" target="_blank" title="<?=$l['view']?>">
			<img src="<?=dosid($srclink)?>" width="<?=$maxw?>" height="<?=$maxh?>" alt=">">
			<span>
			<span><?=(htmlspecialchars($file['name']))?></span>
			<small style="clear:both;"><?= getfsize($file['size'])?></small>
			</span>
		</a>
		</li>
	<? } ?>
	</ul>
	</div>
	<?

	} catch(Exception $e) {
		echo $e->getMessage();
	}
break;
//^^gallery^^

//__info__
case 'info':
	//show server info
	$title = $l['title']['info'];

	//space:
	$freespace  = getfsize(@disk_free_space(HOME));
	$totalspace = getfsize(@disk_total_space(HOME));
	$location   = htmlspecialchars(pathTo(HOME, $_SERVER['DOCUMENT_ROOT']) . '/');

	//count languages and themes
	$langcount = $themecount = 0;

	$dir = $langdir;
	$dh = @opendir($dir);
		while($file = @readdir($dh)){
			if(is_file($dir. '/' .$file)) {
			if(strpos($file, '.ini.php') !== FALSE) {
				$langcount++;
			}
			}
		}
	$dir = $themedir;
	$dh = @opendir($dir);
		while($file = @readdir($dh)){
			if(is_file($dir. '/' .$file)) {
			if(strpos($file, '.ini.php') !== FALSE) {
				$themecount++;
			}
			}
		}

?>

<center id="fix"><b><?=$l['title']['info']?></b></center>
<center id="scroll">
<?
	//format and output
?>
<div class="box">
<h3><img src="<?=img('drive')?>" width="16" height="16" alt="<?=$l['info']?>"> harddisk</h3>
<?
	printf($l['freespace'], $freespace, '<var class="dir">'.$location.'</var>');
	echo '<br>';
	printf($l['totalspace'], $totalspace, '<var class="dir">'.$location.'</var>');
?>
</div>

<div class="box">
<h3><img src="<?=img('drive')?>" width="16" height="16" alt="<?=$l['info']?>"> server</h3>
	<dl class="aligned">
		<dt>Server name: </dt>
		<dd>"<i><?=$_SERVER['SERVER_NAME']?></i>"</dd>

		<dt>Server Software: </dt>
		<dd>"<i><?=$_SERVER['SERVER_SOFTWARE']?></i>"</dd>

		<dt>Operating System: </dt>
		<dd>"<i><?=@$_ENV['OS']?></i>"</dd>

	</dl>

</div>

<div class="box">
<h3><img src="<?=img('drive')?>" width="16" height="16" alt="<?=$l['info']?>"> environment</h3>
<dl class="aligned">
<?
	foreach($_ENV as $env => $val) {
		echo '<dt class="b">', $env, '= </dt>';
		echo '<dd>';
		print_r($val);
		echo '</dd>';
	}
?>
</dl>
</div>

<div class="box">
<h3><img src="<?=img('user')?>" width="16" height="16" alt="<?=$l['user']?>"> <?=$l['user']?></h3>
	<dl class="aligned">
		<dt><?=$l['user']?>: </dt>
		<dd>"<i><?=$user?></i>"</dd>

		<dt><?=$l['home']?>: </dt>
		<dd>"<i><?=HOME?></i>"</dd>

		<dt><?=$l['lang']?>: </dt>
		<dd>"<i><?=$accounts[$user]['lang']?></i>"</dd>

		<dt><?='theme'?>: </dt>
		<dd>"<i><?=$accounts[$user]['theme']?></i>"</dd>
	</dl>
</div>

<div class="box">
<h3><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['info']?>"> script</h3>
	<dl class="aligned">
		<dt>Domain: </dt>
		<dd><?=$_SERVER['HTTP_HOST']?></dd>

		<dt>Path: </dt>
		<dd><?=SELF?></dd>

		<dt>Url: </dt>
		<dd><a href="<?=dosid('http://'.$_SERVER['HTTP_HOST'].SELF)?>"><?=$_SERVER['HTTP_HOST'].SELF?></a></dd>


		<dt>languages: </dt>
		<dd><?=$langcount?></dd>

		<dt>themes: </dt>
		<dd><?=$themecount?></dd>
	</dl>
</div>

</center>
<?
break;
//^^info^^




//__mod__
case 'mod':
/*
	# php specific
	Socket:           0140000
	Symbolic link:    0120000
	Regular:          0100000
	Block special:     060000
	Directory:         040000
	Character special: 020000
	FIFO Pipe:         010000
	
	# special bits
	Suid:               04000
	Guid:               02000
	Sticky:             01000
	
	# regular permissions
	urwx:                0400 0200 0100
	grwx:                 040  020  010
	orwx:                  04   02   01
*/
	// needs a whole lotta attention
//chmod-ing
$title = $l['title']['mod'];

?>
	<div class="box">
	<h3><img src="<?=img('perms')?>" width="16" height="16" alt="<?=$l['perms']?>"> <?=$l['editperms']?></h3>
<?
try {

	if(isset($MFP['edit'])) {

		foreach($MFP['mod'] as $file) {
			$path = new mfp_path($file['path']);

			$directlink  = htmlspecialchars(directlink($path));
			$wrappedpath = wrap(htmlspecialchars(pathTo($path)));
			$class = getCssClass($path);

			$lstat = $path->stat();
			$userinfo = _posix_getpwuid($lstat['uid']);
			$groupinfo = _posix_getgrgid($lstat['gid']);

			$owner = &$file['owner'];
			$group = &$file['group'];
			$other = &$file['other'];
	
			$ownermod  = isset($owner) ? array_sum($owner) : '0';
			$groupmod  = isset($group) ? array_sum($group) : '0';
			$othermod  = isset($other) ? array_sum($other) : '0';
			$mod = octdec($ownermod . $groupmod . $othermod);
	
			if($mod > 0777) throw new Exception(sprintf($l['err']['unexpected'], ''));
			if(!$path->chmod($mod))
				throw new Exception(sprintf('Error setting permissions of "<var class="'.$class.'">%s</var>"',
					'<a href="'.$directlink
					.'" target="_blank">'.$wrappedpath.'</a>'));
			
			// clear file info cache
			clearstatcache();
	
			printf('Set permissions of "<var class="'.$class.'">%1$s</var>" to %2$s (%3$o)',
				'<a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a>',
				perm2str(fileperms($path)%01000), fileperms($path)%01000);
		} ?>
		<form name="mfp_form" action="javascript:window.close()" class="footer">
		<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
				opener.location.reload();
				document.mfp_form.closebut.focus();
		//-->
		</script>
		</form>
<?
	} else {
		$path = new mfp_path($MFP['path']);

		$directlink  = htmlspecialchars(directlink($path));
		$wrappedpath = wrap(htmlspecialchars(pathTo($path)));
		$class = getCssClass($path);

		$lstat = lstat($path);
		$uinfo = _posix_getpwuid($lstat['uid']);
		$ginfo = _posix_getgrgid($lstat['gid']);
		$mod = $lstat['mode'];

		?>
	<form method="post" action="<?=dosid(SELF.'?a=mod');?>" accept-charset="<?=$charset?>">
	<input type="hidden" name="mod[0][path]" value="<?=isset($MFP['path']) ?htmlspecialchars($MFP['path']) :''?>">
		
	<center>
		<?#needs new lang!!!?>
		<?printf('Edit permissions of "<var class="'.getCssClass($MFP['path']).'">%1$s</var>":',
				'<a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a>')?>

		<table rules="rows">
		<tr>
			<th><img src="<?=img('user')?>" width="16" height="16" alt="u"> Owner <br><small><?=$uinfo['name']?></small></th>
			<td><label for="chk1"><input type="checkbox" name="mod[0][owner][]" id="chk1" value="4" <?=($mod & 0400) ? 'checked' : ''?>> r</label></td>
			<td><label for="chk2"><input type="checkbox" name="mod[0][owner][]" id="chk2" value="2" <?=($mod & 0200) ? 'checked' : ''?>> w</label></td>
			<td><label for="chk3"><input type="checkbox" name="mod[0][owner][]" id="chk3" value="1" <?=($mod & 0100) ? 'checked' : ''?>> x</label></td>
		</tr>
		<tr>
			<th><img src="<?=img('group')?>" width="16" height="16" alt="g"> Group <br><small><?=$ginfo['name']?></small></th>
			<td><label for="chk4"><input type="checkbox" name="mod[0][group][]" id="chk4" value="4" <?=($mod & 040) ? 'checked' : ''?>> r</label></td>
			<td><label for="chk5"><input type="checkbox" name="mod[0][group][]" id="chk5" value="2" <?=($mod & 020) ? 'checked' : ''?>> w</label></td>
			<td><label for="chk6"><input type="checkbox" name="mod[0][group][]" id="chk6" value="1" <?=($mod & 010) ? 'checked' : ''?>> x</label></td>
		</tr>
		<tr>
			<th><img src="<?=img('others')?>" width="16" height="16" alt="o"> Others</th>
			<td><label for="chk7"><input type="checkbox" name="mod[0][other][]" id="chk7" value="4" <?=($mod & 04) ? 'checked' : ''?>> r</label></td>
			<td><label for="chk8"><input type="checkbox" name="mod[0][other][]" id="chk8" value="2" <?=($mod & 02) ? 'checked' : ''?>> w</label></td>
			<td><label for="chk9"><input type="checkbox" name="mod[0][other][]" id="chk9" value="1" <?=($mod & 01) ? 'checked' : ''?>> x</label></td>
		</tr>
		</table>
	</center>

		<div class="footer">
		<input type="button" value="  <?=$l['cancel']?>  " onClick="window.close()">
		<input type="reset" value="<?=$l['reset']?>">
		<input type="submit" name="edit" value="<?=$l['editperms']?>">
		</div>
	</form>
	<? }
} catch(Exception $e) {
	echo $e->getMessage();
}
?>

	</div>
<?
break;
//^^mod^^

//__multi__
//multiple file ops, still under *construction*
// down/zip working
case 'multi':
$dir = &$MFP['dir'];

if(isset($MFP['chks']) && count($MFP['chks'])) {
	// create list filled with checked boxes
	$checkboxes = new mfp_list($MFP['chks']);

	//quickfick
	if(isset($MFP['add']) || isset($MFP['sub'])) {
		$clipboard = &$_SESSION['mfp_clipboard'];

		// loop checkboxes and then decide what to do!
		foreach($checkboxes as $file) {

			$path = HOME . pathTo($dir.'/'.$file);
			echo '<br>dir "', $dir, '" / path "', $path, '":&nbsp;';

			try {
				if(!is_file($path)) throw new Exception(sprintf($l['err']['forbidden'].'<br>', '<var class="file">'.$path.'</var>'));
				if(!allowed($path)) throw new Exception($l['err']['nofile']);
				
				// subaction (add, substract):
				if(isset($MFP['add'])) {
					// check for duplicates
					if(!in_array($path, $clipboard)) {
						$clipboard[] = $path;
						echo 'added to clipboard';
					}
				} elseif(isset($MFP['sub'])) {
					if(in_array($path, $clipboard)) {
						unset($clipboard[array_search($path, $clipboard)]);
						echo 'removed from clipboard';
					}
				}
			} catch(Exception $e) {
				echo $e->getMessage();
			}
		}

		// list clipboard
		header('Location: '. dosid(SELF.'?a=clip&list', '&'));
	}

	//__ren__
	if(isset($MFP['ren'])) {
		$title = $l['title']['ren']; ?>
		<div class="box">
		<h3><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"> <?=$l['rename']?></h3>
		<form method="post" action="<?=dosid(SELF.'?a=ren')?>" name="renform" onSubmit="return chkform(); return false;" accept-charset="<?=$charset?>">
			<?#<input type="hidden" name="oldpaths" value='< ?=base64_encode(serialize($checkboxes->getArray()));? >'>?>
			<?
			foreach($checkboxes as $file) {
				$path = htmlspecialchars($dir.'/'.$file);
				$basename = htmlspecialchars(basename($path));
			?>
				<div><input type="hidden" name="oldpath[]" value="<?=$path?>">
				<input type="text" name="newname[]" value="<?=$basename?>"></div>
			<? } ?>
			<div class="footer">
			<input type="submit" name="rename" value=" <?=$l['rename']?> ">&nbsp;
			<input type="reset" value=" <?=$l['reset']?> ">&nbsp;
			<input type="button" value="  <?=$l['cancel']?>  " onClick="window.close()">
			</div>
		</form>
		</div>
		<?
	//__del__
	} elseif(isset($MFP['del'])) {
		$title = $l['title']['del']; ?>
		<div class="box">
		<h3><img src="<?=img('del')?>" width="16" height="16" alt="<?=$l['delete']?>"> <?=$l['delete']?></h3>
		<ul>
		<?
		foreach($checkboxes as $file) {
			$path = htmlspecialchars($dir.'/'.$file);
			$wrappedpath = wrap(htmlspecialchars(pathTo($path)));
	
			echo '<li class="file">',
			sprintf($GLOBALS['l']['warn']['reallydel'],
				'<var><a href="'.$path
				.'" target="_blank">'.$wrappedpath.'</a></var>'),
			"</li>\n";
		} ?>
		</ul>
	
		<form method="post" action="<?=dosid(SELF.'?a=del&amp;dir='.urlencode($dir))?>" class="footer" accept-charset="<?=$charset?>">
			<input type="hidden" name="paths" value='<?=base64_encode(serialize($checkboxes->getArray()));?>'>
			<input type="submit" name="delete" value=" <?=$l['delete']?> ">&nbsp;
			<input type="button" value="  <?=$l['cancel']?>  " onClick="window.close()">
		</form>
		</div>
	<?
	
	//__src__
	} elseif(isset($MFP['src'])) { $title = $l['title']['src']; ?>
	<?
		foreach($checkboxes as $file) {
			try {
				if(!isset($file)) throw new Exception($l['err']['nofile']); // ??? needed?
				$file = new mfp_file($dir.'/'.$file);

				$directlink  = htmlspecialchars(directLink($file));
				$wrappedpath = wrap(htmlspecialchars(pathTo($file), 80));
			?>
				<div style="border:1px solid <?=$c['border']['fix']?>; padding:0.4em; -moz-border-radius:1em;">
				<?
				// newest approach
				// http://www.selfphp.info/kochbuch/kochbuch.php?code=39
	
					// buffering highlighted source
					$source = $file->show_source();
	
					$lines     = file($file);
					$linecount = count($lines);
					$length    = strlen($linecount);
					$numbers   = '';
	
					for($i=1;$i<=$linecount;$i++) {
							$curnumber = str_pad($i, $length, "0", STR_PAD_LEFT);
							if(!($i%10)) $curnumber = '<em>'.$curnumber.'</em>';
							$numbers .= $curnumber. "<br>\n";
					}
	
				// shows colored source
				// with line numbers
				// new try with floating divs
				?>
				<!--  -->
				<var class="file"><a href="<?=$directlink?>" target="_blank"><?=$wrappedpath?></a></var>
				<table>
				<tr class="vtop">
					<td class="enum" style="background-color:<?=$c['bg']['input']?>; border-right:1px solid <?=$c['border']['lite']?>; -moz-border-radius:0.5em 0 0 0.5em;"><code><?=$numbers?></code></td>
					<td style="background-color:<?=$c['bg']['inputlite']?>; padding-left:1em; -moz-border-radius:0 0.5em 0.5em 0;"><?=$source?></td>
				</tr>
				</table>
				<!-- rendering floated divs is obviously more resource-hungry -->
				<!-- sth is broken with divs anyways... float + min-width+overflow!!!-->
				</div>
				<?
			} catch (Exception $e) {
				echo $e->getMessage();
			}
		}
		#echo '</div>';
	
	//__down__
	} elseif(isset($MFP['down'])) {
	// create zip of files and send to browser
		//end-delete buffering
		ob_end_clean();
	
		//load lib
		require_once($libdir.'/zip.lib.php');
	
		$zip = new zipfile();
	
		foreach($checkboxes as $file) {
			try {
				$file = new mfp_file($dir.'/'.$file);
	
				if(($content = $file->file_get_contents()) === FALSE) throw new Exception(sprintf($l['err']['openfile'].'<br>', '<var class="file">'.htmlspecialchars($file).'</var>'));
	
				$zip->addFile($content, $file->basename());
			} catch (Exception $e) {
				// only log messages, so archive stays valid
				mfp_log($e->getMessage());
			}
		}
	
		$zipdump = $zip->file();
		// send headers
		header('Content-type: application/zip');
		header('Content-length: ' . strlen($zipdump));
		header('Content-Disposition: attachment; filename="'.basename(realpath($dir)).'.zip"');
	
		// output zipfile content and send it to browser
		print($zipdump);
	
		/*if(isset($zipfiles) && count($zipfiles)) {
		} else { echo 'no files to zip'; }*/
	
		//exit script :)
		exit;
	}
} else { echo 'nothing checked<br>'; }

break;
//^^multi^^

//__new__
case 'new':
$title = $l['title']['new'];
?>
<div class="box full">
<?if(isset($MFP['what']) && $MFP['what'] == 'dir') {?>
<h3><img src="<?=img('newdir')?>" width="16" height="16" alt="<?=$l['new']?>"> <?=$title?></h3>
<?}else{?>
<h3><img src="<?=img('newfile')?>" width="16" height="16" alt="<?=$l['new']?>"> <?=$title?></h3>
<?}?>
<center>

<?
try {

	if(!isset($MFP['create'])) throw new Exception('Forbidden!');
	if(!allowed($MFP['dir'])) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.$MFP['dir'].'</var>'));
	if(empty($MFP['filename'])) throw new Exception($l['err']['emptyfield']);
	
	$newname = $MFP['dir'].'/'.$MFP['filename'];
	$url_name = urlencode($newname);
	$wrappedpath = wrap(htmlspecialchars(pathTo($newname)));

	//possibility to extend in future eg: 'link', 'archive', ...
	switch($MFP['what']) {

		case 'dir':
			$wrappedpath .= '/';
			if(file_exists($newname)) throw new Exception(sprintf($l['err']['direxists'],
					'<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;dir='.$url_name)
					.'" target="_blank">'.$wrappedpath.'</a></var>'));
			if(!mkdir($newname)) throw new Exception(sprintf($l['err']['createdir'], '<var class="dir">'.$wrappedpath.'</var>'));

			printf($l['ok']['createdir'],
						'<var class="dir"><a href="'. dosid(SELF.'?a=view&amp;dir='.$url_name)
						.'" target="view" onclick="opener.location=this.href;window.close();">'. $wrappedpath.'</a></var>');
		break;

		case 'file':
			$directlink = htmlspecialchars(directlink($newname));
			if(file_exists($newname)) throw new Exception(sprintf($l['err']['fileexists'],
					'<var class="file"><a href="'.$url_name
					.'" target="_blank">'.$wrappedpath.'</a></var>',
					getfsize(filesize($newname))));
			if(!touch($newname)) throw new Exception(sprintf($l['err']['createfile'], '<var class="file">'.$wrappedpath.'</var>'));

			printf($l['ok']['createfile'],
				'<var class="file"><a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a></var>');

		break;
	}

?>
	<form name="mfp_form" action="javascript:window.close()" accept-charset="<?=$charset?>">
	<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">

	<?= $MFP['what'] == 'file' ? '<input name="editbut" type="button" value="  '.$l['editcode'].'  " onClick="document.location = \''.dosid(SELF.'?a=edit&amp;file='.urlencode($newname)).'\';">' : "\n" ?>

	<script type="text/javascript" language="JavaScript">
	<!--
			opener.document.quickform.filename.value = "";
			opener.location.reload();
			opener.parent.tree.location.reload();

			document.mfp_form.closebut.focus();
	//-->
	</script>
	</form>

<?
} catch(Exception $e) {
	echo $e->getMessage();
}
?>

</center>
</div>
<?
break;
//^^new^^

//__props__
case 'props':
// file properties
$title = $l['title']['props'];


$imgexts = array('gif', 'jpg', 'jpeg', 'jpe', 'png', 'svg', 'svgz', 'tif', 'tiff');


$path = $MFP['path'];
$ext = strtolower(substr($path, strrpos($path, '.')+1));

if(allowed($path)) {

	$lstat = @lstat($path);
	$owner = _posix_getpwuid($lstat['uid']);
	$group = _posix_getgrgid($lstat['gid'])
?>
	<center id="fix"><b><?=$l['props']?></b></center>
	<center id="scroll">

	<div class="box">
	<h3><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['props']?>"> <?=$l['props']?></h3>

		<div class="box">
		<h3><img src="<?=img(getCssClass($path))?>" width="16" height="16" alt="<?=$l['src']?>"> File</h3>
		<dl>
			<dt>Name: </dt>
			<dd>"<i><?=basename($path)?></i>"
			<a href="<?=dosid(SELF.'?a=ren&amp;path='.urlencode($path))?>" title="<?=$l['renamefile']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"></a></dd>

			<dt>Path: </dt>
			<dd>"<i><?=wrap(htmlspecialchars(pathTo($path)))?></i>"</dd>

		<? if(is_file($path)) { ?>
			<dt>Size: </dt>
			<dd>"<i><?=getfsize($lstat['size'])?></i>"</dd>

			<dt>Extension: </dt>
			<dd>"<i><?=$ext?></i>"</dd>
		<? } ?>

			<dt>Last modified: </dt>
			<dd>"<i><?=@date($l['fulldate'], $lstat['mtime'])?></i>"</dd>

			<dt>Last accessed: </dt>
			<dd>"<i><?=@date($l['fulldate'], $lstat['atime'])?></i>"</dd>
		</dl>

		</div>

		<div class="box">
		<h3><a href="<?=dosid(SELF.'?a=mod&amp;path='.urlencode($path))?>" title="<?=$l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><img src="<?=img('perms')?>" width="16" height="16" alt="<?=$l['perms']?>"></a> Permissions</h3>
		<dl class="aligned">
			<dt>Permissions: </dt>
			<dd>"<i><?printf('%o', $lstat['mode']%01000)?></i>"</dd>

			<? if(($owner) && ($group)) { ?>
			<dt>Owner: </dt>
			<dd>"<i><?=$owner['name']?></i>"</dd>

			<dt>Group: </dt>
			<dd>"<i><?=$group['name']?></i>"</dd>
			<? } ?>
		</dl>
		</div>

		<div class="box">
		<h3><a href="<?=dosid(SELF.'?a=src&amp;file='.urlencode($path))?>" title="<?=$l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['src']?>"></a> Preview</h3>
	<? if(is_file($path)) { ?>
		<? if(in_array($ext, $imgexts)) {
			$wh = getimagesize($path);
			$w = $wh[0];
			$h = $wh[1];
		?>
		<img src="<?=dosid(SELF.'?a=thumb&amp;img='.urlencode($path).'&amp;size=100')?>" style="float:left; margin-right:10px; width:100px; height:100px;" alt="<?=$l['thumb']?>">
		<div>
		<?=$w?>px x <?=$h?>px<br>
		</div>
		<? } else { ?>
		<code>
		<?
			$fsize = @filesize($path);
			$h = @fopen($path, 'rb+');
			$cont = @fread($h, $fsize < $previewlen ? $fsize : $previewlen);

			echo nl2br(htmlentities($cont));
		?>
		</code>
		<? } ?>
	<? } elseif(is_dir($path)) {
			$dircount = $filecount = 0;
			$filesizes = 0;
			$h = @opendir($path);
			while($file = @readdir($h)){
				$filepath = $path.'/'.$file;
				if(allowed($filepath)) {
					if(is_dir($filepath)) {
						if($file != '.' && $file != '..') $dircount++;
					} elseif(is_file($filepath)) {
						$filecount++;
						$filesizes += @filesize($filepath);
					}
				}
			}
			@closedir($h);
	?>
		<img src="<?=img('dir')?>" style="float:left; margin-right:10px; width:100px; height:100px;" alt="<?=$l['dir']?>">
		<dl style="float:left;">
			<dt>Files: </dt>
			<dd><?=$filecount?></dd>

			<dt>Directories: </dt>
			<dd><?=$dircount?></dd>

			<dt>Size: </dt>
			<dd><?=getfsize($filesizes)?></dd>
		</dl>
	<? } ?>
		<div style="clear:both;"></div>
	</div>

	</div>
	</center>

<?
	} else {
		printf($l['err']['forbidden'], '<var class="'.getCssClass($path).'">'.$path.'</var>');
	}
break;
//^^props^^


//__rem__
case 'rem':
//remove directory recursive
$title = $l['title']['rem'];
?>
<div class="box full">
<h3><img src="<?=img('rem')?>" width="16" height="16" alt="<?=$l['remove']?>"> <?=$title?></h3>
<center>

<?
try {
	$dir = &$MFP['dir'];
	if(!allowed($dir)) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.$MFP['dir'].'</var>'));
	
	if(isset($MFP['remove'])) {
		$reldir = pathTo($dir);
		$wrapdir = wrap(htmlspecialchars($reldir));
	
		function recursiveRem($dir) {
			global $debug;

			if(is_writeable($dir)) {
				$handle = opendir($dir);
				while($file = readdir($handle)) {
					if($file != '.' && $file != '..') {
						$path = $dir.'/'.$file;
		
						// coz of symlinks
						if(allowed($path)) {
							if(is_dir($path)) {
								if($file != '.' && $file != '..') {
									//recursion
									recursiveRem($path);
									rmdir($path);
									$debug.= '<br><b>dir: '.$path.'</b>';
								}
							} else {
								unlink($path);
								$debug.= '<br>file: '.$path;
							}
						}
					}
				}
				closedir($handle);
			}
			return TRUE;
		}
	
		//recursion
		if(is_writeable($dir) && recursiveRem($dir)) {
			//remove directory itself
			// shouldn't remove rootdir - needs workaround
			if(realpath($dir) == REALHOME) die('permission denied');
	
			if(allowed($dir)) {
				if(@rmdir($dir)) {
					printf($l['ok']['removedir'], '<var class="dir">'.$wrapdir.'</var>');
				} else {
					printf($l['err']['removedir'], '<var class="dir">'.$wrapdir.'</var>');
				}
			} else {
				printf($l['err']['forbidden'], '<var class="dir">'.$wrapdir.'</var>');
			}
	?>
				<form name="mfp_form" action="javascript:window.close()" accept-charset="<?=$charset?>">
				<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
				<script type="text/javascript" language="JavaScript">
				<!--
					opener.location.reload();
					opener.parent.tree.location.reload();
	
					document.mfp_form.closebut.focus();
				//-->
				</script>
				</form>
			<?
		} else {
			printf($l['err']['removedir'], '<var class="dir">'.$wrapdir.'</var>');
		}
	
	} else {
	// confirm - very ugly
	?>
	<form method="post" action="<?=dosid(SELF.'?a=rem')?>" onSubmit="return confirm('Remove <?=addcslashes(pathTo($dir), '\\')?>?'); return false;" accept-charset="<?=$charset?>">
		<input type="hidden" name="dir" value="<?=htmlspecialchars($dir)?>">
		<?printf($l['warn']['reallyrem'],
			'<var class="dir"><a href="'. dosid(SELF.'?a=view&amp;dir='.urlencode($dir))
			.'" target="_blank">'. wrap(htmlspecialchars(pathTo($dir))) .'</a></var>')?><br>
		<?=$l['warn']['alldirs']?><br>
		<input type="submit" name="remove" value=" <?=$l['remove']?> ">&nbsp;
		<input type="button" name="cancel" value="  <?=$l['cancel']?>  " onClick="window.close()">
	</form>
	<? }
} catch(Exception $e) {
	echo $e->getMessage();
} ?>

</center>
</div>

<?
break;
//^^rem^^


//__ren__
case 'ren':
$title = $l['title']['ren'];
?>
<div class="box">
<h3><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"> <?=$l['rename']?></h3>
	<?
	try {

		if(isset($MFP['rename'])) {
			if(empty($MFP['newname'])) { throw new Exception(sprintf($l['err']['emptyfield'])); }

			#$oldpaths = unserialize(base64_decode($MFP['oldpaths']));
			$oldpaths = &$MFP['oldpath'];
			$newnames = &$MFP['newname'];

			function makeRenArray($oldpath, $newname) {
				return array('oldpath' => $oldpath, 'newname' => $newname);
			}
			$newnames = new mfp_list(array_map('makeRenArray', $oldpaths, $newnames));

			echo '<ul>';
			foreach($newnames as $file) {
				$class = getCssClass($file['oldpath']);
				
				echo '<li class="',$class,'">';

				try {
					$oldpath = &$file['oldpath'];
					$path = new mfp_path($oldpath);
					$wrappedoldpath = wrap(htmlspecialchars($oldpath));

					$newname = &$file['newname'];
					$directlink = htmlspecialchars(directLink($newname));
					$wrappedpath = wrap(htmlspecialchars($newname));

					if(empty($newname)) { throw new Exception(sprintf($l['err']['emptyfield'])); }

					if(!$path->rename($newname)) {
						throw new Exception(sprintf($l['err']['rename'], '<var>'.$wrappedoldpath.'</var>', '<var>'.$wrappedpath.'</var>'));
					}

					printf($l['ok']['rename'], $wrappedoldpath,
						'<var><a href="'.$directlink
						.'" target="_blank">'.$wrappedpath.'</a></var>');
				} catch(Exception $e) {
					echo $e->getMessage();
				}
				echo "</li>\n";
			}
		?>
		</ul>
		<form name="mfp_form" action="javascript:window.close()">
		<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
				opener.location.reload();
				document.mfp_form.closebut.focus();
		//-->
		</script>
		</form>
	<?
	} else {
		$path = new mfp_path($MFP['path']);
	?>
	<script type="text/javascript" language="JavaScript">
	<!--
		function chkform() {
			if(document.forms.renform.newname.value == '') {
				alert('<?=$l['err']['emptyfield']?>');
				return false;
			}
			return true;
		}
	//-->
	</script>


	<form method="post" action="<?=dosid(SELF.'?a=ren')?>" name="renform" onSubmit="return chkform(); return false;" accept-charset="<?=$charset?>">
		<?printf($l['renameto'],
				'<var class="'.getCssClass($path).'"><a href="'. htmlspecialchars(directLink($path))
				.'" target="_blank">'. wrap(htmlspecialchars(basename($path))) .'</a></var>')?>
		<div>
		<?#<input type="hidden" name="oldpaths" value='< ?=base64_encode(serialize(array($path)));? >'>?>
		<input type="hidden" name="oldpath[]" value="<?=htmlspecialchars($path)?>">
		<input type="text" name="newname[]" value="<?=htmlspecialchars(basename($path))?>"></div>

		<div class="footer">
		<input type="submit" name="rename" value="<?=$l['rename']?>">
		<input type="reset" value="<?=$l['reset']?>">
		<input type="button" value="<?=$l['cancel']?>" onClick="window.close()">
		</div>
	</form>

	<?
		}
	} catch(Exception $e) {
		echo $e->getMessage();
	}
	?>
</div>
<?
break;
//^^ren^^

//__src__
case 'src':
// show source code
$title = $l['title']['src'];
$file = &$MFP['file'];

	try {
		if(!isset($file)) throw new Exception($l['err']['nofile']); // ??? needed?
		$file = new mfp_file($file);
		$directlink  = htmlspecialchars(directLink($file));
		$wrappedpath = wrap(htmlspecialchars(pathTo($file), 100));
	?>
		<div id="fix">
			<form method="post" action="<?=dosid(SELF.'?a=edit')?>" target="editwin" onSubmit="popUp(this.action, 'editwin', 'width=640,height=480');">
			<input type="hidden" name="file" value="<?=htmlspecialchars($file)?>">
			<input type="submit" name="edit" value="<?=$l['editcode']?>">&nbsp;
			<input type="button" name="reload" value="<?=$l['reload']?>" onClick="window.location.reload()">&nbsp;
			<input type="button" name="close" value="<?=$l['close']?>" onClick="window.close()">&nbsp;
			<var class="file"><a href="<?=$directlink?>" target="_blank"><?=$wrappedpath?></a></var>
			</form>
		</div>

		<div id="scroll" style="border:1px solid <?=$c['border']['fix']?>; padding:0.4em; -moz-border-radius:1em;">
		<?
		// newest approach
		// http://www.selfphp.info/kochbuch/kochbuch.php?code=39

			// buffering highlighted source
			$source = $file->show_source();

			$lines     = file($file);
			$linecount = count($lines);
			$length    = strlen($linecount);
			$numbers   = '';

			for($i=1;$i<=$linecount;$i++) {
					$curnumber = str_pad($i, $length, "0", STR_PAD_LEFT);
					if(!($i%10)) $curnumber = '<a name="'.$i.'"></a><em>'.$curnumber.'</em>';
					$numbers .= $curnumber. "<br>\n";
			}

		// shows colored source
		// with line numbers
		// new try with floating divs
		?>
		<!--  -->
		<table>
		<tr class="vtop">
			<td class="enum" style="background-color:<?=$c['bg']['input']?>; border-right:1px solid <?=$c['border']['lite']?>; -moz-border-radius:0.5em 0 0 0.5em;"><code><?=$numbers?></code></td>
			<td style="background-color:<?=$c['bg']['inputlite']?>; padding-left:1em; -moz-border-radius:0 0.5em 0.5em 0;"><?=$source?></td>
		</tr>
		</table>
		<!-- rendering floated divs is obviously more resource-hungry -->
		<!-- sth is broken anyway with divs... float + min-width+overflow!!!-->
		</div>
		<?
	} catch (Exception $e) {
		echo $e->getMessage();
	}
break;
//^^src^^


//__thumb__
case 'thumb':
// create thumbnailed images
// see http://www.weberdev.com/ViewArticle-388.html

	$img = &$MFP['img'];
	$refresh = isset($MFP['refresh']);
	if(isset($MFP['size'])) $maxw = $maxh = $MFP['size'];

	try {
		if(!isset($img)) throw new Exception($l['err']['nofile']); // ??? needed?
		$img = new mfp_file($img);
		$cachefile = $cachedir.'/'.md5($img->realpath()).$img->filemtime().'.png';

		ob_end_clean();

		if($caching && file_exists($cachefile) && !$refresh) {
			// read cached file to buffer
			readfile($cachefile);
		} else {

			// avoid probs with empty files (0bytes)
			if($img->filesize() != 0) {
				$wh = @getimagesize($img);
				$w = $wh[0];
				$h = $wh[1];

				switch($wh[2]) {
					case 1: // gif
						$oldimg = imageCreateFromGif($img);
					break;
					case 2: // jpg
						$oldimg = imageCreateFromJpeg($img);
					break;
					case 3: // png
						$oldimg = imageCreateFromPng($img);
					break;
					default: // other, draw error icon
						$resizeall = TRUE;

						$wh = getimagesize(img('error'));
						$w = $wh[0];
						$h = $wh[1];

						$oldimg = imageCreateFromPng(img('error'));
				}

				if(($w > $maxw || $h > $maxh) || $resizeall) {
					if($w > $h) {
						$ratio = $maxw / $w;
					} elseif($h > $w) {
						$ratio = $maxh / $h;
					} else {
						$ratio = ($maxh >= $maxw) ? $maxw / $w : $maxh / $h;
					}

					$nw = $w * $ratio;
					$nh = $h * $ratio;
				} else {
					$nw = $w;
					$nh = $h;
				}
				$newimg = imageCreate($maxw,$maxh);

				if(function_exists('imageAntiAlias')) imageAntiAlias($newimg,TRUE);
				//center image ;)
				imageCopyResampled(
					$newimg, $oldimg,
					($maxw - $nw)/2, ($maxh - $nh)/2,
					0, 0,
					$nw, $nh,
					$w, $h);
				imageDestroy($oldimg);
			} else {
				$newimg = imageCreate($maxw,$maxh);
				$imgbg  = ImageColorAllocate($newimg, 0xFF, 0xFF, 0xFF);
			}
			imagePng($newimg);
			// write thumbnail to cachefile
			if($caching) {
				imagePng($newimg, $cachefile);
			}

			imageDestroy($newimg);
		}

		//png in most cases better
		header('Content-Type: image/png');
	} catch (Exception $e) {
		echo $e->getMessage();
	}

	// end script - no further output
	exit;
break;
//^^thumb^^


//__tree__
case 'tree':
// directories: tree view
$title = $l['title']['tree'];

	//if no dir was passed, use home instead
	$dir = isset($MFP['dir']) ? $MFP['dir'] : HOME;
	if (!allowed($dir)) $dir = HOME;

	try {
		$dir = new mfp_dir($dir);

		// the actual depth of directory tree
		$maxlevel = 0;

		// walk through directories recursive
		// returns list of directories in current dir
		// now sortable! guess it works even better than tree-like-array for now
		function buildTreeList($dir, $depth = 0) {
			if(file_exists($dir)) {
				global $maxlevel;
				static $nowlevel = 0;
				static $dirs = array();

				$nowlevel++;
				// set new maximum depth
				$maxlevel = $maxlevel < $nowlevel ? $nowlevel : $maxlevel;

				if(is_readable($dir)) {
					$handle = opendir($dir);
					// maximum depth already reached, or no limit?
					if($nowlevel <= $depth || $depth === 0) {
						while($file = readdir($handle)) {
							//don't fetch . and ..
							if($file != '.' && $file != '..') {
	
								$path = $dir.'/'.$file;
								if(is_dir($path)) {
	
									// set directory info
									$dirs[$path] = array (
										'name'  => $file,
										'level' => $nowlevel,
										'fileCount' => 0,
									);
	
									//descend deeper
									buildTreeList($path, $depth);
	
									//level down -in logical structure up
									$nowlevel--;
								} // no directory: file, link > increase counter
								#$dirs[$path]['fileCount']++;
							} // . and ..
						}
					}
					@closedir($handle);
				}
				return $dirs;
			} else {
				printf('<br><br>'.$GLOBALS['l']['err']['baddir'], '<var class="dir">'.$dir.'</var>');
			}
		}

		// WIP!!! // not working
		//
		// $tree = array(name => null, name => array(), name => array(name => array(), name => null));
		//
		// returns multidimenional array with directoy-like structure
		function buildTree($dir, $depth = 0) {

			if(file_exists($dir)) {
				global $level;
				// current level of recursion
				static $nowlevel;
				$tree = array();

				$nowlevel++;

				$handle = @opendir($dir);
				//maximum depth already reached, or infinite recursion?
				if($nowlevel <= $depth || $depth === 0) {
					//read directory
					while($file = @readdir($handle)) {
						$path = $dir.'/'.$file;

						//check if directory
						if(is_dir($path)) {
							//don't fetch . and ..
							if($file != '.' && $file != '..') {

								//fill array
								$tree[HOME . pathTo($path)] = buildTree($path, $depth);

								//level down -in logical structure up
								$nowlevel--;
							}
						//no directory: file, link or . and ..
						}
					}
				}
				@closedir($handle);

				// fill complete return array
				return $tree;
			} else {
				printf('<br><br>'.$GLOBALS['l']['err']['baddir'], '<var class="dir">'.$dir.'</var>');
			}

		}

		// print header line
		// watch out, tricky torn apart tags due to nested lists
		?>
	<div id="fix" style="text-align:center;">
		<a href="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode(HOME));?>" title="<?=$l['home']?>"><img src="<?=img('home')?>" width="16" height="16" alt="<?=$l['home']?>"></a>
		<a href="<?=dosid(htmlspecialchars(URI));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
	</div>

	<div id="scroll">
		<ul width="100%" class="tree">

			<li class="home">
				<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode(HOME))?>" target="view" title="<?=$l['home']?>">Home [<?=htmlspecialchars(basename(realpath(HOME))) ?>]</a>
			<?
			if($dir->realpath() != REALHOME) {
				$breadcrumbs = $dir->breadcrumbs();
				echo '<ul>'; // ordered list???

				foreach($breadcrumbs as $path) {
					$path = HOME . $path;
				?>
				<li><a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($path))?>" target="view" title="<?=$l['changedir']?>"><?=htmlspecialchars(basename(realpath($path)))?></a></li>
				<?
				}
			?>
			</ul>
			</li>
			<li class="home">
				<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir))?>" target="view" title="<?=$l['changedir']?>"><?=htmlspecialchars(basename($dir->realpath())) ?></a>
		<?
			}

		// open requested dir and sort by keys
		$dirs = buildTreeList($dir, $treeDepth);
		ksort($dirs);

		// formatted output with lists, saves tables...
		$prevlevel = 0;
		if($dirs) {
			foreach($dirs as $path => $info) {
				// 0: same level/parent -: to parent level +: to child level
				$level = $prevlevel > $info['level'] ? -1 :
								($prevlevel < $info['level'] ? 1 : 0);
				// create nesting
				switch($level) {
					case 1: echo '<ul>';
					break;
					case -1: echo '</li></ul>';
					// no break!
					default: echo '</li>';
				}
				?>
				<li><a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($path))?>" target="view" title="<?=$l['changedir']?>"><?=htmlspecialchars($info['name'])?></a>
				<?
				$prevlevel = $info['level'];
			}
			// add missing closing tags | got it working :)
			for($prevlevel; $prevlevel > 0; $prevlevel--) {
				echo '</li></ul>';
			}
		} else {
			echo '<ul><li>&nbsp;&nbsp;';
			echo $l['err']['nodirs'];
			echo '</li></ul>';
		}
		echo '</li></ul>', '</div>';
	} catch(Exception $e) {
		echo $e->getMessage();
	}

break;
//^^tree^^

//__up__
case 'up':
// file upload
$title = $l['title']['up'];
?>

<center id="scroll">
<div class="box" style="margin-top:2em;">
<h3><img src="<?=img('upload')?>" width="16" height="16" alt="<?=$l['upload']?>"> <?=$title?></h3>

<?
// sent form
try {
	if(isset($MFP['upload'])) {

		$dir = new mfp_dir($MFP['dir']);
		// overwrite existing files?
		$overwrite = isset($MFP['over']);

		if(!allowed($dir)) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.$dir.'</var>'));

		echo '<ul>';

		$uploadedFilesCount = count($_FILES['file']['name']);
		for($i=0; $i < $uploadedFilesCount; $i++) {
			$remotename = &$_FILES['file']['name'][$i];
			$tmpname    = &$_FILES['file']['tmp_name'][$i];
			$newname    = $dir.'/'.$remotename;

			$filesize = &$_FILES['file']['size'][$i];
			$filetype = &$_FILES['file']['type'][$i];

			$errorcode = &$_FILES['file']['error'][$i];

			try {
				switch($errorcode) {
					case UPLOAD_ERR_NO_FILE:
						throw new Exception($l['err']['up']['nofile']);
					break;
					case UPLOAD_ERR_INI_SIZE:
						throw new Exception($l['err']['up']['toobig']);
					break;
					case UPLOAD_ERR_PARTIAL:
						throw new Exception($l['err']['up']['partially']);
					break;
	
					case UPLOAD_ERR_OK:
						if(file_exists($newname) && !$overwrite) throw new Exception(sprintf($l['err']['fileexists'], '<var><a href="'.  htmlspecialchars(directLink($newname)) .'" target="_blank">'. wrap(htmlspecialchars(pathTo($newname))) .'</a></var>', getfsize(filesize($newname))));

						if(!move_uploaded_file($tmpname, $newname)) throw new Exception(sprintf($l['err']['unexpected'], $errorcode));

						echo '<li class="file">', sprintf($l['ok']['up'],
								'<var><a href="'. htmlspecialchars(directLink($newname))
								.'" target="_blank">'. wrap(htmlspecialchars(pathTo($newname))) .'</a></var>',
								getfsize($filesize));
						echo '<br>';
						printf(ucfirst($l['filetype']).'<br>', '<var>'.$filetype.'</var>');
					break;
					default:
						echo $l['err']['up']['unknown'];
				}
			} catch(Exception $e) {
				echo '<li class="error">',$e->getMessage();
			}
			echo '</li>';
		}
		?>
		</ul>
		<script type="text/javascript" language="JavaScript">
		<!--
			opener.location.reload();
		//-->
		</script>
		<div class="footer">
		<input type="button" onClick="history.back();" value=" <?=$l['back']?> ">
		&nbsp;<input type="button" onClick="window.close();" value=" <?=$l['close']?> ">
		</div>
		<?
	} else {
	$url_dir = urlencode($MFP['dir']);
	$wrappedpath = wrap(htmlspecialchars(pathTo($MFP['dir']).'/'));
	?>
		<center>
		<form enctype="multipart/form-data" method="post" action="<?=dosid(SELF.'?a=up')?>" name="upform">
			<script type="text/javascript" language="JavaScript">
			<!--
				function addField() {
					if(document.getElementById) {
						var br = document.createElement('br');
						var nField = document.createElement('input');
							nField.name = 'file[]';
							nField.type = 'file';
							nField.size = '40';
						var par = document.getElementById("ups");
						par.appendChild(nField);
						par.appendChild(br);
					} else {
						add('ups', '\n<input type="file" name="file[]" size="40"><br>');
					}
				}
			//-->
			</script>

<?#dom editing?>
			<input type="hidden" name="dir" value="<?=htmlspecialchars($MFP['dir'])?>">
	
			<?printf($l['uploadto'],
				'<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;dir='.$url_dir)
				.'" target="_blank">'.$wrappedpath.'</a></var>'
			)?>:<br>
			<div id="ups"><input type="file" name="file[]" size="40"><br></div>
	
			<div <?=(IE)? 'class="footer"': 'id="fix"'?>>
				<input type="button" value="<?=$l['add']?>" onClick="addField()">
				<input type="submit" name="upload" value=" <?=$l['upload']?> ">&nbsp;
				<input type="button" value=" <?=$l['cancel']?> " onClick="window.close();">&nbsp;
				<label for="over"><input type="checkbox" name="over" id="over"><?=$l['overwrite']?></label>
			</div>
		</form>
	<? }
	} catch(Exception $e) {
		echo $e->getMessage();
	} ?>
</center>
</div>
</center>

<?
break;
//^^up^^

//__user__
case 'user':
	$title = 'user preferences';

	$olduser  = $accounts[$user];
	$username = $user;
	$curpwd   = $olduser['pass'];
	$curhome  = $olduser['home'];
	$curlang  = $olduser['lang'];
	$curtheme = $olduser['theme'];

	$langs = array();
	$themes = array();

	// open directory and read it :: langs
	$dir = $langdir;
	$dh = @opendir($dir);
	while($file = @readdir($dh)){
		if(is_file($dir. '/' .$file)) {
		if(strpos($file, '.ini.php') !== FALSE) {
			$langs[] = substr($file, 0, -8);
		}
		}
	}
	// open directory and read it :: themes
	$dir = $themedir;
	$dh = @opendir($dir);
	while($file = @readdir($dh)){
		if(is_file($dir. '/' .$file)) {
		if(strpos($file, '.ini.php') !== FALSE) {
			$themes[] = substr($file, 0, strpos($file, '.'));
		}
		}
	}

	// putting current prefs first and sort list
	// avoids checking for selected value while looping
	unset($langs[array_search($curlang, $langs)]);
	sort($langs);
	array_unshift($langs, $curlang);

	unset($themes[array_search($curtheme, $themes)]);
	sort($themes);
	array_unshift($themes, $curtheme);
?>


<center id="fix"><b><?=$l['cust']?></b></center>
<center id="scroll">

<?
$newuser = $olduser;

if(isset($MFP['password'])) {
	echo 'editing passsword<br>';
	if(isset($MFP['oldpwd'], $MFP['newpwd'][0], $MFP['newpwd'][1])
		&& ($MFP['oldpwd'] && $MFP['newpwd'][0] && $MFP['newpwd'][1])) {
		echo 'all set<br>';
		#echo $MFP['oldpwd'];
		#echo $accounts[$user]['pass'];
		if(sha1($MFP['oldpwd']) == $curpwd) {
			echo 'old pwd correct<br>';
			if($MFP['newpwd'][0] == $MFP['newpwd'][1]) {
				echo 'new pwds identical<br>';
				$newpwd = sha1($MFP['newpwd'][0]);
				$newuser['pass'] = $newpwd;
			} else {
				echo 'new pwds differ<br>';
			}
		} else {
			echo 'old pwd is incorrect<br>';
		}
	} else {
		echo 'some field empty<br>';
	}

} elseif(isset($MFP['username'])) {
	echo 'editing username<br>';
	if(isset($MFP['newusername'])) {
		echo 'new username: ', $MFP['newusername'], '<br>';
	} else {
		echo 'no user name<br>';
	}
} elseif(isset($MFP['homedir'])) {
	echo 'editing homedir<br>';
	if(isset($MFP['newhomedir'])) {
		echo 'new homedir: ', $MFP['newhomedir'], '<br>';
	} else {
		echo 'no home dir<br>';
	}
} elseif(isset($MFP['customize'])) {
	echo 'customizing<br>';
	if(isset($MFP['newlang'], $MFP['newtheme'])) {
		echo 'both set<br>';
		echo '<ul>';
		echo '<li>', $MFP['newlang'],'</li>';
		echo '<li>', $MFP['newtheme'],'</li>';
		echo '</ul>';
		$newuser['lang'] = $MFP['newlang'];
		$newuser['theme'] = $MFP['newtheme'];

		//set new language, session and reload page for changes to take place
		$_SESSION['mfp_lang'] = $newuser['lang'];
		//set new theme, session and reload page for changes to take place
		$_SESSION['mfp_theme'] = $newuser['theme'];

		#echo '<link rel="stylesheet"  type="text/css" href="',dosid(SELF.'?a=css'),'">';
		// no &amp; !!
		header('Location: '.dosid(URI, '&'));
	} else {
		echo 'not set<br>';
	}
}

$newaccounts = $accounts;
$newaccounts[$username] = $newuser;

#echo '$accounts = ', var_export($newaccounts), ';';

?>

	<!-- -- >

	<form method="post" action="<?=dosid(htmlspecialchars(URI))?>">
	<div class="box">
	<h3><img src="<?=img('user')?>" alt="<?=$l['user']?>"> <?=$l['user']?></h3>
		<input type="text" name="newusername" value="<?=$username?>"> <?=$l['user']?>
	<div class="footer"><input type="submit" name="username" value="ok"></div>
	</div>
	</form>

	<form method="post" action="<?=dosid(htmlspecialchars(URI))?>">
	<div class="box">
	<h3><img src="<?=img('home')?>" alt="<?=$l['home']?>"> <?=$l['home']?></h3>
		<input type="text" name="newhomedir" value="<?=$curhome?>"> <?=$l['home']?>
	<div class="footer"><input type="submit" name="homedir" value="ok"></div>
	</div>
	</form>

	<form method="post" action="<?=dosid(htmlspecialchars(URI))?>">
	<div class="box">
	<h3><img src="<?=img('pwd')?>" alt="<?=$l['pwd']?>"> <?=$l['pwd']?></h3>
		<table>
		<tr>
			<td><input type="password" name="oldpwd"></td>
			<td>old <?=$l['pwd']?></td>
		</tr>
		<tr>
			<td><input type="password" name="newpwd[]"></td>
			<td>new <?=$l['pwd']?></td>
		</tr>
		<tr>
			<td><input type="password" name="newpwd[]"></td>
			<td>confirm <?=$l['pwd']?></td>
		</tr>
		</table>

	<div class="footer"><input type="submit" name="password" value="ok"></div>
	</div>
	</form>
	<!--  -->

	<form method="post" action="<?=dosid(htmlspecialchars(URI))?>">
	<div class="box">
	<h3><img src="<?=img('thumbs')?>" alt="<?=$l['cust']?>"> <?=$l['cust']?></h3>
		<dl class="aligned">
			<dt><label for="newlang"><?=$l['lang']?></label></dt>
			<dd>
			<select size="0" name="newlang" id="newlang">
			<? foreach($langs as $lang) {
					echo '<option>',$lang,'</option>';
				 } ?>
			</select>
			</dd>

			<dt><label for="newtheme">colors</label></dt>
			<dd>
			<select size="0" name="newtheme" id="newtheme">
			<?
			foreach($themes as $theme) {
				echo '<option>',$theme,'</option>';
			}
			?>
			</select>
			</dd>
		</dl>
	<div class="footer"><input type="submit" name="customize" value="ok"></div>
	</div>
	</form>

 <!-- -- >
	<hr>

	<form method="post" action="<?=dosid(htmlspecialchars(URI))?>">
	<fieldset class="box">
	<legend><img src="<?=img('user')?>" alt="<?=$l['user']?>"> <?=$l['user']?></legend>
		<input type="text" name="newusername" value="<?=$username?>"> <?=$l['user']?>
	<div class="footer"><input type="submit" name="username" value="ok"></div>	</fieldset>
	</form>
<!--  -->

</center>

<?
break;
//^^user^^

//__view__
case 'view':
// view single directories
	$title = $l['title']['view'];

	// if no dir was passed, use homedir instead
	$dir = isset($MFP['dir']) ? $MFP['dir'] : HOME;

	// create mfp_dir object
	try {
		$dir = new mfp_dir($dir);

		// sorting values | default: by name ascending
		$sort = isset($MFP['sort']) ? $MFP['sort'] : '+name';
		$sortby = substr($sort,1);

		// initiate objects
		$viewdirs = new mfp_dirs();
		$viewfiles = new mfp_files();

		// open directory and read it
		if(is_readable($dir)) {
			$dir->opendir();
			while($file = $dir->readdir()) {
				if($file != '.' && $file != '..') {
					// take the huge overhead for instancing mfp_path for each file???
					$path = $dir.'/'.$file;
	
					if(allowed($path)) {
						if(is_dir($path)) {
							//directory
							$viewdirs->add(array(
								'name'  => $file,
								'path'  => ($path),
								'mtime' => filemtime($path),
								'perm'  => fileperms($path)%01000
							));
	
						} else {
							//other(file, link)
							$viewfiles->add(array(
								'name' => $file,
								'path' => ($path),
	
								'size'  => filesize($path),
								'mtime' => filemtime($path),
								'perm'  => fileperms($path)%01000
							));
						}
					}
				}
			}
			$dir->closedir();
		}

		// init current dir
		$nowdir = HOME . pathTo($dir);
		$thisdir = ($nowdir);

		// realupdir: for checking allowance
		// to avoid problems when home dir is webroot or even real root
		$realupdir = @realpath($thisdir.'/..');
		// updir: for link generation
		$updir = HOME . pathTo($realupdir);


		$breadcrumbs = $dir->breadcrumbs();
		if($dir->realpath() != REALHOME) { array_push($breadcrumbs, $dir->getCleanPath()); }

		$url_dir = urlencode($dir);
	?>

	<script type="text/javascript" language="JavaScript">
	<!--
		function chkform() {
				if(document.forms.quickform.filename.value == '') {
					alert("<?=$l['err']['emptyfield']?>");
					return false;
				}
				popUp('<?=dosid(SELF.'?a=new')?>', 'newwin');
				return true;
		}
	//-->
	</script>

	<!-- quick access panel, fixed -->
	<div id="fix">
	<form name="quickform" method="post" action="<?=dosid(SELF.'?a=new')?>" onSubmit="return chkform(); return false;" target="newwin" accept-charset="<?=$charset?>">
		<input type="hidden" name="dir" value="<?=htmlspecialchars($thisdir)?>">

			<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.$url_dir)?>" title="<?=$l['viewgallery']?>"><img src="<?=img('thumbs')?>" width="16" height="16" alt="<?=$l['viewgallery']?>"></a>
			<a href="<?=dosid(SELF.'?a=find&amp;dir='.$url_dir)?>" title="<?=$l['find']?>"><img src="<?=img('find')?>" width="16" height="16" alt="<?=$l['find']?>"></a>
			<a href="<?=dosid(htmlspecialchars(URI));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
			<a href="<?=dosid(SELF.'?a=up&amp;dir='.$url_dir)?>" onClick="popUp(this.href, 'upwin', 'width=460,height=200,status=yes'); return false;" title="<?=$l['uploadfile']?>"><img src="<?=img('upload')?>" width="16" height="16" alt="<?=$l['upload']?>"></a>
			|
			<input id="quicktext" type="text" name="filename" maxlength="255" size="45">
			<label for="file" title="<?=$l['createnewfile']?>"><input type="radio" name="what" value="file" id="file">
			<img src="<?=img('newfile')?>" width="16" height="16" alt="<?=$l['file']?>"> [<?=$viewfiles->count()?> | <?=getfsize($viewfiles->size())?>]&nbsp;</label>
			<label for="dir" title="<?=$l['createnewdir']?>"><input type="radio" name="what" value="dir" id="dir" checked>
			<img src="<?=img('newdir')?>" width="16" height="16" alt="<?=$l['dir']?>"> [<?=$viewdirs->count()?>]</label>
			<input type="submit" name="create" value="<?=$l['new']?>">
			|
			<a href="<?=dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['view']?>"><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']['list']?>"></a>
			[<?=count($_SESSION['mfp_clipboard'])?>]
			<a href="<?=dosid(SELF.'?a=clip&amp;copy&amp;dir='.$url_dir);?>"  onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['copy']?>"><img src="<?=img('copy')?>" width="16" height="16" alt="<?=$l['copy']?>"></a>
			<a href="<?=dosid(SELF.'?a=clip&amp;move&amp;dir='.$url_dir);?>"  onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['move']?>"><img src="<?=img('move')?>" width="16" height="16" alt="<?=$l['move']?>"></a>
	</form>
	</div>

	<div id="scroll">
	<form name="form" method="post" action="<?=dosid(SELF.'?a=multi&amp;dir='.$url_dir)?>" onSubmit="popUp(action, 'multiwin');" target="multiwin" accept-charset="<?=$charset?>">

		<div class="breadcrumbs">
			<img src="<?=img('dir')?>" width="16" height="16" alt="<?=$l['dir']?>">&nbsp;
			<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode(HOME))?>" title="<?=$l['changedir']?>"><?=basename(REALHOME)?>/</a>
		<?
		foreach($breadcrumbs as $path) {
			$path = HOME . $path;
		?>
			<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($path))?>" title="<?=$l['changedir']?>"><?=basename($path)?>/</a>
		<? } ?>
		</div>

		<table rules="groups">
		<colgroup>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col <?=$sortby == 'name' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?=$sortby == 'size' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?=$sortby == 'size' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?=$sortby == 'perm' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?=$sortby == 'mtime' ? 'style="background:'.$c['o'].';"' : ''?>>
		</colgroup>

<?	//sorting buttons?>
		<thead>
			<tr class="toprnd c">
				<th><input type="checkbox" name="toggle_top" onclick="toggleAll(this, 'chks'); this.form.toggle_bottom.checked = this.checked;"></th>
				<td colspan="6"></th>
				<td class="toprnd" <?=$sortby == 'name' ? 'class="marked"' : ''?>>
					<a href="<?=dosid(SELF.'?a=view&amp;sort=+name&amp;dir='.$url_dir)?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="^"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-name&amp;dir='.$url_dir)?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="v"></a></th>
				<td colspan="2" <?=$sortby == 'size' ? 'class="marked"' : ''?>>
					<a href="<?=dosid(SELF.'?a=view&amp;sort=+size&amp;dir='.$url_dir)?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="^"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-size&amp;dir='.$url_dir)?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="v"></a></th>
				<td <?=$sortby == 'perm' ? 'class="marked"' : ''?>>
					<a href="<?=dosid(SELF.'?a=view&amp;sort=+perm&amp;dir='.$url_dir)?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="^"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-perm&amp;dir='.$url_dir)?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="v"></a></th>
				<td <?=$sortby == 'mtime' ? 'class="marked"' : ''?>>
					<a href="<?=dosid(SELF.'?a=view&amp;sort=+mtime&amp;dir='.$url_dir)?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="^"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-mtime&amp;dir='.$url_dir)?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="v"></a></th>
			</tr>

<?	// parent dir link
		if($realupdir !== FALSE && allowed($realupdir)) { ?>
			<tr class="l o" style="border-bottom:1px solid <?=$c['border']['dark']?>;">
				<th></th>
				<th></th>
				<th></th>
				<th><a href="<?=dosid(SELF.'?a=rem&amp;dir='.$url_dir);?>" onClick="popUp(this.href, 'remwin'); return false;" title="<?=$l['removedir']?>"><img src="<?=img('rem')?>" width="16" height="16" alt="<?=$l['removedir']?>"></a></th>
				<th><a href="<?=dosid(SELF.'?a=ren&amp;path='.$url_dir)?>" title="<?=$l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['renamedir']?>"></a></th>
				<th></th>
				<th><a href="<?=dosid(SELF.'?a=tree&amp;dir='.$url_dir)?>" title="<?=$l['viewdir']?>" target="tree"><img src="<?=img('tree')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a></th>
				<th><a href="<?= dosid(SELF.'?a=view&amp;dir='.urlencode($updir)) ?>" title="<?=$l['up']?>" class="rnd"><img src="<?=img('dirup')?>" width="16" height="16" alt="<?=$l['up']?>"> ..</a></th>

				<th></th><th></th>
				<th></th><th></th>
			</tr>
		<? } // /check for root ?>
		</thead>
		<tfoot>
		<tr>
			<td><input type="checkbox" name="toggle_bottom" onclick="toggleAll(this, 'chks'); this.form.toggle_top.checked = this.checked;"></td>
			<td colspan="11">
			<button type="submit" name="down"><img src="<?=img('download')?>" alt="<?=$l['download']?>"></button>
			<button type="submit" name="del"><img src="<?=img('del')?>" alt="<?=$l['delete']?>"></button>
			<button type="submit" name="ren"><img src="<?=img('ren')?>" alt="<?=$l['rename']?>"></button>
			<button type="submit" name="src"><img src="<?=img('src')?>" alt="<?=$l['src']?>"></button>
			<!-- <button type="submit" name="mod"><img src="<?=img('perms')?>" alt="<?=$l['editperms']?>"></button> -->
		</tr>
		<tr>
			<td></td>
			<td colspan="11">
			<button type="submit" name="add"><img src="<?=img('clipadd')?>" width="16" height="16" alt="<?=$l['clip']['add']?>"></button>
			<button type="submit" name="sub"><img src="<?=img('clipsub')?>" width="16" height="16" alt="<?=$l['clip']['sub']?>"></button>
			<a href="<?=dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['view']?>"><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']['list']?>"> list</a>
		</tr>
		</tfoot>
		
		<tbody>
		<?
		$viewdirs->sort($sort);
		$viewdirs->printout();

		//spacing + ruler
		?>
		</tbody>
		<tbody>
		<?
		$viewfiles->sort($sort);
		$viewfiles->printout() ?>
		</tbody>

		</table>
	</form>
	</div>

	<?
	} catch(Exception $e) {
		echo $e->getMessage();
	}
break;
//^^view^^


//__default__
default:

//(i)frameset
$title = $l['title']['default']. ' | '. RELHOME. '/';

$dir = isset($MFP['dir']) ? $MFP['dir'] : HOME;
?>

<style type="text/css">
<!--
		body { min-width:480px; min-height:240px; }
-->
</style>

<div class="box full">
<h2 style="margin-bottom:0;">
<a href="<?=dosid(SELF.'?a=user')?>" title="<?=$l['cust']?>" onClick="popUp(this.href, 'userwin', 'width=400,height=200'); return false;"><?=htmlspecialchars($user)?></a> <a href="<?=dosid(SELF.'?a=logout')?>" title="<?=$l['logout']?>"><img src="<?=img('exit')?>" width="16" height="16" alt="<?=$l['logout']?>"></a>
<a href="<?=dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>" onClick="popUp(this.href, 'helpwin', 'width=400,height=400'); return false;"><img src="<?=img('help')?>" width="16" height="16" alt="<?=$l['help']?>"></a>
|
<a href="<?=dosid(SELF)?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
<a href="<?=dosid(SELF.'?a=info')?>" title="<?=$l['info']?>" onClick="popUp(this.href, 'infowin', 'width=450,height=400'); return false;"><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['info']?>"></a>
<img src="<?=img('drive')?>" width="16" height="16" alt="">
<? //free space
	//bytes:
	$freespace = @disk_free_space(HOME);
	$location  = htmlspecialchars(pathTo(HOME, $_SERVER['DOCUMENT_ROOT']) . '/');

	//format and output
	printf($l['freespace'], getfsize($freespace), '<var class="dir">'.$location.'</var>');
?>
</h2>

	<? if($tree) {?><iframe src="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode($dir))?>" height="90%" width="20%" name="tree" frameborder="0">Browser needs to understand inlineframes</iframe><?}?><iframe src="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir))?>" height="90%" width="<?=$tree?80:100?>%" name="view" frameborder="0">
	Browser needs to understand inlineframes<br>
	<a href="<?=dosid(SELF.'?a=view')?>">Load only directory view without tree view</a></iframe>

</div>
<?
//^^default^^
}

} else {
// no login yet
$title = $l['title']['login'];

$user = &$MFP['user'];

	if(isset($MFP['login'])) {
		try {
			$pass = &$accounts[$user]['pass'];
			if(!isset($pass)) throw new Exception(sprintf($l['err']['baduser'], $user));
			if(sha1($MFP['pwd']) != $pass) throw new Exception($l['err']['badpass']);

			@include('./' . $langdir . '/' . $accounts[$user]['lang'] . '.ini.php');

			// auth session vars
			$_SESSION['mfp_user'] = $user;
			$_SESSION['mfp_pass'] = $pass;
			$_SESSION['mfp_hash'] = md5($user. $hashkey .$pass);

			// init
			$_SESSION['mfp_clipboard'] = array();
			$_SESSION['mfp_find'] = array();

			$_SESSION['mfp_ip'] = ip2hex($_SERVER['REMOTE_ADDR']);

			header('Location: '.dosid(URI, '&'));

			echo $l['ok']['granted'],"<br>\n";
			echo '<a href="',dosid(URI),'">Click here if you aren\'t redirected automatically</a>';

		} catch(Exception $e) {
			echo '<div style="text-align:center;">';
				echo '<div class="box login"><h3>ERROR</h3>',
				$e->getMessage(),
				'</div></div>';
		}


	}# else {
		// do not append sid on first call of page (a is empty)
		$action = htmlspecialchars(URI); #urlencode(URI)
		if(empty($a)) $action = dosid($action);
	?>
	<!-- -->
		<hr>
		<div style="text-align:center;">
		<div class="box login">
		<h3><!-- <img src="<?=img('water')?>" alt="myftphp"> --><a href="<?=dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>"  onClick="popUp(this.href, 'helpwin', 'width=400,height=400'); return false;"><img src="<?=img('help')?>" width="16" height="16" alt="<?=$l['help']?>"></a> <?=$l['login']?></h3>
			<form method="post" action="<?=$action?>" accept-charset="<?=$charset?>">
			<div><img src="<?=img('user')?>" width="16" height="16"  alt="<?=$l['user']?>">
			<input type="text" name="user" size="40"></div>
			<div><img src="<?=img('pwd')?>" width="16" height="16" alt="<?=$l['pwd']?>">
			<input type="password" name="pwd" size="40"></div>
			<div><img src="<?=img('enter')?>" width="16" height="16"  alt="<?=$l['login']?>">
			<input type="submit" name="login" value="<?=$l['login']?> "></div>
		</form>
		</div>
		</div>
		<hr>

	<?
	#}
}
}

?>

<? // get output buffer
$buffer = ob_get_contents();
ob_end_clean();
?>
<html>
<head>
	<title> [myFtPhp]&nbsp;&nbsp;<?=isset($title) ? $title : ''?> </title>
	
	<meta name="Author" content="knittl">
	<meta name="OBGZip" content="<?=function_exists('ob_gzhandler')?>">
	<meta http-equiv="Content-Type" content="text/html; charset=<?=$charset?>">
	
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?=dosid(SELF.'?a=css')?>" title="myFtPhp: <?=$theme?>">
<?if(IE) { // double check for IE | hack for IE 7 'coz of quirks-mode?>
<!--[if lt IE 8]><style type="text/css">
	@media screen {
		html, body { height:100%; overflow:hidden; }

		#scroll { padding:0px; margin:0px; height:90%; width:100%; overflow:auto; }
		#scroll * { position:static; }
	}
</style><![endif]-->
<?}?>
<script type="text/javascript">
<!--
	function popUp(url, name, size) {
		var xy = 'left=200,top=100';
		if(!size) size = 'width=360,height=220';
		var win = window.open(url, name, xy + ",resizable=yes,scrollbars=yes," + size);
		win.focus();
	}

	// sets status of fromObj to all name[] checkboxes
	function toggleAll(fromObj, name, form) {
		var form = this.document.forms[form] || this.document.forms['form'];
		if(form[name+'[]']) {
			if(form[name+'[]'].length) {
				for(i=0;i<form[name+'[]'].length;i++) {
					form[name+'[]'][i].checked = fromObj.checked;
				}
			} else {
				form[name+'[]'].checked = fromObj.checked;
			}
		}
	}

	//hides (error) boxes
	// see cvs

	// adds content (eg textfield) ~070405
	// ---
	// doesnt really work
	// see old revision for code of both :)

//-->
</script>

</head>

<body>
<?
	// print buffer
	print($buffer);
?>
<!--
	generated on: <?=@date($l['fulldate'])?> 
	generated in: <?=microtime(TRUE)-$mfp_starttime?> sec.
-->
</body>
</html>
<? // send length of compressed page, important for gay browsers
header("Content-Length: " . ob_get_length());
// end compressed buffer
ob_end_flush();
exit;?>