<?php
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

/*
 * Creates a form and adds 2 text inputs with different asserts
 */
$form = $app ["form.factory"]->createBuilder ( "form" )->add ( "end", "text", array (
		"label" => "End (threshold value)",
		"max_length" => 4,
		"trim" => true,
		"constraints" => array (
				new Assert\NotBlank (),
				new Assert\Regex ( array (
						"pattern" => "/([0-9])/i",
						"message" => "Your entry cannot contain characters" 
				) ),
				new Assert\Length ( array (
						"min" => 3,
						"max" => 4 
				) ),
				new Assert\LessThanOrEqual ( array (
						"value" => 0.40 
				) ) 
		) 
) )->add ( "days", "text", array (
		"label" => "Working days",
		"max_length" => 3,
		"trim" => true,
		"constraints" => array (
				new Assert\NotBlank (),
				new Assert\Regex ( array (
						"pattern" => "/([0-9])/i",
						"message" => "Your entry cannot contain characters" 
				) ),
				new Assert\Length ( array (
						"min" => 2,
						"max" => 3 
				) ),
				new Assert\LessThanOrEqual ( array (
						"value" => 199 
				) ) 
		) 
) )->getForm ();

/*
 * Creates a get route with request-object, imports global object and form
 * Renders the form to the template coffee.html in /views
 * Adds coffee to the url-generator
 */
$app->get ( "/", function (Request $request) use($app, $form) {
	
	return $app ["twig"]->render ( "coffee.html", array (
			'coffeeForm' => $form->createView () 
	) );
} )->bind ( "coffee" );

/*
 * Creates a post route with request-object, imports global object and form
 * Simulates the behavior of employees regarding coffee using different settings
 * Renders the form, data and image to the template coffee.html in /views
 */
$app->post ( "/", function (Request $request) use($app, $form) {
	$set = null;
	$pImage = null;
	if ("POST" == $request->getMethod ()) {
		$form->bind ( $request );
		if ($form->isValid ()) { // Only if form data are valid
			$data = $form->getData (); // Get data of form
			$end = htmlentities ( $data ["end"] + 0.01 );
			$days = htmlentities ( $data ["days"] );
			
			$set = array ();
			foreach ( range_yield ( 0, $end, 0.01 ) as $alpha ) { // call generator
				$employees = array ();
				$coffeePot = new CoffeePot ( 10 );
				foreach ( range ( 0, 14 ) as $object ) { // Initialize 15 employee - objects
					array_push ( $employees, new Employee ( $alpha, $coffeePot ) );
				}
				foreach ( range ( 0, 9 ) as $day ) { // first 10 days on the basis of the assistent
					if ($day > 0) {
						foreach ( $employees as $employee ) {
							$employee->newDay ();
						}
					}
					$coffeePot->setMugs ( 10 );
					foreach ( range ( 0, 2 ) as $daytime ) {
						foreach ( $employees as $employee ) {
							$employee->getCoffee ();
							$coffeePot->setMugs ( 10 );
						}
					}
					$coffeePot->setMugs ( 0 );
					foreach ( $employees as $employee ) {
						$employee->endOfTheDay ();
					}
				} // All employees drank three coffee every day
				foreach ( range ( 0, $days ) as $day ) {
					foreach ( $employees as $employee ) {
						$employee->newDay ();
					}
					foreach ( range ( 0, 2 ) as $daytime ) { // 3 daytimes
						shuffle ( $employees );
						foreach ( $employees as $employee ) {
							$employee->getCoffee ();
						}
					}
					foreach ( $employees as $employee ) {
						$employee->endOfTheDay ();
					}
				}
				$coffeePot->setMugs ( 0 );
				// Evaluation
				$sumAverage = 0;
				foreach ( $employees as $employee ) {
					$sumAverage += $employee->calcAverage ();
				}
				$set ["$alpha"] = round ( $sumAverage / count ( $employees ), 2 ); // Save result in an array
			}
			$_SESSION ["chartData"] = $set; // Save array into session
			$pImage = true; // Set boolean value pImage to true
		}
	}
	return $app ['twig']->render ( "coffee.html", array (
			"coffeeForm" => $form->createView (),
			"set" => $set,
			"pImage" => $pImage 
	) );
} );
