<?php
/**
 * Plugin Name: Real Estate OS
 * Description: A standardized, organized, object-oriented foundation for building high-quality WordPress Plugins.
 * Version:     1.0.0
 * Author:      donald
 * Author URI:  https://github.com/dearvn/real-estate-os
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: real-estate-os
 *
 * @package WPRS
 */

/*
Real Estate OS is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Real Estate OS is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Real Estate OS. If not, see http://www.gnu.org/licenses/gpl-2.0.txt.
*/

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define plugin __FILE__
 */
if ( ! defined( 'WPRS_PLUGIN_FILE' ) ) {
	define( 'WPRS_PLUGIN_FILE', __FILE__ );
}

/**
 * Include necessary files to initial load of the plugin.
 */
if ( ! class_exists( 'WPRS\Bootstrap' ) ) {
	require_once __DIR__ . '/includes/traits/trait-singleton.php';
	require_once __DIR__ . '/includes/class-bootstrap.php';
}

/**
 * Initialize the plugin functionality.
 *
 * @since  1.0.0
 * @return WPRS\Bootstrap
 */
function real_estate_os_plugin() {
	return WPRS\Bootstrap::instance();
}

// Call initialization function.
real_estate_os_plugin();

class WDS_CLI {

	/**
	 * Migrate Data as sample data to test
	 *
	 * @since  0.0.1
	 * @author Scott Anderson
	 */
	public function run_migrate() {
		$total = 4;
		for ( $i = 0; $i < $total; $i++ ) {
			$this->migrate_data( $i + 1 );
		}

	}

	/**
	 * Migrate data from file.
	 *
	 * @param int $i input value.
	 * return void
	 */
	private function migrate_data( $i ) {
		$content = file_get_contents( __DIR__ . '/datasample/list' . $i . '.json' );

		$datas = json_decode( $content );

		try {
			register_taxonomy( 'location', 'realestate' );

			foreach ( $datas as $data ) {
				$city_slug = $data->code;
				$city      = get_term_by( 'slug', $city_slug, 'location' );
				if ( empty( $city->term_id ) ) {
					$city_id = wp_insert_term(
						$data->name,
						'location',
						array(
							'slug'        => $city_slug,
							'description' => 'city',
						)
					);
					add_term_meta( $city_id, 'term_type', 'city' );
				} else {
					$city_id = $city->term_id;
					wp_update_term( $city_id, 'location', array( 'description' => 'city' ) );
					$term_value = get_term_meta( $city_id, 'term_type', true );
					if ( $term_value != 'city' ) {
						add_term_meta( $city_id, 'term_type', 'city' );
					}
				}

				$districts = $data->district;
				$projects  = array();
				foreach ( $districts as $item ) {
					$dist_slug = sanitize_title( $item->pre . ' ' . $item->name ) . '-' . $city_slug;
					$dist      = get_term_by( 'slug', $dist_slug, 'location' );
					if ( empty( $dist->term_id ) ) {
						$dist_id = wp_insert_term(
							$item->pre . ' ' . $item->name,
							'location',
							array(
								'slug'        => $dist_slug,
								'parent'      => $city_id,
								'description' => 'district',
							)
						);
						add_term_meta( $dist_id, 'term_type', 'district' );
					} else {
						$dist_id = $dist->term_id;
						wp_update_term(
							$dist_id,
							'location',
							array(
								'parent'      => $city_id,
								'description' => 'district',
							)
						);
						$term_value = get_term_meta( $dist_id, 'term_type', true );
						if ( $term_value != 'district' ) {
							add_term_meta( $dist_id, 'term_type', 'district' );
						}
					}

					$wards = $item->ward;
					foreach ( $wards as $itm ) {
						$ward_slug = sanitize_title( $itm->pre . ' ' . $itm->name ) . '-' . sanitize_title( $item->pre . ' ' . $item->name );
						$ward      = get_term_by( 'slug', $ward_slug, 'location' );
						if ( empty( $ward->term_id ) ) {
							$ward_id = wp_insert_term(
								$itm->pre . ' ' . $itm->name,
								'location',
								array(
									'slug'        => $ward_slug,
									'parent'      => $dist_id,
									'description' => 'ward',
								)
							);
							add_term_meta( $ward_id, 'term_type', 'ward' );
						} else {
							$ward_id = $ward->term_id;
							wp_update_term(
								$ward_id,
								'location',
								array(
									'parent'      => $dist_id,
									'description' => 'ward',
								)
							);
							$term_value = get_term_meta( $ward_id, 'term_type', true );
							if ( $term_value != 'ward' ) {
								add_term_meta( $ward_id, 'term_type', 'ward' );
							}
						}
					}

					$streets = $item->street;
					foreach ( $streets as $itm ) {
						$street_slug = sanitize_title( $itm->pre . ' ' . $itm->name ) . '-' . sanitize_title( $item->pre . ' ' . $item->name );
						$street      = get_term_by( 'slug', $street_slug, 'location' );
						if ( empty( $street->term_id ) ) {
							$street_id = wp_insert_term(
								$itm->pre . ' ' . $itm->name,
								'location',
								array(
									'slug'        => $street_slug,
									'parent'      => $dist_id,
									'description' => 'street',
								)
							);
							add_term_meta( $street_id, 'term_type', 'street' );
						} else {
							$street_id = $street->term_id;
							wp_update_term(
								$street_id,
								'location',
								array(
									'parent'      => $dist_id,
									'description' => 'street',
								)
							);
							$term_value = get_term_meta( $street_id, 'term_type', true );
							if ( $term_value != 'street' ) {
								add_term_meta( $street_id, 'term_type', 'street' );
							}
						}
					}

					$projects[] = array(
						'dist_id'   => $dist_id,
						'dist_slug' => $dist_slug,
						'projects'  => $item->project,
					);
				}

				register_taxonomy( 'project', 'realestate' );
				foreach ( $projects as $item ) {
					foreach ( $item['projects'] as $itm ) {
						$project_slug = sanitize_title( $itm->name ) . '-' . $item['dist_slug'];
						$project      = get_term_by( 'slug', $project_slug, 'project' );

						if ( empty( $project->term_id ) ) {
							$project_id = wp_insert_term(
								$itm->name,
								'project',
								array(
									'slug'   => $project_slug,
									'parent' => $item['dist_id'],
								)
							);
							add_term_meta( $project_id, 'term_type', 'project' );
						} else {
							$project_id = $project->term_id;
							wp_update_term( $project_id, 'project', array( 'parent' => $item['dist_id'] ) );
							$term_value = get_term_meta( $project_id, 'term_type', true );
							if ( $term_value != 'project' ) {
								add_term_meta( $project_id, 'term_type', 'project' );
							}
						}
					}
				}
			}
		} catch ( \Exception $e ) {
			echo $e->getMessage();
		}
	}

}

function wds_cli_register_commands() {
	WP_CLI::add_command( 'wds', 'WDS_CLI' );
}

add_action( 'cli_init', 'wds_cli_register_commands' );
