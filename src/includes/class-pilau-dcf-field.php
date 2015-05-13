<?php

/**
 * Modelling a field
 *
 * @since      1.0.0
 *
 * @package    Pilau_DCF
 * @subpackage Pilau_DCF/includes
 */

/**
 * Modelling a field
 *
 * @since      1.0.0
 * @package    Pilau_DCF
 * @subpackage Pilau_DCF/includes
 * @author     Steve Taylor <steve@sltaylor.co.uk>
 */
class Pilau_DCF_Field {

	/**
	 * The prefix for the meta key
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $prefix    The prefix for the meta key
	 */
	private $prefix;

	/**
	 * Set up the field
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->prefix = '_pdcf_';
	}

}
