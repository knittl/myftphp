<?php //defines colors for myftphp
// client system's theme (CSS2 color names)
$c['txt']     = 'WindowText';
$c['fixtxt']  = 'CaptionText';
$c['o'] = 'Menu';
#$c['e'] = ''; //recommended: transparent or ''
$c['bg'] = array(
	'main'       => 'Window',
	'input'      => 'ButtonFace',
	'inputlite'  => 'ThreeDHighlight',
	'inputhover' => 'ButtonHighlight',
	'fix'        => 'ActiveCaption',
	'tablehover' => 'HighlightText',
);
$c['a'] = array(
	'link'    => 'Highlight',
	'hover'   => 'Highlight',
	'bghover' => 'HighlightText',
);
$c['border'] = array(
	'lite'  => 'ButtonHighlight',
	'light' => 'ButtonHighlight',
	'dark'  => 'ButtonShadow',
	'img'   => array(
		'shade' => 'ButtonShadow',
		'light' => 'ButtonHighlight'
	),
	'ruler' => 'WindowFrame',
);
//won't work in array above
$c['border']['fix'] = 'ActiveBorder';

//ie scrollbars
$c['scrollbars'] = array(
	'face'       => 'ThreeDFace',
	'track'      => $c['bg']['main'],
	'arrow'      => 'ThreeDDarkShadow',
	'highlight'  => 'ButtonHighlight',
	'3dlight'    => 'ThreeDHighlight',
	'shadow'     => 'ThreeDShadow',
	'darkshadow' => 'ThreeDDarkShadow'
);
?>
