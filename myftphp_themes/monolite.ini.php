<? //defines colors for myftphp
// light monochrome theme
$c['txt']     = '#111';
$c['fixtxt']  = '#111';
$c['o'] = '#DDD';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => '#EEE',
	'input'      => '#DDD',
	'inputlite'  => '#EEE',
	'inputhover' => '#CCC',
	'fix'        => 'white',
	'tablehover' => '#CCC',
);
$c['a'] = array(
	'link'    => '#222',
	'hover'   => '#000',
	'bghover' => '#FAFAFA',
);
$c['border'] = array(
	'lite'  => '#CCC',
	'light' => '#999',
	'dark'  => '#666',
	'img'   => array(
		'shade' => '#666',
		'light' => '#AAA'
	),
	'ruler' => '#999',
);
//won't work in array above
$c['border']['fix'] = $c['border']['ruler'];

//ie scrollbars
$c['scrollbars'] = array(
	'face'       => '#CCC',
	'track'      => $c['bg']['main'],
	'arrow'      => '#333',
	'highlight'  => '#CFCFCF',
	'3dlight'    => '#DCDCDC',
	'shadow'     => '#C0C0C0',
	'darkshadow' => '#BCBCBC'
);
?>