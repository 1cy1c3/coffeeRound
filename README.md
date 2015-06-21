coffeeRound
============

## Description
Simulates the behavior of employees regarding coffee using different settings.

## Prerequisites
+ Apache HTTP Server
+ PHP 5.5 or higher
+ Modul gd and FreeType for charts (check it with `phpinfo()`)

## Installation
Put the folder `coffee_round*` into your web - folder (e. g. htdocs or www). Afterwards, navigate to the folder `libs` and 
run the following commands:
```
$ curl -sS https://getcomposer.org/installer | php
$ php composer.phar install
```
For your information, the composer is a package manager for PHP that managing dependencies of PHP software 
and required libraries.

## Usage
Open your browser and visit the following url of your web folder (e. g. `localhost/coffee_round*/web`). 
Afterwards, you are able to enter the threshold value and working days. The calculation is beginning.
The output is a table respectively a chart which displays the correlation between threshold value and 
average (drunk coffee) regarding the employees.

## More information
Generate the documentation regarding the special comments with a command in your terminal or with an IDE such as Eclipse. 
Furthermore, read the documentation about the framework at
http://silex.sensiolabs.org/documentation.

