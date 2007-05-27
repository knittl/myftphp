<?php
	$l['date']     = 'y/m/d';
	$l['time']     = 'h:i:s a';
	$l['fulldate'] = $l['date'].' - '.$l['time'];

	$l['cancel'] = 'cancel';
	$l['close']  = 'close';

	$l['byte'] = array(
		'b' => 'b',
		'k' => 'k',
		'm' => 'm',
		'g' => 'g',
		't' => 't',
		'p' => 'p',
		'e' => 'e',
	);

	$l['add']    = 'add';
	$l['asc']    = 'ascending';
	$l['back']   = 'back';
	$l['bout']   = 'about';
	$l['change'] = 'change';
	$l['clip']   = 'clipboard';
	$l['code']   = 'code';
	$l['copy']   = 'copy';
	$l['create'] = 'create';
	$l['cust']   = 'customize';
	$l['delete'] = 'delete';
	$l['desc']   = 'descending';
	$l['dir']    = 'directory';
	$l['empty']  = 'empty';
	$l['edit']   = 'edit';
	$l['field']  = 'textfield';
	$l['file']   = 'file';
	$l['find']   = 'find';
	$l['help']   = 'help';
	$l['home']   = 'home';
	$l['img']    = 'image';
	$l['info']   = 'information';
	$l['lang']   = 'language';
	$l['login']  = 'login';
	$l['logout'] = 'logout';
	$l['move']   = 'move';
	$l['new']    = 'new';
	$l['perms']  = 'permissions';
	$l['props']  = 'properties';
	$l['pwd']    = 'password';
	$l['reload'] = 'refresh';
	$l['remove'] = 'remove';
	$l['rename'] = 'rename';
	$l['reset']  = 'reset';
	$l['save']   = 'save';
	$l['show']   = 'show';
	$l['sort']   = 'sort';
	$l['src']    = 'source';
	$l['thumb']  = 'thumbnail';
	$l['to']     = 'to';
	$l['up']     = 'up';
	$l['upload'] = 'upload';
	$l['user']   = 'user';
	$l['view']   = 'view';


	$l['err'] = array(
		'home' => 'Home-Directory "<var>%s</var>" doesn\'t exist.<br>
		<a href="'.SELF.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'An unexpected error occured (%s).',
		'emptyfield' => ucfirst($l['field']).' is '.$l['empty'],

		'up' => array(
			'nofile'  => 'No (existing) '.$l['file'].' selected.',
			'partial' => ucfirst($l['file']).' uploaded only partially',
			'toobig'  => ucfirst($l['file']).' too big',
			'unknown' => 'An unknown error occured. Please contact the system administrator ',
		),

		'createfile' => 'Error creating file "<var>%s</var>"',
		'deletefile' => 'Error deleting file "<var>%s</var>"',
		'removedir'  => 'Error removing directory "<var>%s</var>"',
		'fileexists' => 'File "<var>%1$s</var>" (%2$s) already exists.',
		'openfile'   => 'Error opening file "<var>%s</var>"',
		'readfile'   => 'Error reading file "<var>%s</var>"',
		'writefile'  => 'Error writing to file "<var>%s</var>"',

		'createdir'  => 'Error creating directory "<var>%s</var>"',
		'direxists'  => 'Directory "<var>%s</var>" already exists.',
		'removedir'  => 'Error removing directory "<var>%s</var>',

		'rename' => 'Error renaming "<var>%1$s</var>" to "<var>%2$s</var>"',
		'find'   => 'Error searching in directory "<var>%1$s</var>"',

		'badfile'   => 'File "<var>%s</var>" nonexistent',
		'nofile'    => 'No file selected',
		'baddir'    => 'Directory "<var>%s</var>" nonexistent',
		'nodirs'    => 'No directories to display',
		'nofiles'   => 'No files to display',
		'forbidden' => 'You don\'t have permission to access "<var>%s</var>"',

		'badpass'  => 'Wrong password!',
		'baduser'  => 'User does not exist!',
		'badtheme' => 'Theme does not exist!',
	);

	$l['warn'] = array(
		'reallyrem'  => 'Really remove this directory<br> "<var>%s</var>"?',
		'alldirs'	   => '<b>WARNING: all</b> files and directories inside this directory will also be removed!',
		#'reallysave' => 'Really save and overwrite this file:\n \'%s\' ?',
		'reallysave' => 'Really save and overwrite this file:\\n \\\'%s\\\' ?',
		'reallydel'  => 'Really delete this file:	"<var>%s</var>"?',
	);

	$l['ok'] = array(
		'createdir'  => 'Directory "<var>%s</var>" successfully created',
		'createfile' => 'File "<var>%s</var>" succuessfully created',
		'removedir'  => 'Directory "<var>%s</var>" was susccessfully removed',
		'deletefile' => 'File "<var>%s</var>" was susccessfully deleted',
		'granted'    => 'Access granted',
		'rename'     => '"<var>%1$s</var> successfully renamed to "<var>%2$s</var>"',
		'up'         => 'File successfully uploaded to:<br> "<var>%1$s</var>" (%2$s)',
		'writefile'  => '%2$s of data written into file "<var>%1$s</var>"',
	);

	$l['changedir']  = $l['change'].' '.$l['dir'];
	$l['download']   = 'download';
	$l['upload']     = 'upload';
	$l['uploadfile'] = $l['upload'].' '.$l['file'];
	$l['uploadrar'] = $l['upload'].' rar';
	$l['uploadzip'] = $l['upload'].' zip';

	$l['freespace']  = '<b>%1$s</b> of free space on <var>%2$s</var>';
	$l['totalspace'] = '<b>%1$s</b> of total space on <var>%2$s</var>';
	$l['filetype']   = 'filetype: <var>%s</var>';

	$l['createnewdir']  = $l['create'].' a '.$l['new'].' '.$l['dir'];
	$l['createnewfile'] = $l['create'].' a '.$l['new'].' '.$l['file'];
	$l['deletefile']    = $l['delete'].' '.$l['file'];
	$l['editcode']      = $l['edit'].' '.$l['code'];
	$l['editperms']     = 'Edit permissions';
	$l['removedir']     = $l['remove'].' '.$l['dir'];
	$l['renamedir']     = $l['rename'].' '.$l['dir'];
	$l['renamefile']    = $l['rename'].' '.$l['file'];
	$l['renameto']      = $l['rename'].' "<var>%s</var>" to:<br>';
	$l['showsrc']       = $l['show'].' '.$l['src'];
	$l['viewfile']      = $l['view'].' '.$l['file'];
	$l['viewdir']       = $l['view'].' '.$l['dir'];
	$l['viewthumbs']    = $l['viewdir'] . ' as thumbnail gallery';
	$l['searchfor']     = 'What to search for in "<var>%s</var>"';

	$l['overwrite']  = 'overwrite';
	$l['uploadto']   = ucfirst($l['upload']).' '.$l['file'].' '.$l['to'].' "<var>%s</var>"';

	$l['casesensitive'] = 'case sensitive';
	$l['exactmatch']    = 'whole word only';
	$l['findsubdirs']   = 'include sub directories';

	$l['read']  = 'read';
	$l['write'] = 'write';
	$l['exec']  = 'execute';


	//titles for switch shid, same name as forks
	//except login
	$l['title'] = array(
		'default' => '[myFtPhp]',
		'bout'    => &$l['bout'],
		'clip'    => 'clipboard',
		'del'     => &$l['deletefile'],
		'down'    => &$l['download'],
		'edit'    => &$l['editcode'],
		'find'    => 'find files and folders',
		'info'    => 'general information',
		'login'   => &$l['login'],
		'mod'     => &$l['editperms'],
		'new'     => &$l['createnewfile'],
		'props'   => &$l['showprops'],
		'rem'     => &$l['removedir'],
		'ren'     => &$l['rename'],
		'src'     => &$l['showsrc'],
		'thumbs'  => 'thumbnail gallery',
		'tree'    => 'browse folders',
		'up'      => 'upload file',
		'view'    => 'view folder',
	);
?>