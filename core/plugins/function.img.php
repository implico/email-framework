<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.img.php
 * Type:     function
 * Name:     img
 * Purpose:  img tag
 * -------------------------------------------------------------
 */

use ImplicoEmail\Utils\Smarty as SmartyUtils;
use ImplicoEmail\Utils\Params;

function smarty_function_img($params, Smarty_Internal_Template $template)
{

  $ret = '';
  $smarty = $template->smarty;
  $repeatCss = $smarty->getConfigVars('repeatAttrInCss');

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'src' => '',
      'srcPrepend' => $smarty->getConfigVars('imgSrcPrepend'),
      'width' => false,
      'height' => false,
      'autoSize' => $smarty->getConfigVars('imgAutoSize'),
      'alt' => false,

      'padding' => false,
      'margin' => '0',
      'marginV' => '0',
      'marginH' => '0',
      'align' => false,
      'display' => $smarty->getConfigVars('imgDisplay'),

      'border' => '0',
      'bordercolor' => false,

      'style' => false,
      'id' => false,
      'class' => '',
      'attrs' => false
    ]
  );


  $ret .= "<img";
  $src = $par['src'];
  if ($par['srcPrepend'] !== false) {
    $src = $par['srcPrepend'] . $src;
  }
  $ret .= SmartyUtils::addAttr('src', $src);

  //auto size
  if ($par['autoSize'] && $par['src'] && !$par['width'] && !$par['height']) {
    $file = SmartyUtils::$config['outputsDir'] . $par['src'];
    if (file_exists($file)) {
      $s = getimagesize($file);
      if ($s) {
        $par['width'] = $s[0];
        $par['height'] = $s[1];
      }
    }
  }


  $ret .= SmartyUtils::addAttr('width', $par['width']);
  $widthCss = SmartyUtils::unitPx($par['width']);
  $ret .= SmartyUtils::addAttr('height', $par['height']);
  $ret .= SmartyUtils::addAttr('alt', $par['alt']);

  $ret .= SmartyUtils::addAttr('vspace', $par['marginV']);
  $ret .= SmartyUtils::addAttr('hspace', $par['marginH']);
  if ($par->isDefault('margin') && ($par['marginV'] || $par['marginH'])) {
    $par['margin'] = ($par['marginV'] ? $par['marginV'] : '0') + 'px ' + ($par['marginH'] ? $par['marginH'] : '0') + 'px';
  }

  $ret .= SmartyUtils::addAttr('align', $par['align']);
  $ret .= SmartyUtils::addAttr('border', $par['border']);
  $ret .= SmartyUtils::addAttr('bordercolor', $par['bordercolor']);

  $ret .= " style=\"";
  $ret .= SmartyUtils::addCss('display', $par['display']);
  if ($repeatCss) {
    $ret .= SmartyUtils::addCss('width', $par['width']);
    $ret .= SmartyUtils::addCss('height', $par['height']);
  }
  $ret .= SmartyUtils::addCss('padding', $par['padding']);
  $ret .= SmartyUtils::addCss('margin', $par['margin']);

  if ($par['border'] && ($par['border'] != '0')) {
    if ($par['bordercolor']) {
      $ret .= "border:{$par['border']}px solid {$par['bordercolor']};";
    }
    else {
      $ret .= "border-width:{$par['border']}px;";
    }
  }
  else {
    if ($repeatCss) {
      $ret .= 'border:none;';
    }
  }

  if ($smarty->getConfigVars('outlookCss')) {
    $ret .= '-ms-interpolation-mode:bicubic;mso-line-height-rule:exactly;';
  }

  if ($par['style']) {
    $ret .= $par['style'];
  }
  $ret .= '"';
  $ret .= SmartyUtils::getAttrs($par['id'], $par['class'], $par['attrs']);
  $ret .= ' />';

  return $ret;

}
