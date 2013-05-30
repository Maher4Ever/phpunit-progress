<?php

/**
 * Prints tests' results in a similar way
 * to rspec's progress formatter.
 *
 * @package    PHPUnit
 * @subpackage Progress
 * @author     Maher Sallam <maher@sallam.me>
 * @copyright  2011 Maher Sallam <maher@sallam.me>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @version    0.1
 */
class PHPUnit_Extensions_Progress_ResultPrinter extends PHPUnit_TextUI_ResultPrinter {

  /**
   * Constructor.
   *
   * @param  mixed   $out
   * @param  boolean $verbose
   * @param  boolean $colors
   * @param  boolean $debug
   */
  public function __construct($out = NULL, $verbose = FALSE, $colors = FALSE, $debug = FALSE) {

    // Start capturing output
    ob_start();

    $argv = $_SERVER['argv'];
    $colors  = in_array('--colors', $argv) || $colors;
    $verbose = in_array('--verbose', $argv) || in_array('-v', $argv) || $verbose;
    $debug   = in_array('--debug', $argv) || $debug;

    parent::__construct($out, $verbose, $colors, $debug);
  }

  /**
   * @param  PHPUnit_Framework_TestResult $result
   */
  public function printResult(PHPUnit_Framework_TestResult $result)
  {
    print "\n";

    if ($result->errorCount() > 0) {
      $this->printErrors($result);
    }

    if ($result->failureCount() > 0) {
      $this->printFailures($result);
    }

    if ($this->verbose) {
      if ($result->deprecatedFeaturesCount() > 0) {
        if ($result->failureCount() > 0) {
          print "\n--\n\nDeprecated PHPUnit features are being used";
        }

        foreach ($result->deprecatedFeatures() as $deprecatedFeature) {
          $this->write($deprecatedFeature . "\n\n");
        }
      }

      if ($result->notImplementedCount() > 0) {
        $this->printIncompletes($result);
      }

      if ($result->skippedCount() > 0) {
        $this->printSkipped($result);
      }
    }

    $this->printFooter($result);
  } 

  /**
   * @param  array   $defects
   * @param  integer $count
   * @param  string  $type
   */
  protected function printDefects(array $defects, $count, $type)
  {
    if ($count == 0) {
      return;
    }

    $this->write("\n" . $type . ":\n");

    $i = 1;
    $failOrError = $type == 'Failures' || $type == 'Errors';

    foreach ($defects as $defect) {
      $this->printDefect($defect, $i++, $failOrError);
      $this->write("\n");
    }
  }

  /**
   * @param  PHPUnit_Framework_TestFailure $defect
   * @param  integer                       $count
   * @param  boolean                       $failOrError
   */
  protected function printDefect(PHPUnit_Framework_TestFailure $defect, $count, $failOrError = true)
  {
    $this->printDefectHeader($defect, $count, $failOrError);

    $padding = str_repeat(' ', 
      4 + ( $failOrError ? strlen((string)$count) : 0 )
    );

    $this->printDefectBody($defect, $count, $failOrError, $padding);
    $this->printDefectTrace($defect, $padding);
  }

  /**
   * @param  PHPUnit_Framework_TestFailure $defect
   * @param  integer                       $count
   * @param  boolean                       $failOrError
   */
  protected function printDefectHeader(PHPUnit_Framework_TestFailure $defect, $count, $failOrError = true)
  {
    $failedTest = $defect->failedTest();

    if ($failedTest instanceof PHPUnit_Framework_SelfDescribing) {
      $testName = $failedTest->toString();
    } else {
      $testName = get_class($failedTest);
    }

    if ( $failOrError ) {
      $this->write(
        sprintf(
          "\n  %d) %s",

          $count,
          $testName
        )
      );
    } else {
      $this->write( 
        sprintf( "  %s", $this->yellow($testName) )
      ); 
    }
  }

  /**
   * @param  PHPUnit_Framework_TestFailure $defect
   * @param  integer                       $count
   * @param  boolean                       $failOrError
   * @param  string                        $padding
   */
  protected function printDefectBody(PHPUnit_Framework_TestFailure $defect, $count, $failOrError, $padding)
  {
    $error = trim($defect->getExceptionAsString());

    if ( !empty($error) ) {
      $error = explode("\n", $error);
      $error = "\n" . $padding . implode("\n  " . $padding , $error);

      $this->write( $failOrError ? $this->red($error) : $this->cyan($error) );
    }
  }

  /**
   * @param  PHPUnit_Framework_TestFailure $defect
   * @param  string                        $padding
   */
  protected function printDefectTrace(PHPUnit_Framework_TestFailure $defect, $padding = 0)
  { 
    $trace = trim(
      PHPUnit_Util_Filter::getFilteredStacktrace(
        $defect->thrownException()
      )
    );

    if ( ! empty($trace) ) {
      $trace = explode("\n", $trace);
      $trace = "\n" . $padding . '# ' . implode("\n${padding}# ", $trace);

      $this->write($this->cyan($trace));
    }
  }

  /**
   * @param  PHPUnit_Framework_TestResult  $result
   */
  protected function printErrors(PHPUnit_Framework_TestResult $result)
  {
    $this->printDefects(
      $result->errors(),
      $result->errorCount(), 
      'Errors'
    );
  }

  /**
   * @param  PHPUnit_Framework_TestResult  $result
   */
  protected function printFailures(PHPUnit_Framework_TestResult $result)
  {
    $this->printDefects(
      $result->failures(),
      $result->failureCount(),
      'Failures'
    );
  }

  /**
   * @param  PHPUnit_Framework_TestResult  $result
   */
  protected function printIncompletes(PHPUnit_Framework_TestResult $result)
  {
    $this->printDefects(
      $result->notImplemented(),
      $result->notImplementedCount(),
      'Incomplete tests'
    );
  }

  /**
   * @param  PHPUnit_Framework_TestResult  $result
   * @since  Method available since Release 3.0.0
   */
  protected function printSkipped(PHPUnit_Framework_TestResult $result)
  {
    $this->printDefects(
      $result->skipped(),
      $result->skippedCount(),
      'Skipped tests'
    );
  }

  /**
   * @param  PHPUnit_Framework_TestResult  $result
   */
  protected function printFooter(PHPUnit_Framework_TestResult $result)
  {

    $this->write( sprintf("\nFinished in %s\n", PHP_Timer::timeSinceStartOfRequest()) );

    $resultsCount = count($result);

    $footer = sprintf("%d test%s, %d assertion%s",
      $resultsCount,
      $resultsCount == 1 ? '' : 's',
      $this->numAssertions,
      $this->numAssertions == 1 ? '' : 's' 
    );

    if ( $result->wasSuccessful() &&
      $result->allCompletelyImplemented() &&
      $result->noneSkipped() )
    {
      $this->write($this->green($footer));
    }

    else if ( ( !$result->allCompletlyImplemented() || !$result->noneSkipped() ) 
      &&
      $result->wasSuccessful() ) 
    {

      $footer .= sprintf(
        "%s%s",

        $this->getCountString(
          $result->notImplementedCount(), 'incomplete'
        ),
        $this->getCountString(
          $result->skippedCount(), 'skipped'
        )
      );

      $this->write($this->yellow($footer));

    }

    else {

      $footer .= sprintf(
        "%s%s%s%s",

        $this->getCountString($result->failureCount(), 'failures'),
        $this->getCountString($result->errorCount(), 'errors'),
        $this->getCountString(
          $result->notImplementedCount(), 'incomplete'
        ),
        $this->getCountString($result->skippedCount(), 'skipped')
      );

      $footer  = preg_replace('/,$/', '', $footer);

      $this->write($this->red($footer));
    }

    if ( ! $this->verbose &&
      $result->deprecatedFeaturesCount() > 0 ) 
    {
      $message = sprintf(
        "Warning: Deprecated PHPUnit features are being used %s times!\n".
        "Use --verbose for more information.\n",
        $result->deprecatedFeaturesCount()
      );

      if ($this->colors) {
        $message = "\x1b[37;41m\x1b[2K" . $message .
          "\x1b[0m";
      }

      $this->write("\n" . $message);
    }

    $this->writeNewLine();
  }

  /**
   * @param  integer $count
   * @param  string  $name
   * @return string
   * @since  Method available since Release 3.0.0
   */
  protected function getCountString($count, $name)
  {
    $string = '';

    if ($count > 0) {
      $string = sprintf(
        ', %d %s',

        $count,
        $name
      );
    }

    return $string;
  }

  /**
   * An error occurred.
   *
   * @param  PHPUnit_Framework_Test $test
   * @param  Exception              $e
   * @param  float                  $time
   */
  public function addError(PHPUnit_Framework_Test $test, Exception $e, $time)
  {
    $this->writeProgress($this->red('E'));
    $this->lastTestFailed = TRUE;
  }

  /**
   * A failure occurred.
   *
   * @param  PHPUnit_Framework_Test                 $test
   * @param  PHPUnit_Framework_AssertionFailedError $e
   * @param  float                                  $time
   */
  public function addFailure(PHPUnit_Framework_Test $test, PHPUnit_Framework_AssertionFailedError $e, $time)
  {
    $this->writeProgress($this->red('F'));
    $this->lastTestFailed = TRUE;
  }

  /**
   * Incomplete test.
   *
   * @param  PHPUnit_Framework_Test $test
   * @param  Exception              $e
   * @param  float                  $time
   */
  public function addIncompleteTest(PHPUnit_Framework_Test $test, Exception $e, $time)
  {
    $this->writeProgress($this->yellow('I'));
    $this->lastTestFailed = TRUE;
  }

  /**
   * Skipped test.
   *
   * @param  PHPUnit_Framework_Test $test
   * @param  Exception              $e
   * @param  float                  $time
   * @since  Method available since Release 3.0.0
   */
  public function addSkippedTest(PHPUnit_Framework_Test $test, Exception $e, $time)
  {
    $this->writeProgress($this->yellow('S'));
    $this->lastTestFailed = TRUE;
  }

  /**
   * A test ended.
   *
   * @param  PHPUnit_Framework_Test $test
   * @param  float                  $time
   */
  public function endTest(PHPUnit_Framework_Test $test, $time)
  {
    if (!$this->lastTestFailed) {
      $this->writeProgress($this->green('.'));
    }

    if ($test instanceof PHPUnit_Framework_TestCase) {
      $this->numAssertions += $test->getNumAssertions();
    }

    else if ($test instanceof PHPUnit_Extensions_PhptTestCase) {
      $this->numAssertions++;
    }

    $this->lastTestFailed = FALSE;

    if ($this->verbose && $test instanceof PHPUnit_Framework_TestCase) {
      $this->write($test->getActualOutput());
    }

  }

  /**
   * @param  string $progress
   */
  protected function writeProgress($progress)
  {
    static $deletedHeader = false;

    if ( ! $deletedHeader ) {
      ob_clean();
      $deletedHeader = true;
    }

    parent::writeProgress($progress);
  }

  /**
   * Returns a colored string which can be used
   * in the terminal.
   *
   * @param string  $text
   * @param integer $color_code
   */
  protected function color($text, $color_code) {
    return $this->colors ? "\033[${color_code}m" . $text . "\033[0m" : $text;
  }

  /**
   * @param string $text
   */
  protected function bold($text) {
    return $this->color($text, "1");
  }

  /**
   * @param string $text
   */
  protected function red($text) {
    return $this->color($text, "31");
  }

  /**
   * @param string $text
   */
  protected function green($text) {
    return $this->color($text, "32");
  }

  /**
   * @param string $text
   */
  protected function yellow($text) {
    return $this->color($text, "33");
  }

  /**
   * @param string $text
   */
  protected function blue($text) {
    return $this->color($text, "34");
  }

  /**
   * @param string $text
   */
  protected function magenta($text) {
    return $this->color($text, "35");
  }

  /**
   * @param string $text
   */
  protected function cyan($text) {
    return $this->color($text, "36");
  }

  /**
   * @param string $text
   */
  protected function white($text) {
    return $this->color($text, "37");
  }
}
