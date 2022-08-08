<?php
/**
 * Dropdown Posts control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Select;

/**
 * Dropdown Posts control class.
 *
 * @since 1.0.0
 */
class DropdownPosts extends Select {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-dropdown-posts';

	/**
	 * Post type.
	 *
	 * @access public
	 * @var string
	 */
	public $post_type = 'post';

	/**
	 * Query arguments.
	 *
	 * @access public
	 * @var array
	 */
	public $query_args = array();

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 *
	 * @param WP_Customize_Manager $manager Customizer bootstrap instance.
	 * @param string               $id      Control ID.
	 * @param array                $args    Optional. Arguments to override class property defaults.
	 */
	public function __construct( $manager, $id, $args = array() ) {
		if ( isset( $args['post_type'] ) && post_type_exists( $args['post_type'] ) ) {
			$this->post_type = esc_attr( $args['post_type'] );
		}

		$query_args = array();

		if ( isset( $args['query_args'] ) ) {
			$this->query_args = $args['query_args'];
		}

		$query_args = $this->query_args;

		$query_args = array_merge(
			$query_args,
			array(
				'post_type'      => $this->post_type,
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'no_found_rows'  => true,
			)
		);

		$the_query = new \WP_Query( $query_args );

		$options = array();

		$options[0] = esc_html__( '&mdash; Select &mdash;', 'ns-customizer-utilities' );

		$all_posts = get_posts( $query_args );

		if ( $all_posts ) {
			foreach ( $all_posts as $key => $p ) {
				$options[ strval( $p->ID ) ] = get_the_title( $p->ID );
			}
		}

		$this->choices = $options;

		parent::__construct( $manager, $id, $args );
	}
}
