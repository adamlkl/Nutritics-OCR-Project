<?php
/*
parameter: string var 
description: checks if a string passed in is a mass
returns: true if yes; false if no
*/
function determineValue ($var){
		//if var is not a string, change it to string
		if (strcmp(gettype($var),"string")!==0)
		{
			if (strcmp(gettype($var),"boolean")===0)
			{
				return false;
			}
			else settype($var, "string");
		}
		//check if the string has the measuring unit of mg
		if (strpos($var, "mg")){
			//check if the substring only exist once in the string
			//then check the index of the string if it is located at the end 
			//try removeing the last two character and check if there are only numbers in it
			return 	strpos($var,"mg")==strrpos($var,"mg") && 
				   	strpos($var,"mg")==mb_strlen($var)-2 && 
					is_numeric(substr($var, 0, -2));
		}
		//check if the string has the measuring unit of μg
		else if ( strpos($var,"μg")){
			//check if the substring only exist once in the string
			//then check the index of the string if it is located at the end 
			//try removing the last two character and check if there are only numbers in it
			return strpos($var,"μg")==strrpos($var,"μg") && 
				   strpos($var,"μg")==mb_strlen($var)-2 && 
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
/*
check similarity of two strings 
correcting typo error 
parameters: string name of nutrient 
returns: string corrected version of name
		 "INVALID" if cant correct typo error	
*/
function checkSimilarity ($nutrient){
	//list of nutrients
	$nutrientList = array("Energy","Protein","Fat","Carbohydrate","Sugars","Sodium","Vitamin E","Vitamin K","Vitamin C", "Vitamin A","Vitamin D","Vitamin B6","Biotin","Thiamin","Riboflavin","Niacin","Folic Acid","Vitamin B12","Calcium","Iron","Zinc","Pantothenic Acid","Folate","Phosphorus","Iodine","Magnesium","Selenium","Copper","Manganese","Chromium","Molybdenum","Chloride");
	$test=str_replace(' ', '', $nutrient);
	for ($x=0;$x<count($nutrientList);$x++)
	{
		$test2=str_replace(' ', '', $nutrientList[$x]);
		//$sim = similar_text(strtolower($nutrient), strtolower($nutrientList[$x]), $perc);
		$sim = similar_text(strtolower($test), strtolower($test2), $perc);
		if ($perc>70 && abs(strlen($test)-strlen($test2)<2))
		{
			//if (strcmp(substr(strtolower($nutrient,0,7))),"vitamin")===0){
			//check if it is a vitamin
			if (strcmp(substr(strtolower($test2),0,7),"vitamin")===0){
				if ($perc>90) return $nutrientList[$x];
				else continue;
			}
			//else return strtoupper(substr($nutrient,0,1)).strtolower(substr($nutrient,1));
			else return $nutrientList[$x];
		}
	}
	return "INVALID";
}
/*
//test results
var_dump(determineValue("10"));     	// bool(true)
var_dump(determineValue("10.334"));   	// bool(true)
var_dump(determineValue("10.8mg"));   	// bool(true)
var_dump(determineValue("10.5μg"));     // bool(true)
var_dump(determineValue("10.5g")); 		// bool(true)
var_dump(determineValue("1.5yg")); 		// bool(false)
var_dump(determineValue("g1.5yg")); 	// bool(false)
var_dump(determineValue("3.4fjj")); 	// bool(false)
var_dump(determineValue(1));			// bool(true)
var_dump(determineValue(1.455));		// bool(true)
var_dump(determineValue(14690));		// bool(true)
var_dump(determineValue(true));			// bool(false)
$foo = "5bar"; // string
settype($foo, "float");
var_dump($foo);  // $bar is now "1" (string))
*/
var_dump(checkSimilarity("f ats"));
var_dump(checkSimilarity("fats"));
var_dump(checkSimilarity("Molyadeuum"));
var_dump(checkSimilarity("codiwhfiwhe"));
var_dump(checkSimilarity("Vitamin K"));
var_dump(checkSimilarity("Vitamin Z"));
?>
