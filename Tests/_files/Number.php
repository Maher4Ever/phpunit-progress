<?php

/**
 * A generic number class
 */
class Number {

  /**
   * The number
   *
   * @var integer
   */
  protected $number;

  /**
   * The constructor
   *
   * @param integer $num
   */
  public function __construct($num) {
    $this->number = $num;
  }

  /**
   *  Adds a number.
   *
   *  @param integer $num
   */
  public function add($num) {
    $this->number += $num;
  }

  /**
   *  Substracts a number.
   *
   *  @param integer $num
   */
  public function substract($num) {
    $this->number -= $num;
  }

  /**
   *  Multiplies by number.
   *
   *  @param integer $num
   */
  public function multiplyBy($num) {
    $this->number *= $num;
  }

  /**
   *  Divides by number.
   *
   *  @param  integer $num
   *  @throws NumberException 
   */
  public function divideBy($num) {
    if ( $num !== 0 ) {
      $this->number /= $num;
    } else {
      throw new NumberException('Division by zero!');
    }
  }

  /*
   * Returns the number.
   *
   * @return integer
   */
   public function get() {
     return $this->number;
  }
}

/**
 * Number exceptions class.
 */
class NumberException extends RuntimeException {}
