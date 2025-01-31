<?php
/**
 * The REST component.
 *
 * This file defines the `REST` class, which registers and manages custom REST API endpoints
 * for the plugin.
 *
 * @package lhpbp\plugin
 */

namespace WpMunich\lhpbp\plugin\REST;

use WpMunich\lhpbp\plugin\Plugin_Component;
use WP_REST_Server;
use function add_action;
use function register_rest_route;

/**
 * REST
 *
 * A class to register and manage the plugin's custom REST API endpoints.
 */
class REST extends Plugin_Component {

	/**
	 * The namespace for REST endpoints in this component.
	 *
	 * @var string
	 */
	private $rest_namespace = 'lhpbpp/v1';

	/**
	 * {@inheritDoc}
	 */
	protected function add_actions() {
		add_action( 'rest_api_init', array( $this, 'register_rest_routes' ) );
	}

	/**
	 * {@inheritDoc}
	 */
	protected function add_filters() {}

	/**
	 * Register custom REST API routes.
	 *
	 * This method is intended to be overridden by developers when adding REST routes.
	 * Example usage is provided in the comments below.
	 *
	 * @return void
	 */
	public function register_rest_routes() {
		/*
		Example route: Retrieve all examples
		register_rest_route(
			$this->rest_namespace,
			'/examples/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'rest_get_examples' ),
				'permission_callback' => '__return_true',
			)
		);
		*/

		/*
		Example route: Retrieve a single example by slug
		register_rest_route(
			$this->rest_namespace,
			'/example/(?P<slug>[a-z0-9-]+)/',
			array(
				'methods'             => WP_REST_Server::READABLE,
				'callback'            => array( $this, 'rest_get_example' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'slug' => array(
						'required' => true,
						'validate_callback' => function( $param ) {
							return is_string( $param ) && preg_match( '/^[a-z0-9-]+$/', $param );
						}
					)
				),
			)
		);
		*/
	}

	/**
	 * Get the current REST namespace.
	 *
	 * Returns the namespace used for this component’s REST routes.
	 *
	 * @return string The REST namespace.
	 */
	public function get_namespace() {
		return $this->rest_namespace;
	}
}
