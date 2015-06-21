<?php
/**
 * Controls the coffee pot
 * 
 * @author Rune Krauss
 */
class CoffeePot {
	/**
	 * Mugs of the coffee pot, max 10
	 *
	 * @var int
	 * @access private
	 */
	private $mugs = 0;
	/**
	 * Initializes the mugs of the coffee pot
	 *
	 * @param int $mugs
	 *        	Mugs of the coffee pot
	 */
	public function __construct($mugs) {
		$this->mugs = $mugs;
	}
	/**
	 * Gets mugs of class
	 *
	 * @return int mugs of the coffee pot
	 * @access public
	 */
	public function getMugs() {
		return $this->mugs;
	}
	/**
	 * Sets mugs of class
	 *
	 * @param
	 *        	int mugs of the coffee pot
	 * @access public
	 */
	public function setMugs($mugs) {
		$this->mugs = $mugs;
	}
	/**
	 * Checks whether coffee pot is empty
	 *
	 * @return int 0 mugs
	 * @access public
	 */
	public function isEmpty() {
		return $this->mugs == 0;
	}
}