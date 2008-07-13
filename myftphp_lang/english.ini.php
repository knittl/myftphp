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
	$l['download'] = 'download';
	$l['dir']    = 'directory';
	$l['empty']  = 'empty';
	$l['edit']   = 'edit';
	$l['field']  = 'textfield';
	$l['file']   = 'file';
	$l['find']   = 'find';
	$l['group']  = 'group';
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

	// errors
	$l['err'] = array(
		'home' => 'Home-Directory "%s" doesn\'t exist.<br>
		<a href="'.SELF.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'An unexpected error occured (%s).',
		'emptyfield' => ucfirst($l['field']).' is '.$l['empty'],

		'up' => array(
			'nofile'  => 'No (existing) '.$l['file'].' selected.',
			'partial' => ucfirst($l['file']).' uploaded only partially',
			'toobig'  => ucfirst($l['file']).' too big',
			'unknown' => 'An unknown error occured. Please contact the system administrator ',
		),

		'createfile' => 'Error creating file "%s"',
		'deletefile' => 'Error deleting file "%s"',
		'fileexists' => 'File "%1$s" (%2$s) already exists.',
		'openfile'   => 'Error opening file "%s"',
		'readfile'   => 'Error reading file "%s"',
		'writefile'  => 'Error writing to file "%s"',

		'createdir'  => 'Error creating directory "%s"',
		'direxists'  => 'Directory "%s" already exists.',
		'removedir'  => 'Error removing directory "%s',

		'rename' => 'Error renaming "%1$s" to "%2$s"',
		'find'   => 'Error searching in directory "%1$s"',

		'badfile'   => 'File "%s" does not exist',
		'nofile'    => 'No file selected',
		'baddir'    => 'Directory "%s" does not exist',
		'nodir'     => '"%s" is not a directory',
		'nodirs'    => 'No directories to display',
		'nofiles'   => 'No files to display',
		'forbidden' => 'You don\'t have sufficent permissions to access "%s"',

		'badpass'  => 'Wrong password!',
		'baduser'  => 'User does not exist!',
		'badtheme' => 'Theme does not exist!',

		'readable' => '"%s" is not readable',
		'writable' => '"%s" is not writeable',
	);

	// warnings
	$l['warn'] = array(
		'reallyrem'  => 'Really remove this directory:<br> "%s"?',
		'alldirs'	   => '<b>WARNING: all</b> files and directories inside this directory will also be removed!',
		#'reallysave' => 'Really save and overwrite this file:\n \'%s\' ?',
		'reallysave' => 'Really save and overwrite this file:\\n \\\'%s\\\'?',
		'reallydel'  => 'Really delete this file:	"%s"?',
	);

	// confirmations
	$l['ok'] = array(
		'createdir'  => 'Directory "%s" successfully created',
		'createfile' => 'File "%s" succuessfully created',
		'removedir'  => 'Directory "%s" was susccessfully removed',
		'deletefile' => 'File "%s" was susccessfully deleted',
		'granted'    => 'Access granted',
		'rename'     => '"%1$s" successfully renamed to "%2$s"',
		'up'         => 'File successfully uploaded to: "%1$s" (%2$s)',
		'writefile'  => '%2$s of data written into file "%1$s"',
	);

	$l['changedir']  = $l['change'].' '.$l['dir'];
	$l['uploadfile'] = $l['upload'].' '.$l['file'];
	$l['uploadrar'] = $l['upload'].' rar';
	$l['uploadzip'] = $l['upload'].' zip';

	$l['freespace']  = '<b>%1$s</b> of free space on %2$s';
	$l['totalspace'] = '<b>%1$s</b> of total space on %2$s';
	$l['filetype']   = 'filetype: %s';

	$l['createnewdir']  = $l['create'].' a '.$l['new'].' '.$l['dir'];
	$l['createnewfile'] = $l['create'].' a '.$l['new'].' '.$l['file'];
	$l['deletefile']    = $l['delete'].' '.$l['file'];
	$l['editcode']      = $l['edit'].' '.$l['code'];
	$l['editperms']     = 'Edit permissions';
	$l['removedir']     = $l['remove'].' '.$l['dir'];
	$l['renamedir']     = $l['rename'].' '.$l['dir'];
	$l['renamefile']    = $l['rename'].' '.$l['file'];
	$l['renameto']      = $l['rename'].' "%s" to:';
	$l['showsrc']       = $l['show'].' '.$l['src'];
	$l['viewfile']      = $l['view'].' '.$l['file'];
	$l['viewdir']       = $l['view'].' '.$l['dir'];
	$l['viewgallery']    = $l['viewdir'] . ' as thumbnail gallery';
	$l['searchfor']     = 'What to search for in "%s":';

	$l['overwrite']  = 'overwrite';
	$l['uploadto']   = ucfirst($l['upload']).' '.$l['file'].' '.$l['to'].' "%s"';

	$l['casesensitive'] = 'case sensitive';
	$l['exactmatch']    = 'exact match';
	$l['findsubdirs']   = 'include subdirectories';
	$l['onlydirs']      = 'directories only';

	$l['read']  = 'read';
	$l['write'] = 'write';
	$l['exec']  = 'execute';

	// clipboard messages
	$l['clipboard'] = 'clipboard';
	$l['clip'] = array(
		'add'  => 'add to '.$l['clipboard'],
		'sub'  => 'remove from '.$l['clipboard'],
		'list' => 'list all files currently in '.$l['clipboard'],
		'free' => 'remove all files currently in '.$l['clipboard'],
	);


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
