<?php

namespace Drupal\lexer_parser\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'lexer_parser_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "lexer_parser_field_formatter",
 *   label = @Translation("Lexer and Parser"),
 *   field_types = {
 *     "text",
 *     "string"
 *   }
 * )
 */
class LexerParserFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'display' => 'result_only',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    return [
      'display' => [
        '#title' => $this->t('Display'),
        '#type' => 'select',
        '#options' => [
          'result_only' => 'Result',
          'result_and_steps' => 'Result and calculation steps',
        ],
        '#default_value' => $this->getSetting('result'),
        '#description' => $this->t('Display the result only or add the calculation steps.'),
      ],
    ] + parent::settingsForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // @todo set value from key
    $summary[] = $this->t('Display: @display', ['@display' => $this->getSetting('display')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = $this->viewValue($item);
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return array
   *   Render array for the item.
   */
  protected function viewValue(FieldItemInterface $item) {
    $result = '';
    /** @var \Drupal\lexer_parser\LexerParserServiceInterface $lexerParser */
    $lexerParser = \Drupal::service('lexer_parser.default');
    switch ($this->getSetting('display')) {
      case 'result_and_steps':
        $steps = $lexerParser->calculationSteps($item->value);
        $displaySteps = [];
        /** @var \Fubhy\Math\Token\BaseToken $step */
        foreach ($steps as $step) {
          $displaySteps[] = [
            'value' => $step->getValue(),
            'offset' => $step->getOffset(),
            'type' => get_class($step),
          ];
        }
        $result = [
          '#theme' => 'lexer_parser',
          '#expression' => $item->value,
          '#result' => $lexerParser->calculate($item->value),
          '#calculation_steps' => $displaySteps,
        ];
        break;

      case 'result_only':
        $result = ['#markup' => $lexerParser->calculate($item->value)];
        break;
    }
    return $result;
  }

}
