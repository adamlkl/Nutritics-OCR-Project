<?php
/*
parameter: string var 
description: checks if a string passed in is a mass
returns: true if yes; false if no
*/
function determineValue ($var){
		
		//check if the string has the measuring unit of mg
		if (strpos($var, "mg")){
			//check if the substring only exist once in the string
			//then check the index of the string if it is located at the end 
			//try removeing the last two character and check if there are only numbers in it
			var_dump("test");
			return 	strpos($var,"mg")==strrpos($var,"mg") && 
				   	strpos($var,"mg")==strlen($var)-2 && 
					is_numeric(substr($var, 0, -2));
		}

		//check if the string has the measuring unit of μg
		else if ( strpos($var,"μg")){
			//check if the substring only exist once in the string
			//then check the index of the string if it is located at the end 
			//try removing the last two character and check if there are only numbers in it
			//var_dump("test2");
			return strpos($var,"μg")==strrpos($var,"μg") && 
				   strpos($var,"μg")==strlen($var)-3 && 
				   is_numeric(substr($var,0,-3));
		}

		//check if the string has the measuring unit of g
		else if (strpos($var,"g")!==false){
			//check if the substring only exist once in the string
			//then check the index of the string 
			return strpos($var,"g") && strrpos($var,"g") && (strpos($var,"g")==strlen($var)-1) && is_numeric(substr($var, 0, -1));
		}

		//if the string does not contain any measuring unit, then we try converting it into integer/float
		else {
			return is_numeric($var)&&(is_float(floatval($var))||is_integer(intval($var)));
		}
	}

//test results
var_dump(determineValue("10"));     	// bool(true)
var_dump(determineValue("10.334"));   	// bool(true)
var_dump(determineValue("10.8mg"));   	// bool(true)
var_dump(determineValue("10.5μg"));     // bool(true)
var_dump(determineValue("10.5g")); 		// bool(true)
var_dump(determineValue("1.5yg")); 		// bool(false)
var_dump(determineValue("g1.5yg")); 	// bool(false)
var_dump(determineValue("3.4fjj")); 	// bool(false)

$foo = "5bar"; // string
settype($foo, "float");
var_dump($foo);  // $bar is now "1" (string))
?>