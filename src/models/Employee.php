<?php
/**
 * Controls the employee
 * 
 * @author Rune Krauss
 */
class Employee {
	/**
	 * Threshold value of employees
	 *
	 * @var double
	 * @access private
	 */
	private $alpha;
	
	/**
	 * Threshold value of employees
	 *
	 * @var int
	 * @access private
	 */
	private $coffeePot;
	
	/**
	 * Respective day
	 *
	 * @var Coffee pot
	 * @access private
	 */
	private $dayNr = 0;
	
	/**
	 * Array of cooked coffee
	 *
	 * @var Array
	 * @access private
	 */
	private $cookedCoffee = array (
			0 
	);
	
	/**
	 * Array of drunk coffee
	 *
	 * @var Array
	 * @access private
	 */
	private $drunkCoffee = array (
			0 
	);
	
	/**
	 * Counter of drunk Coffee
	 *
	 * @var int
	 * @access private
	 */
	private $n = 0;
	
	/**
	 * Counter of cooked Coffee
	 *
	 * @var int
	 * @access private
	 */
	private $m = 0;
	
	/**
	 * Threshold value of employees
	 *
	 * @var int
	 * @access private
	 */
	private $coffeeStack = array ();
	
	/**
	 * Initializes threshold value and coffee pot object
	 * 
	 * @param double $alpha
	 *        	threshold value
	 * @param CoffeePot $coffeePot
	 *        	coffee pot object
	 */
	public function __construct($alpha, $coffeePot) {
		$this->alpha = $alpha;
		$this->coffeePot = $coffeePot;
	}
	
	/**
	 * Increases the day number and creates an new array of m and n
	 * 
	 * @return void New day
	 */
	public function newDay() {
		$this->dayNr += 1;
		if (! ($this->dayNr < 10)) {
			unset ( $this->cookedCoffee [0] );
			unset ( $this->drunkCoffee [0] );
		}
		array_push ( $this->drunkCoffee, 0 );
		array_push ( $this->cookedCoffee, 0 );
	}
	
	/**
	 * If coffee pot isn't empty, drinks a cup
	 * else if the employee is happy, cooks coffee and drinks one cup
	 * 
	 * @return void Coffee
	 */
	public function getCoffee() {
		if (! ($this->coffeePot->isEmpty ())) {
			$this->drinkCup ();
		} else {
			if ($this->isHappy ()) {
				$this->cookCoffee ();
				$this->drinkCup ();
			}
		}
	}
	
	/**
	 * If coffeepot isn't empty gets mugs and decreases it.
	 * Afterwards, gets last element of drunk coffee, increases it and saves into array
	 * 
	 * @return void Drink cup
	 */
	public function drinkCup() {
		if (! ($this->coffeePot->isEmpty ())) {
			$mugs = $this->coffeePot->getMugs ();
			$this->coffeePot->setMugs ( $mugs -= 1 );
			$value = end ( $this->drunkCoffee );
			$key = key ( $this->drunkCoffee );
			$value += 1;
			$this->drunkCoffee [$key] = $value;
		}
	}
	/**
	 * Sets mugs to ten
	 * Afterwards, gets the last elements of cooked coffee, increases it and saves into array
	 * 
	 * @return void cook coffee
	 */
	public function cookCoffee() {
		$this->coffeePot->setMugs ( 10 );
		$value = end ( $this->cookedCoffee );
		$key = key ( $this->cookedCoffee );
		$value += 1;
		$this->cookedCoffee [$key] = $value;
	}
	/**
	 * Checks whether an employee is happy using a formula
	 * 
	 * @return boolean Happiness
	 */
	public function isHappy() {
		return $this->n >= 10 and $this->m / $this->n < $this->alpha;
	}
	/**
	 * Saves the last element of drunk coffee into stack and calculates the sum of n and m
	 * 
	 * @return void End of the day
	 */
	public function endOfTheDay() {
		$value = end ( $this->drunkCoffee );
		$key = key ( $this->drunkCoffee );
		$this->coffeeStack [$this->dayNr] = $this->drunkCoffee [$key];
		$this->n = array_sum ( $this->drunkCoffee );
		$this->m = array_sum ( $this->cookedCoffee );
	}
	/**
	 * Iterates the coffee stack and returns the result of an operation
	 * 
	 * @return number Division between sum of coffee stack and count of it
	 */
	public function calcAverage() {
		foreach ( $this->coffeeStack as $value => $key ) {
			return array_sum ( $this->coffeeStack ) / count ( $this->coffeeStack );
		}
	}
}