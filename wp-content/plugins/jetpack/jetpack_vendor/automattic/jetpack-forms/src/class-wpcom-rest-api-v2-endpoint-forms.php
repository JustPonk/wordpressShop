<?php
/**
 * The Forms Rest Controller class.
 * Registers the REST routes for Jetpack Forms (taken from stats-admin).
 *
 * @package automattic/jetpack-forms
 */

namespace Automattic\Jetpack\Forms;

use Automattic\Jetpack\Connection\Manager;
use Automattic\Jetpack\Forms\ContactForm\Contact_Form_Plugin;
use WP_Error;
use WP_REST_Controller;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * Handles the REST routes for Form Responses, aka Feedback.
 */
class WPCOM_REST_API_V2_Endpoint_Forms extends WP_REST_Controller {
	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->namespace = 'wpcom/v2';
		$this->rest_base = 'forms';

		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}

	/**
	 * Registers the REST routes.
	 *
	 * @access public
	 */
	public function register_rest_routes() {
		// Stats for single resource type.

		register_rest_route(
			$this->namespace,
			$this->rest_base . '/responses',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'get_responses' ),
				'permission_callback' => array( $this, 'get_responses_permission_check' ),
				'args'                => array(
					'limit'   => array(
						'default'  => 20,
						'type'     => 'integer',
						'required' => false,
						'minimum'  => 1,
					),
					'offset'  => array(
						'default'  => 0,
						'type'     => 'integer',
						'required' => false,
						'minimum'  => 0,
					),
					'form_id' => array(
						'type'     => 'integer',
						'required' => false,
						'minimum'  => 1,
					),
					'search'  => array(
						'type'     => 'string',
						'required' => false,
					),
				),
			)
		);

		register_rest_route(
			$this->namespace,
			$this->rest_base . '/responses/bulk_actions',
			array(
				'methods'             => WP_REST_Server::CREATABLE,
				'callback'            => array( $this, 'bulk_actions' ),
				'permission_callback' => array( $this, 'get_responses_permission_check' ),
			)
		);
	}

	/**
	 * Returns Jetpack Forms responses.
	 *
	 * @param WP_REST_Request $request The request sent to the WP REST API.
	 *
	 * @return WP_REST_Response A response object containing Jetpack Forms responses.
	 */
	public function get_responses( $request ) {
		$args = array(
			'post_type'   => 'feedback',
			'post_status' => array( 'publish', 'draft' ),
		);

		if ( isset( $request['parent_id'] ) ) {
			$args['post_parent'] = $request['parent_id'];
		}

		if ( isset( $request['month'] ) ) {
			$args['m'] = $request['month'];
		}

		if ( isset( $request['limit'] ) ) {
			$args['posts_per_page'] = $request['limit'];
		}

		if ( isset( $request['offset'] ) ) {
			$args['offset'] = $request['offset'];
		}

		if ( isset( $request['search'] ) ) {
			$args['s'] = $request['search'];
		}

		$filter_args = array_merge(
			$args,
			array( 'post_status' => array( 'draft', 'publish', 'spam', 'trash' ) )
		);

		$current_query = 'inbox';
		if ( isset( $request['status'] ) && in_array( $request['status'], array( 'spam', 'trash' ), true ) ) {
			$current_query = $request['status'];
		}

		$query = array(
			'inbox' => new \WP_Query(
				array_merge(
					$args,
					array(
						'post_status'    => array( 'draft', 'publish' ),
						'posts_per_page' => $current_query === 'inbox' ? $args['posts_per_page'] : -1,
					)
				)
			),
			'spam'  => new \WP_Query(
				array_merge(
					$args,
					array(
						'post_status'    => array( 'spam' ),
						'posts_per_page' => $current_query === 'spam' ? $args['posts_per_page'] : -1,
					)
				)
			),
			'trash' => new \WP_Query(
				array_merge(
					$args,
					array(
						'post_status'    => array( 'trash' ),
						'posts_per_page' => $current_query === 'trash' ? $args['posts_per_page'] : -1,
					)
				)
			),
		);

		$source_ids = Contact_Form_Plugin::get_all_parent_post_ids(
			array_diff_key( $filter_args, array( 'post_parent' => '' ) )
		);

		$base_fields   = Contact_Form_Plugin::NON_PRINTABLE_FIELDS;
		$data_defaults = array(
			'_feedback_author'       => '',
			'_feedback_author_email' => '',
			'_feedback_author_url'   => '',
			'_feedback_all_fields'   => array(),
			'_feedback_ip'           => '',
			'_feedback_subject'      => '',
		);

		$responses = array_map(
			function ( $response ) use ( $base_fields, $data_defaults ) {
				$data = array_merge(
					$data_defaults,
					\Automattic\Jetpack\Forms\ContactForm\Contact_Form_Plugin::parse_fields_from_content( $response->ID )
				);

				$all_fields = array_merge( $base_fields, $data['_feedback_all_fields'] );
				return array(
					'id'                      => $response->ID,
					'uid'                     => $all_fields['feedback_id'],
					'date'                    => get_the_date( 'c', $response ),
					'author_name'             => $data['_feedback_author'],
					'author_email'            => $data['_feedback_author_email'],
					'author_url'              => $data['_feedback_author_url'],
					'author_avatar'           => empty( $data['_feedback_author_email'] ) ? '' : get_avatar_url( $data['_feedback_author_email'] ),
					'email_marketing_consent' => $all_fields['email_marketing_consent'],
					'ip'                      => $data['_feedback_ip'],
					'entry_title'             => $all_fields['entry_title'],
					'entry_permalink'         => $all_fields['entry_permalink'],
					'subject'                 => $data['_feedback_subject'],
					'fields'                  => array_diff_key(
						$all_fields,
						$base_fields
					),
				);
			},
			$query[ $current_query ]->posts
		);

		return rest_ensure_response(
			array(
				'responses'         => $responses,
				'totals'            => array_map(
					function ( $subquery ) {
						return $subquery->found_posts;
					},
					$query
				),
				'filters_available' => array(
					'month'  => $this->get_months_filter_for_query( $filter_args ),
					'source' => array_map(
						function ( $post_id ) {
							return array(
								'id'    => $post_id,
								'title' => get_the_title( $post_id ),
								'url'   => get_permalink( $post_id ),
							);
						},
						$source_ids
					),
				),
			)
		);
	}

	/**
	 * Returns a list of months which can be used to filter the given query.
	 *
	 * @param array $query Query.
	 *
	 * @return array List of months.
	 */
	private function get_months_filter_for_query( $query ) {
		global $wpdb;

		$filters = '';

		if ( isset( $query['post_parent'] ) ) {
			$filters = $wpdb->prepare( 'AND post_parent = %d ', $query['post_parent'] );
		}

		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery,WordPress.DB.DirectDatabaseQuery.NoCaching,WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$months = $wpdb->get_results(
			$wpdb->prepare(
				"SELECT DISTINCT YEAR( post_date ) AS year, MONTH( post_date ) AS month
				FROM $wpdb->posts
				WHERE post_type = 'feedback'
				$filters
				ORDER BY post_date DESC"
			)
		);
		// phpcs:enable

		return array_map(
			function ( $row ) {
				return array(
					'month' => intval( $row->month ),
					'year'  => intval( $row->year ),
				);
			},
			$months
		);
	}

	/**
	 * Handles bulk actions for Jetpack Forms responses.
	 *
	 * @param WP_REST_Request $request The request sent to the WP REST API.
	 *
	 * @return WP_REST_Response A response object..
	 */
	public function bulk_actions( $request ) {
		$action   = $request->get_param( 'action' );
		$post_ids = $request->get_param( 'post_ids' );

		if ( $action && ! is_array( $post_ids ) ) {
			return new $this->error_response( __( 'Bad request', 'jetpack-forms' ), 400 );
		}

		switch ( $action ) {
			case 'mark_as_spam':
				return $this->bulk_action_mark_as_spam( $post_ids );

			case 'mark_as_not_spam':
				return $this->bulk_action_mark_as_not_spam( $post_ids );

			case 'trash':
				return $this->bulk_action_trash( $post_ids );

			case 'untrash':
				return $this->bulk_action_untrash( $post_ids );

			case 'delete':
				return $this->bulk_action_delete_forever( $post_ids );

			default:
				return $this->error_response( __( 'Bad request', 'jetpack-forms' ), 400 );
		}
	}

	/**
	 * Verifies that the current user has the requird capability for viewing form responses.
	 *
	 * @return true|WP_Error Returns true if the user has the required capability, else a WP_Error object.
	 */
	public function get_responses_permission_check() {
		$site_id = Manager::get_site_id();
		if ( is_wp_error( $site_id ) ) {
			return $site_id;
		}

		if ( ! current_user_can( 'edit_pages' ) ) {
			return new WP_Error(
				'invalid_user_permission_jetpack_form_responses',
				'unauthorized',
				array( 'status' => rest_authorization_required_code() )
			);
		}

		return true;
	}

	/**
	 * Marks all feedback posts matchin the given IDs as spam.
	 *
	 * @param  array $post_ids Array of post IDs.
	 * @return WP_REST_Response
	 */
	private function bulk_action_mark_as_spam( $post_ids ) {
		foreach ( $post_ids as $post_id ) {
			$post = get_post( $post_id );
			if ( $post->post_type !== 'feedback' ) {
				continue;
			}
			$status = wp_update_post(
				array(
					'ID'          => $post_id,
					'post_status' => 'spam',
				),
				false,
				false
			);

			if ( ! $status || is_wp_error( $status ) ) {
				return $this->error_response(
					sprintf(
						/* translators: %s: Post ID */
						__( 'Failed to mark post as spam. Post ID: %d.', 'jetpack-forms' ),
						$post_id
					),
					500
				);
			}

			/** This action is documented in \Automattic\Jetpack\Forms\ContactForm\Admin */
			do_action(
				'contact_form_akismet',
				'spam',
				get_post_meta( $post_id, '_feedback_akismet_values', true )
			);
		}

		return new WP_REST_Response( array(), 200 );
	}

	/**
	 * Marks all feedback posts matchin the given IDs as not spam.
	 *
	 * @param  array $post_ids Array of post IDs.
	 * @return WP_REST_Response
	 */
	private function bulk_action_mark_as_not_spam( $post_ids ) {
		foreach ( $post_ids as $post_id ) {
			$post = get_post( $post_id );
			if ( $post->post_type !== 'feedback' ) {
				continue;
			}
			$status = wp_update_post(
				array(
					'ID'          => $post_id,
					'post_status' => 'publish',
				),
				false,
				false
			);

			if ( ! $status || is_wp_error( $status ) ) {
				return $this->error_response(
					sprintf(
						/* translators: %s: Post ID */
						__( 'Failed to mark post as not-spam. Post ID: %d.', 'jetpack-forms' ),
						$post_id
					),
					500
				);
			}

			/** This action is documented in \Automattic\Jetpack\Forms\ContactForm\Admin */
			do_action(
				'contact_form_akismet',
				'ham',
				get_post_meta( $post_id, '_feedback_akismet_values', true )
			);
		}

		return new WP_REST_Response( array(), 200 );
	}

	/**
	 * Moves all feedback posts matchin the given IDs to trash.
	 *
	 * @param  array $post_ids Array of post IDs.
	 * @return WP_REST_Response
	 */
	private function bulk_action_trash( $post_ids ) {
		foreach ( $post_ids as $post_id ) {
			if ( ! wp_trash_post( $post_id ) ) {
				return $this->error_response(
					sprintf(
						/* translators: %s: Post ID */
						__( 'Failed to move post to trash. Post ID: %d.', 'jetpack-forms' ),
						$post_id
					),
					500
				);
			}
		}

		return new WP_REST_Response( array(), 200 );
	}

	/**
	 * Removes all feedback posts matchin the given IDs from trash.
	 *
	 * @param  array $post_ids Array of post IDs.
	 * @return WP_REST_Response
	 */
	private function bulk_action_untrash( $post_ids ) {
		foreach ( $post_ids as $post_id ) {
			if ( ! wp_untrash_post( $post_id ) ) {
				return $this->error_response(
					sprintf(
						/* translators: %s: Post ID */
						__( 'Failed to remove post from trash. Post ID: %d.', 'jetpack-forms' ),
						$post_id
					),
					500
				);
			}
		}

		return new WP_REST_Response( array(), 200 );
	}

	/**
	 * Deletes all feedback posts matchin the given IDs.
	 *
	 * @param  array $post_ids Array of post IDs.
	 * @return WP_REST_Response
	 */
	private function bulk_action_delete_forever( $post_ids ) {
		foreach ( $post_ids as $post_id ) {
			if ( ! wp_delete_post( $post_id ) ) {
				return $this->error_response(
					sprintf(
						/* translators: %s: Post ID */
						__( 'Failed to delete post. Post ID: %d.', 'jetpack-forms' ),
						$post_id
					),
					500
				);
			}
		}

		return new WP_REST_Response( array(), 200 );
	}

	/**
	 * Returns a WP_REST_Response containing the given error message and code.
	 *
	 * @param  string $message Error message.
	 * @param  int    $code    Error code.
	 * @return WP_REST_Response
	 */
	private function error_response( $message, $code ) {
		return new WP_REST_Response( array( 'error' => $message ), $code );
	}
}

if ( defined( 'IS_WPCOM' ) && IS_WPCOM ) {
	wpcom_rest_api_v2_load_plugin( 'Automattic\Jetpack\Forms\WPCOM_REST_API_V2_Endpoint_Forms' );
}
