<?php

namespace Drupal\my_calendar_module\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Block\BlockPluginInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\fullcalendar\Api\FullCalendarApi;

/**
 * Provides a block for displaying the calendar with events.
 *
 * @Block(
 *   id = "calendar_block",
 *   admin_label = @Translation("Calendar Block"),
 * )
 */
class CalendarBlock extends BlockBase implements BlockPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array &$form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);

    // Add a configuration option for selecting the view mode.
    $form['view_mode'] = [
      '#type' => 'select',
      '#title' => $this->t('View Mode'),
      '#options' => $this->getViewModes(),
      '#default_value' => $this->getConfigurationValue('view_mode'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->setConfigurationValue('view_mode', $form_state->getValue('view_mode'));
  }

  /**
   * {@inheritdoc}
   */
  public function blockBuild() {
    $build = [];

    $view_mode = $this->getConfigurationValue('view_mode');
    // Replace with your logic to retrieve events based on the view mode and permissions
    $events = $this->getEvents($view_mode);

    // Use FullCalendar library to build the calendar based on retrieved events (replace with actual logic)
    $fullcalendar = new FullCalendarApi();
    $build['calendar'] = $fullcalendar->build([
      'events' => $events,
      'headerToolbar' => [
        'left' => 'prev,next today',
        'center' => 'title',
        'right' => 'dayGridMonth,timeGridWeek,timeGridDay',
      ],
    ]);

    return $build;
  }

  /**
   * Gets available calendar view modes.
   *
   * @return array
   *   An array of available view mode labels mapped to their machine names.
   */
  protected function getViewModes() {
    $view_modes = [];
    foreach (\Drupal::entityTypeManager()->getViewModes('calendar_event') as $id => $view_mode) {
      $view_modes[$id] = $view_mode->getLabel();
    }
    return $view_modes;
  }

  /**
   * Retrieves events based on the configured view mode.
   *
   * @param string $view_mode
   *   The machine name of the view mode.
   *
   * @return array
   *   An array of event data for the FullCalendar library.
   */
  protected function getEvents($view_mode) {
    // Replace this with your logic to retrieve and format event data
    // based on the chosen view mode and user permissions.
    // You might use entity query or other methods to fetch event data.
    $events = [];
    // ... Populate events using Drupal's entity query or other logic

    return $events;
  }
}
