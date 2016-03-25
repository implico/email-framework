<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     block.table.php
 * Type:     block
 * Name:     table
 * Purpose:  table tag
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_block_table($params, $content, Smarty_Internal_Template $template, &$repeat)
{

  $ret = '';
  $smarty = $template->smarty;
  $repeatCss = $smarty->getConfigVars('repeatAttrInCss');

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'width' => $smarty->getConfigVars('tableWidth'),
      'cellpadding' => '0',
      'cellspacing' => '0',
      'bgcolor' => false,
      'border' => '0',
      'bordercolor' => false,
      'align' => $smarty->getConfigVars('tableAlign'),
      'style' => false,
      'id' => false,
      'class' => false,
      'attrs' => false
    ]
  );

  // only output on the closing tag
  if (!$repeat) {
    if (isset($content)) {
      if ($par['width'] === null) {
        $par['width'] = $smarty->getConfigVars('lWidth');
      }
  
      $widthCss = SmartyUtils::unitPx($par['width']);
      
      $ret .= "<table cellpadding=\"{$par['cellpadding']}\" cellspacing=\"{$par['cellspacing']}\" border=\"{$par['border']}\"";
      $ret .= SmartyUtils::addAttr('align', $par['align']);
      $ret .= SmartyUtils::addAttr('width', $par['width']);
      $ret .= SmartyUtils::addAttr('bgcolor', $par['bgcolor']);
      $ret .= SmartyUtils::addAttr('bordercolor', $par['bordercolor']);

      $style = '';
      if ($repeatCss) {
        $style .= "margin:0";
        if ($par['align'] == 'center') {
          $style .= " auto";
        }
        $style .= ';';
        $style .= SmartyUtils::addCss('width', $widthCss);
      }
      $style .= SmartyUtils::addCss('bgcolor', $par['bgcolor']);
      if ($par['border']) {
        $style .= "border:{$border}px solid ";
        if ($par['bordercolor']) {
          $style .= $par['bordercolor'];
        }
        else {
          $style .= '#000';
        }
      }

      $style .= 'border-collapse:collapse;';
      
      if ($smarty->getConfigVars('outlookCss')) {
        $style .= "mso-table-lspace:0pt;mso-table-rspace:0pt;";
      }
      if ($par['align'] == 'center') {
        $style .= 'margin-left:auto;margin-right:auto;';
      }
      if ($par['style']) {
        $style .= $par['style'];
      }

      if (strlen($style)) {
        $ret .= ' style="' . $style . '"';
      }

      $ret .= SmartyUtils::getAttrs($par['id'], $par['class'], $par['attrs']);

      $ret .= ">";
      $ret .= $content . '</table>';
    
      return $ret;

    }
  }
}
