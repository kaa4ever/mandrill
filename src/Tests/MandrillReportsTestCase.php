<?php
namespace Drupal\mandrill\Tests;

/**
 * Tests Mandrill Reports functionality.
 * 
 * @group mandrill
 */
class MandrillReportsTestCase extends \Drupal\simpletest\WebTestBase {

  protected $profile = 'standard';

  /**
   * Returns info displayed in the test interface.
   *
   * @return array
   *   Formatted as specified by simpletest.
   */
  public static function getInfo() {
    // Note: getInfo() strings are not translated with t().
    return [
      'name' => 'Mandrill Reports Tests',
      'description' => 'Tests Mandrill Reports functionality.',
      'group' => 'Mandrill',
    ];
  }

  /**
   * Pre-test setup function.
   *
   * Enables dependencies.
   * Sets the mandrill_api_key variable to the test key.
   */
  protected function setUp() {
    // Use a profile that contains required modules:
    $prof = drupal_get_profile();
    $this->profile = $prof;
    // Enable modules required for the test.
    $enabled_modules = [
      'libraries',
      'mandrill',
      'mandrill_reports',
      'entity',
    ];
    parent::setUp($enabled_modules);
    \Drupal::config('mandrill.settings')->set('mandrill_api_classname', 'DrupalMandrillTest')->save();
    \Drupal::config('mandrill.settings')->set('mandrill_api_key', 'MANDRILL_TEST_API_KEY')->save();
  }

  /**
   * Post-test function.
   *
   * Sets test mode to FALSE.
   */
  protected function tearDown() {
    parent::tearDown();

    \Drupal::config('mandrill.settings')->clear('mandrill_api_classname')->save();
    \Drupal::config('mandrill.settings')->clear('mandrill_api_key')->save();
  }

  /**
   * Tests getting Mandrill reports data.
   */
  public function testGetReportsData() {
    $reports_data = mandrill_reports_data();

    $this->assertTrue(!empty($reports_data), 'Tested retrieving reports data.');
    $this->assertTrue(!empty($reports_data['user']), 'Tested user report data exists.');
    $this->assertTrue(!empty($reports_data['tags']), 'Tested tags report data exists.');
    $this->assertTrue(!empty($reports_data['all_time_series']), 'Tested all time series report data exists.');
    $this->assertTrue(!empty($reports_data['senders']), 'Tested senders report data exists.');
    $this->assertTrue(!empty($reports_data['urls']), 'Tested URLs report data exists.');
  }

}
