<?php
/*
  Widget Name: Sputznik Image Popup
  Description: A simple widget with a repeater using builder and unique_id.
  Author: Suhail Bin Abdullah
  Author URI: https://sputznik.com
  Widget URI:
*/

class SP_IMAGE_POPUP extends SiteOrigin_Widget {

  function __construct() {
    parent::__construct(
      'so-image-popup',
      __('Sputznik Image Popup', 'siteorigin-widgets'),
      array(
        'description' => __('A simple SiteOrigin widget with repeater.', 'siteorigin-widgets'),
        'help' => '',
      ),
      array(),
      array(
        'classname' => array(
        'type' => 'text',
        'label' => __('Classname', 'siteorigin-widgets'),
        'default' => 'popup',
        'description' => __('This will be used to generate the trigger class like: classname-uniqueid', 'siteorigin-widgets'),
      ),
        'popup_items' => array(
          'type' => 'repeater',
          'label' => __('Popup Items', 'siteorigin-widgets'),
          'item_name' => __('Popup Item', 'siteorigin-widgets'),
          'fields' => array(
            'builder_content' => array(
              'type' => 'builder',
              'label' => __('Popup Builder Content', 'siteorigin-widgets'),
              'default' => '',
            ),
            'unique_id' => array(
              'type' => 'text',
              'label' => __('Unique ID', 'siteorigin-widgets'),
              'description' => __('Must be unique. Lowercase only. No spaces.', 'siteorigin-widgets'),
              'input_attrs' => array(
                'pattern' => '[a-z0-9\-]+',
                'title' => 'Only lowercase letters, numbers, and hyphens. No spaces.',
                'placeholder' => 'e.g. popup-1'
              )
            ),
            'combined_label' => array(
              'type' => 'text',
              'label' => __('Generated Class', 'siteorigin-widgets'),
              'readonly' => true,
              'default' => '',
              'description' => __('Auto-generated from classname and unique_id'),
              'input_attrs' => array(
                'readonly' => 'readonly',
                'class' => 'readonly-generated-class',
              ),
            ),

            'popup_width_section' => array(
              'type' => 'section',
              'label' => __('Popup Width', 'siteorigin-widgets'),
              'hide' => true,
              'fields' => array(
                'dialog_width_mobile' => array(
                  'type' => 'text',
                  'label' => __('Mobile Width (%)', 'siteorigin-widgets'),
                  'description' => __('e.g. 100 for full width. Leave blank for default.', 'siteorigin-widgets'),
                  'default' => '',
                ),
                'dialog_width_tablet' => array(
                  'type' => 'text',
                  'label' => __('Tablet Width (%)', 'siteorigin-widgets'),
                  'description' => __('Applies above 768px. Leave blank for default.', 'siteorigin-widgets'),
                  'default' => '',
                ),
                'dialog_width_pc' => array(
                  'type' => 'text',
                  'label' => __('PC Width (%)', 'siteorigin-widgets'),
                  'description' => __('Applies above 960px. Leave blank for default.', 'siteorigin-widgets'),
                  'default' => '',
                ),
              ),
            ),
          )
        ),

      'used_classes' => array(
      'type' => 'html',
      'label' => __('Classes used in this widget', 'siteorigin-widgets'),
      'default' => 'suhail bin abdula',
      'html' => true,
    ),

      ),
      
      plugin_dir_path(__FILE__) . '/widgets/so-image-popup/'
    );
  }

  public function enqueue_admin_scripts() {
      wp_enqueue_script(
          'so-image-popup-admin',
          plugin_dir_url(__FILE__) . '../../assets/js/so-image-popup.js',
          array('jquery', 'siteorigin-widget-admin'),
          SP_SOW_VERSION,
          true
      );
  }

  function update($new_instance, $old_instance, $form_type = 'widget') {
      if ( ! empty( $new_instance['popup_items'] ) && is_array( $new_instance['popup_items'] ) ) {
          $ids = array();
          foreach ( $new_instance['popup_items'] as $index => &$popup_item ) {
              if ( isset( $popup_item['unique_id'] ) ) {
                  $popup_item['unique_id'] = preg_replace( '/\s+/', '', strtolower( $popup_item['unique_id'] ) );
              }

              $id = $popup_item['unique_id'];
              if ( in_array( $id, $ids ) ) {
                  unset( $new_instance['popup_items'][ $index ] );
                  continue;
              }

              $ids[] = $id;

              if ( isset($popup_item['popup_width_section']) ) {
                  foreach (['dialog_width_mobile', 'dialog_width_tablet', 'dialog_width_pc'] as $key) {
                      if (isset($popup_item['popup_width_section'][$key])) {
                          $val = trim($popup_item['popup_width_section'][$key]);
                          $val = is_numeric($val) ? (int) $val : '';
                          $popup_item['popup_width_section'][$key] = ($val >= 10 && $val <= 100) ? $val : '';
                      }
                  }
              }
          }

          $new_instance['popup_items'] = array_values( $new_instance['popup_items'] );
      }

    return $new_instance;
  }

  function get_template_name($instance) {
    return 'template';
  }

  function get_template_dir($instance) {
    return 'templates';
  }

  function get_style_name($instance) {
    return '';
  }
}

siteorigin_widget_register('so-image-popup', __FILE__, 'SP_IMAGE_POPUP');
