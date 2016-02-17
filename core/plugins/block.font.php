<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.font.php
 * Type:     block
 * Name:     font
 * Purpose:  font tags
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_block_font($params, $content, Smarty_Internal_Template $template, &$repeat)
{

  $ret = '';
  $smarty = $template->smarty;
  $repeatCss = $smarty->getConfigVars('repeatAttrInCss');

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'color' => $smarty->getConfigVars('fontColor'),
      'size' => $smarty->getConfigVars('fontSize'),
      'family' => $smarty->getConfigVars('fontFamily'),
      'bold' => false,
      'b' => false,	//alias for bold
  		'italic' => false,
  		'i' => false,	//alias for italic
  		'underlined' => false,
  		'u' => false,	//alias for underlined
  		'centered' => false,
  		'c' => false,	//alias for centered
  		'style' => false,
      'lineHeight' => false,
      'forceCss' => false
    ]
  );

  // only output on the closing tag
  if (!$repeat) {
    if (isset($content)) {

      $setCss = false;
      //check if any argument was set - if true, the css are applied
      foreach ($par as $key => $value) {
        if (!$par->isDefault($key)) {
          $setCss = true;
          break;
        }
      }

      $setCss = $setCss || !$smarty->getConfigVars('fontStyleTdTag');

      $isBold = ($par['bold'] !== false) || ($par['b'] !== false);
      $isItalic = ($par['italic'] !== false) || ($par['i'] !== false);
      $isUnderlined = ($par['underlined'] !== false) || ($par['u'] !== false);
      $isCentered = ($par['centered'] !== false) || ($par['c'] !== false);
      

      $css = "";
      $css .= SmartyUtils::addCss('font-size', $par['size'] . 'px');
      $cssFont = $css;
      $css .= SmartyUtils::addCss('color', $par['color']);
      $css .= SmartyUtils::addCss('font-family', $par['family']);
      $css .= SmartyUtils::addCss('font-weight', $par['weight']);
      $css .= SmartyUtils::addCss('font-style', $par['style']);
      $css .= SmartyUtils::addCss('text-decoration', $par['decoration']);
      if ($repeatCss || $par['forceCss']) {
        $cssFont = $css;
      }

      $prop = SmartyUtils::addCss('line-height', $par['lineHeight']);
      $css .= $prop;
      $cssFont .= $prop;
      if ($par['cssStyle']) {
        $prop = $par['cssStyle'];
        $css .= $prop;
        $cssFont .= $prop;
      }

      if ($isCentered)
        $ret .= '<center>';
      if ($isBold)
        $ret .= '<b>';
      if ($isItalic)
        $ret .= '<i>';
      if ($isUnderlined)
        $ret .= '<u>';

      $useSpan = $smarty->getConfigVars('fontStyleSpanTag') && ($setCss || $par['forceCss']);
      if ($useSpan) {
        $ret .= "<span style=\"$css\">";
      }

      $useFont = $smarty->getConfigVars('fontStyleFontTag');
      if ($useFont) {
        $sizeFont = SmartyUtils::convertFontSize($par['size']);
        $ret .= "<font color=\"{$par['color']}\" size=\"{$sizeFont}\" face=\"{$par['family']}\" style=\"$cssFont\">";
      }

      $ret .= $content;

      if ($useFont)
        $ret .= '</font>';
      
      if ($useSpan)
        $ret .= '</span>';

      if ($isUnderlined)
        $ret .= '</u>';
      if ($isItalic)
        $ret .= '</i>';
      if ($isBold)
        $ret .= '</b>';
      if ($isCentered)
        $ret .= '</center>';
      

      return $ret;
    }
  }
}
