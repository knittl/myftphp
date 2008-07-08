<? //defines colors for myftphp
// negative theme
$c['txt']     = '#EEE';
$c['fixtxt']  = '#EEE';
$c['o'] = '#112';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => '#000823',
	'input'      => '#222',
	'inputlite'  => '#111',
	'inputhover' => '#332',
	'fix'        => 'black',
	'tablehover' => '#220',
);
$c['a'] = array(
	'link'    => '#DDD',
	'hover'   => '#FFF',
	'bghover' => '#001',
);
$c['border'] = array(
	'lite'  => '#333',
	'light' => '#996',
	'dark'  => '#FF9',
	'img'   => array(
		'shade' => '#C96',
		'light' => '#653'
	),
	'ruler' => '#FF7',
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