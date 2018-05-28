<?php

namespace Drupal\Tests\lexer_parser\Functional;

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Entity\Entity\EntityViewDisplay;
use Drupal\Core\Url;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;
use Drupal\Tests\BrowserTestBase;

/**
 * Simple test to ensure that field displays the expected calculation.
 *
 * @group lexer_parser
 */
class TestLexerParser extends BrowserTestBase {

  /**
   * Modules to enable.
   *
   * @var array
   */
  public static $modules = [
    'field',
    'field_ui',
    'node',
    'entity_test',
    'lexer_parser',
  ];

  /**
   * An array of display options to pass to EntityViewDisplay.
   *
   * @var array
   */
  protected $displayOptions;

  /**
   * A field storage to use in this test class.
   *
   * @var \Drupal\field\Entity\FieldStorageConfig
   */
  protected $fieldStorage;

  /**
   * The field used in this test class.
   *
   * @var \Drupal\field\Entity\FieldConfig
   */
  protected $field;

  /**
   * A user with permission to administer site configuration.
   *
   * @var \Drupal\user\UserInterface
   */
  protected $user;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();
    $this->user = $this->drupalCreateUser([
      'access content',
      'view test entity',
      'administer entity_test content',
      'administer entity_test form display',
      'administer content types',
      'administer node fields',
    ]);
    $this->drupalLogin($this->user);

    $field_name = 'field_lexer_parser';
    $type = 'string';
    $formatter_type = 'lexer_parser_field_formatter';
    // Add the lexer parser field to the entity test.
    $this->fieldStorage = FieldStorageConfig::create([
      'field_name' => $field_name,
      'entity_type' => 'entity_test',
      'type' => $type,
    ]);
    $this->fieldStorage->save();
    $this->field = FieldConfig::create([
      'field_storage' => $this->fieldStorage,
      'label' => 'Lexer and Parser',
      'bundle' => 'entity_test',
      'required' => TRUE,
    ]);
    $this->field->save();
    EntityFormDisplay::load('entity_test.entity_test.default')
      ->setComponent($field_name)
      ->save();
    $this->displayOptions = [
      'type' => $formatter_type,
      'label' => 'hidden',
    ];
    EntityViewDisplay::create([
      'targetEntityType' => $this->field->getTargetEntityTypeId(),
      'bundle' => $this->field->getTargetBundle(),
      'mode' => 'full',
      'status' => TRUE,
    ])->setComponent($field_name, $this->displayOptions)->save();
  }

  /**
   * Tests the field creation and expected value.
   */
  public function testField() {
    // @todo
  }

  /**
   * Tests the calculate service.
   * @todo should be moved in Kernel test
   */
  public function testCalculate() {
    // @todo
  }

  /**
   * Data provider for the testCalculate() test case.
   * @todo should be moved in Kernel test
   *
   * @see https://github.com/fubhy/math-php/blob/master/tests/CalculatorTest.php
   */
  public function calculateProvider(){
    return [
      ['3 + 2', 5],
      ['7/6', 1.1666666666667],
      ['3^5 * 5 * $pi', 3817.0350741116],
      ['(3^2) * -2 + [foo]', -13, ['foo' => 5]],
      ['signum(-5)', -1],
      ['sqrt(5)', 2.2360679774],
      // Example expression from Wikipedia.
      // @see http://en.wikipedia.org/wiki/Shunting-yard_algorithm
      ['3 + 4 * 2 / ( 1 - 5 ) ^ 2 ^ 3', 3.0001220703125],
    ];
  }


}
