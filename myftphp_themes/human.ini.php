<?php //defines colors for myftphp
// ubuntu human theme
$c['txt']     = '#111';
$c['fixtxt']  = '#FFF';
$c['o'] = '#D58F6F';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => '#C47F5F',
	'input'      => '#EEE9E6',
	'inputlite'  => '#F8F6F4',
	'inputhover' => '#F4F2F0',
	'fix'        => '#EA6',
	'tablehover' => '#FB7',
);
$c['a'] = array(
	'link'    => '#222',
	'hover'   => '#000',
	'bghover' => '#FC8',
);
$c['border'] = array(
	'lite'  => '#958C82',
	'light' => '#736A60',
	'dark'  => '#3D3A38',
	'img'   => array(
		'shade' => '#963',
		'light' => '#ECA'
	),
	'ruler' => '#F2CCAA',
);
//won't work in array above
$c['border']['fix'] = $c['border']['ruler'];

//ie scrollbars
$c['scrollbars'] = array(
	'face'       => '#CCC',
	'track'      => $c['bg']['main'],
	'arrow'      => '#B86',
	'highlight'  => '#CCC',
	'3dlight'    => '#DCDCDC',
	'shadow'     => '#CCC',
	'darkshadow' => '#BCBCBC'
);
?>
