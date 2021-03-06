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
//   * caveat: totally not working with symlinks to files not in HOME
//


define('IN_MFP', TRUE);

// donotchange
///////////////////////
error_reporting(E_ALL | E_STRICT);
set_error_handler('mfp_errorHandler');
#@date_default_timezone_set('Europe/Vienna');

// load configuration
require_once('myftphp.cfg.php');

// init debug buffer
$debug = '';
$errmsg = '';

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
		E_RECOVERABLE_ERROR => 'RECOVERABLE ERROR', // since php5.2
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
	require_once($GLOBALS['cfg']['dirs']['classes'].'/'.$class.'.php');
}


// dir/filelist classes
class mfp_dirs extends mfp_list {

	public function printout() {
		//print directories as table with alternating colored lines
		global $l;

		$i = 0;
		foreach($this->list as $dir) {
			$i++;
			$inclip = in_array($dir['path'], $_SESSION['mfp']['clipboard']);

			$class = ($i &1) ? 'o' : 'e';
			$clipped = $inclip? 'clip': '';
			$url_path = u($dir['path']);
			$url_name = h($dir['name']);
			$date     = @date($l['fulldate'], $dir['mtime']);
		?>
		<tr class="l <?php echo $class?> <?php echo $clipped?>">
		<td></td>
		<td></td>
		<td><a href="<?php echo dosid(SELF.'?a=props&amp;p='.$url_path)?>" title="<?php echo $l['props']?>" onClick="popUp(this.href, 'propswin', 'width=400,height=500'); return false;"><img src="<?php echo img('info')?>" class="ico" alt="<?php echo $l['props']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=rem&amp;d='.$url_path)?>" title="<?php echo $l['removedir']?>" onClick="popUp(this.href, 'remwin'); return false;"><img src="<?php echo img('rem')?>" class="ico" alt="<?php echo $l['removedir']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=ren&amp;p='.$url_path)?>" title="<?php echo $l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?php echo img('ren')?>" class="ico" alt="<?php echo $l['renamedir']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=gallery&amp;d='.$url_path)?>" title="<?php echo $l['viewgallery']?>"><img src="<?php echo img('thumbs')?>" class="ico" alt="<?php echo $l['thumb']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=tree&amp;d='.$url_path)?>" title="<?php echo $l['viewdir']?>" target="tree"><img src="<?php echo img('tree')?>" class="ico" alt="<?php echo $l['viewdir']?>"></a></td>
<?php ##?>
		<td><a href="<?php echo dosid(SELF.'?a=view&amp;d='.$url_path)?>" title="<?php echo $l['changedir']?>" class="rnd"><?php echo $url_name?></a></td>
		<td></td><td></td>
		<td><a href="<?php echo dosid(SELF.'?a=mod&amp;p='.$url_path)?>" title="<?php echo $l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><?php printf('%03o', $dir['perm'])?><img src="<?php echo img('perms')?>" class="ico" alt=""></a></td>
		<td><?php echo $date?></td></tr>

<?php
		}
	}
}

class mfp_files extends mfp_list {
	private $size = 0;

	public function add($file) {
		parent::add($file);
		$this->size += $file['size'];
	}

	public function printout($checkall = FALSE) {
		//print files and alternate lines
		global $l;

		$i = 0;
		foreach($this->list as $file) {
			$i++;
			$inclip = in_array($file['path'], $_SESSION['mfp']['clipboard']);

			list($size, $sizeunit) = getfsize($file['size'], TRUE);

			$class = ($i &1) ? 'o' : 'e';
			$clipped = $inclip? 'clip': '';
			$url_path   = u($file['path']);
			$directlink = directLink($file['path']);
			$hasLink    = pathTo(fullpath($file['path']), WEBROOT) != '';
			$url_name   = h($file['name']);
			$date       = @date($l['fulldate'], $file['mtime']);
		?>
		<tr class="l <?php echo $class?> <?php echo $clipped?>">
		<td><input type="checkbox" name="chks[]" id="chk<?php echo $i?>" value="<?php echo h($file['name'])?>" <?php echo $checkall?'checked':''?>></td>
		<td><a href="<?php echo dosid(SELF.'?a=down&amp;p='.$url_path)?>"  onClick="popUp(this.href, 'downwin'); return false;"  title="<?php echo $l['download']?>"><img src="<?php echo img('download')?>" class="ico" alt="<?php echo $l['download']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=props&amp;p='.$url_path)?>" title="<?php echo $l['props']?>" onClick="popUp(this.href, 'propswin', 'width=400,height=500'); return false;"><img src="<?php echo img('info')?>" class="ico" alt="<?php echo $l['props']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=del&amp;p='.$url_path)?>" title="<?php echo $l['deletefile']?>" onClick="popUp(this.href, 'delwin'); return false;"><img src="<?php echo img('del')?>" class="ico" alt="<?php echo $l['delete']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=ren&amp;p='.$url_path)?>" title="<?php echo $l['renamefile']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?php echo img('ren')?>" class="ico" alt="<?php echo $l['rename']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=edit&amp;p='.$url_path)?>" title="<?php echo $l['editcode']?>" onClick="popUp(this.href, 'editwin', 'width=640,height=480'); return false;"><img src="<?php echo img('edit')?>" class="ico" alt="<?php echo $l['edit']?>"></a></td>
		<td><a href="<?php echo dosid(SELF.'?a=src&amp;p='.$url_path)?>" title="<?php echo $l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?php echo img('src')?>" class="ico" alt="<?php echo $l['src']?>"></a></td>
<?php if($hasLink) { ?>
		<td><a href="<?php echo $directlink?>" title="<?php echo $l['viewfile']?>" target="_blank" class="rnd"><?php echo $url_name?></a></td>
<?php } else { ?>
		<td><?php echo $url_name?></td>
<?php } ?>
		<td><?php echo $size?></td><td><?php echo $sizeunit?></td>
		<td><a href="<?php echo dosid(SELF.'?a=mod&amp;p='.$url_path)?>" title="<?php echo $l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><?php printf('%03o', $file['perm'])?><img src="<?php echo img('perms')?>" class="ico" alt=""></a></td>
		<td><?php echo $date?></td>
		</tr>

<?php
		}
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

// set session properties
// prefer cookies over SID in url
ini_set('session.use_cookies', TRUE);
ini_set('session.use_only_cookies', FALSE);
ini_set('session.cookie_httponly', TRUE);
ini_set('session.use_trans_sid', TRUE); # doesn't work. for now using dosid() !!!
// which tags to get SID
ini_set('url_rewriter.tags','a=href,frame=src,input=src,form=fakeentry,fieldset=');
// allow caching on clients, but not on proxies
session_cache_limiter('private');

session_name('myftphp');
session_start();
$mfp_user = &$_SESSION['mfp']['user'];
$mfp_on = isset($_SESSION['mfp']['hash']) && $_SESSION['mfp']['hash'] == md5($mfp_user.$cfg['hashkey'].$_SESSION['mfp']['pass']) && isset($_SESSION['mfp']['ip']) && $_SESSION['mfp']['ip'] == ip2hex($_SERVER['REMOTE_ADDR']);

// CONSTANTS
// alias for dir delimiter
define('DEL', DIRECTORY_SEPARATOR);
// gets magicquotes, scriptlink, and browser
define('MQUOTES', get_magic_quotes_gpc()); #!!!
define('SELF', $_SERVER['PHP_SELF']);
define('WEBROOT', $_SERVER['DOCUMENT_ROOT']);
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

// unescape if magic_quotes_gpc is set
if(MQUOTES) {
	array_walk_recursive($_REQUEST, create_function('&$item, $key', '$item = stripslashes($item);'));
}

// language initiation
$l = array();
$l['err']['badlang'] = 'Language "%s" does not exist!';

// language changed in session?
if(isset($_SESSION['mfp']['lang'], $mfp_user)
&& $_SESSION['mfp']['lang'] != $accounts[$mfp_user]['lang']) {
	// only allow files inside $cfg|dirs|langs
	if(strpos(realpath($cfg['dirs']['langs'].'/'.$_SESSION['mfp']['lang']), realpath($cfg['dirs']['langs'])) === 0)
		$accounts[$mfp_user]['lang'] = $_SESSION['mfp']['lang'];
}

$lang = init($accounts[$mfp_user]['lang'], 'english');
// load default/fallback language
@include($cfg['dirs']['langs'].'/english.ini.php');
if(!@include($cfg['dirs']['langs'].'/'.$lang.'.ini.php')) {
	die(sprintf($l['err']['badlang'], h($lang)));
}

// colors #RGB, #RRGGBB, rgb(rrr,ggg,bbb), color name - anything that works in css
$c = array();
$c['txt']        = '#111';
$c['bg']['main'] = '#EFF';

// theme changed in session?
if(isset($_SESSION['mfp']['theme'], $mfp_user)
&& $_SESSION['mfp']['theme'] != $accounts[$mfp_user]['theme']) {
	// only allow files inside $cfg|dirs|themes
	if(strpos(realpath($cfg['dirs']['themes'].'/'.$_SESSION['mfp']['theme']), realpath($cfg['dirs']['themes'])) === 0)
		$accounts[$mfp_user]['theme'] = $_SESSION['mfp']['theme'];
}

// TODO: just checking, including happens in __css__ (not yet)
$mfp_theme = init($accounts[$mfp_user]['theme'], 'light');
$themepath = $cfg['dirs']['themes'].'/'.$mfp_theme.'.ini.php';
#if(!(file_exists($themepath) && is_readable($themepath))) {
if(!@include($themepath)) {
	die(sprintf($l['err']['badtheme'], h($mfp_theme)));
}


// some helper functions, alphabetical order

// checks for subdir
function allowed($path) {
	return file_exists($path) && strpos(realpath($path), REALHOME) === 0;
}

// checks password against salted hash
function chkSaltedHash($pwd, $saltedhash) {
	list($hash, $salt) = explode(':', $saltedhash);
	return sha1($pwd.$salt) === $hash;
}

// creates salted hash from password
function createSaltedHash($pwd) {
	$salt = md5(uniqid(rand(), TRUE));
	return sha1($pwd.$salt).':'.$salt;
}

// directory delimiter to slash conversion
function del2slash($bstr) {
	return str_replace(DEL, '/', $bstr);
}

// creates full url ( http://www.domainname.tld/path/to/file )
// tries to clean path before (maybe i can remove that later)
function directlink($path) {
	// thx to vizzy
	return 'http://' . $_SERVER['HTTP_HOST'] .'/'. h(del2slash(pathTo(fullpath($path), WEBROOT)));
}

// adds session id
function dosid($uri, $amp = '&amp;') {
	$sid = SID;
	if(!empty($sid) && !preg_match('#'.session_name().'=#', $uri))
		$uri .= (strpos($uri, '?') !== FALSE ? $amp : '?'). $sid;
	return $uri;
}

// prepends HOME/ doesn't check anything
function fullpath($path) {
	return HOME.'/'.$path;
}

// returns css class: file|dir|link[|error|]
function getCssClass($path) {
	if(is_link($path)) return 'link';
	if(is_file($path)) return 'file';
	if(is_dir($path))  return 'dir';
	return 'error';
}

// formats filesize to a readable number
function getfsize($size, $array = FALSE) {
	static $prefixes = ' kmgtpe';
	$byte = &$GLOBALS['l']['byte'];

	$log = empty($size) ? 0 : (int)log(abs($size), K);
	$log = $log < strlen($prefixes) ? $log : strlen($prefixes)-1;
	$size /= pow(K, $log);
	$unit = trim($prefixes[$log]) ? $byte[$prefixes[$log]] : '';

	if($array) return array(sprintf('%02.2f', $size), $unit . $byte['b']);
	return sprintf('%02.2f&nbsp;%s%s', $size, $unit, $byte['b']);
}

// returns array of available languages
function getLangs() {
	$langs = array();
	// open directory and read it :: langs
	$dir = new mfp_dir_iterator($GLOBALS['cfg']['dirs']['langs']);
	foreach($dir as $file) {
		if(is_file($dir.'/'.$file)
		&& strpos($file, '.ini.php') == strlen($file)-8) {
			$langs[] = substr($file, 0, -8);
		}
	}
	return $langs;
}

// returns bytes without unit
function getrealsize($sizestr = '') {
	// first remove whitespaces
	$sizestr = str_replace(array(' ', "\t", "\r", "\n"), '', $sizestr);
	if(empty($sizestr)) return 0;

	$units['b'] = 1;
	$units['k'] = $units['kb'] = K;
	$units['m'] = $units['mb'] = M;
	$units['g'] = $units['gb'] = G;
	$units['t'] = $units['tb'] = T;
	$units['e'] = $units['eb'] = E;

	foreach ($units as $unit => $factor) {
		$unitlen = strlen($unit);
		if (strlen($sizestr) > $unitlen
		&& strtolower(substr($sizestr, -$unitlen)) == $unit)
			return substr($sizestr, 0, -$unitlen) * $factor;
	}

	// try casting to int
	return (int)$sizestr;
}

// returns array of available themes
function getThemes() {
	$themes = array();
	// open directory and read it :: themes
	$dir = new mfp_dir_iterator($GLOBALS['cfg']['dirs']['themes']);
	foreach($dir as $file) {
		if(is_file($dir.'/'.$file)
		&& strpos($file, '.ini.php') == strlen($file)-8) {
			$themes[] = substr($file, 0, -8);
		}
	}
	return $themes;
}

// returns full way to dir
function getTrack($to, $from = HOME) {
	$tmpTo = pathTo($to, $from);
	$toDirArray = array();

	// filling array in reversed order
	while($tmpTo = substr($tmpTo, 0, strrpos($tmpTo, DEL))) {
		array_unshift($toDirArray, $tmpTo);
	}

	return $toDirArray;
}

// shorthand for htmlspecialchars
function h($str) {
	return htmlspecialchars($str);
}

// initialize variables and set to default
function init(&$v, $default = NULL) {
	return isset($v) ? $v : $v = $default;
}

// compares if two relative paths point to the same file
function isSameFile($path1, $path2) {
	return realpath($path1) == realpath($path2);
}

// inserts image links
function img($img) {
	return $GLOBALS['cfg']['dirs']['imgs'] .'/'. $GLOBALS['cfg']['imglist'][$img];
}

// returns binary form of ip as hex
function ip2hex($ip) {
	return bin2hex(inet_pton($ip));
}

// error_log() wrapper
function mfp_log($message, $file = '', $type = 3, $extra_headers = '') {
	static $lastlogged = '';

	$file = $file ? $file : $GLOBALS['cfg']['files']['log'];

	// "group" error logs on a per file and run basis
	if($lastlogged != __FILE__) {
		// heading format: ":timestamp:URI:IP"
		$heading = ':'.time().':'.URI.':'.ip2hex($_SERVER['REMOTE_ADDR'])."\n";
		error_log($heading, $type, $file, $extra_headers);

		$lastlogged = __FILE__;
	}

	$message = "\t$message\n";
	error_log($message, $type, $file, $extra_headers);
}

// shows relative path from $home w/o beginning slash
function pathTo($path, $home = HOME) {
	// needs benchmarking - and security tests
	#return str_replace(realpath($home), '', realpath($path));
	$realpath = realpath($path);
	$realhome = realpath($home);
	if(strpos($realpath, $realhome) === 0)
		return substr($realpath, strlen($realhome)+1);
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
	$str .= (($mode & 0400) ? 'r' : '-')
	. (($mode & 0200) ? 'w' : '-')
	. (($mode & 0100) ?
			(($mode & 04000) ? 's' : 'x' ) :
			(($mode & 04000) ? 'S' : '-'));

	// group
	$str .= (($mode & 0040) ? 'r' : '-')
	. (($mode & 0020) ? 'w' : '-')
	. (($mode & 0010) ?
			(($mode & 02000) ? 's' : 'x' ) :
			(($mode & 02000) ? 'S' : '-'));

	// others
	$str .= (($mode & 0004) ? 'r' : '-')
	. (($mode & 0002) ? 'w' : '-')
	. (($mode & 0001) ?
			(($mode & 01000) ? 't' : 'x' ) :
			(($mode & 01000) ? 'T' : '-'));

	return $str;
}

// send location header and exit script
// no other operations on $url are performed
function redirect($url) {
	header('Location: '.$url);
	exit(); // fear the EAR
}

// shorthand for urlencode
function u($str) {
	return urlencode($str);
}

// wraps long strings
// using own function to handle htmlspecialchars properly (like &quot;)
// howto multibyte safe ??? problems if mb char gets split
function wrap($str, $at = 30, $del = '-<br>') {
	// remove extra split at end
	#return substr(chunk_split($str, $at, $del), 0,-strlen($del));
	#return wordwrap($str, $at, $del, TRUE);
	$wstr = '';
	$strlen = strlen($str);

	// no need to wrap
	if($at >= $strlen) return $str;

	$lastwrap = 0;
	$i = 0;
	while($i < $strlen) {
		$c = substr($str, $i, 1/*, 'UTF-8'*/);
		$wrap = FALSE;
		$lastwrap++;

		$wstr .= $c;
		// skip htmlspecialchars
		if($c == '&') {
			while($i < $strlen && $c != ';') {
				if($lastwrap % $at == 0) $wrap = TRUE;
				$c = $str{++$i}; // only singlebyte chars in htmlspecialchars
				$wstr .= $c;
			}
		}

		#$wstr.=$lastwrap;
		// add wrap-delimiter, but not at end ($i+1)
		if(($wrap || $lastwrap % $at == 0) && $i+1 < $strlen) {
			$wstr .= $del;
		}

		#$i += mb_strlen($c);
		$i++;
	}

	return $wstr;
}

// emu-functions for non-posix systems
function _posix_getpwuid($uid) {
	return function_exists('posix_getpwuid') ? posix_getpwuid($uid) : $uid;
}
function _posix_getgrgid($gid) {
	return function_exists('posix_getgrgid') ? posix_getgrgid($gid) : $gid;
}




// action -> todo?
$a = &$_GET['a'];

// cases available without login
// (logout,bout,css,setup)
switch($a) {
	//__logout__
	case 'logout':
		unset($_SESSION['mfp']);
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		redirect(dosid(SELF, '&'));
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
		<center id="fix">
		<a href="http://myftphp.sf.net" target="_blank">myFtPhp</a>, 2007
		</center>

		<div id="scroll" class="about">

		<div id="hcard" class="vcard">
			Code and idea: <span class="fn nickname">Knittl</span><br>
			<a href="http://sourceforge.net/projects/myftphp" class="url" rel="me" title="myFtPhp on sourceforge.net">&lt; sourceforge.net/projects/myftphp &gt;</a><br>
			<a href="mailto:knittl89@yahoo.de" class="email" rel="me" title="send me an email!">&lt; knittl89@yahoo.de &gt;</a>
		</div>

		<hr>
		<div class="vcard">
		<a href="http://www.famfamfam.com/lab/icons/silk/" class="url" rel="contact colleague">Silk icon set 1.3</a> by <u class="fn">Mark James</u>
		<br>
		His work is licensed under a
		<a href="http://creativecommons.org/licenses/by/2.5/">Creative Commons Attribution 2.5 License</a>
		</div>
		<hr>

		Thanks further goes to:
		<ul class="credits">
			<li class="vcard"><a href="http://tellmatic.de" target="_blank" class="fn nickname url" rel="acquaintance colleague">Vizzy</a>, for his support, testing and critics</li>
			<li class="vcard"><a href="http://edysoft.de/" target="_blank" class="fn nickname url" rel="contact colleague">Edy</a>, for help and motivation</li>
			<li class="vcard"><u class="fn nickname">Horny</u>, for his mental support and for hunting bugs</li>
			<li class="vcard"><u class="fn nickname">Squirrel</u>, for testing and using myFtPhp</li>
			<li class="vcard"><u class="fn">Alberto Torres</u>, for some nice ideas</li>
			<li class="vcard"><u class="fn nickname">Eliasp</u>, for pointing out <a href="http://chrispederick.com/work/webdeveloper/" target="_blank">Web Developer Tool</a></li>
		</ul>
		</div>
	<?php break;
	//^^bout^^

	//__css__
	case 'css':
	// TODO: use $_GET['theme'] to load specific theme
	?>
	* { margin:0; padding:0; }
	body {
		<?php #http://css-discuss.incutio.com/?page=UsingEms?>
		font-size:90%;
		color:<?php echo $c['txt']?>;
		background-color:<?php echo $c['bg']['main']?>;
		background-image:url(<?php echo img('water')?>);
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:right bottom;
		margin:<?php echo IE? '0': '6'?>px;
	}
<?php if(IE) { // only works in ie?>
	* html body {
		scrollbar-face-color:<?php echo $c['scrollbars']['face']?>;
		scrollbar-highlight-color:<?php echo $c['scrollbars']['highlight']?>;
		scrollbar-shadow-color:<?php echo $c['scrollbars']['shadow']?>;
		scrollbar-3dlight-color:<?php echo $c['scrollbars']['3dlight']?>;
		scrollbar-arrow-color:<?php echo $c['scrollbars']['arrow']?>;
		scrollbar-track-color:<?php echo $c['scrollbars']['track']?>;
		scrollbar-darkshadow-color:<?php echo $c['scrollbars']['darkshadow']?>;
	}
<?php }?>
	iframe { border:none; margin:0px; }

 /* form styling */
	form { padding:0; margin:0; }
	input, textarea, button {
		background-color:<?php echo $c['bg']['input']?>;
		background-position:left center;
		background-repeat:no-repeat;
		border:1px solid;
		border-color:<?php echo $c['border']['light']?> <?php echo $c['border']['dark']?> <?php echo $c['border']['dark']?> <?php echo $c['border']['light']?>;
		color:<?php echo $c['txt']?>;
		padding:0.3em;
		-moz-border-radius:4px;
		vertical-align:middle;
	}
	* html input, button { display:inline; } /* IE */
	textarea {
		background-color:<?php echo $c['bg']['inputlite']?>;
		background-image:url(<?php echo img('txtarea')?>);
		background-position:left top;
		background-repeat:repeat-y;
		padding-left:18px;
		font-family:monospace; -moz-border-radius:1em 0 0 1em; }
	textarea.full { padding-left:18px; height:85%; margin-top:5px; }
	input { padding:0px; text-indent:2px; }
	button {
		padding:0px;
		-moz-border-radius:0.3em;
		background-color:transparent;
		cursor:pointer;
	}

	label { padding:0px 0.5ex; -moz-border-radius:0.4em; cursor:pointer; }
	label:hover { background-color:<?php echo $c['bg']['inputhover']?>; }

	select, option {
		color:<?php echo $c['txt']?>;
		background-repeat: no-repeat;
	}
	select {
		border:1px solid <?php echo $c['border']['dark']?>;
		background-color:<?php echo $c['bg']['input']?>;
		background-image:url(<?php echo img('desc')?>);
		padding-left:12px;
		/*-moz-border-radius:4px;*/
	}
	select:hover { background-color:<?php echo $c['bg']['inputhover']?>; }
	select:focus { background-color:<?php echo $c['bg']['inputlite']?>; }
	option {
		background-color:<?php echo $c['bg']['inputlite']?>;
		background-image:url(<?php echo img('bullet')?>);
		padding-left:16px;
	}
	option:hover { color:<?php echo $c['a']['hover']?>; }

	input[type=text], input[type=password] {
		background-image:url(<?php echo img('kbd')?>);
		border:1px solid <?php echo $c['border']['lite']?>;
		border-bottom:1px solid <?php echo $c['border']['dark']?>;
		<?php #personal flavour?>
		text-indent:5px;
		-moz-border-radius:0.6em 0.6em 0 0;
	}
	input[type=password] {
		background-image:url(<?php echo img('pwd')?>);
		border-color:<?php echo $c['border']['dark']?>;
		-moz-border-radius:0.5em;
	}

	input:hover, option:hover {
		background-color:<?php echo $c['bg']['inputhover']?>;
		text-decoration:underline;
	}
	input[type=text]:focus, input[type=password]:focus {
		background-image:url();
		background-color:<?php echo $c['bg']['inputlite']?>;
		text-decoration:none;
	}

	input[type=submit] {
		font-weight:bold;
		background-image:url(<?php echo img('ok')?>);
		padding-left:16px;
	}
	html > body input#quicktext { width:24px; background-position:center; }
	html > body input#quicktext:focus { width:25em; }

 /* anchors, links */
	a { color:<?php echo $c['a']['link']?>; text-decoration:none; font-weight:<?php echo (!WIN)? 'bold': 'normal'?>; font-size:90%; font-family:<?php echo (WIN)? 'system': 'Courier New,monospace'?>; }
	a:hover { color:<?php echo $c['a']['hover']?>; background-color:<?php echo $c['a']['bghover']?>; text-decoration:underline; }
	a.rnd { padding:0px 0.5em; -moz-border-radius:0.5em; }

	a img { border:1px solid <?php echo IE? $c['bg']['main']: 'transparent'?>;
	opacity:1; } /* opacity other than 1 breaks FF3, check back when released !!! */
	a:hover img {
		border:1px solid <?php echo $c['border']['img']['shade']?>;
		border-top-color:<?php echo $c['border']['img']['light']?>;
		border-left-color:<?php echo $c['border']['img']['light']?>;
		opacity:1;
	}

	a .out, a:hover .over { display:inline; }
	a:hover .out, a .over { display:none; }


 /* headerdiv */
	#fix {
		position:fixed;
		top:0px; left:0px;
		display:block;
		width:100%;
		margin:0px;
		/*margin-right:-1.1em; /* 2x padding + border*/
		margin-right:auto;
		color:<?php echo $c['fixtxt']?>;
		background-color:<?php echo $c['bg']['fix']?>;
		border:1px solid <?php echo $c['border']['fix']?>;
		border-top:none;
		-moz-border-radius:0 0 4em 2em;
		padding:1px 0.5em;
		overflow:hidden;
		/* -moz-opacity:0.9; isn't needed */
		<?php echo IE ? 'filter:alpha(opacity=90);' : null?> opacity:0.9;
	}
	#scroll { clear:both; }
	<?php if(!IE) echo '#fix + #scroll { margin-top:2.5em; }'?>

 /* tables */
	table { border:none; border-collapse:collapse; border-spacing:0px; padding:0; }
	tr, tr td { vertical-align:top; }
	td, th { padding:0px 2px; text-align:left; }
	tr.c td, tr.c th { text-align:center; }

	/* hovered table rows */
	table tr.e:hover td,
	table tr.o:hover td,
	table tr.hover td /* for later IE js */ {
		background-color:<?php echo $c['bg']['tablehover']?>;
	}

	tr.o td, tr.o th { background-color:<?php echo $c['o']?>; }
	tr.clip td a { font-style:italic; }

	tbody, thead, tfoot { border-color:<?php echo $c['border']['ruler']?>; }
	tbody { margin-bottom:1em; }

	tr.l { white-space:nowrap; }
	tr.l a { display:block; white-space:pre; }

	.marked { background-color:<?php echo $c['o']?>; }

 /* gallery floating tiles, mostly lists */
	.gallery .dirlist, .gallery .filelist { text-align:left; clear:both; }
	.gallery ul.dirlist, .gallery ul.filelist { list-style-image:url(); }

	.tile {
		float:left; /*display:inline;*/
		padding:5px; margin:5px;
		border:1px solid <?php echo $c['border']['img']['light']?>;
		background-color:<?php echo $c['bg']['fix']?>;
	}

	.tile a { font-weight:normal; text-decoration:none; }
	.tile a img { margin-right:1ex; vertical-align:middle; }
	.tile a img.ico { width:<?php echo $cfg['thumbs']['max']['w']?>px; height:<?php echo $cfg['thumbs']['max']['h']?>px; }
	.gallery .filelist .tile * { float:left; }

	 /* gallery lists */
		.breadcrumbs {  } /* separate for gallery??? */
		ul.dirlist, ul.filelist { list-style-type:none; }

 /* selection, rulers */
	::-moz-selection { color:<?php echo $c['a']['hover']?>; background:<?php echo $c['bg']['inputhover']?>; }
	/* needs checking for safari or others
	::selection { color:<?php echo $c['a']['hover']?>; background:<?php echo $c['bg']['inputhover']?>; }*/

 /* BOXES, fake windows */
	.box {
		min-width:150px;
		max-width:400px;
		-moz-border-radius:0 0 6px 6px;
		margin:0px auto 1em;
		padding:0px 10px 5px;
		border:1px solid <?php echo $c['border']['ruler']?>;
		text-align:left;
	}

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
		color:<?php echo $c['fixtxt']?>;
		background-color:<?php echo $c['bg']['fix']?>;
		border-bottom:1px solid <?php echo $c['border']['fix']?>;
	}
	/* now w/o .container class thanks to negative margins */
	.box .footer {
		margin:1ex -10px -5px; /* compensate padding */
		padding:2px 3px 3px;
		display:block;
		text-align:right;
		border-top:1px solid <?php echo $c['border']['fix']?>;
	}

	.box a { display:inline !important; }

	.full { height:100%; min-width:100%; max-width:100%; margin:-2px 0px -1px; padding:0; }
	/* reset/clear h-margins */
	.full h1, .full h2, .full h3, 
	.full h4, .full h5, .full h6 { margin-left:0; margin-right:0; }
	.full .footer { margin-left:0; margin-right:0; }

	.login { width:182px; margin:2em auto; padding-bottom:10px; }
	html > body .login { width:162px; } /* mozilla */
	/* .login div { margin-left:auto; margin-right:auto; } */
	.login input { width:140px; }

	.center { margin-left:auto; margin-right:auto; } /* width needs to be set */

 /* lists */
	ul {
		list-style-position:outside;
		list-style-type:square;
		list-style-image:url(<?php echo img('bullet')?>); /* ??? not sure yet */
		text-align:left;
		margin-left:24px;
	} /* !!! have a look at -position:inside */

	dl { margin-bottom:1ex; }
	dt { clear:left; float:left; margin-right:1ex; overflow:hidden; }
	dl.aligned dt { width:50%; }
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
		ul.tree li { white-space:nowrap; list-style-image:url(<?php echo img('dir')?>); }
		ul.tree li a { white-space:pre; }
		ul.tree li.home { list-style-image:url(<?php echo img('home')?>); }
		ul.tree li:hover { list-style-image:url(<?php echo img('explore')?>); }

		ul.tree a { display:block; }
		ul.tree a:hover { background-color:<?php echo $c['bg']['tablehover']?>; }

		/* first item of nested lists, 2nd level up */
		li li:first-child { border-top:1px dotted <?php echo $c['border']['ruler']?>; } /* check thoroughly in more browsers!!! */
		/* IE hacks. IT SUCKS */
		* html ul.tree li a { display:inline; padding-left:1ex; }

	 /* file/dir list items */
		li.dir   { list-style-image:url(<?php echo img('dir')?>); }
		li.file  { list-style-image:url(<?php echo img('file')?>); }
		li.link  { list-style-image:url(<?php echo img('link')?>); }
		li.warn  { list-style-image:url(<?php echo img('warn')?>); }
		li.error { list-style-image:url(<?php echo img('error')?>); }

/* other stuff */
	 /* nice helper classes :) */
		.b { font-weight:bold; }
		.i { font-style:italic; }

	* html p { padding:4px; } /*IE*/
	img { vertical-align:middle; border:0px none; }
	img.ico { width:16px; height:16px; }
	hr {
		color:<?php echo $c['border']['ruler']?>;
		background-color:<?php echo $c['border']['ruler']?>;
		width:80%; height:1px;
		border:0 none;
		text-align:center;
		margin:1ex auto 1em;
	}
	.enum { padding-left:5px; }
	.enum code .b {
		background-color:<?php echo $c['bg']['inputhover']?>;
		margin-left:-5px;
		padding-left:5px;
	}
	/*.enum, .enum code a.b, code { font-size:14pt !important; font-family:serif; }*/
	code { display:block; }
	var a { padding-right:0.6ex; padding-left:0.1ex; }

	/* display of paths */
	/* and user input */
	var.dir, var.file, var.link, var.error, kbd { padding-left:18px; background-repeat:no-repeat; }
	var.dir   { background-image:url(<?php echo img('dir')?>); }
	var.file  { background-image:url(<?php echo img('file')?>); }
	var.link  { background-image:url(<?php echo img('link')?>); }
	var.error { background-image:url(<?php echo img('error')?>); }
	kbd { background-image:url(<?php echo img('kbd')?>); }

	.about {
		background-color:<?php echo $c['bg']['main']?>;
		-moz-border-radius:2.5em;
		padding:1em;
		<?php if(IE) echo 'filter:alpha(opacity=80);'?>
		opacity:0.8;
	}

	/* errors and warnings */
	div.error, div.warn {
		display:block;
		padding:1ex 1ex 1ex 28px;
		background-color:<?php echo $c['bg']['fix']?>; /* TODO: find better colors */
		background-repeat:no-repeat;
		background-position:4px 1ex;
		border:1px solid;
		border-left:none;
		margin:1ex 1em 2ex;
		font-style:italic;
	}
	div.error { background-image:url(<?php echo img('error')?>); }
	div.warn  { background-image:url(<?php echo img('warn')?>); }

<?php
		// set filetype to css
		header('Content-Type: text/css');
		// cache css for 1h
		header('Expires: '.gmdate('D, d M Y H:i:s', time()+3600).' GMT');
		header('Cache-Control: max-age:3600, must-revalidate');
		header('Content-Length: '.ob_get_length());
		// that's it for css
		exit;
	break;
	//^^css^^

	//__setup__
	case 'setup':
		$title = 'setup';

		$langs  = getLangs();
		$themes = getThemes();

		// english and light are default and first
		// TODO: benchmark, see  __user__
		unset($langs[array_search('english', $langs)]);
		sort($langs);
		array_unshift($langs, 'english');

		unset($themes[array_search('light', $themes)]);
		sort($themes);
		array_unshift($themes, 'light');
	?>

	<div id="scroll">

	<?php

	if(isset($_POST['setup'])) {
		// print config array
		// no further checking for values
		try {
			$user = &$_POST['user'];
			$pwd  = &$_POST['pwd'];
			$retype = &$_POST['retype'];
			$home = &$_POST['home'];
			$setuplang  = &$_POST['lang'];
			$setuptheme = &$_POST['theme'];
			if(!isset($user) || empty($user)) throw new Exception('Username not set');
			if(!isset($pwd, $retype)) throw new Exception('Password not set');
			if(!isset($home) || empty($home)) throw new Exception('Homedir not set');
			if(!isset($setuplang, $setuptheme)) throw new Exception('Language or theme not set');

			if($pwd !== $retype) throw new Exception('Passwords do not match');

			if($pwd == '') {
				echo '<div class="warn">Your password is empty</div>';
			} elseif(strlen($pwd) < 6) {
				echo '<div class="warn">You should use a longer password</div>';
			}

			// all ok, print config array
			echo '<div class="box">';
			echo '<h3>Config</h3>';
			echo 'Your account data: <hr>';
			echo '<pre><code>\'', $user, '\' => ';
			var_export(array(
					'pass'  => createSaltedHash($pwd),
					'home'  => $home,
					'lang'  => $setuplang,
					'theme' => $setuptheme));
			echo '</code></pre>';
			echo '</div>';
		} catch(Exception $e) {
			echo '<div class="error">', $e->getMessage(), '</div>';
		}
	}

	?>

		<form method="post" action="<?php echo dosid(h(URI))?>">
		<div class="box">
		<h3><img src="<?php echo img('user')?>" class="ico" alt="setup"> setup</h3>
			<dl class="aligned">
				<dt><label for="user">username</label></dt>
				<dd><input type="text" name="user" id="user" value="<?php echo init($user, '')?>"></dd>
				<dt><label for="pwd"><?php echo $l['pwd']?></label></dt>
				<dd><input type="password" name="pwd" id="pwd"></dd>
				<dt><label for="retype">retype password</label></dt>
				<dd><input type="password" name="retype" id="retype"></dd>
				<dt><label for="home"><?php echo $l['home']?></label></dt>
				<dd><input type="text" name="home" id="home" value="<?php echo init($home, '')?>"></dd>

				<dt><hr></dt><dd>&nbsp;</dd>

				<dt><label for="lang"><?php echo $l['lang']?></label></dt>
				<dd>
				<select size="0" name="lang" id="lang">
				<?php foreach($langs as $lang) {
						echo '<option',
						(isset($setuplang) && $setuplang == $lang ? ' selected' : ''),
						'>',$lang,'</option>';
					 } ?>
				</select>
				</dd>

				<dt><label for="theme">theme</label></dt>
				<dd>
				<select size="0" name="theme" id="theme">
				<?php
				foreach($themes as $theme) {
					echo '<option',
					(isset($setuptheme) && $setuptheme == $theme ? ' selected' : ''),
					'>',$theme,'</option>';
				}
				?>
				</select>
				</dd>
			</dl>
		<div class="footer"><input type="submit" name="setup" value="generate config"></div>
		</div>
		</form>

	</div>

<?php
	break;
	//^^setup^^

	//__default__
	default:


// only auth users
//logged in or empty user array
if(($mfp_on && isset($accounts[$mfp_user])) || (empty($accounts) && isset($accounts))) {

	// home: at least read permissions are needed
	$home = &$accounts[$mfp_user]['home'];

	// is home existing?
	if(is_dir($home) && define('HOME', $home)) {
		define('REALHOME', realpath(HOME));
		define('RELHOME', pathTo(HOME, WEBROOT));
	} else {
		unset($_SESSION['mfp']['user']);
		die(sprintf($l['err']['home'], '<var class="dir">'.h($home).'</var>'));
		#die('Bad home');
	}


//what to do?
switch($a) {
//a(ction) = [clip,del,down,edit,find,gallery,info,mod,new,rem,ren,props,src,thumb,tree,up,user,view,'default']


//__clip__
case 'clip':
	$clipboard = &$_SESSION['mfp']['clipboard'];
	try {
		$dir = &$_GET['d'];

		if(isset($_GET['copy']) || isset($_GET['move'])) { ?>
		<script type="text/javascript" language="JavaScript">
		<!--
			opener.location.reload();
		//-->
		</script>
		<?php }

		// #copy, move, list, free
		// since copy and move are essentially the same loop clipboard and decide while looping. a bit slower though, but saves code
		// TODO: do something with variable functions
		if(isset($_GET['copy']) || isset($_GET['move'])) {
			if(count($clipboard)) {
				$dir = new mfp_dir($dir);
				foreach($clipboard as $key => $entry) {
					try {
						$oldpath = fullpath($entry);
						$newpath = $dir->fullpath().'/'.basename($oldpath);

						// we can't trust user data!
						if(!allowed($oldpath)) {
							// remove forbidden/broken paths from clipboard
							unset($clipboard[$key]);
							throw new Exception(sprintf($l['err']['forbidden'], '<var class="file">'.$oldpath.'<var>'));
						}

						if(file_exists($newpath)) throw new Exception(sprintf($l['err']['fileexists'], '<var class="file">'.wrap(h($newpath)).'</var>', getfsize(filesize($newpath))));

						if(isset($_GET['copy'])) {
							if(copy($oldpath, $newpath)) {
								echo '<br>succesfully copied: ', $oldpath;
								unset($clipboard[$key]);
							} else {
								echo '<br>error copying';
							}
						} elseif(isset($_GET['move'])) {
							if(rename($oldpath, $newpath)) {
								echo '<br>succesfully moved: ', $oldpath;
								unset($clipboard[$key]);
							} else {
								echo '<br>error moving';
							}
						}
					} catch(Exception $e) {
						echo '<div class="error">', $e->getMessage(), '</div>';
					}
				}
			} else { echo 'no files in clipboard'; }

		} elseif(isset($_GET['free'])) {
			$clipboard = array();
			redirect(dosid(SELF.'?a=clip&list', '&'));
		} elseif(isset($_GET['list'])) { ?>

			<form name="form" method="post" action="<?php echo dosid(SELF.'?a=multi&amp;d=.')?>" accept-charset="<?php echo $cfg['charset']?>">
			<div class="box">
			<h3><img src="<?php echo img('clip')?>" class="ico" alt="<?php echo $l['clip']?>"> clipboard</h3>
			<?php
				if(count($clipboard)) {
					$i = 0;
					?>

					<table>
					<thead>
					<tr>
					<th><input type="checkbox" name="toggle_top" onClick="toggleAll(this, 'chks');"></th>
					<th><?php echo $l['file']?></th>
					<th><?php echo $l['dir']?></th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach($clipboard as $entry) {
						$i++;

						$class = ($i &1) ? 'o' : 'e';
						$path = h($entry);
						$directlink = directLink($entry);
						$basename = basename($entry);
						$dir = dirname($entry).'/';
						?>
						<tr class="l <?php echo $class?>">
							<td><input type="checkbox" name="chks[]" id="chk<?php echo $i?>" value="<?php echo $path?>"></td>
							<td><a href="<?php echo $directlink?>" title="<?php echo $l['viewfile']?>" target="_blank" class="rnd"><?php echo $basename?></a></td>
							<td><?php echo $dir?></td>
						</tr>
					<?php
					}
					echo '</tbody></table>';
				} else {
					echo $l['err']['nofiles'];
				}
			?>
			<div class="footer">
				<button type="submit" name="sub"><img src="<?php echo img('clipsub')?>" alt="<?php #=$l['clipsub']?>"></button>
				<a href="<?php echo dosid(SELF.'?a=clip&amp;free')?>" title="free clipboard">free clipboard</a>
			</div>
			</div>
			</form>

		<?php } else {

		}
	} catch(Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}
break;
//^^clip^^

//__del__
case 'del':
//delete file
$title = $l['title']['del'];
?>

<div class="box">
<h3><img src="<?php echo img('del')?>" class="ico" alt="<?php echo $l['delete']?>"> <?php echo $title?></h3>
<?php
if(isset($_POST['delete'])) {
	echo '<ul>';
	$dir = &$_GET['d'];
	$paths = json_decode($_POST['ps'], TRUE);

	foreach($paths as $file) {
		$directlink = directLink($file);
		$wrappedpath = wrap(h($file));

		echo '<li class="';
		try {
			$path = new mfp_file($dir.'/'.$file);

			if(!$path->unlink()) throw new Exception(sprintf($l['err']['deletefile'], '<var><a href="'.$directlink.'" target="_blank">'.$wrappedpath.'</a></var>'));

			printf('file">'.$l['ok']['deletefile'], '<var>'.$wrappedpath.'</var>');
		} catch(Exception $e) {
			echo 'error">', $e->getMessage();
		}
		echo "</li>\n";
	}

?>
	</ul>
	<form name="mfp_form" action="javascript:window.close()" class="footer">
	<input name="closebut" type="submit" value="  <?php echo $l['close']?>  " onClick="window.close()">
	<script type="text/javascript" language="JavaScript">
	<!--
		opener.location.reload();

		document.mfp_form.closebut.focus();
	//-->
	</script>
	</form>

<?php
} else {
	$directlink = directLink($_GET['p']);
	$wrappedpath = wrap(h($_GET['p']));
	$dir = dirname($_GET['p']);
	$wrappeddir = wrap(h($dir));
?>
	<?php printf($l['warn']['reallydel'],
				'<var class="file"><a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a></var>');

		if(!is_writeable(fullpath($dir))) printf('<div class="warn">'.$l['err']['writable'].'</div>', '<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.u($dir)).'" target="_blank">'.$wrappeddir.'</a></var>');
?><br>

<form method="post" action="<?php echo dosid(SELF.'?a=del&amp;d=.')?>" class="footer">
	<input type="hidden" name="ps" value="<?php echo u(json_encode(array($_GET['p'])))?>">
	<input type="submit" name="delete" value="  <?php echo $l['delete']?>  ">&nbsp;
	<input type="button" name="cancel" value="  <?php echo $l['cancel']?>  " onClick="window.close()">
</form>
<?php } ?>
</div>

<?php
break;
//^^del^^


//__down__
case 'down':
//download
$title = $l['title']['down'];

$file = &$_REQUEST['p'];
?>
<div class="box">
<h3><img src="<?php echo img('download')?>" class="ico" alt="<?php echo $l['download']?>"> <?php echo $l['download']?></h3>
<?php
try {
	//filename passed?
	if(!isset($file) || $file == '') throw new Exception($l['err']['nofile']);
	$file = new mfp_file($file);

	if(isset($_POST['down'])) {
		$compression = &$_POST['compression'];

		// read and print file content
		if(!$file->is_readable()) throw new Exception(sprintf($l['err']['readable'], '<var class="file">'.h($file).'</var>'));

		// clean all output buffers
		while(ob_get_level()) {
			ob_end_clean();
		}

		// write session and release lock on sessionfile
		session_write_close();

		// original uncompressed content
		$buffer = $file->file_get_contents();
		$extension = '';
		// generic "only bytes" type
		$submimetype = 'octet-stream';

		// compressed download?
		// zip
		if ($compression == 'zip' && @function_exists('gzcompress')) {
			// load lib
			require_once($cfg['dirs']['libs'].'/zip.lib.php');

			$zip = new zipfile();
			$zip->addFile($buffer, $file->basename());
			$buffer = $zip->file();

			$extension = '.zip';
			$submimetype = 'zip';
		} elseif ($compression == 'gz' && @function_exists('gzencode')) {
		// gzip
			$buffer = gzencode($buffer);
			$extension = '.gz';
			$submimetype = 'x-gzip';
		} elseif ($compression == 'bz2' && @function_exists('bzcompress')) {
		// bzip
			$buffer = bzcompress($buffer);
			$extension = '.bz2';
			$submimetype = 'x-bzip2';
		}

		// send headers and file
		header('Content-type: application/'.$submimetype);
		header('Content-encoding: none'); // clear status of ob_gzhandler and send without encoding

		// set filename for download
		header('Content-length: ' . strlen($buffer));
		header('Content-Disposition: attachment; filename="' . $file->basename().$extension . '"');

		echo $buffer;
		exit;

	} else {
		$directlink = directlink($file);
?>
		<form method="post" action="<?php echo dosid(SELF.'?a=down')?>">
			Download file "<var class="file"><a href="<?php echo $directlink?>" target="_blank"><?php echo h($file)?></a></var>"

			<?php if(!$file->is_readable()) printf('<div class="warn">'.$l['err']['readable'].'</div>', '<var class="file">'.h($file).'</var>');?>

			<div>
			Compression: 
			<label for="none"><input type="radio" name="compression" id="none" value="none" checked> none</label>
			<?php if(@function_exists('gzcompress')) echo '<label for="zip"><input type="radio" name="compression" id="zip" value="zip"> zip</label>' ?>
			<?php if(@function_exists('gzencode')) echo '<label for="gz"><input type="radio" name="compression" id="gz" value="gz"> gzip</label>' ?>
			<?php if(@function_exists('bzcompress')) echo '<label for="bz2"><input type="radio" name="compression" id="bz2" value="bz2"> bzip</label>' ?>
			</div>

			<div class="footer">
			<input type="hidden" name="p" value="<?php echo h($file)?>">
			<input type="submit" name="down" value="<?php echo $l['download']?>">&nbsp;
			<input type="button" name="cancel" value="<?php echo $l['cancel']?>" onClick="window.close()">
			</div>
		</form>
<?php
	}
} catch (Exception $e) {
	echo '<div class="error">', $e->getMessage(), '</div>';
}
?>
</div>
<?php
break;
//^^down^^


//__edit__
case 'edit':
$title = $l['title']['edit'];
	try {
		$file = new mfp_file($_REQUEST['p']);

		$directlink = directLink($file);
		$basename   = h($file->basename());
		$filesize   = getfsize($file->filesize());
		//fixed line
?>
	<form method="post" action="<?php echo dosid(SELF.'?a=edit&amp;p='.u($file))?>" name="form" onSubmit="return confirm('<?php printf($l['warn']['reallysave'], addslashes(h($file)))?>'); return false;" accept-charset="<?php echo $cfg['charset']?>">
	<div id="fix">
		<input type="submit" name="save" value="<?php echo $l['save']?>">&nbsp;
		<input type="reset" name="reset" value="<?php echo $l['reset']?>">&nbsp;
		<input type="button" name="reload" value="<?php echo $l['reload']?>" onClick="window.location.reload()">&nbsp;
		<input type="button" name="cancel" value="<?php echo $l['close']?>" onClick="window.close()">&nbsp;
		<var class="file"><a href="<?php echo $directlink?>" target="_blank"><?php echo $basename?></a>
		(<?php echo $filesize?>)</var>
	</div>

<div id="scroll">
<?php		$wrappedpath = wrap(h($file));
		if(isset($_POST['save'])) {
			try {
				if(!$file->is_writeable()) throw new Exception(sprintf($l['err']['writable'], '<var class="file">'.$wrappedpath.'</var>'));

				if(($bytes = $file->file_put_contents($_POST['source'])) === FALSE) throw new Exception(sprintf($l['err']['writefile'], '<var class="file">'.$wrappedpath.'</var>'));

				$filesize = getfsize($bytes);
				printf($l['ok']['writefile'], '<var class="file">'.$wrappedpath.'</var>', $filesize);
				?>
				<script type="text/javascript" language="JavaScript">
				<!--
					opener.location.reload();
				//-->
				</script>
				<?php
				echo '<br>';
			} catch (Exception $e) {
				echo '<div class="error">', $e->getMessage(), '</div>';
			}
		}# else {
		try {
			if(!$file->is_readable()) throw new Exception(sprintf($l['err']['readable'], '<var class="file">'.$wrappedpath.'</var>'));

			if(!$file->is_writeable()) printf('<div class="warn">'.$l['err']['writable'].'</div>', '<var class="file">'.$wrappedpath.'</var>');


			if(($source = $file->file_get_contents()) === FALSE) throw new Exception(sprintf($l['err']['readfile'], '<var class="file">'.$wrappedpath.'</var>'));
			?>

		<textarea name="source" class="full" cols="10" rows="20" wrap="off"><?php echo h($source);?></textarea>
<?php	} catch (Exception $e) {
			echo '<div class="error">', $e->getMessage(), '</div>';
		}
?>
	</div>
	</form>

<?php #}
	} catch (Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}
break;
//^^edit^^

//__find__
case 'find':
$title = $l['title']['find'];
	// find files recursive
	$dir   = $_REQUEST['d'];
	$term  = &$_REQUEST['term'];
	$realdir = pathTo(fullpath($dir));

	$adv = init($_POST['adv'], array());
	$case  = in_array('case', $adv);
	$exact = in_array('exact', $adv);
	$rec   = in_array('rec', $adv);
	$dirs_only = in_array('dirs', $adv);

	if(isset($_POST['find'])) {
		//save checkboxes to session
		//to remember status for current session
		$_SESSION['mfp']['find'] = array(
			'case'  => $case,
			'exact' => $exact,
			'rec'   => $rec
		);
	}

	$url_dir = u($dir);

	if(!allowed(fullpath($dir))) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.h($dir).'</var>'));
	?>
<div id="fix">
<form method="post" name="quickform" action="<?php echo dosid(SELF.'?a=find&amp;d='.$url_dir)?>" accept-charset="<?php echo $cfg['charset']?>">
	<div>
		<a href="<?php echo dosid(SELF.'?a=view&amp;d='.$url_dir);?>" title="<?php echo $l['viewdir']?>"><img src="<?php echo img('explore')?>" class="ico" alt="<?php echo $l['viewdir']?>"></a>
		<a href="<?php echo dosid(SELF.'?a=gallery&amp;d='.$url_dir);?>" title="<?php echo $l['viewgallery']?>"><img src="<?php echo img('thumbs')?>" class="ico" alt="<?php echo $l['thumb']?>"></a>
		<a href="<?php echo dosid(h(URI));?>" title="<?php echo $l['reload']?>"><img src="<?php echo img('reload')?>" class="ico" alt="<?php echo $l['reload']?>"></a>
		<?php #printf($l['searchfor'], $realdir)?>
		<input type="text" name="term" value="<?php echo init($term, '')?>" maxlength="255" size="50" style="width:25em;">&nbsp;&nbsp;
		<input type="submit" name="find" value=" <?php echo $l['find']?> ">
	</div>
	<div style="margin-left:62px;">
		<label for="case"><input type="checkbox" name="adv[]" value="case" id="case" <?php echo $case? 'checked': ''?>> <?php echo $l['casesensitive']?></label>
		<label for="exact"><input type="checkbox" name="adv[]" value="exact" id="exact" <?php echo $exact? 'checked': ''?>> <?php echo $l['exactmatch']?></label>
		<label for="rec"><input type="checkbox" name="adv[]" value="rec" id="rec" <?php echo $rec? 'checked': ''?>> <?php echo $l['findsubdirs']?></label>
		<label for="dirs"><input type="checkbox" name="adv[]" value="dirs" id="dirs" <?php echo $dirs_only? 'checked': ''?>> <?php echo $l['onlydirs']?></label>
	</div>
</form>
</div>

<div id="scroll" style="margin-top:3.5em;">
<?php
if(isset($_POST['find'])) {
try {

	if(empty($term)) throw new Exception($l['err']['emptyfield']);
	if(!isset($dir)) throw new Exception(sprintf($l['err']['baddir'], '<var class="dir">'.$dir.'</var>'));

	$realdir = wrap(h($dir));

	$matches['dirs'] = new mfp_dirs();
	$matches['files'] = new mfp_files();

	function match($haystack, $needle) {
		global $case, $exact;

		if($exact) return ($haystack === $needle);
		if($case)  return (strpos($haystack, $needle) !== FALSE);
		return (stripos($haystack, $needle) !== FALSE);
	}

	function recursiveFind($dir) {
		global $term, $matches;
		global $rec, $dirs_only;

		$fulldir = fullpath($dir);

		// skip forbidden dirs (mostly symlinks)
		if(!allowed(fullpath($dir))) return FALSE;
		if(!is_readable($fulldir)) return FALSE; // do not search unreadable dirs

		foreach(new mfp_dir_iterator($fulldir) as $file) {
			$path = $dir.'/'.$file;
			$fullpath = fullpath($path);
			$name = pathTo($fullpath);

			// checking happens only for dirs now, see _view_ again:
			//if(!allowed($fullpath)) continue; // skip rest of loop

			if(is_dir($fullpath)) {
				if($file == '.' || $file == '..') continue;
				if(match($file, $term)) {
					$matches['dirs']->add(array(
						'name' => $name,
						'path' => $path,
						'mtime' => filemtime($fullpath),
						'perm' => fileperms($fullpath)%01000,
						'link' => is_link($fullpath)
					));
				}

				//recursion
				if($rec) {
					recursiveFind($path);
				}
			} else if(!$dirs_only) {
				if(match($file, $term)) {
					$matches['files']->add(array(
						'name' => $name,
						'path' => $path,

						'size'  => filesize($fullpath),
						'mtime' => filemtime($fullpath),
						'perm'  => fileperms($fullpath)%01000,
						'link' => is_link($fullpath)
					));
				}
			}
		}
		return TRUE;
	}


	//recursion
	if(!recursiveFind($dir)) throw new Exception(sprintf($l['err']['find'], '<var class="dir">'.$realdir.'</var>')); ?>
	<form name="findform" method="post" action="<?php echo dosid(SELF.'?a=multi&amp;d='.u($dir))?>" onSubmit="popUp(this.action, 'multiwin');" target="multiwin" accept-charset="<?php echo $cfg['charset']?>">
	<table rules="groups">
<?php if($matches['dirs']->count() + $matches['files']->count() > 0) { ?>
	<tfoot>
	<tr>
		<td><input type="checkbox" name="toggle" onclick="toggleAll(this, 'chks', 'findform');"></td>
		<td colspan="11">
		<button type="submit" name="add"><img src="<?php echo img('clipadd')?>" class="ico" alt="<?php echo $l['clip']['add']?>"></button>
		<button type="submit" name="sub"><img src="<?php echo img('clipsub')?>" class="ico" alt="<?php echo $l['clip']['sub']?>"></button>
		<a href="<?php echo dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?php echo $l['clip']['list']?>"><img src="<?php echo img('clip')?>" class="ico" alt="<?php echo $l['clip']?>"> list</a>
	</tr>
	</tfoot>
	<?php } ?>
	<tbody>
<?php //dirs
		if($matches['dirs']->count()>0) {
			$matches['dirs']->printout();
		} else {	?>
			<tr>
				<td colspan="11"><?php echo $l['err']['nodirs']?></td>
			</tr>
<?php } ?>
	</tbody>

	<tbody>
<?php //files
		if($matches['files']->count()>0) {
			$matches['files']->printout();
		} elseif(!$dirs_only) {	?>
			<tr>
				<td colspan="11"><?php echo $l['err']['nofiles']?></td>
			</tr>
<?php } ?>
	</tbody>

	</table>
	</form>
<?php
} catch(Exception $e) {
	echo '<div class="error">', $e->getMessage(), '</div>';
}
?>
</div>
<?php
}
break;
//^^find^^

//__gallery__
case 'gallery':
// thumbnail gallery
$title = $l['title']['thumbs'];

try {

	// if no dir was passed, use homedir instead
	$dir = init($_GET['d'], '.');
	$dir = new mfp_dir($dir);
	//init
	$thumbdirs = new mfp_list();
	$thumbfiles = new mfp_files();

	if(!$dir->is_readable()) throw new Exception(sprintf($l['err']['readable'], '<var class="file">'.h($dir).'</var>'));

	foreach($dir as $file) {
		if($file == '.' || $file == '..') continue;

		$path = $dir.'/'.$file;
		$fullpath = fullpath($path);

		// see _view:
		//if(!allowed($fullpath)) throw new ...
		if(is_dir($fullpath)) {
			$thumbdirs->add(array(
				'name' => $file,
				'path' => $path,

				'mtime' => filemtime($fullpath),
				'link' => is_link($fullpath)
			));
		} elseif(is_file($fullpath)) {
			$thumbfiles->add(array(
				'name' => $file,
				'path' => $path,

				'size' => filesize($fullpath),
				'mtime' => filemtime($fullpath),
				'link' => is_link($fullpath),

				#'hash' => md5(realpath($fullpath)).filemtime($fullpath) // not used atm
			));
		}
	}

	// sort listings
	$thumbdirs->sort('+name');
	$thumbfiles->sort('+name');

	// cleaning
	$thisdir = HOME . pathTo(fullpath($dir));

	// see --view--
	$realupdir = @realpath($thisdir.'/..');
	$updir = HOME . pathTo($realupdir);

	$breadcrumbs = $dir->breadcrumbs();
	if($dir->realpath() != REALHOME) { array_push($breadcrumbs, (string)$dir); }
	// grid output
	?>

	<!-- quick access panel, fixed -->
	<div id="fix">
		<a href="<?php echo dosid(SELF.'?a=view&amp;d='.u($dir));?>" title="<?php echo $l['viewdir']?>"><img src="<?php echo img('explore')?>" class="ico" alt="<?php echo $l['viewdir']?>"></a>
		<a href="<?php echo dosid(SELF.'?a=find&amp;d='.u($dir));?>" title="<?php echo $l['find']?>"><img src="<?php echo img('find')?>" class="ico" alt="<?php echo $l['find']?>"></a>
		<a href="<?php echo dosid(SELF.'?a=gallery&amp;d='.u($dir));?>" title="<?php echo $l['reload']?>"><img src="<?php echo img('reload')?>" class="ico" alt="<?php echo $l['reload']?>"></a>
		<img src="<?php echo img('images')?>" class="ico" alt="<?php echo $l['img']?>">
		[<?php echo $thumbfiles->count()?> | <?php echo getfsize($thumbfiles->size())?>]&nbsp;

		<img src="<?php echo img('dir')?>" class="ico" alt="<?php echo $l['dir']?>">
		[<?php echo $thumbdirs->count()?>]
		<?php echo '&nbsp;&nbsp;'.h(basename($dir))?>
	</form>
	</div>

	<div id="scroll" class="gallery">
	<div class="breadcrumbs">
		<img src="<?php echo img('dir')?>" class="ico" alt="/">&nbsp;
		<a href="<?php echo dosid(SELF.'?a=gallery&amp;d=.')?>" title="<?php echo $l['changedir']?>"><?php echo h(basename(REALHOME))?>/</a>
<?php
	foreach($breadcrumbs as $path) {
	?>
		<a href="<?php echo dosid(SELF.'?a=gallery&amp;d='.u($path))?>" title="<?php echo $l['changedir']?>"><?php echo h(basename($path))?>/</a>
	<?php } ?>
	</div>

	<ul class="dirlist">
<?php	//dirs
	foreach($thumbdirs as $dir) {
		?>
		<li class="tile">
		<a href="<?php echo dosid(SELF.'?a=gallery&amp;d='.u($dir['path']))?>" title="<?php echo $l['changedir']?>">
			<img src="<?php echo img('dir')?>" class="ico" alt="/">
			<span><?php echo (h($dir['name']))?></span>
		</a>
		</li>
<?php } ?>
	</ul>

	<ul class="filelist">
<?php //files
	foreach($thumbfiles as $file) {
	$imgpath = $file['path'];
	$isimage = TRUE;

	// get extension - and corresponding imagepath
	$ext = strtolower(substr(strrchr($imgpath,'.'),1));
	foreach($cfg['ftypes'] as $key => $val) {
		if(in_array($ext, $val)) {
			$imgpath = $cfg['dirs']['icons'].'/'.$cfg['icons'][$key];
			$isimage = FALSE;
			// ends loop:
			break;
		}
	}

	if($isimage == FALSE) {
		$srclink = $imgpath;
	} else {
		$srclink = SELF.'?a=thumb&amp;p='.u($imgpath);
	}
	?>
		<li class="tile">
		<a href="<?php echo directlink($file['path'])?>" target="_blank" title="<?php echo $l['view']?>">
			<img src="<?php echo dosid($srclink)?>" class="ico" alt=">">
			<span>
			<span><?php echo (h($file['name']))?></span>
			<small style="clear:both;"><?php echo getfsize($file['size'])?></small>
			</span>
		</a>
		</li>
<?php } ?>
	</ul>
	</div>
<?php

	} catch(Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
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
	$location   = h(pathTo(HOME, WEBROOT) . '/');

	//count languages and themes
	$langcount  = count(getLangs());
	$themecount = count(getThemes());
?>

<div id="scroll">
<?php
	//format and output
?>
<div class="box">
<h3><img src="<?php echo img('drive')?>" class="ico" alt="<?php echo $l['info']?>"> harddisk</h3>
<?php
	printf($l['freespace'], $freespace, '<var class="dir">'.$location.'</var>');
	echo '<br>';
	printf($l['totalspace'], $totalspace, '<var class="dir">'.$location.'</var>');
?>
</div>

<div class="box">
<h3><img src="<?php echo img('drive')?>" class="ico" alt="<?php echo $l['info']?>"> server</h3>
	<dl class="aligned">
		<dt>Server name: </dt>
		<dd>"<i><?php echo $_SERVER['SERVER_NAME']?></i>"</dd>

		<dt>Server Software: </dt>
		<dd>"<i><?php echo $_SERVER['SERVER_SOFTWARE']?></i>"</dd>

		<dt>Operating System: </dt>
		<dd>"<i><?php echo @$_ENV['OS']?></i>"</dd>

	</dl>

</div>

<div class="box">
<h3><img src="<?php echo img('drive')?>" class="ico" alt="<?php echo $l['info']?>"> environment</h3>
<dl class="aligned">
<?php
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
<h3><img src="<?php echo img('user')?>" class="ico" alt="<?php echo $l['user']?>"> <?php echo $l['user']?></h3>
	<dl class="aligned">
		<dt><?php echo $l['user']?>: </dt>
		<dd>"<i><?php echo $mfp_user?></i>"</dd>

		<dt><?php echo $l['home']?>: </dt>
		<dd>"<i><?php echo HOME?></i>"</dd>

		<dt><?php echo $l['lang']?>: </dt>
		<dd>"<i><?php echo $accounts[$mfp_user]['lang']?></i>"</dd>

		<dt><?php echo 'theme'?>: </dt>
		<dd>"<i><?php echo $accounts[$mfp_user]['theme']?></i>"</dd>
	</dl>
</div>

<div class="box">
<h3><img src="<?php echo img('src')?>" class="ico" alt="<?php echo $l['info']?>"> script</h3>
	<dl class="aligned">
		<dt>Domain: </dt>
		<dd><?php echo $_SERVER['HTTP_HOST']?></dd>

		<dt>Path: </dt>
		<dd><?php echo SELF?></dd>

		<dt>Url: </dt>
		<dd><a href="<?php echo dosid('http://'.$_SERVER['HTTP_HOST'].SELF)?>"><?php echo $_SERVER['HTTP_HOST'].SELF?></a></dd>


		<dt>languages: </dt>
		<dd><?php echo $langcount?></dd>

		<dt>themes: </dt>
		<dd><?php echo $themecount?></dd>
	</dl>
</div>

</div>
<?php
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
	<h3><img src="<?php echo img('perms')?>" class="ico" alt="<?php echo $l['perms']?>"> <?php echo $l['editperms']?></h3>
<?php
try {

	if(isset($_POST['edit'])) {

		foreach($_POST['mod'] as $file) {
			$path = new mfp_path($file['p']);

			$directlink  = directlink($path);
			$wrappedpath = wrap(h($path));
			$class = getCssClass(fullpath($path));

			$lstat = $path->lstat();
			$userinfo = _posix_getpwuid($lstat['uid']);
			$groupinfo = _posix_getgrgid($lstat['gid']);

			$owner = &$file['owner'];
			$group = &$file['group'];
			$other = &$file['other'];

			$mod = octdec(
				array_sum(init($file['owner'], array())) +
				array_sum(init($file['group'], array())) +
				array_sum(init($file['other'], array()))
			);

			if($mod > 0777) throw new Exception(sprintf($l['err']['unexpected'], ''));
			if(!$path->chmod($mod))
				throw new Exception(sprintf('Error setting permissions of "<var class="'.$class.'">%s</var>"',
					'<a href="'.$directlink
					.'" target="_blank">'.$wrappedpath.'</a>'));

			// clear file info cache
			clearstatcache();

			printf('Set permissions of "<var class="'.$class.'">%1$s</var>" to %2$s (%3$03o)',
				'<a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a>',
				perm2str($path->fileperms()%01000), $path->fileperms()%01000);
		} ?>
		<form name="mfp_form" action="javascript:window.close()" class="footer">
		<input name="closebut" type="submit" value="  <?php echo $l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
			opener.location.reload();
			document.mfp_form.closebut.focus();
		//-->
		</script>
		</form>
<?php
	} else {
		$path = new mfp_path($_GET['p']);

		$directlink  = directlink($path);
		$wrappedpath = wrap(h($path));
		$class = getCssClass($path);

		$uinfo = _posix_getpwuid($path->fileowner());
		$ginfo = _posix_getgrgid($path->filegroup());
		$mod   = $path->fileperms();

		?>
	<form method="post" action="<?php echo dosid(SELF.'?a=mod');?>" accept-charset="<?php echo $cfg['charset']?>">
	<input type="hidden" name="mod[0][p]" value="<?php echo h(init($_GET['p'], ''))?>">

	<center>
		<?php #needs new lang!!!?>
		<?php printf('Edit permissions of "<var class="'.getCssClass(fullpath($_GET['p'])).'">%1$s</var>":',
				'<a href="'.$directlink.
				'" target="_blank">'.$wrappedpath.'</a>')?>

		<table rules="rows">
		<tr>
			<th><img src="<?php echo img('user')?>" class="ico" alt="u"> Owner <br><small><?php echo $uinfo['name']?></small></th>
			<td><label for="ur"><input type="checkbox" name="mod[0][owner][]" id="ur" value="0400" <?php echo ($mod & 0400) ? 'checked' : ''?>> r</label></td>
			<td><label for="uw"><input type="checkbox" name="mod[0][owner][]" id="uw" value="0200" <?php echo ($mod & 0200) ? 'checked' : ''?>> w</label></td>
			<td><label for="ux"><input type="checkbox" name="mod[0][owner][]" id="ux" value="0100" <?php echo ($mod & 0100) ? 'checked' : ''?>> x</label></td>
		</tr>
		<tr>
			<th><img src="<?php echo img('group')?>" class="ico" alt="g"> Group <br><small><?php echo $ginfo['name']?></small></th>
			<td><label for="gr"><input type="checkbox" name="mod[0][group][]" id="gr" value="040" <?php echo ($mod & 040) ? 'checked' : ''?>> r</label></td>
			<td><label for="gw"><input type="checkbox" name="mod[0][group][]" id="gw" value="020" <?php echo ($mod & 020) ? 'checked' : ''?>> w</label></td>
			<td><label for="gx"><input type="checkbox" name="mod[0][group][]" id="gx" value="010" <?php echo ($mod & 010) ? 'checked' : ''?>> x</label></td>
		</tr>
		<tr>
			<th><img src="<?php echo img('others')?>" class="ico" alt="o"> Others</th>
			<td><label for="or"><input type="checkbox" name="mod[0][other][]" id="or" value="04" <?php echo ($mod & 04) ? 'checked' : ''?>> r</label></td>
			<td><label for="ow"><input type="checkbox" name="mod[0][other][]" id="ow" value="02" <?php echo ($mod & 02) ? 'checked' : ''?>> w</label></td>
			<td><label for="ox"><input type="checkbox" name="mod[0][other][]" id="ox" value="01" <?php echo ($mod & 01) ? 'checked' : ''?>> x</label></td>
		</tr>
		</table>
	</center>

		<div class="footer">
		<input type="button" value="  <?php echo $l['cancel']?>  " onClick="window.close()">
		<input type="reset" value="<?php echo $l['reset']?>">
		<input type="submit" name="edit" value="<?php echo $l['editperms']?>">
		</div>
	</form>
<?php }
} catch(Exception $e) {
	echo '<div class="error">', $e->getMessage(), '</div>';
}
?>

	</div>
<?php
break;
//^^mod^^

//__multi__
//multiple file ops, still under *construction*
// down/zip working
case 'multi':
$dir = &$_REQUEST['d'];

if(isset($_POST['chks']) && count($_POST['chks'])) {
	// create list filled with checked boxes
	$checkboxes = new mfp_list($_POST['chks']);

	//quickfick
	if(isset($_POST['add']) || isset($_POST['sub'])) {
		$clipboard = &$_SESSION['mfp']['clipboard'];

		// loop checkboxes and then decide what to do!
		foreach($checkboxes as $key => $file) {

			$path = $dir.'/'.$file;
			$fullpath = fullpath($path);
			echo '<br>dir "', $dir, '" / path "', $path, '":&nbsp;';

			try {
				if(!allowed($fullpath)) throw new Exception($l['err']['forbidden']);
				if(!is_file($fullpath)) throw new Exception(sprintf($l['err']['nofile'], '<var class="file">'.$path.'</var>'));

				// subaction (add, substract):
				if(isset($_POST['add'])) {
					// check for duplicates
					if(!in_array($path, $clipboard)) {
						$clipboard[] = $path;
						echo 'added to clipboard';
					}
				} elseif(isset($_POST['sub'])) {
					if(in_array($path, $clipboard)) {
						unset($clipboard[$key]);
						echo 'removed from clipboard';
					}
				}
			} catch(Exception $e) {
				echo '<div class="error">', $e->getMessage(), '</div>';
			}
		}

		// list clipboard
		redirect(dosid(SELF.'?a=clip&list', '&'));
	}

	//__ren__
	if(isset($_POST['ren'])) {
		$title = $l['title']['ren']; ?>
		<div class="box">
		<h3><img src="<?php echo img('ren')?>" class="ico" alt="<?php echo $l['rename']?>"> <?php echo $l['rename']?></h3>
		<form method="post" action="<?php echo dosid(SELF.'?a=ren')?>" name="renform" onSubmit="return chkform(); return false;" accept-charset="<?php echo $cfg['charset']?>">
<?php #<input type="hidden" name="oldpaths" value='< ?=base64_encode(serialize($checkboxes->getArray()));? >'>?>
<?php
			foreach($checkboxes as $file) {
				$path = ($dir.'/'.$file);
				$basename = h(basename($path));
?>
				<div><input type="hidden" name="ps[]" value="<?php echo h($path)?>">
				<input type="text" name="newnames[]" value="<?php echo $basename?>"></div>
<?php } ?>
			<div class="footer">
			<input type="submit" name="rename" value=" <?php echo $l['rename']?> ">&nbsp;
			<input type="reset" value=" <?php echo $l['reset']?> ">&nbsp;
			<input type="button" value="  <?php echo $l['cancel']?>  " onClick="window.close()">
			</div>
		</form>
		</div>
<?php
	//__del__
	} elseif(isset($_POST['del'])) {
		$title = $l['title']['del']; ?>
		<div class="box">
		<h3><img src="<?php echo img('del')?>" class="ico" alt="<?php echo $l['delete']?>"> <?php echo $l['delete']?></h3>
<?php
			if(!is_writeable(fullpath($dir))) printf('<div class="warn">'.$l['err']['writable'].'</div>', '<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.u($dir)).'" target="_blank">'.h($dir.'/').'</a></var>');
?>
		<ul>
<?php
		foreach($checkboxes as $file) {
			$path = ($dir.'/'.$file);
			$wrappedpath = wrap(h($path));

			echo "\t\t\t", '<li class="file">',
			sprintf($GLOBALS['l']['warn']['reallydel'],
				'<var><a href="'.h($path)
				.'" target="_blank">'.$wrappedpath.'</a></var>'),
			"</li>\n";
		} ?>
		</ul>

		<form method="post" action="<?php echo dosid(SELF.'?a=del&amp;d='.u($dir))?>" class="footer" accept-charset="<?php echo $cfg['charset']?>">
			<input type="hidden" name="ps" value='<?php echo u(json_encode($checkboxes->getArray()));?>'>
			<input type="submit" name="delete" value=" <?php echo $l['delete']?> ">&nbsp;
			<input type="button" value="  <?php echo $l['cancel']?>  " onClick="window.close()">
		</form>
		</div>
<?php

	//__src__
	} elseif(isset($_POST['src'])) { $title = $l['title']['src']; ?>
<?php
		foreach($checkboxes as $file) {
			try {
				if(!isset($file)) throw new Exception($l['err']['nofile']); // ??? needed?
				$file = new mfp_file($dir.'/'.$file);

				$directlink  = directLink($file);
				$wrappedpath = wrap(h($file, 80));
			?>
				<div style="border:1px solid <?php echo $c['border']['fix']?>; padding:0.4em; -moz-border-radius:1em;">
				<?php
				// newest approach
				// http://www.selfphp.info/kochbuch/kochbuch.php?code=39

					// buffering highlighted source
					$source = $file->show_source();

					$lines     = $file->file();
					$linecount = count($lines);
					$length    = strlen($linecount);
					$numbers   = '';

					for($i=1;$i<=$linecount;$i++) {
							$curnumber = str_pad($i, $length, "0", STR_PAD_LEFT);
					if(!($i%10)) $curnumber = '<a name="'.$i.'" href="'.dosid(SELF.'?a=src&amp;p='.$file).'#'.$i.'" class="b">'.$curnumber.'</a>';
							$numbers .= $curnumber. "<br>\n";
					}

				// shows colored source
				// with line numbers
				// new try with floating divs
				?>
				<!--  -->
				<var class="file"><a href="<?php echo $directlink?>" target="_blank"><?php echo $wrappedpath?></a></var>
				<table>
				<tr>
					<td class="enum" style="background-color:<?php echo $c['bg']['input']?>; border-right:1px solid <?php echo $c['border']['lite']?>; -moz-border-radius:0.5em 0 0 0.5em;"><code><?php echo $numbers?></code></td>
					<td style="background-color:<?php echo $c['bg']['inputlite']?>; padding-left:1em; -moz-border-radius:0 0.5em 0.5em 0;"><?php echo $source?></td>
				</tr>
				</table>
				<!-- rendering floated divs is obviously more resource-hungry -->
				<!-- sth is broken with divs anyways... float + min-width+overflow!!!-->
				</div>
				<?php
			} catch (Exception $e) {
				echo '<div class="error">', $e->getMessage(), '</div>';
			}
		}
		#echo '</div>';

	//__down__
	} elseif(isset($_POST['down'])) {
	// create zip of files and send to browser

		// load lib
		require_once($cfg['dirs']['libs'].'/zip.lib.php');

		session_write_close();

		$zip = new zipfile();

		// add checked files to zipfile
		foreach($checkboxes as $file) {
			try {
				$file = new mfp_file($dir.'/'.$file);

				if(($content = $file->file_get_contents()) === FALSE) throw new Exception(sprintf($l['err']['openfile'], '<var class="file">'.h($file).'</var>'));

				$zip->addFile($content, $file->basename());
			} catch (Exception $e) {
				echo '<div class="error">', $e->getMessage(), '</div>';
				// also log messages
				mfp_log($e->getMessage());
			}
		}

		// delete all buffers
		while(ob_get_level()) {
			ob_end_clean();
		}

		$zipdump = $zip->file();
		// send headers
		header('Content-type: application/zip');
		header('Content-encoding: none');
		header('Content-length: ' . strlen($zipdump));
		header('Content-Disposition: attachment; filename="'.basename(realpath(fullpath($dir))).'.zip"');

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
<div class="box">
<h3><img src="<?php echo (isset($_POST['what']) && $_POST['what'] == 'dir') ? img('newdir') : img('newfile')?>" class="ico" alt="<?php echo $l['new']?>"> <?php echo $title?></h3>
<?php
try {
	$dir = &$_GET['d'];

	if(!isset($_POST['create'])) throw new Exception('Forbidden!');
	if(!allowed(fullpath($dir))) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.$dir.'</var>'));
	if(!isset($_POST['newname']) || $_POST['newname'] == '') throw new Exception($l['err']['emptyfield']);

	if(!is_writeable(fullpath($dir))) throw new Exception(sprintf($l['err']['writable'], '<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.u($dir).'" target="_blank">'.wrap(h($dir.'/')).'</a></var>')));

	$newname = $dir.'/'.$_POST['newname'];
	$url_name = u($newname);
	$wrappedpath = wrap(h($newname));
	$fullnewname = fullpath($newname);

	//possibility to extend in future eg: 'link', 'archive', ...
	switch($_POST['what']) {

		case 'dir':
			$wrappedpath .= '/';
			if(file_exists($fullnewname)) throw new Exception(sprintf($l['err']['direxists'],
					'<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.$url_name)
					.'" target="_blank">'.$wrappedpath.'</a></var>'));
			if(!mkdir($fullnewname)) throw new Exception(sprintf($l['err']['createdir'], '<var class="dir">'.$wrappedpath.'</var>'));

			printf($l['ok']['createdir'],
						'<var class="dir"><a href="'. dosid(SELF.'?a=view&amp;d='.$url_name)
						.'" target="view" onclick="opener.location=this.href;window.close();">'. $wrappedpath.'</a></var>');
		break;

		case 'file':
			$directlink = directlink($newname);
			if(file_exists($fullnewname)) throw new Exception(sprintf($l['err']['fileexists'],
					'<var class="file"><a href="'.$url_name
					.'" target="_blank">'.$wrappedpath.'</a></var>',
					getfsize(filesize($newname))));
			if(!touch($fullnewname)) throw new Exception(sprintf($l['err']['createfile'], '<var class="file">'.$wrappedpath.'</var>'));

			printf($l['ok']['createfile'],
				'<var class="file"><a href="'.$directlink
				.'" target="_blank">'.$wrappedpath.'</a></var>');
		break;

		default: throw new Exception($l['err']['unknown']);
	}

?>
	<form name="mfp_form" action="javascript:window.close()" accept-charset="<?php echo $cfg['charset']?>">
	<input name="closebut" type="submit" value="  <?php echo $l['close']?>  " onClick="window.close()">

	<?php echo $_POST['what'] == 'file' ? '<input name="editbut" type="button" value="  '.$l['editcode'].'  " onClick="document.location = \''.dosid(SELF.'?a=edit&amp;p='.u($newname)).'\';">' : "\n" ?>

	<script type="text/javascript" language="JavaScript">
	<!--
		opener.document.quickform.newname.value = "";
		opener.location.reload();
		opener.parent.tree.location.reload();

		document.mfp_form.closebut.focus();
	//-->
	</script>
	</form>

<?php
} catch(Exception $e) {
	echo '<div class="error">', $e->getMessage(), '</div>';
}
?>

</div>
<?php
break;
//^^new^^

//__props__
case 'props':
// file properties
$title = $l['title']['props'];

$imgexts = array('gif', 'jpg', 'jpeg', 'jpe', 'png', 'svg', 'svgz', 'tif', 'tiff');
?>
	<div id="scroll">
<?php
try {

	$path = new mfp_path($_GET['p']);

	$lstat = $path->lstat();
	$owner = _posix_getpwuid($lstat['uid']);
	$group = _posix_getgrgid($lstat['gid']);

	// get pathinfo on relative path
	$pathinfo = pathinfo($path);
	if(!isset($pathinfo['extension'])) $pathinfo['extension'] = ''

?>	
		<div class="box">
		<h3><img src="<?php echo img('info')?>" class="ico" alt="<?php echo $l['props']?>"> <?php echo $l['props']?></h3>

			<div class="box">
			<h3><img src="<?php echo img(getCssClass($path->fullpath()))?>" class="ico" alt="<?php echo $l['src']?>"> Info</h3>
			<dl>
				<dt>Name: </dt>
				<dd>"<i><?php echo wrap(h($pathinfo['basename']))?></i>"</dd>

				<dt><img src="<?php echo img('dir')?>" class="ico" alt="<?php echo $l['dir']?>"> Directory: </dt>
				<dd>"<i><?php echo wrap(h($pathinfo['dirname']).'/')?></i>"</dd>

<?php if($path->is_file()) { ?>
				<dt>Size: </dt>
				<dd>"<i><?php echo getfsize($lstat['size'])?></i>"</dd>

				<dt>Extension: </dt>
				<dd>"<i><?php echo h($pathinfo['extension'])?></i>"</dd>
<?php } ?>

				<dt><img src="<?php echo img('edit')?>" class="ico" alt="<?php echo $l['edit']?>"> Last modified: </dt>
				<dd>"<i><?php echo @date($l['fulldate'], $lstat['mtime'])?></i>"</dd>

				<dt>Last accessed: </dt>
				<dd>"<i><?php echo @date($l['fulldate'], $lstat['atime'])?></i>"</dd>
			</dl>

			</div>

			<div class="box">
			<h3><img src="<?php echo img('perms')?>" class="ico" alt="<?php echo $l['perms']?>"> Permissions</h3>
			<dl class="aligned">
				<dt>Permissions: </dt>
				<dd>"<i><?php echo perm2str($lstat['mode'])?> (<?php printf('%03o', $lstat['mode']%01000)?>)</i>"</dd>

<?php // only show owner and group on posix systems
if($owner && $group) { ?>
				<dt><img src="<?php echo img('user')?>" class="ico" alt="<?php echo $l['user']?>"> Owner: </dt>
				<dd>"<i><?php echo $owner['name']?></i>"</dd>

				<dt><img src="<?php echo img('group')?>" class="ico" alt="<?php echo $l['group']?>"> Group: </dt>
				<dd>"<i><?php echo $group['name']?></i>"</dd>
<?php } ?>
			</dl>
			</div>

			<div class="box">
			<h3><a href="<?php echo dosid(SELF.'?a=src&amp;p='.u($path))?>" title="<?php echo $l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?php echo img('src')?>" class="ico" alt="<?php echo $l['src']?>"></a> Preview</h3>
<?php if($path->is_file()) {
		// file is an image?
		if(in_array($pathinfo['extension'], $imgexts)) {
			list($h, $w) = getimagesize($path);
?>
				<img src="<?php echo dosid(SELF.'?a=thumb&amp;img='.u($path).'&amp;size=100')?>" style="float:left; margin-right:10px; width:100px; height:100px;" alt="<?php echo $l['thumb']?>">
				<div>
				<?php echo $w?>px x <?php echo $h?>px<br>
				</div>
<?php // no image -> show textcontent
	} else {
		echo '<code>';
		if($path->is_readable()) {
			$file = new mfp_file($path);
			$file->fopen('rb+');
			$fsize = $file->filesize();
			if($fsize > 0) $cont = $file->fread($cfg['previewlen']);
			else $cont = '';
			$file->fclose();
			echo nl2br(h($cont));
		} else {
			printf('<div class="error">'.$l['err']['readable'].'</div>', '<var class="file">'.h($path).'</var>');
		}
		echo '</code>';
	}
} elseif($path->is_dir()) {
	$dircount = $filecount = 0;
	$filesizes = 0;
	$dir = new mfp_dir($path);
	foreach($dir as $file) {
		$filepath = $path.'/'.$file;
		$fullfilepath = fullpath($filepath);
		if(allowed($fullfilepath)) {
			if($file == '.' || $file == '..') continue;
			if(is_dir($fullfilepath)) {
				 $dircount++;
			} elseif(is_file($fullfilepath)) {
				$filecount++;
				$filesizes += @filesize($fullfilepath);
			}
		}
	}
?>
			<img src="<?php echo img('dir')?>" style="float:left; margin-right:10px; width:100px; height:100px;" alt="<?php echo $l['dir']?>">
			<dl style="float:left;">
				<dt>Files: </dt>
				<dd><?php echo $filecount?></dd>

				<dt>Directories: </dt>
				<dd><?php echo $dircount?></dd>

				<dt>Size: </dt>
				<dd><?php echo getfsize($filesizes)?></dd>
			</dl>
<?php } ?>
			<div style="clear:both;"></div>
		</div>

	</div>
<?php
	} catch(Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}
?>
	</div>

<?php
break;
//^^props^^


//__rem__
case 'rem':
//remove directory recursive
$title = $l['title']['rem'];
?>
<div class="box">
<h3><img src="<?php echo img('rem')?>" class="ico" alt="<?php echo $l['remove']?>"> <?php echo $title?></h3>

<?php
try {
	$dir = new mfp_dir($_GET['d']);
	if(!allowed($dir->fullpath())) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.$dir.'</var>'));

	if(isset($_POST['remove'])) {
		$wrapdir = wrap(h($dir));

		function recursiveRem($dir) {
			global $debug;
			$fulldir = fullpath($dir);

			if(!is_writeable($fulldir)) return FALSE; // skip writeprotected dirs

			$h = new mfp_dir_iterator($fulldir);
			foreach($h as $file) {
				if($file == '.' || $file == '..') continue;
				$path = $dir.'/'.$file;
				$fullpath = $fulldir.'/'.$file;

				// coz of symlinks
				if(!allowed($fullpath)) continue; // skip rest of loop

				if(is_dir($fullpath)) {
					//recursion
					recursiveRem($path);
					rmdir($fullpath);
					$debug.= '<br><b>dir: '.$fullpath.'</b>';
				} else {
					unlink($fullpath);
					$debug.= '<br>file: '.$fullpath;
				}
			}
			return TRUE;
		}

		//recursion
		if(!($dir->is_writeable() && recursiveRem($dir))) throw new Exception(sprintf($l['err']['removedir'], '<var class="dir">'.$wrapdir.'</var>'));

		//remove directory itself
		// shouldn't remove homedir - needs workaround
		if($dir->realpath() == REALHOME) die('permission denied');

		if(!$dir->allowed()) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.$wrapdir.'</var>'));
		if(!$dir->rmdir()) throw new Exception(sprintf($l['err']['removedir'], '<var class="dir">'.$wrapdir.'</var>'));

		printf($l['ok']['removedir'], '<var class="dir">'.$wrapdir.'</var>');
?>
		<form name="mfp_form" action="javascript:window.close()" accept-charset="<?php echo $cfg['charset']?>">
		<input name="closebut" type="submit" value="  <?php echo $l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
			opener.location.reload();
			opener.parent.tree.location.reload();

			document.mfp_form.closebut.focus();
		//-->
		</script>
		</form>
<?php

	} else {
	// confirm - very ugly
	$url_dir = u($dir);
	$wrappeddir = wrap(h($dir));
	?>
	<?php printf($l['warn']['reallyrem'],
		'<var class="dir"><a href="'. dosid(SELF.'?a=view&amp;d='.$url_dir)
		.'" target="_blank">'.$wrappeddir.'</a></var>')?><br>
	<div class="warn"><?php echo $l['warn']['alldirs']?></div>
	<?php if(!is_writeable(fullpath($dir))) printf('<div class="warn">'.$l['err']['writable'].'</div>', '<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.$url_dir).'" target="_blank">'.$wrappeddir.'</a></var>');?>
	<form method="post" action="<?php echo dosid(SELF.'?a=rem&amp;d='.$url_dir)?>" onSubmit="return confirm('Remove <?php echo h($dir)?>?'); return false;" accept-charset="<?php echo $cfg['charset']?>" class="footer">
		<input type="submit" name="remove" value=" <?php echo $l['remove']?> ">&nbsp;
		<input type="button" name="cancel" value="  <?php echo $l['cancel']?>  " onClick="window.close()">
	</form>
<?php }
} catch(Exception $e) {
	echo '<div class="error">', $e->getMessage(), '</div>';
} ?>

</div>

<?php
break;
//^^rem^^


//__ren__
case 'ren':
$title = $l['title']['ren'];
?>
<div class="box">
<h3><img src="<?php echo img('ren')?>" class="ico" alt="<?php echo $l['rename']?>"> <?php echo $l['rename']?></h3>
<?php
	try {

		if(isset($_POST['rename'])) {
			#$oldpaths = unserialize(base64_decode($_POST['oldpaths']));
			$oldpaths = &$_POST['ps'];
			$newnames = &$_POST['newnames'];

			function makeRenArray($oldpath, $newname) {
				return array('oldpath' => $oldpath, 'newname' => $newname);
			}
			$newnames = new mfp_list(array_map('makeRenArray', $oldpaths, $newnames));

			echo '<ul>';
			foreach($newnames as $file) {
				$class = getCssClass(fullpath($file['oldpath']));

				echo '<li class="';

				try {
					$oldpath = &$file['oldpath'];
					$path = new mfp_path($oldpath);
					$wrappedoldpath = wrap(h($oldpath));

					$newname = &$file['newname'];
					$directlink = directLink($newname);
					$wrappedpath = wrap(h($newname));

					if((!isset($newname) || $newname == '')) { throw new Exception(sprintf($l['err']['emptyfield'])); }

					if(!$path->rename($newname)) {
						throw new Exception(sprintf($l['err']['rename'], '<var>'.$wrappedoldpath.'</var>', '<var>'.$wrappedpath.'</var>'));
					}

					printf($class.'">'.$l['ok']['rename'], $wrappedoldpath,
						'<var><a href="'.$directlink
						.'" target="_blank">'.$wrappedpath.'</a></var>');
				} catch(Exception $e) {
					echo 'error">', $e->getMessage();
				}
				echo "</li>\n";
			}
		?>
		</ul>
		<form name="mfp_form" action="javascript:window.close()">
		<input name="closebut" type="submit" value="  <?php echo $l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
			opener.location.reload();
			document.mfp_form.closebut.focus();
		//-->
		</script>
		</form>
<?php
	} else {
		$path = new mfp_path($_GET['p']);
	?>
	<script type="text/javascript" language="JavaScript">
	<!--
		function chkform() {
			if(document.forms.renform.newname.value == '') {
				alert('<?php echo $l['err']['emptyfield']?>');
				return false;
			}
			return true;
		}
	//-->
	</script>


	<form method="post" action="<?php echo dosid(SELF.'?a=ren')?>" name="renform" onSubmit="return chkform(); return false;" accept-charset="<?php echo $cfg['charset']?>">
		<?php printf($l['renameto'],
				'<var class="'.$path->getCssClass().'"><a href="'. h($path->directLink())
				.'" target="_blank">'. wrap(h(basename($path))) .'</a></var>');
			$dir = dirname($path);
			$url_dir = u($dir);
			$wrappeddir = wrap(h($dir));;
			if(!is_writeable(fullpath($dir))) printf('<div class="warn">'.$l['err']['writable'].'</div>', '<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.$url_dir).'" target="_blank">'.$wrappeddir.'</a></var>');
		?>
		<div>
		<?php #<input type="hidden" name="oldpaths" value='< ?=base64_encode(serialize(array($path)));? >'>?>
		<input type="hidden" name="ps[]" value="<?php echo h($path)?>">
		<input type="text" name="newnames[]" value="<?php echo h($path->basename())?>"></div>

		<div class="footer">
		<input type="submit" name="rename" value="<?php echo $l['rename']?>">
		<input type="reset" value="<?php echo $l['reset']?>">
		<input type="button" value="<?php echo $l['cancel']?>" onClick="window.close()">
		</div>
	</form>

<?php
		}
	} catch(Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}
	?>
</div>
<?php
break;
//^^ren^^

//__src__
case 'src':
// show source code
$title = $l['title']['src'];
$file = &$_GET['p'];

	try {
		if(!isset($file)) throw new Exception($l['err']['nofile']); // ??? needed?

		$file = new mfp_file($file);
		$directlink  = directLink($file);
		$wrappedpath = wrap(h($file, 100));

		if(!$file->is_readable()) throw new Exception(sprintf($l['err']['readable'], '<var class="file">'.$wrappedpath.'</var>'));
	?>
		<div id="fix">
			<form method="post" action="<?php echo dosid(SELF.'?a=edit&amp;p='.u($file))?>" target="editwin" onSubmit="popUp(this.action, 'editwin', 'width=640,height=480');">
			<input type="submit" name="edit" value="<?php echo $l['editcode']?>">&nbsp;
			<input type="button" name="reload" value="<?php echo $l['reload']?>" onClick="window.location.reload()">&nbsp;
			<input type="button" name="close" value="<?php echo $l['close']?>" onClick="window.close()">&nbsp;
			<var class="file"><a href="<?php echo $directlink?>" target="_blank"><?php echo $wrappedpath?></a></var>
			</form>
		</div>

		<div id="scroll" style="border:1px solid <?php echo $c['border']['fix']?>; padding:0.4em; -moz-border-radius:1em;">
		<?php
		// newest approach
		// http://www.selfphp.info/kochbuch/kochbuch.php?code=39


			// buffering highlighted source
			$source = $file->show_source();

			$lines     = $file->file();
			$linecount = count($lines);
			$length    = strlen($linecount);
			$numbers   = '';

			for($i=1;$i<=$linecount;$i++) {
					$curnumber = str_pad($i, $length, "0", STR_PAD_LEFT);
					if(!($i%10)) $curnumber = '<a name="'.$i.'" href="'.dosid(SELF.'?a=src&amp;p='.$file).'#'.$i.'" class="b">'.$curnumber.'</a>';
					$numbers .= $curnumber. "<br>\n";
			}

		// shows colored source
		// with line numbers
		// new try with floating divs
		?>
		<!--  -->
		<table>
		<tr>
			<td class="enum" style="background-color:<?php echo $c['bg']['input']?>; border-right:1px solid <?php echo $c['border']['lite']?>; -moz-border-radius:0.5em 0 0 0.5em;"><code><?php echo $numbers?></code></td>
			<td style="background-color:<?php echo $c['bg']['inputlite']?>; padding-left:1em; -moz-border-radius:0 0.5em 0.5em 0;"><?php echo $source?></td>
		</tr>
		</table>
		<?php #!-- rendering floated divs is obviously more resource-hungry -->
		#<!-- sth is broken anyway with divs... float + min-width+overflow!!!--?>
		</div>
		<?php
	} catch (Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}
break;
//^^src^^


//__thumb__
case 'thumb':
// create thumbnailed images
// see http://www.weberdev.com/ViewArticle-388.html

	$maxw = $cfg['thumbs']['max']['w'];
	$maxh = $cfg['thumbs']['max']['h'];
	$resizeall = $cfg['thumbs']['resizeall'];

	$img = &$_GET['p'];
	$refresh = isset($_GET['refresh']);
	if(isset($_GET['size'])) $maxw = $maxh = $_GET['size'];

	try {
		if(!isset($img)) throw new Exception($l['err']['nofile']); // ??? needed?
		$img = new mfp_file($img);
		$cachefile = $cfg['dirs']['cache'].'/'.md5($img->realpath()).$img->filemtime().'.png';

		ob_end_clean();

		if($cfg['thumbs']['cache']['enabled'] && file_exists($cachefile) && !$refresh) {
			// read cached file to buffer
			readfile($cachefile);
		} else {

			// avoid probs with empty files (0bytes)
			if($img->filesize() != 0) {
				list($w, $h, $type) = $img->getimagesize();

				switch($type) {
					case 1: // gif
						$oldimg = $img->imageCreateFromGif();
					break;
					case 2: // jpg
						$oldimg = $img->imageCreateFromJpeg();
					break;
					case 3: // png
						$oldimg = $img->imageCreateFromPng();
					break;
					default: // other, draw error icon
						$resizeall = TRUE;

						list($w, $h) = getimagesize(img('error'));
						$oldimg = imageCreateFromPng(img('error'));
				}

				$ratio = 1;
				if(($w > $maxw || $h > $maxh) || $resizeall) {
					if($w > $h) {
						$ratio = $maxw / $w;
					} elseif($h > $w) {
						$ratio = $maxh / $h;
					} else { // $w == $h
						$ratio = max($maxw, $maxh) / $w;
					}
				}
				$nw = $w * $ratio;
				$nh = $h * $ratio;

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
			if($cfg['thumbs']['cache']['enabled'] && is_writeable($cfg['dirs']['cache'])) {
				imagePng($newimg, $cachefile);
			}

			imageDestroy($newimg);
		}

		//png in most cases better
		header('Content-Type: image/png');
	} catch (Exception $e) {
		echo $e->getMessage();
		// log message
		mfp_log($e->getMessage());
	}

	// end script - no further output
	exit;
break;
//^^thumb^^


//__tree__
case 't':
case 'tree':
// directories: tree view
$title = $l['title']['tree'];

	//if no dir was passed, use home instead
	$dir = init($_GET['d'], '.');
	// fallback to HOME on forbidden dirs
	if(!allowed(fullpath($dir))) $dir = '.';

	try {
		$dir = new mfp_dir($dir);

		// the actual depth of directory tree
		$maxlevel = 0;

		// walk through directories recursive
		// returns list of directories in current dir
		// now sortable! guess it works even better than tree-like-array for now
		function buildTreeList($dir, $depth = 0) {
			global $maxlevel;
			static $nowlevel = 0;
			static $dirs = array();

			$fulldir = fullpath($dir);
			if(!file_exists($fulldir)) printf('<br><br>'.$GLOBALS['l']['err']['baddir'], '<var class="dir">'.$dir.'</var>');

			$nowlevel++;
			// set actual maximum depth
			$maxlevel = $maxlevel < $nowlevel ? $nowlevel : $maxlevel;

			if(!is_readable($fulldir)) return FALSE;

			// maximum depth reached > do not loop dir
			if($depth != 0 && $nowlevel > $depth) return $dirs;

			$h = new mfp_dir_iterator($fulldir);
			foreach($h as $file) {
				if($file == '.' || $file == '..') continue;

				$path = $dir.'/'.$file;
				$fullpath = $fulldir.'/'.$file;
				if(is_dir($fullpath) && allowed($fullpath)) {

					// set directory info
					$dirs[$fullpath] = array (
						'name'  => $file,
						'path'  => $path,
						'level' => $nowlevel,
						'fileCount' => 0,
						'link' => is_link($path)
					);

					//descend deeper
					buildTreeList($path, $depth);

					//level down -in logical structure up
					$nowlevel--;
				} // no directory: file, link > increase counter
				#$dirs[$path]['fileCount']++;
			}
			return $dirs;
		}

		// print header line
		// watch out, tricky torn apart tags due to nested lists
		?>
	<div id="fix" style="text-align:center;">
		<a href="<?php echo dosid(SELF.'?a=tree&amp;d='.u(HOME));?>" title="<?php echo $l['home']?>"><img src="<?php echo img('home')?>" class="ico" alt="<?php echo $l['home']?>"></a>
		<a href="<?php echo dosid(h(URI));?>" title="<?php echo $l['reload']?>"><img src="<?php echo img('reload')?>" class="ico" alt="<?php echo $l['reload']?>"></a>
	</div>

	<div id="scroll">
		<ul class="tree">

			<li class="home">
				<a href="<?php echo dosid(SELF.'?a=view&amp;d=.')?>" target="view" title="<?php echo $l['home']?>">Home [<?php echo h(basename(realpath(HOME))) ?>]</a>
				<?php
		if($dir->realpath() != REALHOME) {
			$breadcrumbs = $dir->breadcrumbs();
			echo "<ul>\n"; // ordered list???

			foreach($breadcrumbs as $path) {
?>
				<li><a href="<?php echo dosid(SELF.'?a=view&amp;d='.u($path))?>" target="view" title="<?php echo $l['changedir']?>"><?php echo h(basename(realpath(fullpath($path))))?></a></li>
<?php
			}
?>
				</ul>
			</li>
			<li class="home">
				<a href="<?php echo dosid(SELF.'?a=view&amp;d='.u($dir))?>" target="view" title="<?php echo $l['changedir']?>"><?php echo h($dir->basename()) ?></a>
<?php
		}

		// open requested dir and sort by keys
		$dirs = buildTreeList($dir, $cfg['tree']['depth']);
		uksort($dirs, create_function('$a, $b',
			'return strcoll(strtolower($a), strtolower($b));'));

		// formatted output with lists, saves tables...
		$prevlevel = 0;
		if($dirs) {
			foreach($dirs as $path => $info) {
				$curlevel = $info['level'];
				// 0: same level/parent -: to parent level +: to child level
				$level = $prevlevel > $curlevel ? -1 :
								($prevlevel < $curlevel ? 1 : 0);
				// create nested lists
				switch($level) {
					case 1: echo "\n", str_repeat("\t", $curlevel+3), '<ul>', "\n";
					break;
					case -1: echo "</li>\n", str_repeat("\t", $prevlevel+3), "</ul>\n", str_repeat("\t", $prevlevel+3);
					// no break!
					default: echo "</li>\n";
				}
				// indent html code
				echo str_repeat("\t", $curlevel);
?>
				<li><a href="<?php echo dosid(SELF.'?a=view&amp;d='.u($info['path']))?>" target="view" title="<?php echo $l['changedir']?>"><?php echo h($info['name'])?></a><?php
				$prevlevel = $info['level'];
			}
			// add missing closing tags | got it working :)
			for($prevlevel; $prevlevel > 0; $prevlevel--) {
				echo "</li>\n", str_repeat("\t", $prevlevel+3), '</ul>', "\n";
			}
		} else {
			echo '<ul><li>';
			echo $l['err']['nodirs'];
			echo '</li></ul>';
		}
		echo "\t\t\t</li>\n\t\t</ul>\n\t</div>";
	} catch(Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}

break;
//^^tree^^

//__up__
case 'up':
// file upload
$title = $l['title']['up'];
?>

<div id="scroll">
<div class="box" style="margin-top:2em;">
<h3><img src="<?php echo img('upload')?>" class="ico" alt="<?php echo $l['upload']?>"> <?php echo $title?></h3>

<?php

// sent form
try {
	// !!!
	$max_upsize_byte = min(getrealsize(ini_get('upload_max_filesize')), getrealsize(ini_get('post_max_size')));
	$max_upsize = getfsize($max_upsize_byte);

	if(isset($_POST['upload'])) {

		$dir = new mfp_dir($_GET['d']);
		// overwrite existing files?
		$overwrite = isset($_POST['over']);

		if(!allowed($dir->fullpath())) throw new Exception(sprintf($l['err']['forbidden'], '<var class="dir">'.h($dir).'</var>'));

		echo '<ul>';

		$uploadedFilesCount = count($_FILES['file']['name']);
		for($i=0; $i < $uploadedFilesCount; $i++) {
			$remotename = &$_FILES['file']['name'][$i];
			if($remotename == "") continue;

			$tmpname    = &$_FILES['file']['tmp_name'][$i];
			$newname    = $dir.'/'.$remotename;
			$fullnewname = fullpath($newname);

			$filesize = &$_FILES['file']['size'][$i];
			$filetype = &$_FILES['file']['type'][$i];

			$errorcode = &$_FILES['file']['error'][$i];

			echo '<li class="';
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
					case UPLOAD_ERR_NO_TMP_DIR:
						throw new Exception('Temp folder is missing!');
					break;
					case 7: //UPLOAD_ERR_CANT_WRITE:
						throw new Exception('Can\'t write file to disk!');
					break;
					case 8: //UPLOAD_ERR_EXTENSION:
						// TODO
						// do not stop here...
					#break;

					case UPLOAD_ERR_OK:
						if(!$dir->is_writeable()) throw new Exception(sprintf($l['err']['writable'], '<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.u($dir)).'" target="_blank">'.wrap(h($dir.'/')).'</a></var>'));

						if(file_exists($fullnewname) && !$overwrite) throw new Exception(sprintf($l['err']['fileexists'], '<var><a href="'.  directLink($newname) .'" target="_blank">'. wrap(h($newname)) .'</a></var>', getfsize(filesize($fullnewname))));

						if(!move_uploaded_file($tmpname, $fullnewname)) throw new Exception(sprintf($l['err']['unexpected'], $errorcode));

						echo 'file">', sprintf($l['ok']['up'],
								'<var><a href="'. directLink($newname)
								.'" target="_blank">'. wrap(h($newname)) .'</a></var>',
								getfsize($filesize));
						echo '<br>';
						printf(ucfirst($l['filetype']).'<br>', '<var>'.$filetype.'</var>');
					break;
					default:
						echo $l['err']['up']['unknown'];
				}
			} catch(Exception $e) {
				echo 'error">',$e->getMessage();
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
		<input type="button" onClick="history.back();" value=" <?php echo $l['back']?> ">
		&nbsp;<input type="button" onClick="window.close();" value=" <?php echo $l['close']?> ">
		</div>
		<?php
	} else {
		$url_dir = u($_GET['d']);
		$wrappedpath = wrap(h($_GET['d']).'/');
	?>
		<form enctype="multipart/form-data" method="post" action="<?php echo dosid(SELF.'?a=up&amp;d='.$url_dir.'&amp;uploaded')?>" name="upform">
			<script type="text/javascript" language="JavaScript">
			<!--
				function addField() {
					if(document.getElementById) {
						var div = document.createElement('div');
						var nField = div.appendChild(document.createElement('input'));
							nField.type = 'file';
							nField.name = 'file[]';
							nField.size = '35';
						var upload = document.getElementById('upload');
						upload.parentNode.insertBefore(div, upload.nextSibling);
					} else {
						document.all['upload'].innerHTML = '\n<div><input type="file" name="file[]" size="35"></div>';
						alert('Please update your browser!');
					}

				}
			//-->
			</script>

			<?php // upload failed. POST gets unset, GET remains untouched
			if(isset($_GET['uploaded'])) echo '<div class="error">', $l['err']['up']['toobig'], '</div>'?>
			<?php if(!is_writeable(fullpath($_GET['d']))) printf('<div class="warn">'.$l['err']['writable'].'</div>',
					'<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.$url_dir)
					.'" target="_blank">'.$wrappedpath.'</a></var>')?>

			<?php printf($l['uploadto'],
				'<var class="dir"><a href="'.dosid(SELF.'?a=view&amp;d='.$url_dir)
				.'" target="_blank">'.$wrappedpath.'</a></var>'
			)?>:
			<div>
				<div id="upload"><input type="file" name="file[]" size="35"></div>
			</div>

			<div class="footer">
				<small>Max. size: <?php echo $max_upsize?></small>
				<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max_upsize_byte?>">
				<label for="over"><input type="checkbox" name="over" id="over"> <?php echo $l['overwrite']?></label>
				<input type="button" value="<?php echo $l['add']?>" onClick="addField()">
				<input type="button" value=" <?php echo $l['cancel']?> " onClick="window.close();">&nbsp;
				<input type="submit" name="upload" value=" <?php echo $l['upload']?> ">&nbsp;
			</div>
		</form>
<?php }
} catch(Exception $e) {
	echo '<div class="error">', $e->getMessage(), '</div>';
} ?>
</div>

<?php
break;
//^^up^^

//__user__
case 'user':
	$title = 'user preferences';

	$olduser  = $accounts[$mfp_user];
	$username = $mfp_user;
	$curpwd   = $olduser['pass'];
	$curhome  = $olduser['home'];
	$curlang  = $olduser['lang'];
	$curtheme = $olduser['theme'];

	$langs  = getLangs();
	$themes = getThemes();

	// putting current prefs first and sort list
	// avoids checking for selected value while looping TODO: benchmark this against ifs in above loop (for hundreds of langs)!
	unset($langs[array_search($curlang, $langs)]);
	sort($langs);
	array_unshift($langs, $curlang);

	unset($themes[array_search($curtheme, $themes)]);
	sort($themes);
	array_unshift($themes, $curtheme);
?>

<div id="scroll">

<?php
$newuser = $olduser;

if(isset($_POST['customize'])) {
	echo 'customizing<br>';
	if(isset($_POST['newlang'], $_POST['newtheme'])) {
		echo 'both set<br>';
		echo '<ul>';
		echo '<li>', $_POST['newlang'],'</li>';
		echo '<li>', $_POST['newtheme'],'</li>';
		echo '</ul>';
		$newuser['lang'] = $_POST['newlang'];
		$newuser['theme'] = $_POST['newtheme'];

		//set new language, session and reload page for changes to take place
		$_SESSION['mfp']['lang'] = $newuser['lang'];
		//set new theme, session and reload page for changes to take place
		$_SESSION['mfp']['theme'] = $newuser['theme'];

		redirect(dosid(URI, '&'));
	} else {
		echo 'not set<br>';
	}
}

$newaccounts = $accounts;
$newaccounts[$username] = $newuser;

?>


	<form method="post" action="<?php echo dosid(h(URI))?>">
	<div class="box">
	<h3><img src="<?php echo img('thumbs')?>" class="ico" alt="<?php echo $l['cust']?>"> <?php echo $l['cust']?></h3>
		<dl class="aligned">
			<dt><label for="newlang"><?php echo $l['lang']?></label></dt>
			<dd>
			<select size="0" name="newlang" id="newlang">
			<?php foreach($langs as $lang) {
					echo '<option>',$lang,'</option>';
				 } ?>
			</select>
			</dd>

			<dt><label for="newtheme">colors</label></dt>
			<dd>
			<select size="0" name="newtheme" id="newtheme">
			<?php
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

</div>

<?php
break;
//^^user^^

//__view__
case 'v':
case 'view':
// view single directories
	$title = $l['title']['view'];

	// if no dir was passed, use homedir instead
	$dir = init($_GET['d'], '.');
	$checkall = isset($_GET['checkall']);

	// create mfp_dir object
	try {
		$dir = new mfp_dir($dir);

		// sorting values | default: by name ascending
		$sort = init($_GET['sort'], '+name');
		$sortby = substr($sort,1);

		// initiate objects
		$viewdirs = new mfp_dirs();
		$viewfiles = new mfp_files();

		// open directory and read it
		if(!$dir->is_readable()) throw new Exception(sprintf($l['err']['readable'], h($dir)));

		foreach($dir as $file) {
			if($file == '.' || $file == '..') continue;
			// take the huge overhead for instancing mfp_path for each file???
			$path = $dir.'/'.$file;
			$fullpath = fullpath($path);

			// i don't think checking is needed. it happens at the appropiate places, and directory contents can be mostly trusted. worst case: symlinks that do not work after clicking them, because the target lies outside HOME
			//if(!allowed($fullpath)) continue;
			if(is_dir($fullpath)) {
				//directory
				$viewdirs->add(array(
					'name'  => $file,
					'path'  => ($path),
					'mtime' => filemtime($fullpath),
					'perm'  => fileperms($fullpath)%01000,
					'link'  => is_link($fullpath)
				));

			} else { // other(file)
				$viewfiles->add(array(
					'name' => $file,
					'path' => ($path),

					'size'  => filesize($fullpath),
					'mtime' => filemtime($fullpath),
					'perm'  => fileperms($fullpath)%01000,
					'link'  => is_link($fullpath)
				));
			}
		}

		// init current dir
		// cleaning
		$thisdir = pathTo(fullpath($dir));

		// realupdir: for checking allowance
		// to avoid problems when home dir is webroot or even real root
		$realupdir = @realpath(fullpath($thisdir.'/..'));
		// updir: for link generation
		$updir = pathTo($realupdir);
		if($updir == '') $updir = '.';
		#echo '<br>', $realupdir, '<br>', $updir;


		$breadcrumbs = $dir->breadcrumbs();
		if($dir->realpath() != REALHOME) { array_push($breadcrumbs, (string)$dir); }

		$url_dir = u($dir);
	?>

	<script type="text/javascript" language="JavaScript">
	<!--
		function chkform() {
			if(document.forms.quickform.newname.value == '') {
				alert("<?php echo $l['err']['emptyfield']?>");
				return false;
			}
			popUp('<?php echo dosid(SELF.'?a=new')?>', 'newwin');
			return true;
		}
	//-->
	</script>

	<!-- quick access panel, fixed -->
	<div id="fix">
	<form name="quickform" method="post" action="<?php echo dosid(SELF.'?a=new&amp;d='.u($thisdir))?>" onSubmit="return chkform(); return false;" target="newwin" accept-charset="<?php echo $cfg['charset']?>">

			<a href="<?php echo dosid(SELF.'?a=gallery&amp;d='.$url_dir)?>" title="<?php echo $l['viewgallery']?>"><img src="<?php echo img('thumbs')?>" class="ico" alt="<?php echo $l['viewgallery']?>"></a>
			<a href="<?php echo dosid(SELF.'?a=find&amp;d='.$url_dir)?>" title="<?php echo $l['find']?>"><img src="<?php echo img('find')?>" class="ico" alt="<?php echo $l['find']?>"></a>
			<a href="<?php echo dosid(h(URI));?>" title="<?php echo $l['reload']?>"><img src="<?php echo img('reload')?>" class="ico" alt="<?php echo $l['reload']?>"></a>
			<a href="<?php echo dosid(SELF.'?a=up&amp;d='.$url_dir)?>" onClick="popUp(this.href, 'upwin', 'width=460,height=200,status=yes'); return false;" title="<?php echo $l['uploadfile']?>"><img src="<?php echo img('upload')?>" class="ico" alt="<?php echo $l['upload']?>"></a>
			|
			<input id="quicktext" type="text" name="newname" maxlength="255" size="45">
			<label for="file" title="<?php echo $l['createnewfile']?>"><input type="radio" name="what" value="file" id="file">
			<img src="<?php echo img('newfile')?>" class="ico" alt="<?php echo $l['file']?>"> [<?php echo $viewfiles->count()?> | <?php echo getfsize($viewfiles->size())?>]&nbsp;</label>
			<label for="dir" title="<?php echo $l['createnewdir']?>"><input type="radio" name="what" value="dir" id="dir" checked>
			<img src="<?php echo img('newdir')?>" class="ico" alt="<?php echo $l['dir']?>"> [<?php echo $viewdirs->count()?>]</label>
			<input type="submit" name="create" value="<?php echo $l['new']?>">
			|
			<a href="<?php echo dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?php echo $l['view']?>"><img src="<?php echo img('clip')?>" class="ico" alt="<?php echo $l['clip']['list']?>"></a>
			[<?php echo count($_SESSION['mfp']['clipboard'])?>]
			<a href="<?php echo dosid(SELF.'?a=clip&amp;copy&amp;d='.$url_dir);?>"  onClick="popUp(this.href, 'clipwin'); return false;" title="<?php echo $l['copy']?>"><img src="<?php echo img('copy')?>" class="ico" alt="<?php echo $l['copy']?>"></a>
			<a href="<?php echo dosid(SELF.'?a=clip&amp;move&amp;d='.$url_dir);?>"  onClick="popUp(this.href, 'clipwin'); return false;" title="<?php echo $l['move']?>"><img src="<?php echo img('move')?>" class="ico" alt="<?php echo $l['move']?>"></a>
	</form>
	</div>

	<div id="scroll">
	<form name="form" method="post" action="<?php echo dosid(SELF.'?a=multi&amp;d='.$url_dir)?>" onSubmit="popUp(action, 'multiwin');" target="multiwin" accept-charset="<?php echo $cfg['charset']?>">

		<div class="breadcrumbs">
			<img src="<?php echo img('dir')?>" class="ico" alt="<?php echo $l['dir']?>">&nbsp;
			<a href="<?php echo dosid(SELF.'?a=view&amp;d=.')?>" title="<?php echo $l['changedir']?>"><?php echo basename(REALHOME)?>/</a>
<?php
		foreach($breadcrumbs as $path) {
?>
			<a href="<?php echo dosid(SELF.'?a=view&amp;d='.u($path))?>" title="<?php echo $l['changedir']?>"><?php echo h(basename($path))?>/</a>
<?php
		}
?>
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
			<col <?php echo $sortby == 'name' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?php echo $sortby == 'size' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?php echo $sortby == 'size' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?php echo $sortby == 'perm' ? 'style="background:'.$c['o'].';"' : ''?>>
			<col <?php echo $sortby == 'mtime' ? 'style="background:'.$c['o'].';"' : ''?>>
		</colgroup>

<?php	//sorting buttons?>
		<thead>
			<tr class="c">
				<td><input type="checkbox" name="toggle_top" onclick="toggleAll(this, 'chks'); this.form.toggle_bottom.checked = this.checked;"></td>
				<td colspan="6"></td>
				<td <?php echo $sortby == 'name' ? 'class="marked"' : ''?>>
					<a href="<?php echo dosid(SELF.'?a=view&amp;sort=+name&amp;d='.$url_dir)?>" title="<?php echo $l['asc']?>"><img src="<?php echo img('asc')?>" class="ico" alt="^"></a><a href="<?php echo dosid(SELF.'?a=view&amp;sort=-name&amp;d='.$url_dir)?>" title="<?php echo $l['desc']?>"><img src="<?php echo img('desc')?>" class="ico" alt="v"></a></td>
				<td colspan="2" <?php echo $sortby == 'size' ? 'class="marked"' : ''?>>
					<a href="<?php echo dosid(SELF.'?a=view&amp;sort=+size&amp;d='.$url_dir)?>" title="<?php echo $l['asc']?>"><img src="<?php echo img('asc')?>" class="ico" alt="^"></a><a href="<?php echo dosid(SELF.'?a=view&amp;sort=-size&amp;d='.$url_dir)?>" title="<?php echo $l['desc']?>"><img src="<?php echo img('desc')?>" class="ico" alt="v"></a></td>
				<td <?php echo $sortby == 'perm' ? 'class="marked"' : ''?>>
					<a href="<?php echo dosid(SELF.'?a=view&amp;sort=+perm&amp;d='.$url_dir)?>" title="<?php echo $l['asc']?>"><img src="<?php echo img('asc')?>" class="ico" alt="^"></a><a href="<?php echo dosid(SELF.'?a=view&amp;sort=-perm&amp;d='.$url_dir)?>" title="<?php echo $l['desc']?>"><img src="<?php echo img('desc')?>" class="ico" alt="v"></a></td>
				<td <?php echo $sortby == 'mtime' ? 'class="marked"' : ''?>>
					<a href="<?php echo dosid(SELF.'?a=view&amp;sort=+mtime&amp;d='.$url_dir)?>" title="<?php echo $l['asc']?>"><img src="<?php echo img('asc')?>" class="ico" alt="^"></a><a href="<?php echo dosid(SELF.'?a=view&amp;sort=-mtime&amp;d='.$url_dir)?>" title="<?php echo $l['desc']?>"><img src="<?php echo img('desc')?>" class="ico" alt="v"></a></td>
			</tr>

<?php	// parent dir link
		if($realupdir !== FALSE && allowed($realupdir)) { ?>
			<tr class="l o" style="border-bottom:1px solid <?php echo $c['border']['dark']?>;">
				<th></th>
				<th></th>
				<th></th>
				<th><a href="<?php echo dosid(SELF.'?a=rem&amp;d='.$url_dir);?>" onClick="popUp(this.href, 'remwin'); return false;" title="<?php echo $l['removedir']?>"><img src="<?php echo img('rem')?>" class="ico" alt="<?php echo $l['removedir']?>"></a></th>
				<th><a href="<?php echo dosid(SELF.'?a=ren&amp;p='.$url_dir)?>" title="<?php echo $l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?php echo img('ren')?>" class="ico" alt="<?php echo $l['renamedir']?>"></a></th>
				<th></th>
				<th><a href="<?php echo dosid(SELF.'?a=tree&amp;d='.$url_dir)?>" title="<?php echo $l['viewdir']?>" target="tree"><img src="<?php echo img('tree')?>" class="ico" alt="<?php echo $l['viewdir']?>"></a></th>
				<th><a href="<?php echo dosid(SELF.'?a=view&amp;d='.u($updir)) ?>" title="<?php echo $l['up']?>" class="rnd"><img src="<?php echo img('dirup')?>" class="ico" alt="<?php echo $l['up']?>"> ..</a></th>

				<th></th><th></th>
				<th></th><th></th>
			</tr>
		<?php } // /check for root ?>
		</thead>
		<tfoot>
		<tr>
			<td><input type="checkbox" name="toggle_bottom" onclick="toggleAll(this, 'chks'); this.form.toggle_top.checked = this.checked;">
			</td>
			<td colspan="11">
			<button type="submit" name="down"><img src="<?php echo img('download')?>" class="ico" alt="<?php echo $l['download']?>"></button>
			<button type="submit" name="del"><img src="<?php echo img('del')?>" class="ico"  alt="<?php echo $l['delete']?>"></button>
			<button type="submit" name="ren"><img src="<?php echo img('ren')?>" class="ico" alt="<?php echo $l['rename']?>"></button>
			<button type="submit" name="src"><img src="<?php echo img('src')?>" class="ico" alt="<?php echo $l['src']?>"></button>
			<!--button type="submit" name="mod"><img src="<?php echo img('perms')?>" class="ico" alt="<?php echo $l['editperms']?>"></button-->
			</td>
		</tr>
		<tr>
			<td></td>
			<td colspan="11">
			<button type="submit" name="add"><img src="<?php echo img('clipadd')?>" class="ico" alt="<?php echo $l['clip']['add']?>"></button>
			<button type="submit" name="sub"><img src="<?php echo img('clipsub')?>" class="ico" alt="<?php echo $l['clip']['sub']?>"></button>
			<a href="<?php echo dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?php echo $l['view']?>"><img src="<?php echo img('clip')?>" class="ico" alt="<?php echo $l['clip']['list']?>"> list</a>
		</tr>
		</tfoot>

		<tbody>
<?php
		$viewdirs->sort($sort);
		$viewdirs->printout();
?>
		</tbody>
		<tbody>
<?php
		$viewfiles->sort($sort);
		$viewfiles->printout($checkall)
?>
		</tbody>

		</table>
		<script type="text/js"><!-- // fake js -->
		</script><noscript>
		<a href="<?php echo dosid(h(URI).'&amp;checkall');?>">select all</a>
		</noscript>

	</form>
	</div>

<?php
	} catch(Exception $e) {
		echo '<div class="error">', $e->getMessage(), '</div>';
	}
break;
//^^view^^


//__default__
default:

//(i)frameset
$title = '| '. RELHOME. '/';

$dir = init($_GET['d'], '.');
?>

<style type="text/css">
<!--
	body { min-width:480px; min-height:240px; }
-->
</style>

<div class="box full">
<h2 style="margin-bottom:0;">
<a href="<?php echo dosid(SELF.'?a=user')?>" title="<?php echo $l['cust']?>" onClick="popUp(this.href, 'userwin', 'width=400,height=200'); return false;"><img src="<?php echo img('user')?>" class="ico" alt="<?php echo $l['user']?>"><?php echo h($mfp_user)?></a> <a href="<?php echo dosid(SELF.'?a=logout')?>" title="<?php echo $l['logout']?>"><img src="<?php echo img('exit')?>" class="ico" alt="<?php echo $l['logout']?>"></a>
<a href="<?php echo dosid(SELF.'?a=bout')?>" title="<?php echo $l['help']?>" onClick="popUp(this.href, 'helpwin', 'width=400,height=400'); return false;"><img src="<?php echo img('help')?>" class="ico" alt="<?php echo $l['help']?>"></a>
|
<a href="<?php echo dosid(SELF)?>" title="<?php echo $l['reload']?>"><img src="<?php echo img('reload')?>" class="ico" alt="<?php echo $l['reload']?>"></a>
<a href="<?php echo dosid(SELF.'?a=info')?>" title="<?php echo $l['info']?>" onClick="popUp(this.href, 'infowin', 'width=450,height=400'); return false;"><img src="<?php echo img('info')?>" class="ico" alt="<?php echo $l['info']?>"></a>
<img src="<?php echo img('drive')?>" class="ico" alt="">
<?php //free space
	//bytes:
	$freespace = @disk_free_space(HOME);
	$location  = h(pathTo(HOME, $_SERVER['DOCUMENT_ROOT']) . '/');

	//format and output
	printf($l['freespace'], getfsize($freespace), '<var class="dir">'.$location.'</var>');
?>
</h2>

	<?php if($cfg['tree']['enabled']) {?><iframe src="<?php echo dosid(SELF.'?a=tree&amp;d='.u($dir))?>" height="90%" width="20%" name="tree" frameborder="0">Browser needs to understand inlineframes</iframe><?php }?><iframe src="<?php echo dosid(SELF.'?a=view&amp;d='.u($dir))?>" height="90%" width="<?php echo $cfg['tree']['enabled']?80:100?>%" name="view" frameborder="0">
	Browser needs to understand inlineframes<br>
	<a href="<?php echo dosid(SELF.'?a=view')?>">Load only directory view without tree view</a></iframe>

</div>
<?php
//^^default^^
}

} else {
// no login yet
$title = $l['title']['login'];

$user = &$_POST['user'];

	if(isset($_POST['login'])) {
		try {
			session_regenerate_id();
			$pass = &$accounts[$user]['pass'];
			if(!isset($pass) || !chkSaltedHash($_POST['pwd'], $pass)) throw new Exception($l['err']['badlogin']);

			@include($cfg['dirs']['langs'].'/'.$accounts[$mfp_user]['lang'] . '.ini.php');

			// auth session vars
			$_SESSION['mfp']['user'] = $user;
			$_SESSION['mfp']['pass'] = $pass;
			$_SESSION['mfp']['hash'] = md5($user.$cfg['hashkey'].$pass); // !!! move hash to separate cookie

			// init
			$_SESSION['mfp']['clipboard'] = array();
			$_SESSION['mfp']['find'] = array();

			$_SESSION['mfp']['ip'] = ip2hex($_SERVER['REMOTE_ADDR']);


			echo $l['ok']['granted'],"<br>\n";
			echo '<a href="',dosid(URI),'">Click here if you aren\'t redirected automatically</a>';

			redirect(dosid(URI, '&'));
		} catch(Exception $e) {
			echo '<div style="text-align:center;">',
				'<div class="box login"><h3>ERROR</h3>',
				$e->getMessage(),
				'</div></div>';
		}


	}# else {
		// do not append sid on first call of page (a isn't set)
		$action = h(URI); #u(URI)
		if(!isset($a)) $action = dosid($action);
	?>
	<!-- -->
		<hr>
		<div style="text-align:center;">
		<form method="post" action="<?php echo $action?>" accept-charset="<?php echo $cfg['charset']?>" class="box login">
		<h3><!-- <img src="<?php echo img('water')?>" alt="myftphp"> --><a href="<?php echo dosid(SELF.'?a=bout')?>" title="<?php echo $l['help']?>"  onClick="popUp(this.href, 'helpwin', 'width=400,height=400'); return false;"><img src="<?php echo img('help')?>" class="ico" alt="<?php echo $l['help']?>"></a> <?php echo $l['login']?></h3>
			<div><img src="<?php echo img('user')?>" class="ico"  alt="<?php echo $l['user']?>">
			<input type="text" name="user" size="40"></div>
			<div><img src="<?php echo img('pwd')?>" class="ico" alt="<?php echo $l['pwd']?>">
			<input type="password" name="pwd" size="40"></div>
			<div><img src="<?php echo img('enter')?>" class="ico"  alt="<?php echo $l['login']?>">
			<input type="submit" name="login" value="<?php echo $l['login']?> "></div>
		</form>
		</div>
		<hr>

<?php
	#}
}
}

// get output buffer
$buffer = ob_get_contents();
ob_end_clean();
?>
<html>
<head>
	<title> [myFtPhp]&nbsp;&nbsp;<?php echo init($title, '')?> </title>

	<meta name="Author" content="knittl">
	<meta name="OBGZip" content="<?php echo function_exists('ob_gzhandler')?>">
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg['charset']?>">

	<link rel="icon" type="image/x-icon"  href="favicon.ico">
	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="stylesheet" type="text/css" href="<?php echo dosid(SELF.'?a=css&amp;theme='.$mfp_theme)?>" title="myFtPhp: <?php echo $mfp_theme?>">
<?php if(IE) { // double check for IE | hack for IE 7 'coz of quirks-mode?>
	<!--[if lt IE 8]><style type="text/css">
		@media screen {
			html, body { height:100%; overflow:hidden; }

			#scroll { padding:0px; margin:0px; height:90%; width:100%; overflow:auto; }
			#scroll * { position:static; }
		}
	</style><![endif]-->
<?php }?>
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
	//-->
	</script>

</head>

<body>
<?php
	// print buffer
	print($buffer);
?>

<!--
	generated on: <?php echo @date($l['fulldate'])?>
	generated in: <?php printf('%010.5f', (microtime(TRUE)-$mfp_starttime)*1000)?> ms
-->
</body>
</html>
<?php
// headers
header('Content-Type: text/html; charset=' . $cfg['charset']);
header('Cache-Control: no-cache, must-revalidate');

// send length of compressed page, important for gay browsers
header('Content-Length: '.ob_get_length());
// end compressed buffer
ob_end_flush();
exit;?>
