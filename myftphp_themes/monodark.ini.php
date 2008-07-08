<? //defines colors for myftphp
// dark monochrome theme
$c['txt']     = '#EEE';
$c['fixtxt']  = '#EEE';
$c['o'] = '#222';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => '#111',
	'input'      => '#222',
	'inputlite'  => '#111',
	'inputhover' => '#333',
	'fix'        => 'black',
	'tablehover' => '#333',
);
$c['a'] = array(
	'link'    => '#DDD',
	'hover'   => '#FFF',
	'bghover' => '#060606',
);
$c['border'] = array(
	'lite'  => '#333',
	'light' => '#777',
	'dark'  => '#AAA',
	'img'   => array(
		'shade' => '#AAA',
		'light' => '#666'
	),
	'ruler' => '#777',
);
//won't work in array above
$c['border']['fix'] = $c['border']['ruler'];

//ie scrollbars
$c['scrollbars'] = array(
	'face'       => '#333',
	'track'      => $c['bg']['main'],
	'arrow'      => '#CCC',
	'highlight'  => '#303030',
	'3dlight'    => '#232323',
	'shadow'     => '#3F3F3F',
	'darkshadow' => '#434343'
);
?>