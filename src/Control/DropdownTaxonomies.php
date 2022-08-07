<?php
/**
 * Dropdown Taxonomies control
 *
 * @package NSCU
 */

namespace Nilambar\CustomizerUtils\Control;

use Nilambar\CustomizerUtils\Control\Select;

/**
 * Dropdown Taxonomies control class.
 *
 * @since 1.0.0
 */
class DropdownTaxonomies extends Select {

	/**
	 * Control type.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	public $type = 'nscu-dropdown-taxonomies';

	/**
	 * Taxonomy.
	 *
	 * @access public
	 * @var string
	 */
	public $taxonomy = '';

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
		$our_taxonomy = 'category';

		if ( isset( $args['taxonomy'] ) ) {
			$taxonomy_exist = taxonomy_exists( esc_attr( $args['taxonomy'] ) );
			if ( true === $taxonomy_exist ) {
				$our_taxonomy = esc_attr( $args['taxonomy'] );
			}
		}

		$args['taxonomy'] = $our_taxonomy;
		$this->taxonomy   = esc_attr( $our_taxonomy );

		$tax_args = array(
			'hierarchical' => 0,
			'taxonomy'     => $this->taxonomy,
		);

		$all_taxonomies = get_categories( $tax_args );

		$choices = array();

		$choices[0] = esc_html__( '&mdash; Select &mdash;', 'ns-customizer-utilities' );

		if ( ! empty( $all_taxonomies ) && ! is_wp_error( $all_taxonomies ) ) {
			foreach ( $all_taxonomies as $tax ) {
				$choices[ $tax->term_id ] = $tax->name;
			}
		}

		$this->choices = $choices;

		parent::__construct( $manager, $id, $args );
	}
}
