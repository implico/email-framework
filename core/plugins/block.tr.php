<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.tr.php
 * Type:     block
 * Name:     tr
 * Purpose:  tr tag
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_block_tr($params, $content, Smarty_Internal_Template $template, &$repeat)
{

  $ret = '';
  $smarty = $template->smarty;

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'id' => false,
      'class' => false,
      'attrs' => false
    ]
  );

  // only output on the closing tag
  if (!$repeat) {
    if (isset($content)) {

      $ret .= "<tr";
      $ret .= SmartyUtils::getAttrs($par['id'], $par['class'], $par['attrs']);      
      $ret .= ">{$content}</tr>";

      return $ret;

    }
  }
}
