<?php

namespace Implico\Email\Utils;

/*
 * Filesystem helpers
 */

class FileSystem
{
  /**
   * Copies directory recursively
   * 
   * @param string $src   Source path
   * @param string $src   Source path
   *
   * @return bool         True on success, false on failure
  */
  public static function copy($src, $dst, $skip = null) { 
    
    $ret = true;

    $dir = opendir($src); 
    if (!@mkdir($dst))
      return false;

    while(false !== ( $file = readdir($dir)) ) { 
      if (( $file != '.' ) && ( $file != '..' ) && (!$skip || !in_array($file, $skip))) { 
        if ( is_dir($src . '/' . $file) ) { 
          if (!($ret = self::copy($src . '/' . $file,$dst . '/' . $file, $skip)))
            break;
        } 
        else { 
          if (!($ret = @copy($src . '/' . $file,$dst . '/' . $file)))
            break;
        } 
      } 
    } 
    closedir($dir);

    return $ret;
  }
}
