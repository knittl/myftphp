<?php
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
//	- so far FIXED
//
//   - the user limitations for dirs should work now
//     - limited to home dir now
//

// _tasks atm:_
//	 * implementing checkboxes > multiple file operations
//	 * archive support (down & upload): zip, tar.gz/bz2, rar
//	 * sorting view list: name, size, modified
//   * packing all colors into an single array for central color definition
//   * login with forwarding to requested page: should be fixed within one minute - done
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
//     * exception handler to log errors
//   * better themeability
//



//__configuration__
// user accounts,
// must exist, but if array is empty *no* authentification happens
// user => (md5(password), home-dir[w/o ending slash], language name, theme name)
$accounts = array(
	'myftphp' => array(
		//md5('myftphp'):
		'pass'  => '55c582a79d29f31ead40f4f739a0d03a',
		'home'  => '.',
		'lang'  => 'english',
		'theme' => 'light',
	),

	'knittl' => array(
		'pass'  => '63d69e446b3f2f2d1c0499ee556bf15c',
		'home'  => '..',
		'lang'  => 'english',
		'theme' => 'light',
	),
	'testers' => array(
		'pass'  => md5('quickey'),
		'home'  => 'test',
		'lang'  => 'english',
		'theme' => 'light',
	),
	'sigma' => array(
		'pass'  => md5('516m4'),
		'home'  => '../sigma',
		'lang'  => 'german',
		'theme' => 'light',
	),
	'Fritz-thecat' => array(
		'pass'  => 'c27852f3ebe7d00a51d256a77a66d5b6',
		'home'  => 'test',
		'lang'  => 'german',
		'theme' => 'light',
	),
	'tellmatic' => array(
		'pass'  => md5('telly'),
		'home'  => '../tellmatic',
		'lang'  => 'german',
		'theme' => 'light',
	),
	'horny' => array(
		'pass'  => '1cd359ff60be3b6b06aa35b28da090ea',
		'home'  => 'test',
		'lang'  => 'english',
		'theme' => 'light',
	),
	'squirrel' => array(
		'pass' => '13dbed89a2884d03e991f9ed863030c7',
		'home' => 'test/squirrel',
		'lang' => 'english',
		'theme' => 'light',
	),
	'KT' => array(
		'pass' => 'f6649483288390446b4cd6ce8c46f936',
		'home' => 'test/KT',
		'lang' => 'english',
		'theme' => 'light',
	),
);

// image files
$img = array(
	'clip'     => 'report.png',
	'clipadd'  => 'report_add.png',
	'clipsub'  => 'report_delete.png',
	'copy'     => 'page_white_copy.png',
	'del'      => 'page_delete.png',
	'dir'      => 'folder.png',
	'dirup'    => 'folder_go.png',
	'download' => 'arrow_down.png',
	'drive'    => 'drive_web.png',
	'edit'     => 'page_edit.png',
	'enter'    => 'door_in.png',
	// error: must be png
	'error'    => 'error.png',
	'exit'     => 'door_out.png',
	'explore'  => 'folder_explore.png',
	'find'     => 'find.png',
	'help'     => 'help.png',
	'home'     => 'house.png',
	'images'   => 'images.png',
	'info'     => 'information.png',
	'keyboard' => 'keyboard.png',
	'move'     => 'page_white_go.png',
	'newdir'   => 'folder_add.png',
	'newfile'  => 'page_white_add.png',
	'ok'       => 'accept.png',
	'perms'    => 'lock_edit.png',
	'pwd'      => 'key.png',
	'reload'   => 'arrow_refresh_small.png',
	'rem'      => 'folder_delete.png',
	'ren'      => 'link_edit.png',
	'src'      => 'page_code.png',
	'thumbs'   => 'application_view_tile.png',
	'tree'     => 'folder_magnify.png',
	'upload'   => 'attach.png',
	'upzip'    => 'compress.png',
	'user'     => 'group.png',
	'water'    => '../water.gif',

	'asc'  => 'bullet_arrow_up.png',
	'desc' => 'bullet_arrow_down.png',
);
//filetypes and extensions
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

ini_set('post_max_size', '256M');
@set_time_limit(60);


//___main script____
//include dirs, w/o slash
$langdir  = 'myftphp_lang';
$imgdir   = 'myftphp_img/silk';
#$imgdir  = 'nocvs/gfx/old_images';
$icondir  = 'myftphp_img/silk/icons';
$themedir = 'myftphp_themes';
$libdir   = 'myftphp_libs';

//file-tree, bool
//if directoy tree takes too many resources to read > set to zero or decrease the value of $level
$tree = 1;
//depth of recursion in treeview > 1
//0: infinite recursion, ATTENTION: may crash server or make script not useable anymore
//please consider recursive symbolic links as a problem
//default: 2
$level = 2;

//thumbnailing config
//maxw & maxh are pixel values
$maxw       = 65;
$maxh       = 65;
$imgquality = 90;
$perline    = 5;
$resizeall  = false;

//preview length in properties dialog
//in bytes/chars
$previewlen = 512;

//^^configuration^^





// donotchange
///////////////////////
error_reporting(E_ALL ^ E_STRICT);
#@date_default_timezone_set('Europe/Vienna');

// init debug buffer
$debug = '';
$errmsg = '';
$allok  = false;

// classes
//error class
class mfp_error {
	private $errmsg, $errcount;

	function __construct() {
		$this->errmsg   = array();
		$this->errcount = 0;
	}

	function add($errtext) {
		$this->errmsg[$this->errcount] = $errtext;
		$this->errcount++;
	}
	function printout() {
		echo '<b>:::E:R:R:O:R:::</b> <br><br>';
		foreach($this->errmsg as $msg) {
			echo $msg . "<br>\n";
		}
	}
} $error = new mfp_error();

//listing classes
abstract class mfp_list {
	protected $list, $count;
	protected $clipboard;

	function __construct() {
		$this->list = array();
		$this->count = 0;
		$this->clipboard = &$_SESSION['mfp_clipboard'];
	}
	function __destruct() {
		unset($this->list);
		unset($this->count);
	}
	#function add(array $listArray) {}
	function printout() {}

	function get($index) { return $this->list[$index]; }
	function getCount() { return $this->count; }
	function getArray() { return $this->list; }

	// adding independent of keys
	function add(array $listArray) {
		foreach($listArray as $key => $value) {
			$this->list[$this->count][$key] = $value;
		}
		/*foreach($listArray as $element => $current) {
			foreach($current as $key => $prop) {
				$this->list[$this->count][$key] = 
			}
		}*/
		$this->count++;
	}

	// -- sort, experimental -- but seems to work quite reasonable
	function sortList($param, $case = true) {
		if(!(empty($param) || empty($this->list))) {
			$tosort = substr($param, 1);
			$tosort = array_key_exists($tosort, $this->list[0]) ? $tosort : 'name';
			$order  = $param{0};
			$order  = $order == '-' ? SORT_DESC : SORT_ASC;

			// array needs to be restructured for this
			// get columned array
			foreach ($this->list as $file => $props) {
				foreach($props as $key => $prop) {
					${$key}[$file] = $case ? strtolower($prop) : $prop;
				}
			}
			array_multisort($$tosort, SORT_REGULAR, $order, $this->list);
		}
	}
}
class mfp_dirs extends mfp_list {
	#private $l = &$GLOBALS['l'];

	public function add(array $dirArray) {
	if(!($dirArray['name'] == '..' || $dirArray['name'] == '.'))
		parent::add($dirArray);
	}

	public function printout() {
		//print directories as table with alternating colored lines
		global $l;
		global $session;

		$oe = 0;
		foreach($this->list as $dir) {
			//kein . or ..
			if($dir['name'] != '.' && $dir['name'] != '..') {
				$oe++;
				$inclip = in_array(HOME . pathTo($dir['path']), $this->clipboard);
			?>
			<tr class="l <?=($oe % 2) ? 'o' : 'e'?><?=$inclip? ' clip': ''?>">
			<td class="left"></td>
			<td></td>
			<td><a href="<?=dosid(SELF.'?a=props&amp;path='.urlencode($dir['path']))?>" title="<?=$l['props']?>" onClick="popUp(this.href, 'propswin', 'width=400,height=500'); return false;"><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['props']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=rem&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['removedir']?>" onClick="popUp(this.href, 'remwin'); return false;"><img src="<?=img('rem')?>" width="16" height="16" alt="<?=$l['removedir']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=ren&amp;file='.urlencode($dir['path']))?>" title="<?=$l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['renamedir']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['viewthumbs']?>"><img src="<?=img('thumbs')?>" width="16" height="16" alt="<?=$l['thumb']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['viewdir']?>" target="tree"><img src="<?=img('tree')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a></td>
			<?##?>
			<td><a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['changedir']?>" class="rnd"><?=$dir['name']?></a></td>
			<td></td>
			<td></td>
			<td><a href="<?=dosid(SELF.'?a=mod&amp;path='.urlencode($dir['path']))?>" title="<?=$l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><?= $dir['perm'] ?><img src="<?=img('perms')?>" width="16" height="16" alt="<?=$l['perms']?>"></a></td>
			<td class="right"><?=@date($l['fulldate'], $dir['lmod']); ?></td></tr>
			<?
			}
			echo "\n";
		}
	}
	#function get($index) { return $this->list[$index]; }
}
class mfp_files extends mfp_list {
	#private $l = &$GLOBALS['l'];
	private $size = 0;

	public function add(array $fileArray) {
		parent::add($fileArray);
		$this->size += $fileArray['size'];
	}

	public function printout() {
		//print files and alternate lines
		global $l;
		global $session;

		$oe = 0;
		foreach($this->list as $file) {
			$oe++;
			$inclip = in_array(HOME . pathTo($file['path']), $this->clipboard);

			$size = getfsize($file['size'], true);
			$sizedesc = $size[1];
			$size     = $size[0];

			$directlink = directLink($file['path']);

		?>
		<tr class="l <?=($oe % 2) ? 'o' : 'e'?><?=$inclip? ' clip': ''?>">
		<td class="left"><input type="checkbox" name="chks[]" id="chk<?=$oe?>" value="<?=$file['name']?>"></td>
		<td><a href="<?=dosid(SELF.'?a=down&amp;file='.urlencode($file['path']))?>" title="<?=$l['download']?>"><img src="<?=img('download')?>" width="16" height="16" alt="<?=$l['download']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=props&amp;path='.urlencode($file['path']))?>" title="<?=$l['props']?>" onClick="popUp(this.href, 'propswin', 'width=400,height=500'); return false;"><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['props']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=del&amp;file='.urlencode($file['path']))?>" title="<?=$l['deletefile']?>" onClick="popUp(this.href, 'delwin'); return false;"><img src="<?=img('del')?>" width="16" height="16" alt="<?=$l['delete']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=ren&amp;file='.urlencode($file['path']))?>" title="<?=$l['renamefile']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=edit&amp;file='.urlencode($file['path']))?>" title="<?=$l['editcode']?>" onClick="popUp(this.href, 'editwin', 'width=640,height=480'); return false;"><img src="<?=img('edit')?>" width="16" height="16" alt="<?=$l['edit']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=src&amp;file='.urlencode($file['path']))?>" title="<?=$l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['src']?>"></a></td>
		<td><a href="<?=($directlink)?>" title="<?=$l['viewfile']?>" target="_blank" class="rnd"><?=$file['name']?></a></td>
		<td><?= $size ?></td>
		<td><?= $sizedesc ?></td>
		<td><a href="<?=dosid(SELF.'?a=mod&amp;path='.urlencode($file['path']))?>" title="<?=$l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><?=$file['perm']?><img src="<?=img('perms')?>" width="16" height="16" alt="<?=$l['editperms']?>"></a></td>
		<td class="right"><?= @date($l['fulldate'], $file['lmod']) ?></td>
		</tr>
		<?}
	}

	public function _size() { return $this->size; }
}

// activate buffering
#header('X-ob_mode: ' . 1);
//compression buffer + content buffer
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
$on = &$_SESSION['mfp_on'];
$user = &$_SESSION['mfp_user'];

// gets magicquotes, scriptlink, and browser
define('MQUOTES', get_magic_quotes_gpc());
define('SELF', $_SERVER['PHP_SELF']);
define('ROOT', $_SERVER['DOCUMENT_ROOT']);
define('AGENT', $_SERVER['HTTP_USER_AGENT']);
// check or internet explorer
if(stripos(AGENT, 'MSIE') !== false) define('IE', true);
else define('IE', false);
//check for windows
if(stripos(AGENT, 'win') !== false) define('WIN', true);
else define('WIN', false);


// language initiation
$l = array();
$l['login']           = 'login';
$l['err']['badlang']  = 'Language (%s) does not exist!';
$l['err']['badtheme'] = 'Theme (%s) does not exist!';
$l['err']['baduser']  = 'User (%s) does not exist!';
$l['err']['home']     = 'Root-Directory does not exist!';

// quickhack ** testing
if(isset($_SESSION['mfp_lang'])) $accounts[$user]['lang'] = $_SESSION['mfp_lang'];

$lang = isset($accounts[$user]['lang']) ? $accounts[$user]['lang'] : 'english';
@include('./' . $langdir . '/english.ini.php');
if(!@include('./' . $langdir . '/' . $lang . '.ini.php')) {
	printf($l['err']['badlang'], $lang);
	exit();
}

//colors #RGB, #RRGGBB, rgb(rrr,ggg,bbb), color name
$c = array();
$c['txt']        = '#111';
$c['bg']['main'] = '#EFF';

// quickhack ** testing
if(isset($_SESSION['mfp_theme'])) $accounts[$user]['theme'] = $_SESSION['mfp_theme'];

$theme = isset($accounts[$user]['theme']) ? $accounts[$user]['theme'] : 'light';
if(!@include('./' . $themedir . '/' . $theme . '.ini.php')) {
	printf($l['err']['badtheme'], $theme);
	exit();
}


// some functions
// format filesize to a reasonable number
function getfsize($size, $array = false) {
	$byte = &$GLOBALS['l']['byte'];

	//init
	$factor = 1;
	$sizedesc = '';

	//convert to kilo, mega, giga, tera, peta und exa ;)
	//microsoft behavior :-/ > means: check is performed with 1000 and calculated with 1024
	if($size > 1000) {
		$factor *= 1024;
		$sizedesc = $byte['k'];        }
	if($size > 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['m'];        }
	if($size > 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['g'];        }
	if($size > 1000 * 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['t'];        }
	if($size > 1000 * 1000 * 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['p'];        }
	if($size > 1000 * 1000 * 1000 * 1000 * 1000 * 1000) {
		$factor *= 1024;
		$sizedesc = $byte['e'];        }

	//float number with a precision of two
	if($array) {
		$return = array(sprintf('%02.2f', $size / $factor), $sizedesc . $byte['b']);
	} else {
		$return = sprintf('%02.2f', $size / $factor) .' '. $sizedesc . $byte['b'];
	}
	return $return;
}
// wrap long strings
function wrap($str, $at = 30) {
	return wordwrap($str, $at, "<br>\n", true);
}
//return ip as hex
function ip2hex($str_ip) {
    $ip_parts = explode('.', $str_ip);
    return sprintf('%02x%02x%02x%02x', $ip_parts[0], $ip_parts[1], $ip_parts[2], $ip_parts[3]);
} 

// insert image links
function img($img) {
	return $GLOBALS['imgdir'] .'/'. $GLOBALS['img'][$img];
}

// check for subdir
function allowed($path) {
	#echo '<br>path: ', realpath($path);
	#echo '<br>home: ', REALHOME;
	if(strpos(realpath($path), REALHOME) === 0) return true;
	return false;
}

//returns full way to dir
function getTrack($to, $from = HOME) {
	$pathToDir = pathTo($to, $from);
	$tmpTo = $pathToDir;
	$toDirArray = array();

	// caching to array - reverse afterwards
	while($tmpTo = substr($tmpTo, 0, strrpos($tmpTo, '/'))) {
		$toDirArray[] = $tmpTo;
	}
	$toDirArray = array_reverse($toDirArray);

	return $toDirArray;
}

//show relative path from $home
function pathTo($path, $home = HOME) {
	// needs benchmarking
	#$return = str_replace(realpath($home), '', realpath($path));
	if(strpos(realpath($path), REALHOME) === 0)
		$return = substr(realpath($path), strlen(realpath($home)));
	else
		$return = false;

	return b2slash($return);
}
function b2slash($bstr) {
	return str_replace('\\', '/', $bstr);
}

function directlink($path) {
	// thx to vizzy
	$directlink = b2slash(pathTo($path, ROOT));
	$directlink = 'http://' . $_SERVER['HTTP_HOST'] . $directlink;
	return $directlink;
}

// add session id
function dosid($uri) {
	$sid = SID;
	if(!empty($sid) && !preg_match('#'.session_name().'=#', $uri))
		$uri .= (strpos($uri, '?') !== false ? '&amp;' : '?'). SID;
	return $uri;
}


// action -> todo?
$a = &$_GET['a'];

// cases available without login
// (bout,css,logout)
switch($a) {
	//__logout__
	case 'logout':
		#unset($_SESSION['mfp_on']);
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		header('Location: '. dosid(SELF));
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

		<div id="scroll" style="background-color:<?=$c['bg']['main']?>; -moz-border-radius:2.5em; padding:1em; <?if(IE) echo 'filter:alpha(opacity=80) DropShadow(color=#C0C0C0, offx=3, offy=3);'?> opacity:0.8;">

		Code and idea: Knittl<br>
		<a href="http://sourceforge.net/projects/myftphp">&lt;sourceforge.net/projects/myftphp&gt;</a><br>
		<a href="mailto:knittl89@yahoo.de">&gt;knittl89@yahoo.de&lt;</a>
		<br><br>
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
			<li><u>Eliasp</u>, for pointing out <a href="http://chrispederick.com/work/webdeveloper/">Web Developer Tool</a></li>
		</ul>
		</div>
	<?break;
	//^^bout^^

	//__css__
	case 'css':
	//set filetype to css
	header('Content-Type: text/css');
	?>
	body {
		<?#http://css-discuss.incutio.com/?page=UsingEms?>
		font-size:95%;

		color:<?=$c['txt']?>;
		background-color:<?=$c['bg']['main']?>;
		background-image:url(<?=img('water')?>);
		background-repeat:no-repeat;
		background-attachment:fixed;
		background-position:bottom right;


		<?if(IE) echo 'margin:0px;'?>
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
		border:1px solid <?=$c['border']['dark']?>;
		border-color:<?=$c['border']['light']?> <?=$c['border']['dark']?> <?=$c['border']['dark']?> <?=$c['border']['light']?>;
		color:<?=$c['txt']?>;
		padding:0.3em;
		/*-moz-border-radius:0.4em;*/
		-moz-border-radius:4px;
	}
	textarea { background-color:<?=$c['bg']['inputlite']?>; font-family:monospace; -moz-border-radius:1em; }
	input { padding:0pt; text-indent:2px; }
	button { padding:0pt; -moz-border-radius:0.3em; background-color:transparent; cursor:pointer; }

	label { padding:0pt 0.5em; }
	label:hover { background-color:<?=$c['bg']['inputhover']?>; -moz-border-radius:0.5em; }

	select {
		color:<?=$c['txt']?>;
		background-color:<?=$c['bg']['input']?>;
		border:1px solid <?=$c['border']['dark']?>;
		background-image:url(<?=img('desc')?>);
		text-indent:5px;
		/*-moz-border-radius:4px;*/
	}
	select:hover { background-color:<?=$c['bg']['inputhover']?>; }
	select:focus { background-color:<?=$c['bg']['inputlite']?>; }
	option { text-indent:3px; }
	option:hover { /*text-indent:5px;*/ text-decoration:underline; color:<?=$c['a']['hover']?>; background-color:<?=$c['bg']['inputhover']?>; }

	input[type=text], input[type=password] {
		background-image:url(<?=img('keyboard')?>);
		background-repeat:no-repeat;
		border:1px solid <?=$c['border']['lite']?>;
		border-bottom:1px solid <?=$c['border']['dark']?>;
		<?#personal flavour?>
		text-indent:5px;
		-moz-border-radius:0.6em 0.6em 0 0;
	}
	input[type=password] { background-image:url(<?=img('pwd')?>); border-color:<?=$c['border']['dark']?>; -moz-border-radius:0.5em; }

	input[type=text]:focus, input[type=password]:focus {
		background-image:url();
		background-color:<?=$c['bg']['inputlite']?>;
		text-decoration:none;
	}
	input:hover { background-color:<?=$c['bg']['inputhover']?>; text-decoration:underline; }
	input[type=submit] {
		font-weight:bold;
		background-image:url(<?=img('ok')?>);
		background-repeat:no-repeat;
		background-position:left center;
		text-indent:16px;
	}
	<?=!IE ? 'input#quicktext { width:2em; background-position:center; }
	input#quicktext:focus { width:100%; }' : ''?>

 /* anchors, links */
	a { color:<?=$c['a']['link']?>; text-decoration:none; font-weight:<?=(!WIN)? 'bold': 'normal'?>; font-size:<?=(!WIN)? '13px': '11px'?>; font-family:<?=(WIN)? 'fixedsys, system': 'Courier New,monospace'?>; }
	a:hover { color:<?=$c['a']['hover']?>; background-color:<?=$c['a']['bghover']?>; text-decoration:underline; }
	a.rnd { padding:0pt 0.5em; }
	a.rnd:hover { -moz-border-radius:0.5em; }
	a.lrnd:hover { -moz-border-radius:0.5em 0 0 0.5em; }

	a img { border:1px <?=IE ? $c['bg']['main'] : 'transparent'; ?> solid; 
	opacity:0.8; }
	a:hover img {
		border:1px <?=$c['border']['img']['shade']?> solid;
		border-top-color:<?=$c['border']['img']['light']?>;
		border-left-color:<?=$c['border']['img']['light']?>;
		opacity:1;
	}

	/*a img { border:0px; opacity:0.6; }
	a:hover img {	opacity:1; }*/

 /* headerdiv */
	#fix {
		position:fixed;
		top:0pt; left:0pt;
		display:block;
		width:100%;
		margin:0px;
		margin-right:-0.5em;

		color:<?=$c['fixtxt']?>;
		background-color:<?=$c['bg']['fix']?>;
		border:1px <?=$c['border']['fix']?> solid;
		border-top:0px none;
		-moz-border-radius:0 0 2em 4em;

		padding:2px 0.5em;
		overflow:hidden;
		float:left; clear:both;
		/* -moz-opacity:0.9; isn't needed */
		<?= IE ? 'filter:alpha(opacity=90);' : null?> opacity:0.9;
	}
	#fix * { margin:0px; padding:0px; }
	#scroll { clear:both; }
	<?if(!IE) echo '#fix + #scroll { margin-top:2.5em; }'?>

 /* tables */
	table { border:none; border-collapse:collapse; border-spacing:0px; padding:0; }
	tr { vertical-align:middle; }
	tr.vtop { vertical-align:top; }
	tr.toprnd td { -moz-border-radius:1em 1em 0 0; }
	td { padding:0px 2px; }
	td.left  { -moz-border-radius:0.5em 0 0 0.5em; }
	td.right { -moz-border-radius:0 0.5em 0.5em 0; }

	/*table tr.l th:hover, table tr.l:hover { background-color:#DDD; }*/

	th { text-align:left; padding:0pt; margin:1px 1px; }

	/* hovered table rows */
	table tr.e:hover td,
	table tr.o:hover td,
	table tr.hover td {
		background-color:<?=$c['bg']['tablehover']?>;
	}

	tr.treeUp { border-top:1px <?=$c['border']['ruler']?> solid; font-weight:bolder; }

	tr.o td, tr.o th { background-color:<?=$c['o']?>; }
	tr.clip td a { font-style:italic; }
	col td { -moz-border-radius:1em 1em 0 0; }

	tr.l { white-space:nowrap; }
	tr.l a { display:block; }
	tr.l a img.folder { display:inline; }
	tr.l a:hover img.folder { display:none; }
	tr.l a img.explore { display:none; }
	tr.l a:hover img.explore { display:inline; }

 /* selection, rulers */
	::-moz-selection { color:<?=$c['a']['hover']?>; background:<?=$c['bg']['inputhover']?>; }
	/* needs checking for safari or others
	::selection { color:<?=$c['a']['hover']?>; background:<?=$c['bg']['inputhover']?>; }*/

 /* sections, fake windows */
	.section {
		min-width:200px;
		max-width:400px;
		/*-moz-border-radius:0 0 6px 6px;*/

		margin-bottom:1em;
		padding-bottom:1px;

		border:1px solid <?=$c['border']['ruler']?>;
		text-align:left;
	}
	div.section { -moz-border-radius:0 0 6px 6px; }
	.caption img { vertical-align:text-bottom; }

	fieldset.section { padding:0px; padding-top:10px; }
	fieldset.section legend { padding:0px 10px; margin:0 20px; text-decoration:underline; /*border-bottom:1px solid <?=$c['border']['fix']?>;*/ }
	
	.section h1 {
		cursor:default;
		display:block;
		margin:0px;

		text-indent:8px;
		font-size:1em;
		font-weight:bold;

		color:<?=$c['fixtxt']?>;
		background-color:<?=$c['bg']['fix']?>;
		border-bottom:1px <?=$c['border']['fix']?> solid;
	}
	.section .container {
		display:block;
		overflow:auto;
		padding:10px 10px 8px;
	}
	.section .footer {
		padding:2px 3px 3px 2px;
		
		display:block;
		text-align:right;

		border-top:1px <?=$c['border']['fix']?> solid;
	}

	.full { height:100%; min-width:100%; max-width:100%; margin:-2px 0px -1px; }

/* other stuff */
	ul { list-style-position:outside; text-align:left; }
	img { vertical-align:middle; border:0px none; }
	hr {
		color:<?=$c['border']['ruler']?>;
		background-color:<?=$c['bg']['fix']?>;
		width:80%; height:1px;
		border-top:1px solid <?=$c['border']['ruler']?>;
	}

	<?
	// omit further output
	return;
	break;
	//^^css^^

	//__default__
	default:


// root: chmod 0777
// rly use . as default!?
$home = !empty($accounts[$user]['home']) ? $accounts[$user]['home'] : '.';
// is root existing?
if(define('HOME', $home) && is_dir($home)) {
	define('REALHOME', realpath(HOME));
	define('RELHOME', pathTo(HOME, ROOT));
} else {
	unset($_SESSION['mfp_on'], $_SESSION['mfp_user']);
	die(sprintf($l['err']['home'], $home));
	#die('Bad home');
}


// main script
if(($on && isset($accounts[$user])) || (empty($accounts) && isset($accounts))) { 
//logged in or empty user array

//what to do?
switch($a) {
//a(ction) = [clip,del,down,edit,find,gallery,info,mod,new,rem,ren,props,src,thumb,tree,up,user,view,'default']


//__clip__
case 'clip':
	$dir = &$_GET['dir'];
	$clipboard = &$_SESSION['mfp_clipboard'];

	if(isset($_GET['copy']) || isset($_GET['move'])) { ?>
	<script type="text/javascript" language="JavaScript">
	<!--
			opener.location.reload();
	//-->
	</script>
	<? }

	// #copy, move, list, free
	if(isset($_GET['copy'])) {

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
						} else { printf($l['err']['fileexists'], wrap($newpath), getfsize(filesize($newpath))); }
					}
				} else { printf($l['err']['baddir'], wrap($dir)); }
			} else { printf($l['err']['forbidden'], wrap($dir)); }
		} else { echo 'no files in clipboard'; }

	} else if(isset($_GET['move'])) {

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
						} else { printf($l['err']['fileexists'], wrap($newpath), getfsize(filesize($newpath))); }
					}
				} else { printf($l['err']['baddir'], wrap($dir)); }
			} else { printf($l['err']['forbidden'], wrap($dir)); }
		} else { echo 'no files in clipboard'; }

	} else if(isset($_GET['free'])) {
		$clipboard = array();
		header('Location: '. dosid(SELF.'?a=clip&list'));
	} else if(isset($_GET['list'])) { ?>

		<form name="form" method="post" action="<?=dosid(SELF.'?a=multi&amp;dir='.urlencode(HOME.'/.'))?>">
		<div class="section">
		<h1><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']?>"> clipboard</h1>
		<div class="container">
		<?
			if(count($clipboard)) {
				$oe = 0;
				?>

				<table>
				<tr>
				<th><input type="checkbox" name="toggle_top" onClick="toggleAll(this, 'chks');"></th>
				<th><?=$l['file']?></th>
				<th><?=$l['dir']?></th>
				</tr>
				<?
				foreach($clipboard as $entry) {
					$oe++;
					$directlink = directLink($entry);
					?>
					<tr class="l <?=($oe % 2) ? 'o' : 'e'?>">
						<td class="left"><input type="checkbox" name="chks[]" id="chk<?=$oe?>" value="<?=pathTo($entry)?>"></td>
						<td><a href="<?=($directlink)?>" title="<?=$l['viewfile']?>" target="_blank" class="rnd"><?=basename($entry)?></a></td>
						<td class="right"><?=pathTo(dirname($entry)),'/'?></td>
					</tr>
				<?
				}
				echo '</table>';
			} else {
				echo $l['err']['nofiles'];
			}
		?>
		</div>
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

<div class="section full">
<h1><img src="<?=img('del')?>" width="16" height="16" alt="<?=$l['delete']?>"> <?=$title?></h1>
<center class="container">
<?
if(isset($_POST['delete'])) {
$file = &$_POST['file'];

	if(isset($file)) {
		$realpath = wrap(pathTo($file));
		if(allowed($file)) {
			if(@unlink($file)) {
				printf($l['ok']['deletefile'], $realpath);
			} else {
				printf($l['err']['deletefile'], $realpath);
			}
		} else {
			printf($l['err']['forbidden'], $file);
		}
	}
?>
	<form name="myftphp_form" action="javascript:window.close()">
	<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
	<script type="text/javascript" language="JavaScript">
	<!--
			opener.location.reload();

			document.myftphp_form.closebut.focus();
	//-->
	</script>
	</form>

<?
} else {
?>
<form method="post" action="<?=dosid(SELF.'?a=del')?>">
	<input type="hidden" name="file" value="<?=$_GET['file']?>">

	<?printf($l['warn']['reallydel'], 
				'<a href="'. directLink($_GET['file'])
				.'" target="_blank">'. wrap(pathTo($_GET['file'])) .'</a>')?><br>

	<input type="submit" name="delete" value="  <?=$l['delete']?>  ">&nbsp;
	<input type="button" name="cancel" value="  <?=$l['cancel']?>  " onClick="window.close()">
</form>

<? } ?>
</center>
</div>

<?
break;
//^^del^^


//__down__
case 'down':
//download
$title = $l['title']['down'];

$file = &$_GET['file'];
//filename passed?
if(isset($file)) {

	if(file_exists($file)) {
		if(allowed($file)) {
			// clean output buffer
			ob_end_clean();

			// set filetype -not needed anymore
			#header('Content-type: x-type/x-subtype');

			// set filename for download
			header('Content-length: ' . filesize($file));
			header('Content-Disposition: attachment; filename="' . basename($file) . '"');
			// read and print file content
			readfile($file);

			exit();
		} else {
			printf($l['err']['forbidden'], $file);
		}
	} else {
		printf($l['err']['nofile'], $file);
	}
} else {
	echo $l['err']['nofile'];
}

break;
//^^down^^


//__edit__
case 'edit':
$title = $l['title']['edit'];
	$file = &$_POST['file'];
//fixed line
?>
	<form method="post" action="<?=dosid(SELF.'?a=edit')?>" name="form" onSubmit="return confirm('<?printf($l['warn']['reallysave'], (addcslashes(pathTo($_REQUEST['file']), '\\')))?>'); return false;">
	<div id="fix">
		<input type="submit" name="save" value="  <?=$l['save']?>  " accessKey="s">&nbsp;
		<input type="button" name="reset" value="  <?=$l['reset']?>  " onClick="setText()">&nbsp;
		<input type="button" name="cancel" value="  <?=$l['close']?>  " onClick="window.close()">&nbsp;
		<input type="button" name="showsource" value="  <?=$l['showsrc']?>  "
		onClick="popUp('<?=dosid(SELF.'?a=src&amp;file='.urlencode($file))?>', 'highwin', ',width=500,height=400')">
	</div>

	<div id="scroll">
	<?if(isset($_POST['save'])) {

	$file = &$_POST['file'];

		if(allowed($file)) {
			if($handle = @fopen($file, 'w+b')) {

				$content = &$_POST['source'];
				if(MQUOTES) {
					$content = stripslashes($content);
				}

				if($written = fwrite($handle, $content)) {
					printf($l['ok']['writefile'], wrap(pathTo($file)), getfsize($written));
					?>
				<script type="text/javascript" language="JavaScript">
				<!--
					opener.location.reload();
				//-->
				</script>
					
					<?

				} else {
					printf($l['err']['writefile'], $file);
				}
			} else {
				printf($l['err']['openfile'], $file);
			}
			@fclose($handle);
		} else {
			printf($l['err']['forbidden'], $file);
		}
		echo '<hr>';
	}# else {

		$file = &$_REQUEST['file'];

		if(allowed($file)) {

			if(($source = @file_get_contents($file)) !== false) {
				echo ucfirst($l['file']).': "<i>'. 
					'<a href="'. directLink($file)
					.'" target="_blank">'. wrap(pathTo($file), 50) .'</a>'
					.'</i>"<br>';
				echo '('.getfsize(filesize($file)).')';
	?>


		<textarea name="source" class="full" cols="10" rows="20" wrap="off"><?=htmlspecialchars($source);?></textarea>
		<?#<textarea name="source" cols="65" rows="20"></textarea>?>
		<?#<textarea name="source" width="100%" height="80%"></textarea>?>
		<input type="hidden" name="file" value="<?=$file?>">
		<br>
	</div>
	</form>

	<script type="text/javascript" language="JavaScript">
	<!--
		var area = document.form.source
		var nowText = area.value;

		function setText() {
			area.value = nowText;
		}
	//-->
	</script>
<?
		} else {
			printf($l['err']['openfile'].'<br>', $file);
			printf($l['err']['readfile'], $file);
		}

	} else {
		printf($l['err']['forbidden'], $file);
	}
#}
break;
//^^edit^^

//__find__
case 'find':
$title = $l['title']['find'];
	// find files recursive
	$dir   = &$_REQUEST['dir'];
	$term  = &$_REQUEST['term'];
	#echo '<br><br><br><br><br><pre>', var_dump($_REQUEST), '</pre>';
	$realdir = pathTo($dir);


	if(isset($_POST['find'])) {
		//save checkboxes to session
		//to remember status for current session
		$adv = isset($_POST['adv'])? $_POST['adv']: array();
		$case  = in_array('case', $adv);
		$exact = in_array('exact', $adv);
		$rec = in_array('rec', $adv);

		$_SESSION['mfp_find'] = array(
			'case'  => $case,
			'exact' => $exact,
			'rec'   => $rec
		);
	}

	if(allowed($dir)) {

	?>
<div id="fix">
<form method="post" name="quickform" action="<?=dosid(SELF.'?a=find&amp;dir='.$dir)?>">
	<input type="hidden" name="dir" value="<?=$dir?>">

	<table>
	<tr>
		<td><a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir));?>" title="<?=$l['viewdir']?>"><img src="<?=img('explore')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a></td>
		<td><a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir));?>" title="<?=$l['viewthumbs']?>"><img src="<?=img('thumbs')?>" width="16" height="16" alt="<?=$l['thumb']?>"></a></td>
		<td><a href="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a></td>
		<td><?#printf($l['searchfor'], $realdir)?>
		<input type="text" name="term" value="<?=isset($term)?$term:''?>" maxlength="201" size="50" style="width:25em;">&nbsp;&nbsp;
		<input type="submit" name="find" value=" <?=$l['find']?> ">
		</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td><label for="case"><input type="checkbox" name="adv[]" value="case" id="case" <?=$case? 'checked': ''?>> <?=$l['casesensitive']?></label>
		<label for="exact"><input type="checkbox" name="adv[]" value="exact" id="exact" <?=$exact? 'checked': ''?>> <?=$l['exactmatch']?></label>
		<label for="rec"><input type="checkbox" name="adv[]" value="rec" id="rec" <?=$rec? 'checked': ''?>> <?=$l['findsubdirs']?></label>
		</td>
	</tr>
</table>
</form>
</div>

<div id="scroll" style="margin-top:3.5em;">
<?
	if(isset($_POST['find'])) {
		
	if(!empty($term)) {
		if(isset($dir)) {

			$realdir = wrap(pathTo($dir));

			$matches['dirs'] = new mfp_dirs();
			$matches['files'] = new mfp_files();

			function match($haystack, $needle) {
				global $case, $exact;

				if($exact) {
					return ($haystack === $needle);
				} else {
					if($case) {
						return (strpos($haystack, $needle) !== false);
					} else {
						return (stripos($haystack, $needle) !== false);
					}
				}
				return false;
			}

			function recursiveFind($dir) {
				global $term, $matches;
				global $rec;

				$handle = @opendir($dir);
					while($file = @readdir($handle)) {
						$path = $dir.'/'.$file;
						$stat = @lstat($path);

						// one can't check too much
						if(allowed($path)) {
							if(is_dir($path)) {
								if($file != '.' && $file != '..') {
									if(match($file, $term)) {
										$matches['dirs']->add(array(
											'name' => $file,
											'path' => $path,
											'lmod' => $stat[9],
											'perm'    => decoct(@fileperms($path)%01000)
										));
									}

									//recursion
									if($rec) {
										recursiveFind($path);
									}
								}
							} else {
								if(match($file, $term)) {

									$matches['files']->add(array(
										'name' => $file,
										'path' => $path,

										'size'     => $stat[7],
										'lmod'  => $stat[9],
										'perm'     => decoct(@fileperms($path)%01000)
									));
								}
							}
						}
					}
				@closedir($handle);
				return true;
			}


				//recursion
				if(recursiveFind($dir)) {
					?>
					<form name="findform" method="post" action="<?=dosid(SELF.'?a=multi&amp;dir='.urlencode($dir))?>" onSubmit="popUp(action, 'multiwin');" target="multiwin">
					<table>
					<? //dirs
					if($matches['dirs']->getCount()>0) {
						$matches['dirs']->printout();
					} else {	?>
						<tr>
							<td colspan="11"><?=$l['err']['nodirs']?></td>
						</tr>
					<? } ?>

				<tr style="border-top:1px <?=$c['border']['ruler']?> solid;">
					<td colspan="11">&nbsp;</td>
				</tr>
					<? //files
					if($matches['files']->getCount()>0) {
						$matches['files']->printout();
					} else {	?>
						<tr>
							<td colspan="11"><?=$l['err']['nofiles']?></td>
						</tr>
					<? } ?>

				<tr>
					<td><input type="checkbox" name="toggle" onclick="toggleAll(this, 'chks', 'findform');"></td>
					<td colspan="11">
					<button type="submit" name="add"><img src="<?=img('clipadd')?>" width="16" height="16" alt="<?=$l['clipadd']?>"></button>
					<button type="submit" name="sub"><img src="<?=img('clipsub')?>" width="16" height="16" alt="<?=$l['clipsub']?>"></button>
					<a href="<?=dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['view']?>"><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']?>"> list</a>
				</tr>

				</table>
				</form>
			<?
			} else {
				printf($l['err']['find'], $realdir);
			}
		} else {
			printf($l['err']['baddir'], $dir);
		}
	} else {
		print($l['err']['emptyfield']);
	}

} ?>
</div>

<?
	} else {
		printf($l['err']['forbidden'], $dir);
	}
break;
//^^find^^

//__gallery__
case 'gallery':
// thumbnail gallery
$title = $l['title']['thumbs'];

$dir = &$_GET['dir'];
	if(isset($dir)) {
		if(allowed($dir)) {

			if(file_exists($dir)) {
				//init
				$thumbdirs = new mfp_dirs();
				$thumbfiles = new mfp_files();

				#$filecount = $dircount = 0;
				#$files = $dirs = array();

				// benchmark...
				#$start = microtime(1);

				$handle = @opendir($dir);
				while($file = @readdir($handle)){
					$filepath = HOME . pathTo($dir.'/'.$file);
				if(allowed($filepath)) {
					$stat = @lstat($filepath);

					if(is_file($filepath)) {
						$size = getfsize(filesize($filepath), 1);

						$thumbfiles->add(array(
							'name' => $file,
							'path' => ($filepath),

							'size' => $size[0],
							'sizedesc' => $size[1],

							'perm'    => decoct(@fileperms($path)%01000),

							'lmod' => $stat[9]
						));
					} else if(is_dir($filepath)) {
						$thumbdirs->add(array(
							'name' => $file,
							'path' => ($filepath),

							'stat' => @lstat($filepath),
							'perm' => decoct(@fileperms($filepath)%01000),

							'lmod' => $stat[9]
						));
					}
				}
				}
				@closedir($handle);

				#$end = microtime(1);
				#echo $end-$start;

				#$start = microtime(1);

				$nowdir = HOME . pathTo($dir);
				$thisdir = ($nowdir);

				// see __view__
				$realupdir = realpath($thisdir.'/..');
				$updir = HOME . pathTo($realupdir);

				// grid output
				?>

				<!-- quick access panel, fixed -->
				<div id="fix">
					<table>
					<tr class="l">
						<td><a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir));?>" title="<?=$l['viewdir']?>"><img src="<?=img('explore')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a></td>
						<td><a href="<?=dosid(SELF.'?a=find&amp;dir='.urlencode($dir));?>" title="<?=$l['find']?>"><img src="<?=img('find')?>" width="16" height="16" alt="<?=$l['find']?>"></a></td>
						<td><a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a></td>
						<td><img src="<?=img('images')?>" width="16" height="16" alt="<?=$l['img']?>">
						[<?=$thumbfiles->getcount()?> | <?=getfsize($thumbfiles->_size())?>]&nbsp;
						</td>

						<td><img src="<?=img('dir')?>" width="16" height="16" alt="<?=$l['dir']?>">
						[<?=$thumbdirs->getcount()?>]
						</td>
						<td><?='&nbsp;&nbsp;'.basename(pathTo($dir))?></td>
					</tr>
					</table>
				</form>
				</div>

				<center id="scroll">
				<p>
					<img src="<?=img('dir')?>" width="16" height="16" alt="<?=$l['dir']?>">&nbsp;
					<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode(HOME))?>" title="<?=$l['changedir']?>"><?=basename(REALHOME)?></a>&nbsp;/
				<?
				$pathlist = getTrack($dir);
				if(realpath($dir) != REALHOME) { array_push($pathlist, pathTo($dir)); }
				if(count($pathlist)) {
					foreach($pathlist as $path) {
						$path = HOME . $path;
				?>
					<a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($path))?>" title="<?=$l['changedir']?>"><?=basename($path)?></a> /
				<? }
				} ?>
				</p>
				<style type="text/css">
				<!--
					.l { vertical-align:top; }
				-->
				</style>
				
				<table style="border-collapse:collapse; text-align:center;"><tr class="e"><td colspan="<?=$perline?>"></td>
				<?	//dirs
				$oe = $i = 0;
				foreach($thumbdirs->getArray() as $dir) {
					if($dir['name'] != '.' && $dir['name'] != '..') {
						$newline = !($i % $perline);
						if($newline) {
							$oe++; ?>
					</tr>
					<tr class="l vtop <?=($oe % 2) ? 'o' : 'e'?>">
						<?}?>
						<td><a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir['path']))?>" title="<?=$l['changedir']?>">
						<img src="<?=img('dir')?>" width="<?=$maxw?>" height="<?=$maxh?>" alt="<?=$l['dir']?>"></a>
						<?=wrap($dir['name'], 10)?>
						</td>
						<?
						$i++;
					}
				}?>
					<td colspan="<?=$perline-($i % $perline)?>"></td>

			<tr><td colspan="<?=$perline?>">&nbsp;</td></tr>

				<? //files
				$oe = $i = $block = 0;
				foreach($thumbfiles->getArray() as $file) {
					$newline = !($i % $perline);
					if($newline) {
						$oe++;
				?>
			</tr>
			<tr class="l vtop <?=($oe % 2) ? 'o' : 'e'?>">
				<?}?>
				<td><a href="<?=$file['path']?>" target="_blank" title="<?=$l['view']?>">
				<img src="<?=dosid(SELF.'?a=thumb&amp;img='.urlencode($file['path']))?>" width="<?=$maxw?>" height="<?=$maxh?>" alt="<?=$l['img']?>"></a>
				<?= $file['size'].$file['sizedesc']?><br>
				<?=wrap($file['name'], 10)?>
				</td>
				<?
				$i++;
				}	?>
			<td colspan="<?=$perline-($i % $perline)?>"></td>
			</tr></table></center>
			<?}

			#$end = microtime(1);
			#echo $end-$start;
		} else {
			printf($l['err']['forbidden'], $dir);
		}
	} else {
			echo $l['err']['baddir'];
	}
break;
//^^gallery^^

//__info__
case 'info':
	//show server info
	$title = $l['title']['info'];

	//space:
	$freespace  = @disk_free_space(HOME);
	$totalspace = @disk_total_space(HOME);
	$location   = pathTo(HOME, $_SERVER['DOCUMENT_ROOT']) . '/';

	//count languages and themes
	$langcount = $themecount = 0;

	$dir = $langdir;
	$dh = @opendir($dir);
		while($file = @readdir($dh)){
			if(is_file($dir. '/' .$file)) {
			if(strpos($file, '.ini.php') !== false) {
				$langcount++;
			}
			}
		}
	$dir = $themedir;
	$dh = @opendir($dir);
		while($file = @readdir($dh)){
			if(is_file($dir. '/' .$file)) {
			if(strpos($file, '.ini.php') !== false) {
				$themecount++;
			}
			}
		}

?>

<center id="fix">
<b><?=$l['title']['info']?></b></center>
<div id="scroll">
<center>
<?
	//format and output
?>
<div class="section">
<h1><img src="<?=img('drive')?>" width="16" height="16" alt="<?=$l['info']?>"> harddisk</h1>
<div class="container">
<?
	printf($l['freespace'], getfsize($freespace), $location);
	echo '<br>';
	printf($l['totalspace'], getfsize($totalspace), $location);
?>
</div>
</div>

<div class="section">
<h1><img src="<?=img('drive')?>" width="16" height="16" alt="<?=$l['info']?>"> server</h1>
<div class="container">
<?
	echo $_SERVER['SERVER_NAME'];
	echo '<br>';
	echo $_SERVER['SERVER_SOFTWARE'];
	echo '<br>';
	@print($_ENV['OS']);
?>
</div>
</div>

<div class="section">
<h1><img src="<?=img('drive')?>" width="16" height="16" alt="<?=$l['info']?>"> environment</h1>
<div class="container">
<?
	echo '<pre>';
	var_dump($_ENV);
	echo '</pre>';
?>
</div>
</div>

<div class="section">
<h1><img src="<?=img('user')?>" width="16" height="16" alt="<?=$l['user']?>"> <?=$l['user']?></h1>
<div class="container">
	<table>
	<tr>
		<td><?=$l['user'], ':'?></td>
		<td>"<i><?=$user?></i>"</td>
	</tr>
	<tr>
		<td><?=$l['home'], ':'?></td>
		<td>"<i><?=HOME?></i>"</td>
	</tr>
	<tr>
		<td><?=$l['lang'], ':'?></td>
		<td>"<i><?=$accounts[$user]['lang']?></i>"</td>
	</tr>
	<tr>
		<td><?='theme', ':'?></td>
		<td>"<i><?=$accounts[$user]['theme']?></i>"</td>
	</tr>
	</table>
</div>
</div>

<div class="section">
<h1><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['info']?>"> script</h1>
<div class="container">
<p><?
	echo 'Domain: ', $_SERVER['HTTP_HOST'];
	echo '<br>';
	echo 'Path: ', SELF;
	echo '<br>';
	echo 'Url: <a href="', dosid('http://'.$_SERVER['HTTP_HOST'].SELF), '">', $_SERVER['HTTP_HOST'].SELF, '</a>';
?></p>
<p>
languages: <?=$langcount?><br>
themes: <?=$themecount?><br>
</p>
</div>
</div>

</center>
</div>
<?
break;
//^^info^^

//__mod__
case 'mod':
	// needs a whole lotta attention
//chmod-ing
$title = $l['title']['mod'];

// emu-functions
// try to resolve uname and gname
// for posix disabled systems, they will return uid and gid
function _posix_getpwuid($uid) {
	if(function_exists('posix_getpwuid'))
		return posix_getpwuid($uid);
	else
		return $uid;
}
function _posix_getgrgid($gid) {
	if(function_exists('posix_getgrgid'))
		return posix_getgrgid($gid);
	else
		return $gid;
}
?>
	<div class="section full">
	<form method="post" action="<?=dosid(SELF.'?a=mod');?>">
	<input type="hidden" name="path" value="<?=$_GET['path']?>">

	<h1><img src="<?=img('perms')?>" width="16" height="16" alt="<?=$l['perms']?>"> <?=$l['editperms']?></h1>
	<center class="container">
<?

if(isset($_POST['edit'])) {
	$path = &$_POST['path'];
	if(isset($path)) {
		if(allowed($path)) {
			$lstat = lstat($path);
			$userinfo = _posix_getpwuid($lstat['uid']);
			$groupinfo = _posix_getgrgid($lstat['gid']);

			echo $userinfo['name'], '<br>', $groupinfo['name'], '<br>';

			$owner = &$_POST['owner'];
			$group = &$_POST['group'];
			$other = &$_POST['other'];

			$ownermod  = isset($owner) ? array_sum($owner) : '0';
			$groupmod  = isset($group) ? array_sum($group) : '0';
			$othermod  = isset($other) ? array_sum($other) : '0';
			$mod = (int)($ownermod . $groupmod . $othermod);
			
			if(octdec($mod) <= 0777) {
				if(chmod($path, octdec($mod))) {
					// clear file info cache
					clearstatcache();

					printf('Set permissions of "<i>%1$s</i>" to %2$o', 
						'<a href="'. directlink($path)
						.'" target="_blank">'. wrap(pathTo($path)) .'</a>',
						fileperms($path)%01000);
					?>
					<script type="text/javascript" language="JavaScript">
					<!--
						opener.location.reload();
					//-->
					</script>
					<?
				} else {
					//error
					printf('Error setting permissions of "<i>%s</i>"', 
						'<a href="'. directlink($path)
						.'" target="_blank">'. wrap(pathTo($path)) .'</a>');
				}
			}
		} else { // forbidden
			printf($l['err']['forbidden'], $path);
		}
	} else { //not set
		echo $l['err']['nofile'];
	}
} else {
		$path = &$_GET['path'];

		$lstat = lstat($path);
		$uinfo = _posix_getpwuid($lstat['uid']);
		$ginfo = _posix_getgrgid($lstat['gid']);

		// _very_ experimental quick hack of bitmasking - using string operations
		$mod = decoct($lstat['mode']%01000);
		$owner = decbin(substr($mod, 0, 1));
		$group = decbin(substr($mod, 1, 1));
		$other = decbin(substr($mod, -1));

		$owner = str_pad($owner, 3, '0', STR_PAD_LEFT);
		$group = str_pad($group, 3, '0', STR_PAD_LEFT);
		$other = str_pad($other, 3, '0', STR_PAD_LEFT);

		/*echo '<br>owner > ', $owner;
		echo '<br>group > ', $group;
		echo '<br>other > ', $other;*/
	?>

	<table>
	<tr>
	<?#needs new lang?>
		<td colspan="3"><?printf('Edit permissions of "<i>%1$s</i>" (%2$s):', 
			'<a href="'. directLink($_GET['path'])
			.'" target="_blank">'. wrap(pathTo($_GET['path'])) .'</a>',
			$mod)?></td>
	</tr>
	<tr>
		<th>Owner (<?=$uinfo['name']?>)</th>
		<th>Group (<?=$ginfo['name']?>)</th>
		<th>Others</th>
	</tr>
	<tr>
		<td><label for="chk1"><input type="checkbox" name="owner[]" id="chk1" value="4" <?=($owner{0}) ? 'checked' : ''?>><?=$l['read']?></label></td>
		<td><label for="chk2"><input type="checkbox" name="group[]" id="chk2" value="4" <?=($group{0}) ? 'checked' : ''?>><?=$l['read']?></label></td>
		<td><label for="chk3"><input type="checkbox" name="other[]" id="chk3" value="4" <?=($other{0}) ? 'checked' : ''?>><?=$l['read']?></label></td>
	</tr>
	<tr>
		<td><label for="chk4"><input type="checkbox" name="owner[]" id="chk4" value="2" <?=($owner{1}) ? 'checked' : ''?>><?=$l['write']?></label></td>
		<td><label for="chk5"><input type="checkbox" name="group[]" id="chk5" value="2" <?=($group{1}) ? 'checked' : ''?>><?=$l['write']?></label></td>
		<td><label for="chk6"><input type="checkbox" name="other[]" id="chk6" value="2" <?=($other{1}) ? 'checked' : ''?>><?=$l['write']?></label></td>
	</tr>
	<tr>
		<td><label for="chk7"><input type="checkbox" name="owner[]" id="chk7" value="1" <?=($owner{2}) ? 'checked' : ''?>><?=$l['exec']?></label></td>
		<td><label for="chk8"><input type="checkbox" name="group[]" id="chk8" value="1" <?=($group{2}) ? 'checked' : ''?>><?=$l['exec']?></label></td>
		<td><label for="chk9"><input type="checkbox" name="other[]" id="chk9" value="1" <?=($other{2}) ? 'checked' : ''?>><?=$l['exec']?></label></td>
	</tr>
	</table>

	<div class="footer"><input type="submit" name="edit" value="<?=$l['editperms']?>"></div>
	<?
} ?>
	</center>
	</form>

	</div>
<?
break;
//^^mod^^

//__multi__
//multiple file ops, still under *construction*
// down/zip working
case 'multi':
echo '<pre>';

#var_dump($_POST);
#var_dump($_GET);
echo '<br>GET: ', var_dump($_GET);
echo '<br>POST: ', var_dump($_POST);
echo '<br>REQUEST: ', var_dump($_REQUEST);
$dir = &$_GET['dir'];

echo '</pre>';

//quickfick
if(isset($_POST['add']) || isset($_POST['sub'])) {
	$clipboard = &$_SESSION['mfp_clipboard'];
echo '<br>B4:', var_dump($clipboard);

		if(isset($_POST['chks']) && count($_POST['chks'])) {
			// loop checkboxes and then decide what to do!

			foreach($_POST['chks'] as $file) {
				$path = HOME . pathTo($dir.'/'.$file);
				echo '<br>dir "', $dir, '" / path "', $path, '":&nbsp;';
				if(is_file($path)) {
					if(allowed($path)) {
						// subaction (add, substract):
						if(isset($_POST['add'])) {
							// check for duplicates
							if(!in_array($path, $clipboard)) {
								$clipboard[] = $path;
								echo 'added to clipboard';
							}
						} else if(isset($_POST['sub'])) {
							if(in_array($path, $clipboard)) {
								unset($clipboard[array_search($path, $clipboard)]);
								echo 'removed from clipboard';
							}
						}
					} else { printf($l['err']['forbidden'].'<br>', $path); }
				} else { echo $l['err']['nofile']; }
			}
		} else { echo 'nothing checked<br>'; }

	echo '<br>after:', var_dump($clipboard);

	// list clipboard
	header('Location: '. dosid(SELF.'?a=clip&list'));
}


if(isset($_POST['ren'])) {
	echo 'renaming...<br>';
	if(isset($_POST['chks'])) {
		foreach($_POST['chks'] as $name) {
		?>
			<?=$dir?> // <?=$name?><br>
		<? }
	}

} else if(isset($_POST['del'])) {
	echo 'deleting...<br>';
} else if(isset($_POST['down'])) {
// create zip of files and send to browser
	//end-delete buffering
	ob_end_clean();

	if(isset($_POST['chks']) && count($_POST['chks'])) {
		foreach($_POST['chks'] as $file) {
			$path = $dir.'/'.$file;
			if(is_file($path)) {
				if(allowed($path)) {
					if(($content = @file_get_contents($path)) !== false) {
						$zipfiles[$name] = $content;
					} else { printf($l['err']['openfile'].'<br>', $path); }
				} else { printf($l['err']['forbidden'].'<br>', $path); }
			} else { echo 'no file<br>'; }
		}
	} else { echo 'nothing checked<br>'; }

	if(isset($zipfiles) && count($zipfiles)) {
		//load lib
		require_once($libdir.'/zip.lib.php');

		$zip = new zipfile();
		$zipfiles = array();

		foreach($zipfiles as $zipname => $zipcont) {
			$zip->addFile($zipcont, $zipname);
		}

		$zipdump = $zip->file();
		// send headers
		header('Content-type: application/zip');
		header('Content-length: ' . strlen($zipdump));
		header('Content-Disposition: attachment; filename="'.basename($dir).'.zip"');

		// print zipfile and send it to browser
		print($zipdump);

	} else { echo 'no files to zip'; }

	//exit script :)
	exit;
} else if(isset($_POST['src'])) {
	echo 'show code...<br>';
} else if(isset($_POST['edit'])) {
	echo 'editing...<br>';
}
break;
//^^multi^^

//__new__
case 'new':
$title = $l['title']['new'];
?>
<div class="section full">
<?if($_POST['what'] == 'dir') {?>
<h1><img src="<?=img('newdir')?>" width="16" height="16" alt="<?=$l['new']?>"> <?=$title?></h1>
<?}else{?>
<h1><img src="<?=img('newfile')?>" width="16" height="16" alt="<?=$l['new']?>"> <?=$title?></h1>
<?}?>
<center class="container">

<?
	if(isset($_POST['create'])) {
		$allok = true;
		if(allowed($_POST['dir'])) $allok = true;
			else { $allok = false; $error->add(sprintf($l['err']['forbidden'], $_POST['dir'])); }

	} else { $allok = false; $error->add('Forbidden'); }

if($allok === true) {

		$newname = $_POST['dir'] . '/' . $_POST['filename'];
		$newtextname = wrap(pathTo($_POST['dir']) .'/'. $_POST['filename']);

		if(!empty($_POST['filename'])) {

			//possibility to extend in future eg: 'link', 'archive', ...
			switch($_POST['what']) {

				case 'dir':
					if(file_exists($newname)) {
						printf($l['err']['direxists'], 
							'<a href="'. dosid(SELF.'?a=view&amp;dir='.urlencode($newname))
							.'" target="_blank">'. wrap(pathTo($newname).'/') .'</a>');
					} else {
						if(@mkdir($newname)) {
							printf($l['ok']['createdir'], 
								'<a href="'. dosid(SELF.'?a=view&amp;dir='.urlencode($newname))
								.'" target="view" onclick="opener.location=this.href;window.close();">'. wrap(pathTo($newname).'/') .'</a>');
					} else {
							printf($l['err']['createdir'], $newtextname);
						}
					}
				break;

				case 'file':
					if(file_exists($newname)) {
						printf($l['err']['fileexists'], 
							'<a href="'. directlink($newname)
							.'" target="_blank">'. wrap(pathTo($newname).'/') .'</a>',
							getfsize(filesize($newname)));
				} else {
						if($handle = @fopen($newname, 'w+b')) {
							printf($l['ok']['createfile'], 
								'<a href="'. directlink($newname)
								.'" target="_blank">'. wrap(pathTo($newname)) .'</a>'
							);
						} else {
							printf($l['err']['createfile'], $newtextname);
						}
						@fclose($handle);
					}
				break;
			}

?>
			<form name="myftphp_form" action="javascript:window.close()">
			<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">

			<?= $_POST['what'] == 'file' ? '<input name="editbut" type="button" value="  '.$l['editcode'].'  " onClick="document.location = \''.dosid(SELF.'?a=edit&amp;file='.urlencode($newname)).'\';">' : "\n" ?>

			<script type="text/javascript" language="JavaScript">
			<!--
					opener.document.quickform.filename.value = "";
					opener.location.reload();

					opener.parent.tree.location.reload();



					document.myftphp_form.closebut.focus();
			//-->
			</script>
			</form>

<?
		} else {
			echo $l['err']['emptyfield'];
		}
	} else {
		$error->printout();
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

// emu-functions
function _posix_getpwuid($uid) {
	if(function_exists('posix_getpwuid')) return posix_getpwuid($uid);
	else return $uid;
}
function _posix_getgrgid($gid) {
	if(function_exists('posix_getgrgid')) return posix_getgrgid($gid);
	else return $gid;
}

$imgexts = array('gif', 'jpg', 'jpeg', 'jpe', 'png', 'svg', 'svgz', 'tif', 'tiff');


$path = $_GET['path'];
$ext = strtolower(substr($path, strrpos($path, '.')+1));

if(allowed($path)) {

	$lstat = @lstat($path);
	$owner = _posix_getpwuid($lstat['uid']);
	$group = _posix_getgrgid($lstat['gid'])
?>
	<center id="fix"><b><?=$l['props']?></b></center>
	<div id="scroll">

	<div class="section">
	<h1><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['props']?>"> <?=$l['props']?></h1>
	<div class="container">

		<div class="section">
		<h1><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['src']?>"> File</h1>
		<table class="container">
		<tr class="vtop">
			<td>Name: </td>
			<td>"<i><?=basename($path)?></i>"
			<a href="<?=dosid(SELF.'?a=ren&amp;file='.urlencode($path))?>" title="<?=$l['renamefile']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"></a></td>
		</tr>
		<tr class="vtop">
			<td>Path: </td>
			<td>"<i><?=wrap(pathTo($path))?></i>"</td>
		</tr>
		<? if(is_file($path)) { ?>
		<tr>
			<td>Size: </td>
			<td>"<i><?=getfsize($lstat['size'])?></i>"</td>
		</tr>
		<tr>
			<td>Extension: </td>
			<td>"<i><?=$ext?></i>"</td>
		</tr>
		<? } ?>
		<tr>
			<td>Last modified: </td>
			<td>"<i><?=@date($l['fulldate'], $lstat['mtime'])?></i>"</td>
		</tr>
		<tr>
			<td>Last accessed: </td>
			<td>"<i><?=@date($l['fulldate'], $lstat['atime'])?></i>"</td>
		</tr>
		</table>
			
		</div>

		<div class="section">
		<h1><a href="<?=dosid(SELF.'?a=mod&amp;path='.urlencode($path))?>" title="<?=$l['editperms']?>" onClick="popUp(this.href, 'chmodwin'); return false;"><img src="<?=img('perms')?>" width="16" height="16" alt="<?=$l['perms']?>"></a> Permissions</h1>
		<table class="container">
		<tr>
			<td>Permissions: </td>
			<td>"<i><?=decoct($lstat['mode']%01000)?></i>"</td>
		</tr>
		<? if(($owner) && ($group)) { ?>
		<tr>
			<td>Owner: </td>
			<td>"<i><?=$owner['name']?></i>"</td>
		</tr>
		<tr>
			<td>Group: </td>
			<td>"<i><?=$group['name']?></i>"</td>
		</tr>
		<? } ?>
		</table>
		</div>

		<div class="section">
		<h1><a href="<?=dosid(SELF.'?a=src&amp;file='.urlencode($path))?>" title="<?=$l['showsrc']?>" onClick="popUp(this.href, 'showwin', 'width=700,height=500'); return false;"><img src="<?=img('src')?>" width="16" height="16" alt="<?=$l['src']?>"></a> Preview</h1>
	<? if(is_file($path)) { ?>
		<? if(in_array($ext, $imgexts)) {
			$wh = getimagesize($path);
			$w = $wh[0];
			$h = $wh[1];
		?>
		<div class="container">
		<img src="<?=dosid(SELF.'?a=thumb&amp;img='.urlencode($path).'&amp;size=100')?>" style="float:left; margin-right:10px; width:100px; height:100px;" alt="<?=$l['thumb']?>">
		<div>
		<?=$w?>px x <?=$h?>px<br>
		</div>
		</div>
		<? } else { ?>
		<code class="container">
		<?
			$fsize = @filesize($path);
			$h = @fopen($path, 'rb+');
			$cont = @fread($h, $fsize < $previewlen ? $fsize : $previewlen);

			#echo '<pre>', htmlspecialchars($cont), '</pre>';
			echo nl2br(htmlspecialchars($cont));
		?>
		</code>
		<? } ?>
	<? } else if(is_dir($path)) {
			$dircount = $filecount = 0;
			$filesizes = 0;
			$h = @opendir($path);
			while($file = @readdir($h)){
				$filepath = $path.'/'.$file;
				if(allowed($filepath)) {
					if(is_dir($filepath)) {
						if($file != '.' && $file != '..') $dircount++;
					} else if(is_file($filepath)) {
						$filecount++;
						$filesizes += @filesize($filepath);
					}
				}
			}
			@closedir($h);
	?>
	<div class="container">
		<img src="<?=img('dir')?>" style="float:left; margin-right:10px; width:100px; height:100px;" alt="<?=$l['dir']?>">
		<table>
		<tr>
			<td>Files: </td>
			<td><?=$filecount?></td>
		</tr>
		<tr>
			<td>Directories: </td>
			<td><?=$dircount?></td>
		</tr>
		<tr>
			<td>Size: </td>
			<td><?=getfsize($filesizes)?></td>
		</tr>
		</table>
	</div>
	<? } ?>
		</div>

	</div>
	</div>

	</div>
<?
	} else {
		printf($l['err']['forbidden'], $path);
	}
break;
//^^props^^


//__rem__
case 'rem':
//remove directory recursive
$title = $l['title']['rem'];
?>
<div class="section full">
<h1><img src="<?=img('rem')?>" width="16" height="16" alt="<?=$l['remove']?>"> <?=$title?></h1>
<center class="container">

<?
if(isset($_POST['remove'])) {

	$dir = &$_POST['dir'];
	if(!allowed($dir)) die('permission denied');

	$reldir = pathTo($dir);
	$wrapdir = wrap($reldir);

	function recursiveRem($dir) {
		global $debug;

		$handle = @opendir($dir);
			while($file = @readdir($handle)) {
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
		@closedir($handle);
		return true;
	}

	//recursion
	if(recursiveRem($dir)) {
		//remove directory itself
		// shouldn't remove rootdir - needs workaround
		if(realpath($dir) == REALHOME) die('permission denied');

		if(allowed($dir)) {
			if(@rmdir($dir)) {
				printf($l['ok']['removedir'], $wrapdir);
			} else {
				printf($l['err']['removedir'], $wrapdir);
			}
		} else {
			printf($l['err']['forbidden'], $wrapdir);
		}
?>
			<form name="myftphp_form" action="javascript:window.close()">
			<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
			<script type="text/javascript" language="JavaScript">
			<!--
				opener.location.reload();
				opener.parent.tree.location.reload();

				document.myftphp_form.closebut.focus();
			//-->
			</script>
			</form>
		<?
	} else {
		printf($l['err']['removedir'], $wrapdir);
	}

} else {
	$dir = &$_GET['dir'];
	if(allowed($dir)) {
		
		// confirm - very ugly
?>
<form method="post" action="<?=dosid(SELF.'?a=rem')?>" onSubmit="return confirm('Remove <?=addcslashes(pathTo($dir), '\\')?>?'); return false;">
	<input type="hidden" name="dir" value="<?=$dir?>">
	<?printf($l['warn']['reallyrem'],
		'<a href="'. dosid(SELF.'?a=view&amp;dir='.urlencode($dir))
		.'" target="_blank">'. wrap(pathTo($dir)) .'</a>')?><br>
	<?=$l['warn']['alldirs']?><br>
	<input type="submit" name="remove" value=" <?=$l['remove']?> ">&nbsp;
	<input type="button" name="cancel" value="  <?=$l['cancel']?>  " onClick="window.close()">
</form>
<?} else {
		printf($l['err']['forbidden'], $_GET['dir']);
	}
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
<div class="section full">
<h1><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['rename']?>"> <?=$l['rename']?></h1>
<center class="container">
	<?
	$oldfile = &$_POST['oldfile'];

	if(isset($_POST['rename'])) {

		if(file_exists($oldfile)) {
			if(allowed($oldfile)) {
				if(!empty($_POST['newname'])) {

					$newname = dirname($oldfile).'/'.$_POST['newname'];

					if(rename($_POST['oldfile'], $newname)) {
						printf($l['ok']['rename'], $oldfile, 
							'<a href="'. directLink($newname)
							.'" target="_blank">'. wrap($newname) .'</a>');
					} else {
						printf($l['err']['rename'], $oldfile, $newname);
					}
				} else {
					echo $l['err']['emptyfield'];
				}
		?>
		<form name="myftphp_form" action="javascript:window.close()">
		<input name="closebut" type="submit" value="  <?=$l['close']?>  " onClick="window.close()">
		<script type="text/javascript" language="JavaScript">
		<!--
				opener.location.reload();
				document.myftphp_form.closebut.focus();
		//-->
		</script>
		</form>
		<?
			} else {
				printf($l['err']['forbidden'], $oldfile);
			}
		// /isset
		} else {
			printf($l['err']['badfile'], $oldfile);
		}
	} else {

		$file = &$_GET['file'];
		if(file_exists($file)) {
			if(allowed($file)) {
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


	<form method="post" action="<?=dosid(SELF.'?a=ren')?>" name="renform" onSubmit="return chkform(); return false;">
		<input type="hidden" name="oldfile" value="<?=$file?>">
		<?printf($l['renameto'], 
				'<a href="'. directLink($file)
				.'" target="_blank">'. basename($file) .'</a>')?><br>
		<input type="text" name="newname" value="<?=basename($file)?>"><br>

		<input type="submit" name="rename" value=" <?=$l['rename']?> ">&nbsp;
		<input type="button" value="  <?=$l['cancel']?>  " onClick="window.close()">
	</form>

	<?	} else {
				printf($l['err']['forbidden'], $file);
			}
		} else {
			printf($l['err']['badfile'], $file);
		}
	}?>
</center>
</div>
<?
break;
//^^ren^^

//__src__
case 'src':
// show source code
$title = $l['title']['src'];
$file = &$_GET['file'];

	if(isset($file)
		&& file_exists($file)
		&& allowed($file)) { ?>
		<div id="fix">
			<form method="post" action="<?=dosid(SELF.'?a=edit')?>" target="editwin" onSubmit="popUp(this.action, 'editwin', 'width=640,height=480');">
			<input type="hidden" name="file" value="<?=$_GET['file']?>">
			<input type="submit" name="edit" value="  <?=$l['editcode']?>  ">&nbsp;
			<input type="button" name="close" value="  <?=$l['close']?>  " onClick="window.close()">&nbsp;
			</form>
		</div>

		<div id="scroll" style="border:1px <?=$c['border']['fix']?> solid; padding:0.4em; -moz-border-radius:1em;">
		<?
		// newest approach
		// http://www.selfphp.info/kochbuch/kochbuch.php?code=39

			// buffering highlighted source
			$source = show_source($file, true);

			$lines     = file($file);
			$linecount = count($lines);
			$length    = strlen($linecount);
			$numbers   = '';
    
			for($i=1;$i<=$linecount;$i++) {
					$numbers .= str_pad($i, $length, "0", STR_PAD_LEFT). ".<br>\n";
			}

		// shows colored source
		// with line numbers
		// new try with floating divs
		?>
		<div style="-moz-border-radius:0.5em 0 0 0.5em; display:table;">
			<div style="float:left; background-color:<?=$c['bg']['input']?>; border-right:1px solid <?=$c['border']['lite']?>; padding:0px 3px;"><code><?=$numbers?><code></div>
			<div style="float:left; background-color:<?=$c['bg']['inputlite']?>; padding-left:1em;"><?=$source?></div>
		</div>

		</div>
		<?
	} else {
		printf($l['err']['badfile'], $_GET['file']);
	}
break;
//^^src^^


//__thumb__
case 'thumb':
// create thumbnailed images
// thx to http://www.weberdev.com/ViewArticle-388.html

	$img = &$_GET['img'];
	if(isset($_GET['size'])) $maxw = $maxh = $_GET['size'];

	if(isset($img)) {
		if(file_exists($img) 
			&& allowed($img)) {

			ob_end_clean();

			//png in most cases better | just toggle the '#' in this and the generate paragraph below
			#header('Content-Type: image/jpg');/*
			header('Content-Type: image/png');/**/

			// probs with empty files (0bytes)
			$wh = @getimagesize($img);
			$w = $wh[0];
			$h = $wh[1];

			switch($wh[2]) {
				case 1:
					$oldimg = imageCreateFromGif($img);
				break;
				case 2:
					$oldimg = imageCreateFromJpeg($img);
				break;
				case 3:
					$oldimg = imageCreateFromPng($img);
				break;
				default:
					//get extension - and draw file icon
					$ext = strtolower(substr(strrchr($img,'.'),1));
					$resizeall = true;

					foreach($ftypes as $key => $val) {
						if(in_array($ext, $val)) {
							$imgpath = $icondir.'/'.$icons[$key];

							//draws file icon
							$wh = getimagesize($imgpath);
							$w = $wh[0];
							$h = $wh[1];
							$oldimg = imageCreateFromPng($imgpath);
						}
					}
					if(!isset($oldimg)) {
						// draws default error image
						$wh = getimagesize(img('error'));
						$w = $wh[0];
						$h = $wh[1];

						$oldimg = imageCreateFromPng(img('error'));
					}
			
/*					switch($ext) {
						default:
							// draws error image
							$wh = getimagesize($err);
							$w = $wh[0];
							$h = $wh[1];

							$oldimg = imageCreateFromPng($err);
						break;
					}
*/
				break;
			}


			if(($w > $maxw || $h > $maxh) || $resizeall) {
				$ratio = ($w >= $h) ? $maxw / $w : $maxh / $h;
				$nw = $w * $ratio;
				$nh = $h * $ratio;
			} else {
				$nw = $w;
				$nh = $h;
			}
			$newimg = imageCreate($maxw,$maxh);
			imageAntiAlias($newimg,true);
			//center image ;)
			imageCopyResampled($newimg,$oldimg,($maxw - $nw)/2,($maxh - $nh)/2,0,0,$nw,$nh, $w, $h);

			//send image - toggle 'tween jpeg/png
			#imageJpeg($newimg,'',$imgquality);/*
			imagePng($newimg);/**/
		} else {
			printf($l['err']['badfile'], $file);
		}
	} else {
		echo $l['err']['nofile'];
	}

	// end script - no further output
	return;
break;
//^^thumb^^


//__tree__
case 'tree':
// directories: tree view
$title = $l['title']['tree'];

	//if no dir was passed, use root instead
	$dir = isset($_GET['dir']) ? $_GET['dir'] : HOME;
	if (!allowed($dir)) $dir = HOME;

	//the maximum depth of directory tree
	$maxlevel = 0;

	//root
	$dirs = array();

	//walk through directories recursive
	function listTree($dir) {
		if(file_exists($dir)) {
			global $level, $dirs, $maxlevel;
			//doesn't get deleted after function call
			static $nowlevel = 0;

			$nowlevel++;
			//set new maximum depth
			$maxlevel < $nowlevel ? $maxlevel = $nowlevel : NULL;

			$handle = @opendir($dir);
			//maximum depth already reached, or infinite recursion?
			if($nowlevel <= $level || $level === 0) {
				//read directory
				while($file = @readdir($handle)) {
					$path = $dir.'/'.$file;

					//check if directory
					if(@is_dir($path)) {
						//don't fetch . and ..
						if($file != '.' && $file != '..') {

							//fill array
							$dirs[] = array (
								'name' => $file,
								'path' => HOME . pathTo($path),
								'level' => $nowlevel,
							);

							//descend deeper
							listTree($path);

							//level down -in logical structure up
							$nowlevel--;
						}
					//no directory: file, link or . and ..
					}/* else {
						#$dirs[$j]['subfiles']++;
					}*/
				}
			}
			@closedir($handle);
		} else {
			printf('<br><br>'.$GLOBALS['l']['err']['baddir'],$dir);
		}
	}

	//open requested dir
	listTree($dir);

	//print header line
	?>
<div id="fix" style="text-align:center;">
	<a href="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode(HOME));?>" title="<?=$l['home']?>"><img src="<?=img('home')?>" width="16" height="16" alt="<?=$l['home']?>"></a>
	<a href="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
</div>

<div id="scroll">
	<table width="100%">

		<tr class="l"><td>
			<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode(HOME))?>" target="view" class="lrnd" title="<?=$l['home']?>">
			<img src="<?=img('home')?>" width="16" height="16" class="folder" alt="~">
			<img src="<?=img('explore')?>" width="16" height="16" class="explore" alt="">
			Home [<?=basename(realpath(HOME)) ?>]
			</a>
		</td></tr>
		<?
		$realdir = realpath($dir);
		if($realdir != REALHOME) {
			$toDirArray = getTrack($dir);

			foreach($toDirArray as $toDir) {
				$toDir = HOME . $toDir;
			?>
			<tr class="l"><td>
				<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($toDir))?>" target="view" class="lrnd" title="<?=$l['changedir']?>">&nbsp;
				<img src="<?=img('dir')?>" width="16" height="16" class="folder" alt="*">
				<img src="<?=img('explore')?>" width="16" height="16" class="explore" alt="">
				<?=basename(realpath($toDir))?>
				</a>
			</td></tr>
			<?
			}
		?>
		<tr class="l"><td>
			<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir))?>" target="view" class="lrnd" title="<?=$l['changedir']?>">
			<img src="<?=img('home')?>" width="16" height="16" class="folder" alt=".">
			<img src="<?=img('explore')?>" width="16" height="16" class="explore" alt="">
			<?=basename(realpath($dir)) ?>
			</a>
		</td></tr>
	<?
		}
	//formatted output
	$prevlevel = 0;
	if($dirs) {
		foreach($dirs as $tmp) {
			$up = $prevlevel < $tmp['level'] ? ' treeUp' : '';
			?>
			<tr class="l <?=$up?>"><td>

				<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($tmp['path']))?>" target="view" class="lrnd" title="<?=$l['changedir']?>">
				<?	for($i = 0; $i < $tmp['level']; $i++) {
							echo '&nbsp&nbsp;';
						} ?>
				<img src="<?=img('dir')?>" width="16" height="16" class="folder" alt="*">
				<img src="<?=img('explore')?>" width="16" height="16" class="explore" alt="">
				<?=$tmp['name']?>
				</a>

			</td></tr>

			<?
			$prevlevel = $tmp['level'];
		}
	} else {
		echo '<tr><td>&nbsp;&nbsp;';
		echo $l['err']['nodirs'];
		echo '</td></tr>';
	}
	echo '</table>';
	echo '</div>';

break;
//^^tree^^

//__up__
case 'up':
// file upload
$title = $l['title']['up'];
?>

<center id="scroll">
<div class="section" style="margin-top:2em;">
<h1><img src="<?=img('upload')?>" width="16" height="16" alt="<?=$l['upload']?>"> <?=$title?></h1>
<center class="container">

<?
// sent form
if(isset($_POST['upload'])) {

	$dir = ($_POST['dir']).'/';
	// global overwrite
	$overwrite = isset($_POST['over']);

	if(allowed($dir)) {

		echo '<ol>';

		for($i=0; $i < count($_FILES['file']['name']); $i++) {
			$remotename = &$_FILES['file']['name'][$i];
			$tmpname    = &$_FILES['file']['tmp_name'][$i];
			$newname    = $dir . $remotename;

			$filesize = &$_FILES['file']['size'][$i];
			$filetype = &$_FILES['file']['type'][$i];

			$errorcode = &$_FILES['file']['error'][$i];

		#dump($_POST);

			echo '<li>';

			switch($errorcode) {
				case UPLOAD_ERR_NO_FILE:
					echo $l['err']['up']['nofile'];
				break;
				case UPLOAD_ERR_INI_SIZE:
					echo $l['err']['up']['toobig'];
				break;
				case UPLOAD_ERR_PARTIAL:
					echo $l['err']['up']['partially'];
				break;

				case UPLOAD_ERR_OK:
					if(file_exists($newname) && !$overwrite) {
						printf($l['err']['fileexists'], $newname, getfsize(filesize($newname)));
					} else {
						if(@move_uploaded_file($tmpname, $newname)){
							printf($l['ok']['up'], 
								'<a href="'. directLink($newname)
								.'" target="_blank">'. wrap(pathTo($newname)) .'</a>', 
								getfsize($filesize));
							echo '<br>';
							printf(ucfirst($l['filetype']).'<br>', $filetype);
						} else {
							printf($l['err']['unexpected'].'<br>', $errorcode);
						}
					}
				echo '</li>';
				break;
				default:
					echo $l['err']['up']['unknown'];
				break;
			}
		}
		?>
		</ol>
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
		printf($l['err']['forbidden'], $dir);
	}
} else {
?>
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

		<?#new lang?>
		<?#dom editing?>
		<input type="hidden" name="dir" value="<?=$_GET['dir']?>">

		<?printf($l['uploadto'],
			'<a href="'. dosid(SELF.'?a=view&amp;dir='.urlencode($_GET['dir']))
			.'" target="_blank">'. wrap(pathTo($_GET['dir']).'/') .'</a>'
		)?>:<br>
		<div id="ups"><input type="file" name="file[]" size="40"><br></div>

		<div <?=(IE)? 'class="footer"': 'id="fix"'?>>
			<input type="button" value="<?=$l['add']?>" onClick="addField()">
			<input type="submit" name="upload" value=" <?=$l['upload']?> ">&nbsp;
			<input type="button" value=" <?=$l['cancel']?> " onClick="window.close();">&nbsp;
			<label for="over"><input type="checkbox" name="over" id="over"><?=$l['overwrite']?></label>
		</div>
	</form>
<? } ?>
</center>
</div>
</center>

<?
break;
//^^up^^

//__user__
case 'user':
	$title = 'user preferences';

	echo '<pre>';
	#var_export($accounts);
	echo '</pre>';

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
			if(strpos($file, '.ini.php') !== false) {
				$langs[] = substr($file, 0, strpos($file, '.'));
			}
			}
		}
	// open directory and read it :: themes
	$dir = $themedir;
	$dh = @opendir($dir);
		while($file = @readdir($dh)){
			if(is_file($dir. '/' .$file)) {
			if(strpos($file, '.ini.php') !== false) {
				$themes[] = substr($file, 0, strpos($file, '.'));
			}
			}
		}

	// putting current prefs first and sort list
	unset($langs[array_search($curlang, $langs)]);
	sort($langs);
	array_unshift($langs, $curlang);
	unset($themes[array_search($curtheme, $themes)]);
	sort($themes);
	array_unshift($themes, $curtheme);
?>


<center id="fix"><b><?=$l['cust']?></b></center>
<center id="scroll">

<?#=var_dump($_POST)?>
<?
	
$newuser = $olduser;

if(isset($_POST['password'])) {
	echo 'editing passsword<br>';
	if(isset($_POST['oldpwd'], $_POST['newpwd'][0], $_POST['newpwd'][1])
		&& ($_POST['oldpwd'] && $_POST['newpwd'][0] && $_POST['newpwd'][1])) {
		echo 'all set<br>';
		#echo $_POST['oldpwd'];
		#echo $accounts[$user]['pass'];
		if(md5($_POST['oldpwd']) == $curpwd) {
			echo 'old pwd correct<br>';
			if($_POST['newpwd'][0] == $_POST['newpwd'][1]) {
				echo 'new pwds identical<br>';
				$newpwd = md5($_POST['newpwd'][0]);
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

} else if(isset($_POST['username'])) {
	echo 'editing username<br>';
	if(isset($_POST['newusername'])) {
		echo 'new username: ', $_POST['newusername'], '<br>';
	} else {
		echo 'no user name<br>';
	}
} else if(isset($_POST['homedir'])) {
	echo 'editing homedir<br>';
	if(isset($_POST['newhomedir'])) {
		echo 'new homedir: ', $_POST['newhomedir'], '<br>';
	} else {
		echo 'no home dir<br>';
	}
} else if(isset($_POST['customize'])) {
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
		$_SESSION['mfp_lang'] = $newuser['lang'];
		//set new theme, session and reload page for changes to take place
		$_SESSION['mfp_theme'] = $newuser['theme'];

		#echo '<link rel="stylesheet"  type="text/css" href="',dosid(SELF.'?a=css'),'">';
		// no &amp; !!
		header('Location: '.dosid($_SERVER['REQUEST_URI']));
	} else {
		echo 'not set<br>';
	}
}

$newaccounts = $accounts;
$newaccounts[$username] = $newuser;

#echo '$accounts = ', var_export($newaccounts), ';';

?>

	<!-- -- >

	<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
	<div class="section">
	<h1><img src="<?=img('user')?>" alt="<?=$l['user']?>"> <?=$l['user']?></h1>
	<div class="container">
		<input type="text" name="newusername" value="<?=$username?>"> <?=$l['user']?>
	</div>
	<div class="footer"><input type="submit" name="username" value="ok"></div>
	</div>
	</form>

	<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
	<div class="section">
	<h1><img src="<?=img('home')?>" alt="<?=$l['home']?>"> <?=$l['home']?></h1>
	<div class="container">
		<input type="text" name="newhomedir" value="<?=$curhome?>"> <?=$l['home']?>
	</div>
	<div class="footer"><input type="submit" name="homedir" value="ok"></div>
	</div>
	</form>

	<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
	<div class="section">
	<h1><img src="<?=img('pwd')?>" alt="<?=$l['pwd']?>"> <?=$l['pwd']?></h1>
	<div class="container">
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

	</div>
	<div class="footer"><input type="submit" name="password" value="ok"></div>
	</div>
	</form>
	<!--  -->

	<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
	<div class="section">
	<h1><img src="<?=img('thumbs')?>" alt="<?=$l['cust']?>"> <?=$l['cust']?></h1>
	<div class="container">
		<table>
		<tr>
			<td>
			<select size="0" name="newlang">
			<? foreach($langs as $lang) {
					echo '<option>',$lang,'</option>';
				 } ?>
			</select>
			</td>
			<td><?=$l['lang']?></td>
		</tr>
		<tr>
			<td>
			<select size="0" name="newtheme">
			<?
			foreach($themes as $theme) {
				echo '<option>',$theme,'</option>';
			}
			?>
			</select>
			</td>
			<td>colors</td>
		</tr>
		</table>
	</div>
	<div class="footer"><input type="submit" name="customize" value="ok"></div>
	</div>
	</form>

 <!-- -- >
	<hr>

	<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
	<fieldset class="section">
	<legend><img src="<?=img('user')?>" alt="<?=$l['user']?>"> <?=$l['user']?></legend>
	<div class="container">
		<input type="text" name="newusername" value="<?=$username?>"> <?=$l['user']?>
	</div>
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

	//if no dir was passed, use root instead
	$dir = isset($_GET['dir']) ? $_GET['dir'] : HOME;
	#//security
	#$dir = pathTo($dir);

	// sorting values
	$sort = isset($_GET['sort']) ? $_GET['sort'] : '+name';

	//flags
	$dir_exists = false;
	$dir_allowed = false;
	if(file_exists($dir)) $dir_exists = true;
		else { $dir_exists = false; $error->add(sprintf($l['err']['baddir'], $dir)); }
	if(allowed($dir)) $dir_allowed = true;
		else { $dir_allowed = false; $error->add(sprintf($l['err']['forbidden'], $dir)); }
	
	if($dir_exists && $dir_allowed) $allok = true;
		else $allok = false;

	if($allok) {
		// initiate objects
		$viewdirs = new mfp_dirs();
		$viewfiles = new mfp_files();

		// open directory and read it
		$handle = @opendir($dir);
		while($file = @readdir($handle)){
			// now working :) | bit of extra safety
			$path = HOME . pathTo($dir.'/'.$file);

		// important for symlinks pointing out of homedir (they can't be accessed anyway)
		if(allowed($path)) {

			$stat = @lstat($path);

				if(is_dir($path)) {
					//directory

					//class
					$viewdirs->add(array(
						'name' => $file,
						'path' => ($path),
						'lmod' => $stat['mtime'],
						'perm' => decoct($stat['mode']%01000)
					));

				} else {
					//other(file, link)

					//file informationen
					$viewfiles->add(array(
						'name' => $file,
						'path' => ($path),

						'size' => $stat['size'],
						'lmod' => $stat['mtime'],
						'perm' => decoct($stat['mode']%01000)
					));
				}
		}
		}
		//free handle
		@closedir($handle);


		//quick hack after new add method --needs workaround
		#$nowdir = $viewdirs->get(0);
		#$nowdir = ($dir.'/.');
		$nowdir = HOME . pathTo($dir);
		$thisdir = ($nowdir);

		// realupdir: for checking allowance
		$realupdir = realpath($thisdir.'/..');
		// updir: for link generation
		$updir = HOME . pathTo($realupdir);

	$pathlist = getTrack($dir);
	if(realpath($dir) != REALHOME) { array_push($pathlist, pathTo($dir)); }
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
	<form name="quickform" method="post" action="<?=dosid(SELF.'?a=new')?>" onSubmit="return chkform(); return false;" target="newwin">
		<input type="hidden" name="dir" value="<?=$thisdir?>">

		<table>
		<tr class="l">
			<td><a href="<?=dosid(SELF.'?a=gallery&amp;dir='.urlencode($dir))?>" title="<?=$l['viewthumbs']?>"><img src="<?=img('thumbs')?>" width="16" height="16" alt="<?=$l['thumb']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=find&amp;dir='.urlencode($dir))?>" title="<?=$l['find']?>"><img src="<?=img('find')?>" width="16" height="16" alt="<?=$l['find']?>"></a>
			</td>
			<td><a href="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']));?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=up&amp;dir='.urlencode($dir))?>" onClick="popUp(this.href, 'upwin', 'width=460,height=200,status=yes'); return false;" title="<?=$l['uploadfile']?>">
			<img src="<?=img('upload')?>" width="16" height="16" alt="<?=$l['upload']?>"></a>
			</td>

			<td>&nbsp;|&nbsp;</td>
			<td><input id="quicktext" type="text" name="filename" maxlength="255" size="55"></td>
			<td><label for="file" title="<?=$l['createnewfile']?>">
			<input type="radio" name="what" value="file" id="file">
			<img src="<?=img('newfile')?>" width="16" height="16" alt="<?=$l['file']?>">
			[<?=$viewfiles->getCount()?> | <?=getfsize($viewfiles->_size())?>]&nbsp;
			</label></td>
			<td><label for="dir" title="<?=$l['createnewdir']?>">
			<input type="radio" name="what" value="dir" id="dir" checked>
			<img src="<?=img('newdir')?>" width="16" height="16" alt="<?=$l['dir']?>">
			[<?=$viewdirs->getCount()?>]
			</label></td>
			<td>&nbsp;<input type="submit" name="create" value="<?=$l['new']?>"></td>

			<td>&nbsp;|&nbsp;</td>
			<td><a href="<?=dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['view']?>"><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']?>"></a></td>
			<td>[<?=count($_SESSION['mfp_clipboard'])?>]</td>
			<td><a href="<?=dosid(SELF.'?a=clip&amp;copy&amp;dir='.urlencode($dir));?>"  onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['copy']?>"><img src="<?=img('copy')?>" width="16" height="16" alt="<?=$l['copy']?>"></a></td>
			<td><a href="<?=dosid(SELF.'?a=clip&amp;move&amp;dir='.urlencode($dir));?>"  onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['move']?>"><img src="<?=img('move')?>" width="16" height="16" alt="<?=$l['move']?>"></a></td>
		</tr>
		</table>

	</form>
	</div>

	<div id="scroll">
	<form name="form" method="post" action="<?=dosid(SELF.'?a=multi&amp;dir='.urlencode($dir))?>" onSubmit="popUp(action, 'multiwin');" target="multiwin">

		<p>
			<img src="<?=img('dir')?>" width="16" height="16" border="0" alt="<?=$l['dir']?>">&nbsp;
			<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode(HOME))?>" title="<?=$l['changedir']?>"><?=basename(REALHOME)?></a>&nbsp;/
		<?
		if(count($pathlist)) {
			foreach($pathlist as $path) {
				$path = HOME . $path;
		?>
			<a href="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($path))?>" title="<?=$l['changedir']?>"><?=basename($path)?></a> /
		<? }
		} ?>
		</p>

		<table style="border-collapse:collapse;">
		<colgroup>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col>
			<col <?if(substr($sort,1) == 'name') echo 'style="background:',$c['o'],';"'?>>
			<col <?if(substr($sort,1) == 'size') echo 'style="background:',$c['o'],';"'?>>
			<col <?if(substr($sort,1) == 'size') echo 'style="background:',$c['o'],';"'?>>
			<col <?if(substr($sort,1) == 'perm') echo 'style="background:',$c['o'],';"'?>>
			<col <?if(substr($sort,1) == 'lmod') echo 'style="background:',$c['o'],';"'?>>
		</colgroup>

		<?//sorting buttons?>
			<tr style="text-align:center;" class="toprnd">
				<td><input type="checkbox" name="toggle_top" onclick="toggleAll(this, 'chks'); this.form.toggle_bottom.checked = this.checked;"></td>
				<td colspan="6"></td>
				<td class="toprnd" <?if(substr($sort,1) == 'name') echo 'style="background:',$c['o'],';"'?>><a href="<?=dosid(SELF.'?a=view&amp;sort=+name&amp;dir='.urlencode($dir))?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="+"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-name&amp;dir='.urlencode($dir))?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="-"></a></td>
				<td colspan="2" <?if(substr($sort,1) == 'size') echo 'style="background:',$c['o'],';"'?>><a href="<?=dosid(SELF.'?a=view&amp;sort=+size&amp;dir='.urlencode($dir))?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="+"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-size&amp;dir='.urlencode($dir))?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="-"></a></td>
				<td <?if(substr($sort,1) == 'perm') echo 'style="background:',$c['o'],';"'?>><a href="<?=dosid(SELF.'?a=view&amp;sort=+perm&amp;dir='.urlencode($dir))?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="+"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-perm&amp;dir='.urlencode($dir))?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="-"></a></td>
				<td <?if(substr($sort,1) == 'lmod') echo 'style="background:',$c['o'],';"'?>><a href="<?=dosid(SELF.'?a=view&amp;sort=+lmod&amp;dir='.urlencode($dir))?>" title="<?=$l['asc']?>"><img src="<?=img('asc')?>" width="16" height="16" alt="+"></a><a href="<?=dosid(SELF.'?a=view&amp;sort=-lmod&amp;dir='.urlencode($dir))?>" title="<?=$l['desc']?>"><img src="<?=img('desc')?>" width="16" height="16" alt="-"></a></td>
			</tr>

		<? if(allowed($realupdir)) { ?>
			<tr class="l o" style="border-bottom:1px <?=$c['border']['dark']?> solid;">
				<td></td>
				<td></td>
				<td></td>
				<td><a href="<?=dosid(SELF.'?a=rem&amp;dir='.urlencode($dir));?>" onClick="popUp(this.href, 'remwin'); return false;" title="<?=$l['removedir']?>"><img src="<?=img('rem')?>" width="16" height="16" alt="<?=$l['removedir']?>"></a></td>
				<td><a href="<?=dosid(SELF.'?a=ren&amp;file='.urlencode($dir))?>" title="<?=$l['renamedir']?>" onClick="popUp(this.href, 'renwin'); return false;"><img src="<?=img('ren')?>" width="16" height="16" alt="<?=$l['renamedir']?>"></a></td>
				<td></td>
				<td><a href="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode($dir))?>" title="<?=$l['viewdir']?>" target="tree"><img src="<?=img('tree')?>" width="16" height="16" alt="<?=$l['viewdir']?>"></a></td>
				<td><a href="<?= dosid(SELF.'?a=view&amp;dir='.urlencode($updir)) ?>" title="<?=$l['up']?>" class="rnd">
				<img src="<?=img('dirup')?>" width="16" height="16" alt="<?=$l['up']?>">.. | <?=basename($pathlist[count($pathlist)-1])?></a></td>
				<td></td><td></td>
				<td></td><td></td>
			</tr>
		<? } // /check for root
		$viewdirs->sortlist($sort);
		$viewdirs->printout();

		//spacing + ruler
		?>
			<tr style="border-top:1px <?=$c['border']['ruler']?> solid;">
				<td colspan="12">&nbsp;</td>
			</tr>
		<? 
		$viewfiles->sortlist($sort);
		$viewfiles->printout() ?>

		<tr>
			<td><input type="checkbox" name="toggle_bottom" onclick="toggleAll(this, 'chks'); this.form.toggle_top.checked = this.checked;"></td>
			<td colspan="11">
			<button type="submit" name="down"><img src="<?=img('download')?>" alt="<?=$l['download']?>"></button>
			<button type="submit" name="rem"><img src="<?=img('del')?>" alt="<?=$l['delete']?>"></button>
			<button type="submit" name="ren"><img src="<?=img('ren')?>" alt="<?=$l['rename']?>"></button>
			<button type="submit" name="edit"><img src="<?=img('edit')?>" alt="<?=$l['edit']?>"></button>
			<button type="submit" name="src"><img src="<?=img('src')?>" alt="<?=$l['src']?>"></button>
		</tr>
		<tr>
			<td></td>
			<td colspan="11">
			<button type="submit" name="add"><img src="<?=img('clipadd')?>" width="16" height="16" alt="<?=$l['clipadd']?>"></button>
			<button type="submit" name="sub"><img src="<?=img('clipsub')?>" width="16" height="16" alt="<?=$l['clipsub']?>"></button>
			<a href="<?=dosid(SELF.'?a=clip&amp;list')?>" onClick="popUp(this.href, 'clipwin'); return false;" title="<?=$l['view']?>"><img src="<?=img('clip')?>" width="16" height="16" alt="<?=$l['clip']?>"> list</a>
		</tr>
		</table>
	</form>
	</div>

	<?} else {
		$error->printout();
	}
break;
//^^view^^


//__default__
default:

//(i)frameset
$title = $l['title']['default']. ' | '. RELHOME. '/';

$dir = isset($_GET['dir']) ? $_GET['dir'] : HOME;
?>

<div class="section full">
<h1>
<a href="<?=dosid(SELF.'?a=user')?>" title="<?=$l['cust']?>" onClick="popUp(this.href, 'userwin', 'width=400,height=640'); return false;"><?=$user?></a> <a href="<?=dosid(SELF.'?a=logout')?>" title="<?=$l['logout']?>"><img src="<?=img('exit')?>" width="16" height="16" alt="<?=$l['logout']?>"></a>
<a href="<?=dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>" onClick="popUp(this.href, 'helpwin', 'width=400,height=400'); return false;"><img src="<?=img('help')?>" width="16" height="16" alt="<?=$l['help']?>"></a>
&nbsp;&nbsp;|&nbsp;&nbsp;
<a href="<?=dosid(SELF)?>" title="<?=$l['reload']?>"><img src="<?=img('reload')?>" width="16" height="16" alt="<?=$l['reload']?>"></a>
<a href="<?=dosid(SELF.'?a=info')?>" title="<?=$l['info']?>" onClick="popUp(this.href, 'infowin', 'width=450,height=400'); return false;"><img src="<?=img('info')?>" width="16" height="16" alt="<?=$l['info']?>"></a>
<img src="<?=img('drive')?>" width="16" height="16" alt="">
<? //free space
	//bytes:
	$freespace = @disk_free_space(HOME);
	$location  = pathTo(HOME, $_SERVER['DOCUMENT_ROOT']) . '/';
	#echo realpath(REALHOME);

	//format and output
	printf($l['freespace'], getfsize($freespace), $location);
?>
</h1>
<div class="container">

	<!-- <? if($tree) {?><div style="float:left; height:90%; width:185px;"><iframe src="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode($dir))?>" width="100%" height="100%" name="tree" frameborder="0">Browser needs to understand inlineframes</iframe></div>
	<?}?>
	<div style="float:left; height:90%;"><iframe src="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir))?>" width="100%" height="100%" name="view" frameborder="0">
	Browser needs to understand inlineframes<br>
	<a href="<?=dosid(SELF.'?a=view')?>">Load only directory view without tree view</a></iframe></div> -->

<table width="100%" height="90%" cellspacing="0" cellpadding="0" style="padding:0px; border-collapse:collapse; margin:0px;">
<tr>
	<? if($tree) {?><td width="185px"><iframe src="<?=dosid(SELF.'?a=tree&amp;dir='.urlencode($dir))?>" height="100%" width="100%" name="tree" frameborder="0">Browser needs to understand inlineframes</iframe>
	</td><?}?>
	<td><iframe src="<?=dosid(SELF.'?a=view&amp;dir='.urlencode($dir))?>" height="100%" width="100%" name="view" frameborder="0">
	Browser needs to understand inlineframes<br>
	<a href="<?=dosid(SELF.'?a=view')?>">Load only directory view without tree view</a></iframe>
</td>
</tr>
</table>

</div>
</div>
<?
break;
//^^default^^
}

} else {
// no login yet
$title = $l['title']['login'];


$user = &$_POST['user'];

	if(isset($_POST['login'])) {

		$pass = &$accounts[$user]['pass'];
		if(isset($pass)) {
			if(md5($_POST['pwd']) == $pass)
				$allok = true;
			else {
				$allok = false;
				$error->add($l['err']['badpass']);
			}
		} else {
			$allok = false; $error->add(sprintf($l['err']['baduser'], $user));
		}

		if($allok === true) {
		
		@include('./' . $langdir . '/' . $accounts[$user]['lang'] . '.ini.php');
				$_SESSION['mfp_on'] = true;
				$_SESSION['mfp_user'] = $user;

				$_SESSION['mfp_clipboard'] = array();
				$_SESSION['mfp_find'] = array();

				$_SESSION['mfp_ip'] = ip2hex($_SERVER['REMOTE_ADDR']);

				// no &amp;
				header('Location: '.dosid($_SERVER['REQUEST_URI']));
				echo $l['ok']['granted']."<br>\n";
				// &amp;
				echo '<a href="'.dosid(htmlspecialchars($_SERVER['REQUEST_URI'])).'">Click here if redirection doesn\'t work</a>';
		} else {
			$error->printout();
		}

	} else { ?>
	<!-- -->
	<table width="100%" height="100%">
	<tr valign="middle">
		<td align="center"><hr>
		<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
	<div style="display:inline;">
		<div class="section" style="width:150px; padding-bottom:10px; margin:10px;">
		<h1><!-- <img src="<?=img('water')?>" alt="myftphp"> --><a href="<?=dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>"  onClick="popUp(this.href, 'helpwin', 'width=400,height=400'); return false;"><img src="<?=img('help')?>" width="16" height="16" alt="<?=$l['help']?>"></a> <?=$l['login']?></h1>
		<div class="container">
				<table align="center">
				<tr><td><img src="<?=img('user')?>" width="16" height="16"  alt="<?=$l['user']?>"></td><td><input type="text" name="user" style="width:140px;" size="40"></td></tr>
				<tr><td><img src="<?=img('pwd')?>" width="16" height="16" alt="<?=$l['pwd']?>"></td><td><input type="password" name="pwd" style="width:140px;" size="40"></td></tr>
				<tr><td><img src="<?=img('enter')?>" width="16" height="16"  alt="<?=$l['login']?>"></td><td><input type="submit" name="login" value="<?=$l['login']?> " style="width:140px;"></td></tr>
				</table>
		</div>
		</div>
	</div>
		</form>
		<hr></td>
	</tr>
	</table>
	<!-- -- >

	<table width="100%" height="100%">
	<tr valign="middle">
		<td><hr>
		<form method="post" action="<?=dosid(htmlspecialchars($_SERVER['REQUEST_URI']))?>">
			<table align="center" style="text-align:center;">
			<tr><td></td><td><img src="<?=img('water')?>" alt="myftphp"><a href="<?=dosid(SELF.'?a=bout')?>" title="<?=$l['help']?>" onClick="popUp(this.href, 'helpwin'); return false;"><img src="<?=img('help')?>" width="16" height="16" alt="<?=$l['help']?>"></a></td></tr>
			<tr><td><img src="<?=img('user')?>" width="16" height="16"  alt="<?=$l['user']?>"></td><td><input type="text" name="user" style="width:140px;" size="40"></td></tr>
			<tr><td><img src="<?=img('pwd')?>" width="16" height="16" alt="<?=$l['pwd']?>"></td><td><input type="password" name="pwd" style="width:140px;" size="40"></td></tr>
			<tr><td><img src="<?=img('enter')?>" width="16" height="16"  alt="<?=$l['login']?>"></td><td><input type="submit" name="login" value="<?=$l['login']?> " style="width:140px;"></td></tr>
			</table>
		</form>
		<hr></td>
	</tr>
	</table> <!-- -->
	<?
	}
}
// end no login block
break;
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
<meta name="OBGZip" content="true">

<link rel="shortcut icon" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="<?=dosid(SELF.'?a=css')?>">
<?if(IE) { // double check for IE?>
<!--[if lt IE 7]><style type="text/css">
	@media screen {
		html, body { height: 100%; overflow: hidden; }

		#scroll { padding:0pt; margin:0pt; height: 95%; width: 100%; overflow: auto; }
		#scroll * { position: static; }
	}
</style><![endif]-->
<?}?>
<script type="text/javascript">
<!--
	function popUp(url, name, size) {
		var xy = 'left=200,top=100';
		size = size ? size  : 'width=350,height=200';
		var win = window.open(url, name, xy + ',resizable=yes,scrollbars=yes,' + size);
		win.focus();
	}

	// sets status of fromObj to all name[] checkboxes
	function toggleAll(fromObj, name, form) {
		var form = form? this.document.forms[form]: this.document.forms.form;
		if(form[name+'[]']) {
			for(i=0;i<form[name+'[]'].length;i++) {
				form[name+'[]'][i].checked = fromObj.checked;
			}
		}
	}


	// adds content (eg textfield) ~070405
	function add(id, cont) {
		var o = false;
		if (document.getElementById) o = document.getElementById(id);
		else if (document.all) o = document.all[id];

		if (o) o.innerHTML += cont;
		else if (document.layers) {
		// still need a way to "add"
			with (document.layers[id].document) { 
				open();
				write(cont);
				close();
			}
		}
	}

	// doesnt really work
	function co(e) {
		//if(!ev) ev = window.event;
		var x=(document.all)?window.event.x+document.body.scrollLeft:e.pageX;
		var y=(document.all)?window.event.y+document.body.scrollTop:e.pageY;
		alert (x+'< x |||| y >'+y);
		//alert('left='+ev.screenX+',top='+ev.screenY);
		var xy = 'left='+e.screenX+',top='+e.screenY;
		//meins = window.open('<?=SELF?>', 'me', xy + ',resizable=yes,scrollbars=yes,width=320,height=240');
	}
	//document.onclick = co;
//-->
</script>

</head>

<body>
<?
	// print buffer
	print($buffer);
?>
</body>
</html>
<? // send length of compressed page, important to make compression work in almost all cases
header("Content-Length: " . ob_get_length());
//end compressed buffer
ob_end_flush();
exit;?>