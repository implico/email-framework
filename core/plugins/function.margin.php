<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.margin.php
 * Type:     function
 * Name:     margin
 * Purpose:  margin as a table row with a specified height
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_function_margin($params, Smarty_Internal_Template $template)
{

  $ret = '';
  $smarty = $template->smarty;

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'width' => false,
      'height' => 30,
      'colspan' => 1,
      'bgcolor' => false,
      'style' => false,
      'id' => false,
      'class' => false,
      'attrs' => false
    ]
  );

  $tpl = "{tr}{td";
  $tpl .= SmartyUtils::addAttr('height', $par['height'], true);
  $tpl .= SmartyUtils::addAttr('width', $par['width'], true);
  $tpl .= " colspan={$par['colspan']} align=false valign=false noFont=true";
  $tpl .= SmartyUtils::addAttr('overflow', 'true');
  $tpl .= SmartyUtils::addAttr('bgcolor', $par['bgcolor']);
  $tpl .= SmartyUtils::addAttr('fontSize', 1);
  $tpl .= SmartyUtils::addAttr('style', $par['style']);
  $tpl .= SmartyUtils::getAttrs($par['id'], $par['class'], $par['attrs']);
  $tpl .= "}";
  if ($par['height'] >= 18)
    $tpl .= "&nbsp;";
  $tpl .= "{/td}{/tr}";

  $ret .= $smarty->fetch('string:' . $tpl);

  return $ret;

}
