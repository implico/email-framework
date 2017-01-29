<?php

namespace Implico\Email\Utils;

/*
 * Params, Parameter Container - klasa obslugi parametrow metod
 */

class Params implements \ArrayAccess, \IteratorAggregate
{
  protected $initContent;
  protected $content;

  //utworzenie poprzez przekazanie tablicy zawierajacej pary: nazwa parametru=>wartosc
  public function __construct($a)
  {
    $this->content = $this->initContent = $a;
  }
  
  //zwraca kopie obiektu, uzupelniajac podanymi wartosciami
  public function getClone($a = array())
  {
    $clone = clone($this);
    $clone->set($a);
    return $clone;
  } 
  
  //ustawienie domyslnych wartosci dla niezdefiniowanych parametrow
  public function setParams($obligatory, $additional)
  {

    //sprawdzenie parametrow obowiazkowych
    foreach ($obligatory as $o)
    {
      if (!array_key_exists($o, $this->content))
      {
        trigger_error('Params::setParams: Required parameters not passed ('.$o.')', E_USER_ERROR);
      }
      $additional[$o] = $this->content[$o];
    }
    //nadpisanie parametrow domyslnych przez zdefiniowane
    foreach ($this->content as $ci=>$c)
    {
      if (array_key_exists($ci, $additional))
      {
        $additional[$ci] = $c;
      }
    }
    
    $this->content = $additional;
    
    return $this;
  }
  
  //ustawienie wartosci parametrow (argumenty: para klucz-wartosc lub tablica)
  public function set($params, $value = null)
  {
    if (is_array($params))
    {
      //tablica
      foreach ($params as $pi=>$p)
        $this->content[$pi] = $p;
    }
    else $this->content[$params] = $value;
    
    return $this;
  }
  
  //ustawienie wartosci pierwszego indeksu w parametrze-tablicy
  public function setArray($key, $offset, $value)
  {
    $this->content[$key][$offset] = $value;
  }
  
  //zwrocenie wartosci parametru
  public function get($i)
  {
    return isset($this->content[$i]) ? $this->content[$i] : null;
  }

  public function isDefault($key)
  {
    return !array_key_exists($key, $this->initContent);
  }
  
  //ArrayAccess
  public function offsetExists($offset)
  {
    return $this->get($offset) !== null;
  }
  
  public function offsetGet($offset)
  {
    return $this->get($offset);
  }
  
  public function offsetSet($offset, $value)
  {
    return $this->set($offset, $value);
  }
  
  public function offsetUnset($offset)
  {
    unset($this->content[$offset]);
  }

  //IteratorAggregate
  public function getIterator() {
    return new \ArrayIterator($this->content);
  } 

}
