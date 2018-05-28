<?php

namespace Drupal\lexer_parser;

use Fubhy\Math\Calculator;
use Fubhy\Math\Exception\IncorrectExpressionException;
use Fubhy\Math\Exception\UnknownVariableException;

/**
 * Class LexerParserService.
 */
class LexerParserService implements LexerParserServiceInterface {

  /**
   * {@inheritdoc}
   */
  public function calculate($expression) {
    $result = '';
    if (!empty($expression)) {
      $calc = new Calculator();
      try {
        $result = $calc->calculate($expression, []);
      }
      catch (IncorrectExpressionException $exception) {
        \Drupal::messenger()->addError($exception->getMessage());
      }
      catch (UnknownVariableException $exception) {
        \Drupal::messenger()->addError($exception->getMessage());
      }
    }
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function calculationSteps($expression) {
    $stepsCalculator = new StepsCalculator();
    $steps = $stepsCalculator->getCalculationSteps($expression);
    return $steps;
  }

}
