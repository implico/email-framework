<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     button.a.php
 * Type:     block
 * Name:     a
 * Purpose:  button
 * -------------------------------------------------------------
 */

use Implico\Email\Utils\Smarty as SmartyUtils;
use Implico\Email\Utils\Params;

function smarty_block_button($params, $content, Smarty_Internal_Template $template, &$repeat)
{

  $ret = '';
  $smarty = $template->smarty;

  $par = new Params($params);
  $par->setParams(
    [],
    [
      'href' => '',
      'width' => false,
      'height' => false,
      'bgcolor' => false,
      'bordercolor' => false,
      'borderRadius' => false,
      'centered' => true,
      'target' => $smarty->getConfigVars('aTarget'),
      'style' => false,
      'id' => false,
      'class' => false,
      'attrs' => false
    ]
  );

  // only output on the closing tag
  if (!$repeat) {
    if (isset($content)) {

      $isCentered = $par['centered'];
      $hasBorder = $par['bordercolor'] !== false;

      $arcSize = false;
      if ($par['height'] && $par['borderRadius']) {
        $arcSize = round($par['borderRadius'] / $par['height'] * 100) . '%';
      }
      $tagName = $par['borderRadius'] ? 'roundrect' : 'rect';
      $ret .= '
      <!--[if mso]>
        <v:'. $tagName .' xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="'. $par['href'] .'" style="height:'. $par['height'] .'px;v-text-anchor:middle;width:'. $par['width'] .'px;"';
      $ret .= SmartyUtils::addAttr('arcsize', $arcSize);
      $ret .= SmartyUtils::addAttr('strokecolor', $par['bordercolor']);
      if (!$par['bordercolor']) {
        $ret .= ' stroke="f"';
      }
      $ret .= ' fillcolor="'.$par['bgcolor'].'">';
      $ret .= '<w:anchorlock/>';
      
      if (!$hasBorder) {
        $ret .= '<![endif]-->';
      }

      if ($isCentered) {
        $ret .= '<center>';
      }

      $inner = "{a href='{$par['href']}' textDecoration='none' buttonHeight='{$par['height']}' style='width:{$par['width']}px;-webkit-text-size-adjust:none;background-color:{$par['bgcolor']};";
      $innerWithBorder = false;

      if ($par['borderRadius'] !== false) {
        $par['borderRadius'] .= 'px';
      }
      $inner .= SmartyUtils::addCss('border-radius', $par['borderRadius']);

      if (!$par['centered']) {
        $inner .= SmartyUtils::addCss('text-align', 'left');
      }

      if ($hasBorder) {
        $par['bordercolor'] = '1px solid ' . $par['bordercolor'];
        $innerWithBorder = $inner;
        $innerWithBorder .= SmartyUtils::addCss('border', $par['bordercolor']);
      }

      $innerFinish = 
        ($par['style'] ? $par['style'] : '') . "' "
        . ($par['attrs'] ? "attrs='" . $par['attrs'] . "' " : '')
        . SmartyUtils::addAttr('target', $par['target'], true)
        . SmartyUtils::getAttrs($par['id'], $par['class'])
        . "}" . $content . '{/a}';

      if ($hasBorder) {
        $innerWithBorder .= SmartyUtils::addCss('mso-hide', 'all');
        $innerWithBorder .= $innerFinish;
      }
      $inner .= $innerFinish;
      $ret .= $inner;

      if ($par['centered']) {
        $ret .= '</center>';
      }
      if (!$hasBorder) {
        $ret .= '<!--[if mso]>';
      }
      $ret .= '</v:'.$tagName.'>
        <![endif]-->';

      //add a button with border hidden for MSO
      if ($hasBorder) {
        $ret .= $innerWithBorder;
      }

      return $smarty->fetch('string:' . $ret);
    }
  }
}
