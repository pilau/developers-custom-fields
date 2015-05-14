<?php

/**
 * Modelling a box
 *
 * @since      1.0.0
 *
 * @package    Pilau_DCF
 * @subpackage Pilau_DCF/includes
 */

/**
 * Modelling a box
 *
 * @since      1.0.0
 * @package    Pilau_DCF
 * @subpackage Pilau_DCF/includes
 * @author     Steve Taylor <steve@sltaylor.co.uk>
 */
class Pilau_DCF_Box {

	/**
	 * The fields
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array		$fields    The fields
	 */
	protected $fields;

	/**
	 * Set up the box
	 *
	 * @since		1.0.0
	 * @param		array	$box
	 */
	public function __construct( $box ) {

		$this->fields = array();


		if ( is_array( $box['fields'] ) && ! empty( $box['fields'] ) ) {

			foreach ( $box['fields'] as $field ) {

				$this->fields[] = new Pilau_DCF_Field( $field );

			}

		}

	}

}
