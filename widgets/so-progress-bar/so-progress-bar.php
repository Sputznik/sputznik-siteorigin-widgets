<?php
/*
Widget Name: Sputznik Progress Bar
Description: An accessible, multi-layout progress bar widget.
Author: Stephen Anil, Sputznik
Author URI:	https://sputznik.com
*/

class SP_PROGRESS_BAR extends SiteOrigin_Widget {

	/**
	 * WIDGET FORM DEFAULTS
	 */
	protected static $sp_widget_form_defaults = array(
		'layout_type'            => 'layout-default',
		'current_value'          => 30,
		'max_value'              => 100,
		'value_prefix'           => '',
		'value_suffix'           => '%',
		'max_prefix'             => '',
		'max_suffix'             => '',
		'current_value_format'   => 'percentage',
		'completion_label'       => 'Complete',
		'aria_template'          => 'Progress: ${value_prefix}${current_value}${value_suffix} out of ${max_prefix}${max_value}${max_suffix}.',
		'track_background_color' => '#e5e7eb',
		'track_foreground_color' => '#3b82f6',
		'current_value_color'    => '#4b5563',
		'max_value_color'        => '#4b5563',
	);

	function __construct(){
		$defaults = self::$sp_widget_form_defaults;

		parent::__construct(
			'so-progress-bar',
			__( 'Sputznik Progress Bar', 'siteorigin-widgets' ),
			array(
				'description' => __( 'Display a dynamic customizable progress bar.', 'siteorigin-widgets' ),
				'help'        => '',
			),
			array(),
			array(
				'layout_type' => array(
					'type'    => 'select',
					'label'   => __( 'Widget Layout Style', 'siteorigin-widgets' ),
					'default' => $defaults['layout_type'],
					'options' => array(
						'layout-default' => __( 'Default Layout', 'siteorigin-widgets' ),
						// 'layout-two' => __( 'Layout Two', 'siteorigin-widgets' ),
					),
				),
				'settings_section' => array(
					'type'   => 'section',
					'label'  => __( 'Settings Section', 'siteorigin-widgets' ),
					'hide'   => false,
					'fields' => array(
						'current' => array(
							'type'   => 'section',
							'label'  => __( 'Current Value Options', 'siteorigin-widgets' ),
							'fields' => array(
								'value'         => array(
									'type'        => 'number',
									'label'       => __( 'Value', 'siteorigin-widgets' ),
									'default'     => $defaults['current_value'],
									'description' => __( 'Automatically capped if it exceeds the max threshold value.', 'siteorigin-widgets' ),
								),
								'prefix' => array( 'type' => 'text', 'label' => __( 'Prefix', 'siteorigin-widgets' ), 'default' => $defaults['value_prefix'] ),
								'suffix' => array( 'type' => 'text', 'label' => __( 'Suffix', 'siteorigin-widgets' ), 'default' => $defaults['value_suffix'] ),
								'display_format' => array(
									'type'    => 'select',
									'label'   => __( 'Display Format', 'siteorigin-widgets' ),
									'default' => $defaults['current_value_format'],
									'options' => array(
										'percentage' => __( 'Percentage', 'siteorigin-widgets' ),
										'decimal'    => __( 'Decimal', 'siteorigin-widgets' ),
										'thousand'   => __( 'Thousand Number (Formatted natively with commas)', 'siteorigin-widgets' ),
									),
								),
                'completion_label' => array(
                  'type'        => 'text',
                  'label'       => __( 'Completion Label', 'siteorigin-widgets' ),
                  'default'     => $defaults['completion_label'],
                  'description' => __( 'Replaces the <code>${current_value}</code> token once progress hits 100%.', 'siteorigin-widgets' ),
                ),
							)
						),
						'max' => array(
							'type'   => 'section',
							'label'  => __( 'Maximum Threshold Options', 'siteorigin-widgets' ),
							'fields' => array(
								'value'  => array( 'type' => 'number', 'label' => __( 'Value', 'siteorigin-widgets' ), 'default' => $defaults['max_value'] ),
								'prefix' => array( 'type' => 'text', 'label' => __( 'Prefix', 'siteorigin-widgets' ), 'default' => $defaults['max_prefix'] ),
								'suffix' => array( 'type' => 'text', 'label' => __( 'Suffix', 'siteorigin-widgets' ), 'default' => $defaults['max_suffix'] ),
							)
						),
						'aria_template' => array(
							'type'        => 'text',
							'label'       => __( 'Accessible Screen Reader Text Template', 'siteorigin-widgets' ),
							'default'     => $defaults['aria_template'],
							'description' => __( 'Available placeholders: <code>${current_value}</code>, <code>${max_value}</code>, <code>${value_prefix}</code>, <code>${value_suffix}</code>, <code>${max_prefix}</code>, <code>${max_suffix}</code>', 'siteorigin-widgets' ),
						),
					),
				),
				'design_section' => array(
					'type'   => 'section',
					'label'  => __( 'Design Section', 'siteorigin-widgets' ),
					'hide'   => true,
					'fields' => array(
						'track' => array(
							'type'   => 'section',
							'label'  => __( 'Progress Track Style', 'siteorigin-widgets' ),
							'fields' => array(
								'background_color' => array( 'type' => 'color', 'label' => __( 'Background Color (Track)', 'siteorigin-widgets' ), 'default' => $defaults['track_background_color'] ),
								'foreground_color' => array( 'type' => 'color', 'label' => __( 'Foreground Color (Fill)', 'siteorigin-widgets' ), 'default' => $defaults['track_foreground_color'] ),
							)
						),
						'current' => array(
							'type'   => 'section',
							'label'  => __( 'Current Value Styles', 'siteorigin-widgets' ),
							'fields' => array(
								'value_color' => array( 'type' => 'color', 'label' => __( 'Value Color', 'siteorigin-widgets' ), 'default' => $defaults['current_value_color'] ),
							)
						),
						'max' => array(
							'type'   => 'section',
							'label'  => __( 'Maximum Threshold Styles', 'siteorigin-widgets' ),
							'fields' => array(
								'value_color' => array( 'type' => 'color', 'label' => __( 'Value Color', 'siteorigin-widgets' ), 'default' => $defaults['max_value_color'] ),
							)
						),
					),
				),
			),
			plugin_dir_path(__FILE__)
		);
	}

	/**
	 * FRONTEND MODEL
	 */
	public function get_layout_data( $instance ){
		$current_nodes       = isset( $instance['settings_section']['current'] ) ? $instance['settings_section']['current'] : array();
		$max_nodes           = isset( $instance['settings_section']['max'] ) ? $instance['settings_section']['max'] : array();
		$track_nodes         = isset( $instance['design_section']['track'] ) ? $instance['design_section']['track'] : array();
		$current_nodes_style = isset( $instance['design_section']['current'] ) ? $instance['design_section']['current'] : array();
		$max_nodes_style     = isset( $instance['design_section']['max'] ) ? $instance['design_section']['max'] : array();

		$user_configs = array(
			'layout_type'            => isset( $instance['layout_type'] ) ? $instance['layout_type'] : '',
			'current_value'          => isset( $current_nodes['value'] ) ? $current_nodes['value'] : null,
			'value_prefix'           => isset( $current_nodes['prefix'] ) ? $current_nodes['prefix'] : null,
			'value_suffix'           => isset( $current_nodes['suffix'] ) ? $current_nodes['suffix'] : null,
			'current_value_format'   => isset( $current_nodes['display_format'] ) ? $current_nodes['display_format'] : null,
			'completion_label'       => isset( $current_nodes['completion_label'] ) ? $current_nodes['completion_label'] : null,
			'max_value'              => isset( $max_nodes['value'] ) ? $max_nodes['value'] : null,
			'max_prefix'             => isset( $max_nodes['prefix'] ) ? $max_nodes['prefix'] : null,
			'max_suffix'             => isset( $max_nodes['suffix'] ) ? $max_nodes['suffix'] : null,
			'aria_template'          => isset( $instance['settings_section']['aria_template'] ) ? $instance['settings_section']['aria_template'] : null,
			'track_background_color' => isset( $track_nodes['background_color'] ) ? $track_nodes['background_color'] : null,
			'track_foreground_color' => isset( $track_nodes['foreground_color'] ) ? $track_nodes['foreground_color'] : null,
			'current_value_color'    => isset( $current_nodes_style['value_color'] ) ? $current_nodes_style['value_color'] : null,
			'max_value_color'        => isset( $max_nodes_style['value_color'] ) ? $max_nodes_style['value_color'] : null,
		);

		// STRIP EMPTY PROPERTIES TO FALLBACK ONTO THE DEFAULTS
		$user_configs = array_filter( $user_configs, function( $val ){ return !is_null($val); } );
		$settings = wp_parse_args( $user_configs, self::$sp_widget_form_defaults );

		$current    = floatval( $settings['current_value'] );
		$max        = floatval( $settings['max_value'] );
		$val_prefix = esc_html( $settings['value_prefix'] );
		$val_suffix = esc_html( $settings['value_suffix'] );
		$max_prefix = esc_html( $settings['max_prefix'] );
		$max_suffix = esc_html( $settings['max_suffix'] );
		$comp_label = esc_html( $settings['completion_label'] );

		$percentage = ( $max > 0 ) ? max( 0, min( 100, ( $current / $max ) * 100 ) ) : 0;

		$format_args = array(
			'current'          => $current,
			'max'              => $max,
			'percentage'       => $percentage,
			'formatting_style' => $settings['current_value_format'],
			'completion_label' => $comp_label,
		);

		$display_format = $this->process_display_format( $format_args );

		$tokens = array(
			'${current_value}'      => $display_format,
			'${max_value}'          => $max,
			'${value_prefix}'       => $val_prefix,
			'${value_suffix}'       => $val_suffix,
			'${max_prefix}'         => $max_prefix,
			'${max_suffix}'         => $max_suffix,
		);

		$aria_value_text = str_replace( array_keys( $tokens ), array_values( $tokens ), sanitize_text_field( $settings['aria_template'] ) );

		return array(
			'track'   => array(
				'bg_color' => esc_attr( $settings['track_background_color'] ),
				'fg_color' => esc_attr( $settings['track_foreground_color'] ),
			),
			'current' => array(
				'value'      => $current,
				'percentage' => $percentage,
				'format'     => $settings['current_value_format'],
				'label'      => $display_format,
				'prefix'     => $val_prefix,
				'suffix'     => $val_suffix,
				'style'      => array(
					'value_color' => esc_attr( $settings['current_value_color'] ),
				)
			),
			'max'     => array(
				'value'      => $max,
				'prefix'     => $max_prefix,
				'suffix'     => $max_suffix,
				'style'      => array(
					'value_color' => esc_attr( $settings['max_value_color'] ),
				)
			),
			'aria_value_text' => $aria_value_text
		);
	}

	private function process_display_format( array $args ){
		$current    = $args['current'];
		$max        = $args['max'];
		$percentage = $args['percentage'];
		$style      = $args['formatting_style'];
		$comp_label = $args['completion_label'];

		if( $current >= $max && $max > 0 ){
			return $comp_label;
		}

		$decimals = ( floor( $current ) == $current ) ? 0 : 1;

		switch( $style ){
			case 'decimal':
				$decimal_fraction = ( $max > 0 ) ? ( $current / $max ) : 0;

				// Format up to 3 decimal places for accuracy (e.g., 0.075)
				$formatted_decimal = number_format( $decimal_fraction, 3, '.', '' );

				// Trim trailing zeros so 0.500 becomes 0.5, but preserve 0 if it's completely flat
				$formatted_decimal = ( strpos( $formatted_decimal, '.' ) !== false ) ? rtrim( rtrim( $formatted_decimal, '0' ), '.' ) : $formatted_decimal;
				return ( $formatted_decimal === '' ) ? '0' : $formatted_decimal;

			case 'thousand': return number_format( $current, $decimals, '.', ',' );

			case 'percentage':
			default: $pct_decimals = ( floor( $percentage ) == $percentage ) ? 0 : 1;
			return number_format( $percentage, $pct_decimals, '.', '' );
		}

	}

	private function get_validated_layout( $instance ){
		$chosen_layout = ! empty( $instance['layout_type'] ) ? sanitize_file_name( $instance['layout_type'] ) : self::$sp_widget_form_defaults['layout_type'];
		$template_dir  = plugin_dir_path(__FILE__) . $this->get_template_dir($instance);
		$target_file   = trailingslashit( $template_dir ) . $chosen_layout . '.php';

		if( !file_exists( $target_file ) ){
			return self::$sp_widget_form_defaults['layout_type'];
		}

		return $chosen_layout;
	}

	function get_template_name( $instance ){
		return $this->get_validated_layout( $instance );
	}

	function get_template_dir( $instance ){
		return 'templates';
	}

	function get_style_name( $instance ){
		return '';
	}

	public function enqueue_frontend_scripts( $instance ){
		$assets_path   = plugin_dir_url(__FILE__);
		$active_layout = $this->get_validated_layout( $instance );

		wp_enqueue_script( 'so-sp-progress-bar-main-js', $assets_path . 'js/script.js', array('jquery'), SP_SOW_VERSION, true );
		wp_enqueue_style( 'so-sp-progress-bar-style-' . $active_layout, $assets_path . 'css/' . $active_layout . '.css', array(), SP_SOW_VERSION );

		parent::enqueue_frontend_scripts( $instance );
	}

	/**
	 * SANITIZE WIDGET FORM
	 */
	function modify_instance( $instance ){
		if( isset( $instance['settings_section']['current']['value'] ) ){
			$instance['settings_section']['current']['value'] = floatval( $instance['settings_section']['current']['value'] );
			if( $instance['settings_section']['current']['value'] < 0 ){
				$instance['settings_section']['current']['value'] = 0;
			}
		}

		if( isset( $instance['settings_section']['max']['value'] ) ){
			$instance['settings_section']['max']['value'] = floatval( $instance['settings_section']['max']['value'] );
			if( $instance['settings_section']['max']['value'] <= 0 ){
				$instance['settings_section']['max']['value'] = self::$sp_widget_form_defaults['max_value'];
			}
		}

		// Ensure current value does not exceed max value
		if( isset( $instance['settings_section']['current']['value'] ) && isset( $instance['settings_section']['max']['value'] ) ){
			$max_val     = $instance['settings_section']['max']['value'];
			$current_val = $instance['settings_section']['current']['value'];

			if( $current_val > $max_val ){
				$instance['settings_section']['current']['value'] = $max_val;
			}
		}

		if( isset( $instance['settings_section']['aria_template'] ) ){
			$instance['settings_section']['aria_template'] = sanitize_text_field( $instance['settings_section']['aria_template'] );
		}

		if( isset( $instance['design_section']['track']['background_color'] ) ){
			$instance['design_section']['track']['background_color'] = sanitize_hex_color( $instance['design_section']['track']['background_color'] );
		}

		if( isset( $instance['design_section']['track']['foreground_color'] ) ){
			$instance['design_section']['track']['foreground_color'] = sanitize_hex_color( $instance['design_section']['track']['foreground_color'] );
		}

		if( isset( $instance['design_section']['current']['value_color'] ) ){
			$instance['design_section']['current']['value_color'] = sanitize_hex_color( $instance['design_section']['current']['value_color'] );
		}

		if( isset( $instance['design_section']['max']['value_color'] ) ){
			$instance['design_section']['max']['value_color'] = sanitize_hex_color( $instance['design_section']['max']['value_color'] );
		}

		return $instance;
	}

}

siteorigin_widget_register( 'so-progress-bar', __FILE__, 'SP_PROGRESS_BAR' );
