<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.td.php
 * Type:     block
 * Name:     td
 * Purpose:  td tag
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_block_td($params, $content, Smarty_Internal_Template $template, &$repeat)
{

  $ret = '';
  $smarty = $template->smarty;
  $repeatCss = $smarty->getConfigVars('repeatAttrInCss');

  $noFont = isset($params['noFont']) ? $params['noFont'] : !$smarty->getConfigVars('fontStyleTdTag');

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'width' => $smarty->getConfigVars('lContentWidth'),
      'height' => false,
      'colspan' => 1,
      'align' => $smarty->getConfigVars('tdAlign'),
      'valign' => $smarty->getConfigVars('tdValign'),
      'padding' => 0,
      'overflow' => $smarty->getConfigVars('tdOverflow'),
      'bgcolor' => false,
      'lineHeight' => $smarty->getConfigVars('tdLineHeight'),
      'borderRadius' => false,
      'noFont' => $noFont,
      'fontFamily' => $noFont ? false : $smarty->getConfigVars('fontFamily'),
      'fontSize' => $noFont ? false : $smarty->getConfigVars('fontSize'),
      'fontColor' => $noFont ? false : $smarty->getConfigVars('fontColor'),
      'style' => false,
      'id' => false,
      'class' => false,
      'attrs' => false
    ]
  );

  // only output on the closing tag
  if (!$repeat) {
    if (isset($content)) {

      //shorthand
      if ($par['overflow'] === true) {
        $par['overflow'] = 'hidden';
      }

      $ret .= "<td";
      $ret .= SmartyUtils::addAttr('width', $par['width']);
      $widthCss = SmartyUtils::unitPx($par['width']);

      $ret .= SmartyUtils::addAttr('height', $par['height']);
      if ($par['colspan'] > 1)
        $ret .= SmartyUtils::addAttr('colspan', $par['colspan']);
      $ret .= SmartyUtils::addAttr('valign', $par['valign']);
      $ret .= SmartyUtils::addAttr('align', $par['align']);
      $ret .= SmartyUtils::addAttr('bgcolor', $par['bgcolor']);

      $style = '';
      if ($repeatCss) {
        $style .= SmartyUtils::addCss('width', $widthCss);
        if ($par['height'] !== false) {
          $style .= SmartyUtils::addCss('height', $par['height'] . 'px');
        }
        $style .= SmartyUtils::addCss('vertical-align', $par['valign']);
        $style .= SmartyUtils::addCss('text-align', $par['align']);
      }

      if ($smarty->getConfigVars('outlookCss')) {
        $style .= "mso-line-height-rule:exactly;";
      }

      if ($repeatCss || !$par->isDefault('padding')) {
        $style .= SmartyUtils::addCss('padding', $par['padding']);
      }
      $style .= SmartyUtils::addCss('overflow', $par['overflow']);
      $style .= SmartyUtils::addCss('background', $par['bgcolor']);
      $style .= SmartyUtils::addCss('line-height', $par['lineHeight']);
      $style .= SmartyUtils::addCss('border-radius', $par['borderRadius']);
      $style .= SmartyUtils::addCss('font-family', $par['fontFamily']);
      if ($par['fontSize'] !== false) {
        $par['fontSize'] = $par['fontSize'] . 'px';
      }
      $style .= SmartyUtils::addCss('font-size', $par['fontSize']);
      $style .= SmartyUtils::addCss('color', $par['fontColor']);
      if ($par['style']) {
        $style .= $par['style'];
      }
      if (strlen($style)) {
        $ret .= ' style="' . $style . '"';
      }

      $ret .= SmartyUtils::getAttrs($par['id'], $par['class'], $par['attrs']);

      $ret .= ">{$content}</td>";

      return $ret;

    }
  }
}
