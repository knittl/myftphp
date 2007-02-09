<?php
	$l['date']     = 'd.m.y';
	$l['time']     = 'H:i:s';
	$l['fulldate'] = $l['date'].', '.$l['time'];

	$l['cancel'] = 'abbruch';
	$l['close']  = 'beenden';

	$l['byte'] = array(
		'b' => 'b',
		'k' => 'k',
		'm' => 'm',
		'g' => 'g',
		't' => 't',
		'p' => 'p',
		'e' => 'e',
	);

	$l['delete'] = 'l&ouml;schen';
	$l['new']    = 'neu';
	$l['create'] = 'erzeugen';
	$l['rename'] = 'umbenennen';
	$l['edit']   = 'bearbeiten';
	$l['show']   = 'zeigen';
	$l['view']   = 'anzeigen';
	$l['file']   = 'datei';
	$l['code']   = 'code';
	$l['src']    = 'quelle';
	$l['remove'] = 'entfernen';
	$l['dir']    = 'verzeichnis';
	$l['logout'] = 'ausloggen';
	$l['login']  = 'einloggen';
	$l['change'] = '&auml;ndern';
	$l['save']   = 'speichern';
	$l['reset']  = 'zur&uuml;cksetzen';
	$l['back']   = 'zur&uuml;ck';
	$l['empty']  = 'leer';
	$l['field']  = 'textfeld';
	$l['root']   = 'root';
	$l['to']     = 'nach';


	$l['err'] = array(
		'rooterr' => 'Root-Verzeichnis "<i>%s</i>" existiert nicht.<br>
		<a href="'.$self.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'Unerwarteter Fehler (%s).',
		'emptyfield' => ucfirst($l['field']).' ist '.$l['empty'],

		'up' => array(
			'nofile'  => 'Keine (existierende) '.$l['file'].' ausgew&auml;hlt.',
			'toobig'  => ucfirst($l['file']).' zu gro&szlig;',
			'partial' => ucfirst($l['file']).' wurde nur teilweise hochgeladen',
			'unknown' => 'Es wurde ein unbekannter Fehler entdeckt. Bitte an den Systemadministrator wenden',
		),

		'createfile' => 'Fehler beim Erzeugen der Datei "<i>%s</i>"',
		'fileexists' => 'Datei "<i>%1$s</i>" (%2$s) existiert bereits.',
		'deletefile' => 'Fehler beim L&ouml;schen der Datei "<i>%s</i>"',
		'openfile'   => 'Fehler beim &Ouml;ffnen der Datei "<i>%s</i>"',
		'writefile'  => 'Fehler beim Schreiben in Datei "<i>%s</i>"',
		'readfile'   => 'Fehler beim Lesen der Datei "<i>%s</i>"',
		'nofile'     => 'Keine Datei ausgew&auml;hlt',

		'createdir'  => 'Fehler beim Erzeuen des Verzeichnisse "<i>%s</i>"',
		'direxists'  => 'Verzeichnis "<i>%s</i>" existiert bereits.',
		'removedir'  => 'Fehler beim Entferen des Verzeichnisses "<i>%s</i>',

		'rename' => 'Fehler beim Umbenennen von "<i>%1$s</i>" auf "<i>%2$s</i>"',

		'badpass' => 'Falsches Passwort!',
		'baduser' => 'Benutzer existiert nicht!',
	);

	$l['warn'] = array(
		'reallyrem'  => 'Dieses Verzeichnis wirklich entfernen "<i>%s</i>"?',
		'alldirs'	   => '<b>ACHTUNG: alle</b> Dateien und Unterverzeichnisse werden auch gel&ouml;scht!',
		'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\\n \\\'%s\\\' ?',
		'reallydel'  => 'Diese Datei wirklich l&ouml;schen:	"<i>%s</i>"?',
	);

	$l['ok'] = array(
		'createfile' => 'Datei "<i>%s</i>" erfolgreich erstellt',
		'createdir'  => 'Verzeichnis "<i>%s</i>" erfolgreich erstellt',
		'deletedir'  => 'Verzeichnis "<i>%s</i>" wurde erfolgreich gel&ouml;scht',
		'deletefile' => 'Datei "<i>%s</i>" wurde erfolgreich gel&ouml;scht',
		'writefile'  => '%2$s Daten in Datei "<i>%1$s</i>" geschrieben',
	
		'up' => 'Datei erfolgreich auf: "<i>%1$s</i> (%2$s)" hochgeladen',

		'rename' => '"<i>%1$s</i> erfolgreich umbenannt nach "<i>%2$s</i>"',

		'granted' => 'Zugriff erlaubt, Login erfolreich',
	);

	$l['upload']     = 'hochladen';
	$l['download']   = 'runterladen';
	$l['uploadfile'] = $l['file'].' '.$l['upload'];
	$l['changedir']  = $l['dir'].' '.$l['change'];

	$l['freespace'] = 'Freier Speicher: <b>%s</b>';
	$l['filetype']  = 'Dateityp: <i>%s</i>';

	$l['createnewfile'] = $l['new'].'e '.$l['file'].' '.$l['create'];
	$l['createnewdir']  = $l['new'].'en '.$l['dir'].' '.$l['create'];
	$l['deletefile']    = $l['file'].' '.$l['delete'];
	$l['removedir']     = $l['dir'].' '.$l['remove'];
	$l['editcode']      = $l['code'].' '.$l['edit'];
	$l['showsrc']       = $l['src'].' '.$l['show'];
	$l['viewfile']      = $l['file'].' '.$l['view'];
	$l['renamedir']     = $l['dir'].' '.$l['rename'];
	$l['renamefile']    = $l['file'].' '.$l['rename'];
	$l['renameto']      = '"<i>%s</i>" '.$l['rename'].' nach:<br>';

	$l['overwrite']  = '&Uuml;berschreiben';
	$l['uploadto']   = ucfirst($l['file']).' '.$l['to'].' '.$l['upload'].': "<i>%s</i>"';


	//titles for switch shid, same name as forks
	//except login
	$l['title'] = array(
		'default' => '[myFTPhp]', 
		'del'     => &$l['deletefile'], 
		'del'     => &$l['download'], 
		'edit'    => &$l['editcode'], 
		'login'   => &$l['login'], 
		'new'     => &$l['createnewfile'], 
		'rem'     => &$l['removedir'], 
		'ren'     => &$l['rename'], 
		'src'     => &$l['showsrc'], 
		'thumb'   => 'show thumbnailsS', 
		'tree'    => 'browse folders', 
		'up'      => 'upload file', 
		'view'    => 'view folders', 
	);


?>