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

	$l['add']    = 'hinzuf&uuml;gen';
	$l['asc']    = 'aufsteigend';
	$l['back']   = 'zur&uuml;ck';
	$l['bout']   = '&uuml;ber';
	$l['change'] = '&auml;ndern';
	$l['clip']   = 'clip';
	$l['code']   = 'code';
	$l['copy']   = 'kopieren';
	$l['create'] = 'erzeugen';
	$l['cust']   = 'anpassen';
	$l['delete'] = 'l&ouml;schen';
	$l['desc']   = 'absteigend';
	$l['download'] = 'herunterladen';
	$l['dir']    = 'verzeichnis';
	$l['empty']  = 'leer';
	$l['edit']   = 'bearbeiten';
	$l['field']  = 'textfeld';
	$l['file']   = 'datei';
	$l['find']   = 'suchen';
	$l['group']  = 'gruppe';
	$l['help']   = 'hilfe';
	$l['home']   = 'home';
	$l['img']    = 'bild';
	$l['info']   = 'information';
	$l['lang']   = 'sprache';
	$l['login']  = 'einloggen';
	$l['logout'] = 'ausloggen';
	$l['move']   = 'bewegen';
	$l['new']    = 'neu';
	$l['perms']  = 'rechte';
	$l['props']  = 'eigenschaften';
	$l['pwd']    = 'passwort';
	$l['reload'] = 'aktualisieren';
	$l['remove'] = 'entfernen';
	$l['rename'] = 'umbennen';
	$l['reset']  = 'zur&uuml;cksetzen';
	$l['save']   = 'speichern';
	$l['show']   = 'zeigen';
	$l['sort']   = 'sortieren';
	$l['src']    = 'quelle';
	$l['thumb']  = 'vorschaubild';
	$l['to']     = 'nach';
	$l['up']     = 'hoch';
	$l['upload'] = 'upload';
	$l['user']   = 'benutzer';
	$l['view']   = 'anzeigen';

	// errors
	$l['err'] = array(
		'home' => 'Home-Verzeichnis "%s" existiert nicht.<br>
		<a href="'.SELF.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'Unerwarteter Fehler (%s).',
		'emptyfield' => ucfirst($l['field']).' ist '.$l['empty'],

		'up' => array(
			'nofile'  => 'Keine (existierende) '.$l['file'].' ausgew&auml;hlt.',
			'partial' => ucfirst($l['file']).' wurde nur teilweise hochgeladen',
			'toobig'  => ucfirst($l['file']).' zu gro&szlig;',
			'unknown' => 'Es trat ein unbekannter Fehler auf. Bitte an den Systemadministrator wenden',
		),

		'createfile' => 'Fehler beim Erzeugen der Datei "%s"',
		'deletefile' => 'Fehler beim L&ouml;schen der Datei "%s"',
		'fileexists' => 'Datei "%1$s" (%2$s) existiert bereits.',
		'openfile'   => 'Fehler beim &Ouml;ffnen der Datei "%s"',
		'readfile'   => 'Fehler beim Lesen der Datei "%s"',
		'writefile'  => 'Fehler beim Schreiben in Datei "%s"',

		'createdir'  => 'Fehler beim Erzeuen des Verzeichnisse "%s"',
		'direxists'  => 'Verzeichnis "%s" existiert bereits.',
		'removedir'  => 'Fehler beim Entfernen des Verzeichnisses "%s"',

		'rename' => 'Fehler beim Umbenennen von "%1$s" in "%2$s"',
		'find'   => 'Fehler beim Suchen in "%1$s"',

		'badfile'   => 'Datei "%s" existiert nicht',
		'nofile'    => 'Keine Datei ausgew&auml;hlt',
		'baddir'    => 'Verzeichnis "%s" existiert nicht',
		'nodirs'    => 'Keine Verzeichnisse zum anzeigen',
		'nofiles'   => 'Keine Dateien zum anzeigen',
		'forbidden' => 'Sie haben nicht die ausreichenden Berechtigungen um auf "%s" zuzugreifen',

		'badlogin' => 'Login fehlgeschlagen!',
		'badtheme' => 'Theme "%s" existiert nicht!',

		'readable' => '"%s" ist nicht lesbar',
		'writable' => '"%s" ist nicht schreibbar',
	);

	// warnings
	$l['warn'] = array(
		'reallyrem'  => 'Dieses Verzeichnis wirklich entfernen: "%s"?',
		'alldirs'	   => '<b>ACHTUNG: alle</b> Dateien und Unterverzeichnisse werden auch gel&ouml;scht!',
		#'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\n \'%s\' ?',
		'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\\n \\\'%s\\\'?',
		'reallydel'  => 'Diese Datei wirklich l&ouml;schen: "%s"?',
	);

	// confirmations
	$l['ok'] = array(
		'createdir'  => 'Verzeichnis "%s" erfolgreich erstellt',
		'createfile' => 'Datei "%s" erfolgreich erstellt',
		'removedir'  => 'Verzeichnis "%s" wurde erfolgreich entfernt',
		'deletefile' => 'Datei "%s" wurde erfolgreich gel&ouml;scht',
		'granted'    => 'Zugriff erlaubt, Login erfolreich',
		'rename'     => '"%1$s" erfolgreich umbenannt in "%2$s"',
		'up'         => 'Datei erfolgreich auf: "%1$s (%2$s)" hochgeladen',
		'writefile'  => '%2$s Daten in Datei "%1$s" geschrieben',
	);

	$l['changedir']  = $l['dir'].' '.$l['change'];
	$l['uploadfile'] = $l['file'].' '.$l['upload'];
	$l['uploadrar']  = 'rar '.$l['upload'];
	$l['uploadzip']  = 'zip '.$l['upload'];

	$l['freespace'] = '<b>%1$s</b> freier Speicher auf %2$s';
	$l['totalspace'] = '<b>%1$s</b> Speicher insgesamt auf %2$s';
	$l['filetype']  = 'Dateityp: %s';

	$l['createnewdir']  = 'Neues Verzeichnis erstellen';
	$l['createnewfile'] = $l['new'].'e '.$l['file'].' '.$l['create'];
	$l['deletefile']    = $l['file'].' '.$l['delete'];
	$l['editcode']      = $l['code'].' '.$l['edit'];
	$l['editperms']     = 'Zugriffsrechte &auml;ndern';
	$l['removedir']     = $l['dir'].' '.$l['remove'];
	$l['renamedir']     = $l['dir'].' '.$l['rename'];
	$l['renamefile']    = $l['file'].' '.$l['rename'];
	$l['renameto']      = '"%s" '.$l['rename'].' auf: ';
	$l['showsrc']       = $l['src'].' '.$l['show'];
	$l['viewfile']      = $l['file'].' '.$l['view'];
	$l['viewdir']       = $l['dir'].' '.$l['view'];
	$l['viewthumbs']    = $l['dir'].' als Thumbnail Gallerie anzeigen';
	$l['searchfor']     = 'Nach was suchen in "%s":';

	$l['overwrite']  = '&Uuml;berschreiben';
	$l['uploadto']   = ucfirst($l['file']).' '.$l['to'].' "%s"'.' '.$l['upload'];

	$l['casesensitive'] = 'Gro&szlig;/Kleinschreibung beachten';
	$l['exactmatch']    = 'genaue Suche';
	$l['findsubdirs']   = 'Unterverzeichnisse durchsuchen';

	$l['read']  = 'lesen';
	$l['write'] = 'schreiben';
	$l['exec']  = 'ausf&uuml;hren';

	// clipboard messages
	$l['clipboard'] = 'Zwischenablage';
	$l['clip'] = array(
		'add'  => 'Zur '.$l['clipboard'].' hinzuf&uuml;gen',
		'sub'  => 'Von der '.$l['clipboard'].' entfernen',
		'list' => 'Alle Dateien in der '.$l['clipboard'].' auflisten',
		'free' => 'Alle Dateien aus der '.$l['clipboard'].' entfernen',
	);


	//titles for switch shid, same name as forks
	//except login
	$l['title'] = array(
		'default' => '[myFtPhp]',
		'bout'    => &$l['bout'],
		'clip'    => 'Zwischenablage',
		'del'     => &$l['deletefile'],
		'down'    => &$l['download'],
		'edit'    => &$l['editcode'],
		'find'    => 'Dateien und Ordner finden',
		'info'    => 'Allgeimene Information',
		'login'   => &$l['login'],
		'mod'     => &$l['editperms'],
		'new'     => &$l['createnewfile'],
		'rem'     => &$l['removedir'],
		'ren'     => &$l['rename'],
		'src'     => &$l['showsrc'],
		'thumbs'  => 'Thumbnail Gallerie',
		'tree'    => 'Ordner browsen',
		'up'      => 'Datei hochladen',
		'view'    => 'Ordner anzeigen',
	);
?>
