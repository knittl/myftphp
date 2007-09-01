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
	$l['dir']    = 'verzeichnis';
	$l['empty']  = 'leer';
	$l['edit']   = 'bearbeiten';
	$l['field']  = 'textfeld';
	$l['file']   = 'datei';
	$l['find']   = 'suchen';
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
		'home' => 'Home-Verzeichnis "<var>%s</var>" existiert nicht.<br>
		<a href="'.SELF.'?mode=logout">'.$l['back'].'</a>',

		'unexpected' => 'Unerwarteter Fehler (%s).',
		'emptyfield' => ucfirst($l['field']).' ist '.$l['empty'],

		'up' => array(
			'nofile'  => 'Keine (existierende) '.$l['file'].' ausgew&auml;hlt.',
			'partial' => ucfirst($l['file']).' wurde nur teilweise hochgeladen',
			'toobig'  => ucfirst($l['file']).' zu gro&szlig;',
			'unknown' => 'Es trat ein unbekannter Fehler auf. Bitte an den Systemadministrator wenden',
		),

		'createfile' => 'Fehler beim Erzeugen der Datei "<var>%s</var>"',
		'deletefile' => 'Fehler beim L&ouml;schen der Datei "<var>%s</var>"',
		'removedir'  => 'Fehler beim Entfernen des Verzeichnisses "<var>%s</var>"',
		'fileexists' => 'Datei "<var>%1$s</var>" (%2$s) existiert bereits.',
		'openfile'   => 'Fehler beim &Ouml;ffnen der Datei "<var>%s</var>"',
		'readfile'   => 'Fehler beim Lesen der Datei "<var>%s</var>"',
		'writefile'  => 'Fehler beim Schreiben in Datei "<var>%s</var>"',

		'createdir'  => 'Fehler beim Erzeuen des Verzeichnisse "<var>%s</var>"',
		'direxists'  => 'Verzeichnis "<var>%s</var>" existiert bereits.',
		'removedir'  => 'Fehler beim Entferen des Verzeichnisses "<var>%s</var>',

		'rename' => 'Fehler beim Umbenennen von "<var>%1$s</var>" in "<var>%2$s</var>"',
		'find'   => 'Fehler beim Suchen in "<var>%1$s</var>"',

		'badfile'   => 'Datei "<var>%s</var>" existiert nicht',
		'nofile'    => 'Keine Datei ausgew&auml;hlt',
		'baddir'    => 'Verzeichnis "<var>%s</var>" existiert nicht',
		'nodirs'    => 'Keine Verzeichnisse zum anzeigen',
		'nofiles'   => 'Keine Dateien zum anzeigen',
		'forbidden' => 'Sie haben keine Berechtigungen um auf "<var>%s</var>" zuzugreifen',

		'badpass'  => 'Falsches Passwort!',
		'baduser'  => 'Benutzer existiert nicht!',
		'badtheme' => 'Theme existiert nicht!',
	);

	// warnings
	$l['warn'] = array(
		'reallyrem'  => 'Dieses Verzeichnis wirklich entfernen "<var>%s</var>"?',
		'alldirs'	   => '<b>ACHTUNG: alle</b> Dateien und Unterverzeichnisse werden auch gel&ouml;scht!',
		#'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\n \'%s\' ?',
		'reallysave' => 'Wirklich speichern und diese Datei &uuml;berschreiben:\\n \\\'%s\\\' ?',
		'reallydel'  => 'Diese Datei wirklich l&ouml;schen:	"<var>%s</var>"?',
	);

	// confirmations
	$l['ok'] = array(
		'createdir'  => 'Verzeichnis "<var>%s</var>" erfolgreich erstellt',
		'createfile' => 'Datei "<var>%s</var>" erfolgreich erstellt',
		'removedir'  => 'Verzeichnis "<var>%s</var>" wurde erfolgreich entfernt',
		'deletefile' => 'Datei "<var>%s</var>" wurde erfolgreich gel&ouml;scht',
		'granted'    => 'Zugriff erlaubt, Login erfolreich',
		'rename'     => '"<var>%1$s</var> erfolgreich umbenannt in "<var>%2$s</var>"',
		'up'         => 'Datei erfolgreich auf: "<var>%1$s</var> (%2$s)" hochgeladen',
		'writefile'  => '%2$s Daten in Datei "<var>%1$s</var>" geschrieben',
	);

	$l['changedir']  = $l['dir'].' '.$l['change'];
	$l['download']   = 'herunterladen';
	$l['upload']     = 'hochladen';
	$l['uploadfile'] = $l['file'].' '.$l['upload'];
	$l['uploadrar']  = 'rar '.$l['upload'];
	$l['uploadzip']  = 'zip '.$l['upload'];

	$l['freespace'] = '<b>%1$s</b> freier Speicher auf <var>%2$s</var>';
	$l['totalspace'] = '<b>%1$s</b> Speicher insgesamt auf <var>%2$s</var>';
	$l['filetype']  = 'Dateityp: <var>%s</var>';

	$l['createnewdir']  = 'Neues Verzeichnis erstellen';
	$l['createnewfile'] = $l['new'].'e '.$l['file'].' '.$l['create'];
	$l['deletefile']    = $l['file'].' '.$l['delete'];
	$l['editcode']      = $l['code'].' '.$l['edit'];
	$l['editperms']     = 'Zugriffsrechte ändern';
	$l['removedir']     = $l['dir'].' '.$l['remove'];
	$l['renamedir']     = $l['dir'].' '.$l['rename'];
	$l['renamefile']    = $l['file'].' '.$l['rename'];
	$l['renameto']      = '"<var>%s</var>" '.$l['rename'].' nach:<br>';
	$l['showsrc']       = $l['src'].' '.$l['show'];
	$l['viewfile']      = $l['file'].' '.$l['view'];
	$l['viewdir']       = $l['dir'].' '.$l['view'];
	$l['viewthumbs']    = $l['dir'].' als Thumbnail Gallerie anzeigen';
	$l['searchfor']     = 'Nach was suchen in "<var>%s</var>"';

	$l['overwrite']  = '&Uuml;berschreiben';
	$l['uploadto']   = ucfirst($l['file']).' '.$l['to'].' "<var>%s</var>"'.' '.$l['upload'];

	$l['casesensitive'] = 'Groß/Kleinschreibung beachten';
	$l['exactmatch']    = 'genaue Suche';
	$l['findsubdirs']   = 'Unterverzeichnisse durchsuchen';

	$l['read']  = 'lesen';
	$l['write'] = 'schreiben';
	$l['exec']  = 'ausführen';

	// clipboard messages
	$l['clipboard'] = 'Zwischenablage';
	$l['clip'] = array(
		'add'  => 'Zur '.$l['clipboard'].' hinzuf&uuml;gen',
		'sub'  => 'Von der '.$l['clipboard'].' entfernen',
		'list' => 'Alle Dateien in der '.$l['clipboard'].' auflisten',
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
		'thumbs'  => 'thumbnail Gallerie',
		'tree'    => 'Ordner browsen',
		'up'      => 'Datei hochladen',
		'view'    => 'Ordner anzeigen',
	);
?>