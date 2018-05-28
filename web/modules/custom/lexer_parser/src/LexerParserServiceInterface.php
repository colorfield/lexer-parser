<?php

namespace Drupal\lexer_parser;

/**
 * Interface LexerParserServiceInterface.
 */
interface LexerParserServiceInterface {

  /**
   * Returns the calculation of a mathematical expression.
   *
   * @param string $expression
   *   The expression to calculate.
   *
   * @return string
   *   The calculated expression.
   */
  public function calculate($expression);

  /**
   * Returns the calculation steps of a mathematical expression.
   *
   * @param string $expression
   *   The expression to calculate.
   *
   * @return array
   *   The calculationSteps of the expression.
   */
  public function calculationSteps($expression);

}
