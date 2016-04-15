<?php

namespace Implico\Email\Utils;

class Smarty
{
  public static $config;

  public static function init($config)
  {
    self::$config = $config;
  }

  public static function removeCssComments($content)
  {
    return preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!' , '' , $content);
  }

  public static function getAttrs($id = '', $class = '', $attrs = '', $style = '')
  {

    $ret = '';

    if ($id) {
      $ret .= ' id="' . $id . '"';
    }

    if ($class) {
      $ret .= ' class="' . $class . '"';
    }

    if ($style) {
      $ret .= ' style="' . $style . '"';
    }

    if ($attrs) {
      $ret .= ' ' . $attrs;
    }

    return $ret;
  }

  public static function addAttr($name, $value, $setFalse = false, $quotes = true)
  {
    $ret = '';

    if ($setFalse && ($value === false)) {
      $value = 'false';
      $quotes = false;
    }

    if ($value !== false) {
      $ret .= " $name=" . ($quotes ? '"' : '') . $value . ($quotes ? '"' : '');
    }

    return $ret;
  }

  public static function addCss($name, $value, $default = null)
  {
    $ret = '';

    if (($value === null) && ($default !== null)) {
      $value = $default;
    }

    if ($value !== false) {
      $ret .= "$name:$value;";
    }

    return $ret;
  }

  public static function convertFontSize($size)
  {
    $ret = 3;

    if ($size < 11) {
      $ret = 1;
    }
    else if ($size < 13) {
      $ret = 2;
    }
    else if ($size < 15) {
      $ret = 3;
    }
    else if ($size < 20) {
      $ret = 4;
    }
    else if ($size < 26) {
      $ret = 5;
    }
    else if ($size < 39) {
      $ret = 6;
    }
    else if ($size >= 39) {
      $ret = 7;
    }

    return $ret;
  }

  public static function unitPx($size)
  {
    if ($size) {
      if (strpos($size, '%') === false) {
        $size = "{$size}px";
      }
    }

    return $size;
  }

}