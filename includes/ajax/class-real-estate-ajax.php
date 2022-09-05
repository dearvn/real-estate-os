<?php
/**
 * Real_Estate_Ajax class.
 *
 * @package WPRS
 */

namespace WPRS\Ajax;

use WPRS\Traits\Singleton;

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load sample ajax functionality inside this class.
 */
class Real_Estate_Ajax {

	use Singleton;

	/**
	 * Constructor of Bootstrap class.
	 */
	private function __construct() {
		// change city will get disctricts.
		add_action( 'wp_ajax_change_city_action', array( $this, 'change_city_action' ) );
		add_action( 'wp_ajax_nopriv_change_city_action', array( $this, 'change_city_action' ) );

		// change district will change wards, street and project
		add_action( 'wp_ajax_change_district_action', array( $this, 'change_district_action' ) );
		add_action( 'wp_ajax_nopriv_change_district_action', array( $this, 'change_district_action' ) );

		// change category will change price
		add_action( 'wp_ajax_change_category_action', array( $this, 'change_category_action' ) );
		add_action( 'wp_ajax_nopriv_change_category_action', array( $this, 'change_category_action' ) );
	}

	/**
	 * Change city action.
	 */
	public function change_category_action() {
		if ( ! wp_verify_nonce( $_GET['nonce'], 'ajax-nonce' ) ) {
			wp_send_json_error( null, 400 );
		}

		$str_prices = '<option value="">' . __( 'All Prices' ) . '</option>';

		if ( isset( $_GET['cat'] ) ) {
			$cat     = (int) sanitize_text_field( $_GET['cat'] );
			$options = get_option( 'real_estate_option_name' );
			if ( ! empty( $options['prices'] ) ) {
				$prices = (array) json_decode( $options['prices'] );
				if ( ! empty( $prices[ $cat ] ) ) {
					foreach ( $prices[ $cat ] as $item ) {
						$itm         = (array) $item;
						$key         = key( $itm );
						$label       = reset( $itm );
						$str_prices .= "<option value='" . $key . "'>";
						$str_prices .= $label . '</option>';
					}
				}
			}
		}

		wp_send_json_success( array( 'prices' => $str_prices ), 200 );
	}

	/**
	 * Change city action.
	 */
	public function change_city_action() {
		if ( ! wp_verify_nonce( $_GET['nonce'], 'ajax-nonce' ) ) {
			wp_send_json_error( null, 400 );
		}

		$str_dists = '<option value="">' . __( 'Select District' ) . '</option>';
		if ( ! empty( $_GET['filter'] ) ) {
			$str_dists = '<option value="">' . __( 'All Districts' ) . '</option>';
		}
		if ( isset( $_GET['city'] ) ) {
			$city  = (int) sanitize_text_field( $_GET['city'] );
			$terms = get_terms(
				'location',
				array(
					'parent'     => $city,
					'orderby'    => 'name',
					'hide_empty' => false,
				)
			);
			foreach ( $terms as $term ) {
				if ( ! empty( $term->name ) ) {
					$str_dists .= "<option value='" . $term->term_id . "'>";
					$str_dists .= $term->name . '</option>';
				}
			}
		}

		wp_send_json_success( array( 'dists' => $str_dists ), 200 );
	}

	/**
	 * Change district action.
	 */
	public function change_district_action() {
		if ( ! wp_verify_nonce( $_GET['nonce'], 'ajax-nonce' ) ) {
			wp_send_json_error( null, 400 );
		}
		$str_wards    = '<option value="">' . __( 'Select One' ) . '</option>';
		$str_streets  = '<option value="">' . __( 'Select One' ) . '</option>';
		$str_projects = '<option value="">' . __( 'Select One' ) . '</option>';
		if ( ! empty( $_GET['filter'] ) ) {
			$str_wards    = '<option value="">' . __( 'All Wards' ) . '</option>';
			$str_streets  = '<option value="">' . __( 'All Streets' ) . '</option>';
			$str_projects = '<option value="">' . __( 'All Projects' ) . '</option>';
		}
		if ( isset( $_GET['district'] ) ) {
			$district   = (int) sanitize_text_field( $_GET['district'] );
			$ward_terms = get_terms(
				'location',
				array(
					'parent'     => $district,
					'orderby'    => 'name',
					'hide_empty' => false,
					'meta_query' => array(
						array(
							'key'     => 'term_type',
							'value'   => 'ward',
							'compare' => '=',
						),
					),
				)
			);
			foreach ( $ward_terms as $term ) {
				if ( ! empty( $term->name ) ) {
					$str_wards .= "<option value='" . $term->term_id . "'>";
					$str_wards .= $term->name . '</option>';
				}
			}
			$street_terms = get_terms(
				'location',
				array(
					'parent'     => $district,
					'orderby'    => 'name',
					'hide_empty' => false,
					'meta_query' => array(
						array(
							'key'     => 'term_type',
							'value'   => 'street',
							'compare' => '=',
						),
					),
				)
			);
			foreach ( $street_terms as $term ) {
				if ( ! empty( $term->name ) ) {
					$str_streets .= "<option value='" . $term->term_id . "'>";
					$str_streets .= $term->name . '</option>';
				}
			}
			$project_terms = get_terms(
				'project',
				array(
					'parent'     => $district,
					'orderby'    => 'name',
					'hide_empty' => false,
				)
			);
			foreach ( $project_terms as $term ) {
				if ( ! empty( $term->name ) ) {
					$str_projects .= "<option value='" . $term->term_id . "'>";
					$str_projects .= $term->name . '</option>';
				}
			}
		}

		wp_send_json_success(
			array(
				'wards'    => $str_wards,
				'streets'  => $str_streets,
				'projects' => $str_projects,
			),
			200
		);
	}
}
