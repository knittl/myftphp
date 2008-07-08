<? //defines colors for myftphp
// default - light theme
$c['txt']     = '#111';
$c['fixtxt']  = '#111';
$c['o'] = '#EED';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => '#FFF8DC',
	'input'      => '#DDD',
	'inputlite'  => '#EEE',
	'inputhover' => '#CCD',
	'fix'        => 'white',
	'tablehover' => '#F0F8FF',
	'ahover'     => '#FFE',
);
$c['a'] = array(
	'link'    => '#222',
	'hover'   => '#000',
	'bghover' => &$c['bg']['ahover'], // compatibility
);
$c['border'] = array(
	'lite'  => '#CCC',
	'light' => '#669',
	'dark'  => '#006',
	'img'   => array(
		'shade' => '#369',
		'light' => '#9AC'
	),
	'ruler' => '#009',
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