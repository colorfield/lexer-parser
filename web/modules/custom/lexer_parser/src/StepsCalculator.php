<?php

namespace Drupal\lexer_parser;

use Fubhy\Math\Calculator;
use Fubhy\Math\Lexer;
use Fubhy\Math\Token\FunctionToken;
use Fubhy\Math\Token\NumberToken;
use Fubhy\Math\Token\Operator\OperatorTokenInterface;

/**
 * Parser for mathematical expressions.
 *
 * @todo use a design pattern (decorator, visitor?)
 * instead of this implementation.
 */
class StepsCalculator {

  /**
   * Static cache of token streams in reverse polish (postfix) notation.
   *
   * @var array
   */
  protected $tokenCache = [];

  /**
   * Constructs a new Calculator object.
   *
   * @param array $constants
   * @param array $functions
   * @param array $operators
   */
  public function __construct(array $constants = NULL, array $functions = NULL, array $operators = NULL) {
    $this->lexer = new Lexer();

    $constants = $constants ?: Calculator::getDefaultConstants();
    $functions = $functions ?: Calculator::getDefaultFunctions();
    $operators = $operators ?: Calculator::getDefaultOperators();

    foreach ($constants as $constant) {
      $this->lexer->addConstant($constant[0], $constant[1]);
    }

    foreach ($functions as $function) {
      $this->lexer->addFunction($function[0], $function[1], $function[2]);
    }

    foreach ($operators as $operator) {
      $this->lexer->addOperator($operator[0], $operator[1]);
    }

  }

  /**
   * Returns the steps of the mathematical expression calculation.
   *
   * @param string $expression
   *     The mathematical expression.
   *
   * @return array
   *     The calculation steps as an array of Tokens.
   *
   * @throws \Fubhy\Math\Exception\IncorrectExpressionException
   *
   * @todo review exceptions
   */
  public function getCalculationSteps($expression) {
    $hash = md5($expression);
    if (!isset($this->tokenCache[$hash])) {
      $this->tokenCache[$hash] = $this->lexer->postfix($this->lexer->tokenize($expression));
    }
    $stack = [];
    $tokens = $this->tokenCache[$hash];
    $steps = [];
    // @todo needs work to get the precedence and expose the calculation
    // in a more friendly way.
    foreach ($tokens as $token) {
      if ($token instanceof NumberToken) {
        array_push($stack, $token);
        array_push($steps, $token);
      }
      elseif ($token instanceof OperatorTokenInterface || $token instanceof FunctionToken) {
        array_push($stack, $token->execute($stack));
        array_push($steps, $token);
      }
    }
    return $steps;
  }

}
