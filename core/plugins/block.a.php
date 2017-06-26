<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.a.php
 * Type:     block
 * Name:     a
 * Purpose:  hyperlink
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_block_a($params, $content, Smarty_Internal_Template $template, &$repeat)
{

  $ret = '';
  $smarty = $template->smarty;

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'href' => '',
      'textDecoration' => $smarty->getConfigVars('aTextDecoration'),
      'target' => $smarty->getConfigVars('aTarget'),
      'buttonHeight' => false,
      'style' => false,
      'id' => false,
      'class' => false,
      'attrs' => false
    ]
  );

  // only output on the closing tag
  if (!$repeat) {
    if (isset($content)) {

      $ret .= "<a";
      $ret .= SmartyUtils::addAttr('href', $par['href']);
      if ($par['textDecoration'] || $par['style'] || $par['buttonHeight']) {
        $ret .= ' style="';
        if ($par['textDecoration']) {
          $ret .= "text-decoration:{$par['textDecoration']};text-decoration:{$par['textDecoration']} !important;";
        }
        if ($par['buttonHeight']) {
          $ret .= "display:inline-block;mso-line-height-rule:exactly;height:{$par['buttonHeight']}px;max-height:{$par['buttonHeight']}px;line-height:{$par['buttonHeight']}px;line-height:{$par['buttonHeight']}px !important;vertical-align:middle;width:100%;white-space:nowrap;overflow:hidden;text-align:center;";
        }
        if ($par['style']) {
          $ret .= $par['style'];
        }
        $ret .= '"';
      }

      $ret .= SmartyUtils::addAttr('target', $par['target'], true);
      $ret .= SmartyUtils::getAttrs($par['id'], $par['class'], $par['attrs']);

      $ret .= ">{$content}</a>";

      return $ret;

    }
  }
}
