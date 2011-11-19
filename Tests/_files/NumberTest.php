<?php

require_once 'Number.php';

/**
 * Tests for the number class.
 */
class NumberTest extends PHPUnit_Framework_TestCase {

  protected $number;

  public function setUp()
  {
    $this->number = new Number(0);
  }

  /**
   * @covers Number::add
   * @group passing
   */
  public function testAdditionWorks()
  {
    $this->number->add(1);
    $this->assertSame($this->number->get(), 1);
  }

  /**
   * @covers Number::substract
   * @group passing
   */
  public function testSubstractionWorks()
  {
    $this->number->substract(1);
    $this->assertSame($this->number->get(), -1);
  }

  /**
   * @covers Number::multiplyBy
   * @group skipped
   */
  public function testMultiplicationWorks()
  {
    $this->markTestSkipped();
  }

  /**
   * @covers Number::divideBy
   * @group skipped
   */
  public function testDivisionWorks()
  {
    $this->markTestSkipped('Division is hard!');
  }

  /**
   * @covers Number::add
   * @group failing
   */
  public function testThatMyMathTeacherSucked()
  {
    $this->number->add(1);
    $this->assertSame($this->number->get(), 10);
  }

  /**
   * @covers Number::substract
   * @group failing
   */
  public function testThatMyMathTeacherSuckedEvenMore()
  {
    $this->number->substract(1);
    $this->assertSame($this->number->get(), "I don't know!");
  }

  /**
   * @covers Number::divideBy
   * @group errors
   */
  public function testMathStillWorks()
  {
    $this->number->divideBy(0);
    $this->assertSame($this->number->get(), 0);
  }

  /**
   * @covers Number::add
   * @covers Number::substract
   * @covers Number::multiplyBy
   * @covers Number::divideBy
   * @group  incomplete
   */
  public function testArithmeticMethodsOnlyAcceptIntegers()
  {
    $this->markTestIncomplete(
      'This test has not been implemented yet.'
    );
  }

}
