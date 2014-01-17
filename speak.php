
<?php
//Color chat script support for Nexuiz/Rocketminsta
//Created by NARKASUR aka H2SO4 on 2013/12/06
//Last Updated on 2014/01/17
header('Content-type: text/plain');

if(!isset($_GET ["say"]) || !isset($_GET ["visibility"]) || !isset($_GET["type"]))
	return;

$say = $_GET["say"];

$chat_type = -1; // random or what
$chat_type = $_GET ["type"];

$possible_null_char = substr($say, 0,6);

$possible_unique_number = substr($say, 0,11);
if( (is_numeric($possible_unique_number) && $possible_unique_number == 94251635430) 
|| strcmp($possible_null_char, "--NULL") == 0) // if string is a unique number or NULL
{
	print "cprint ^1 No input; echo ^1 No input";
	return;
}

$visibility = $_GET["visibility"];

if($visibility == 1)
	echo "say ";
elseif($visibility == 2)
	echo "say_team ";
else
	echo "echo ";
	
$color_count = 1;
$trimmed_char = "";
$space = 0;
$trimmed_char = TrimAlreadyExistingColorCodes($say);

//place your color codes here, if you change the number of colors in each set then adjust the cases in colorify also
$color_set = array(
	 array('000', '222', '555', '777', '888', 'AAA', 'BBB', 'CCC', 'EEE'),//gray gradiant
	 array('700', 'A10', 'E20', 'F21', 'F33', 'F76', 'F77', 'FAA', 'FEE'), //red gradiant
	 array('020', '070', '0b0', '1f4', '3f6', '6f9', '8fa', 'bfd', 'dfe'), //green gradiant
	 array('220', '450', '8a0', 'ae0', 'ef3', 'df5', 'df9', 'efb', 'dfd'), // yellow gradiant
	 array('001', '108', '10c', '22f', '55f', '88f', 'bbf', 'ccf', 'eef'), //indigo gradiant
	 array('011', '055', '0AB', '0DE', '1EF', '5EF', '7DF', 'ACF', 'EFF'), //cyan gradiant
	 array('305', 'A0A', 'D0D', 'F2F', 'F4F', 'F7F', 'F9F', 'FBF', 'FEF'), //magenta - pink
	 array('50F', '209', '05E', '080', 'EE0', 'B40', 'E10', '080', 'EE0'), //rainbow 
	 array('210', '840', 'C60', 'E70', 'FA4', 'FD6', 'FE9', 'FEA', 'FFD'), //brownish gradiant
	 array('000', '222', '555', '777', '888', 'AAA', 'BBB', 'CCC', 'EEE'), //gray gradiant
);

$color_code = ($chat_type < 0) ? $color_set[rand(0, count($color_set) - 1)]: $color_set[$chat_type];

#Debug
#print "--- $trimmed_char--- ";
#debug
$prev_char = "x";//some garbage value other than $
$length = strlen($trimmed_char);


//main function
$remove_existing_color = 0;
if(isset($_GET ["rm_color"])){
	$remove_existing_color = $_GET["rm_color"];
	if($remove_existing_color != 0 && $remove_existing_color != 1)//if value is out of our scope
		$remove_existing_color = 1;
	}

$color_count = 1;
$prev_token_color_prevails = 0;

$tok = strtok($say, " \n\t");
	while ($tok !== false) {
	
	$test_char = substr($tok,0,2);
	if(strcmp($test_char,"\${") == 0)
		break;//end of chat string
		
	if($remove_existing_color == 0)//do not remove color
	{
		if(StringHasColor($tok))
		{
			echo $tok;
			$last_two_char = substr($tok,-2, strlen($tok));
			if(strcmp($last_two_char, "^7") != 0) //end is not ^7
			{
				$prev_token_color_prevails = 1;
			}
			else
				$prev_token_color_prevails = 0;
		}
		else
		{
			if($prev_token_color_prevails == 1)
			{
				echo $tok;
				$last_two_char = substr($tok,-2, strlen($tok));
				//echo  "-- $last_two_char --";
				if(strcmp($last_two_char, "^7") == 0)  //end is  ^7
				{
					$prev_token_color_prevails = 0;
				}
			}
			else
				ColorPrint($tok);
		}
	}
	else //remove color
	{
		$trimmed_char = TrimAlreadyExistingColorCodes($tok);
		ColorPrint($trimmed_char);
	}
	//if($prev_token_color_prevails == 0)
		//ColorPrint(" ");
	//else
		echo " ";
	
    $tok = strtok(" \n\t");
}

function ColorPrint($i_string)
{
	global $color_count;
	for( $i = 0; $i < strlen($i_string); ++$i)
	{
		$color_count = colorify($color_count);
		echo $i_string[$i];
	}
}

//° ± ² ³ ´ µ ¶ · ¸ ¹ 


function TrimAlreadyExistingColorCodes($say){
	$trimmed_char = "";
	$color_code_position = 0;
	$stringlength = strlen($say);
	$position_B = $stringlength;  # A........B..A............B
	$position_A = 0;  # A........^1.A............^xCF0.A......
	$position_B_memory = $position_B; #need to reset if color code verification fails
	for($j = 0; $j <$stringlength; ++$j)
	{
		$temp_char = substr($say, $j,1);
		
		if(strcmp ($temp_char, "^") == 0)
		{
			$color_code_position  = 1 ;
		}
		elseif($color_code_position == 1 )
		{
		
			if($temp_char <= 9 && $temp_char >=0 && is_numeric($temp_char))
			{
				#add1;
				$position_B = $j - 1 ;
				
				if($position_B - $position_A > 0)
				{
					$trimmed_char = $trimmed_char.substr($say, $position_A, $position_B - $position_A);
				}
			
				$position_A = $position_B + 2;
				$position_B = $stringlength;
				$color_code_position = 0;
				
			}
			elseif (strcmp ( $temp_char , "x")==0)
			{
				$color_code_position  = 2;
			}
			else
			{
				$color_code_position = 0;
			#	$position_B = $position_B_memory; # color code verification failed; something like ...^a..
			}
			
		}
		elseif($color_code_position == 2 || $color_code_position == 3 || $color_code_position == 4 || $color_code_position == 5)
		{
		
			if( (0 <= $temp_char && $temp_char <= 9 && is_numeric($temp_char)) || strcmp ( $temp_char , "A" ) == 0||
			strcmp ( $temp_char , "B") == 0 || strcmp( $temp_char, "C") == 0|| strcmp ( $temp_char , "D") == 0|| strcmp ( $temp_char , "E") == 0|| strcmp ( $temp_char , "F") == 0
			|| strcmp ( $temp_char , "a") == 0 || strcmp ( $temp_char , "b") == 0 || strcmp ( $temp_char , "c") == 0|| strcmp ( $temp_char , "d"|| strcmp ( $temp_char , "e") == 0|| strcmp ( $temp_char , "f") == 0))
			{
				++$color_code_position;
			}
			else
			{
				$color_code_position = 0;
				#???
			}
			
			if($color_code_position == 4)
			{
				#add2;
				
				$position_B = $j - 3;
				if($position_B - $position_A > 0)
				{
					$trimmed_char = $trimmed_char.substr($say, $position_A, $position_B- $position_A );
				}
			
				$position_A = $position_B + 5;
				$position_B = $stringlength;
				$color_code_position = 0;
			}
				
		}
	}
	
	$trimmed_char = $trimmed_char.substr($say, $position_A, $position_B - $position_A);
	return $trimmed_char;
}


function StringHasColor($say){

	$color_code_position = 0;
	$stringlength = strlen($say);
	$position_B = $stringlength;  # A........B..A............B
	$position_A = 0;  # A........^1.A............^xCF0.A......

	for($j = 0; $j <$stringlength; ++$j)
	{
		$temp_char = substr($say, $j,1);
		
		if(strcmp ($temp_char, "^") == 0)
		{
			$color_code_position  = 1 ;
		}
		elseif($color_code_position == 1 )
		{
		
			if($temp_char <= 9 && $temp_char >=0 && is_numeric($temp_char))
			{
				#return 1;
				return 1;
				
			}
			elseif (strcmp ( $temp_char , "x")==0)
			{
				$color_code_position  = 2;
			}
			else
			{
				$color_code_position = 0;
			#	$position_B = $position_B_memory; # color code verification failed; something like ...^a..
			}
			
		}
		elseif($color_code_position == 2 || $color_code_position == 3 || $color_code_position == 4 || $color_code_position == 5)
		{
		
			if( (0 <= $temp_char && $temp_char <= 9 && is_numeric($temp_char)) || strcmp ( $temp_char , "A" ) == 0||
			strcmp ( $temp_char , "B") == 0 || strcmp( $temp_char, "C") == 0|| strcmp ( $temp_char , "D") == 0|| strcmp ( $temp_char , "E") == 0|| strcmp ( $temp_char , "F") == 0
			|| strcmp ( $temp_char , "a") == 0 || strcmp ( $temp_char , "b") == 0 || strcmp ( $temp_char , "c") == 0|| strcmp ( $temp_char , "d"|| strcmp ( $temp_char , "e") == 0|| strcmp ( $temp_char , "f") == 0))
			{
				++$color_code_position;
			}
			else
			{
				$color_code_position = 0;
				#???
			}
			
			if($color_code_position == 4)
			{
				#return 2;
				return 1;
			}
				
		}
	}
	
	return 0;
}

function colorify($color_count) 
{
		global $color_code;
		switch ($color_count){
			case 1 :
				echo("^x$color_code[0]");
				++$color_count;
				break;
			case 2 :
				echo("^x$color_code[1]");
				++$color_count;
				break;
			case 3 :
				echo("^x$color_code[2]");
				++$color_count;
				break;
			case 4 :
				echo("^x$color_code[3]");
				++$color_count;
				break;
			case 5 :
				echo("^x$color_code[4]");
				++$color_count;
				break;
			case 6 :
				echo("^x$color_code[5]");
				++$color_count;
				break;
			case 7 :
				echo("^x$color_code[6]");
				++$color_count;
				break;
			case 8 :
				echo("^x$color_code[7]");
				++$color_count;
				break;
			case 9 :
				echo("^x$color_code[8]");
				++$color_count;
				break;
			#reverse color
			case 10 :#same as 8
				echo("^x$color_code[7]");
				++$color_count;
				break;
			case 11 :#same as 7
				echo("^x$color_code[6]");
				++$color_count;
				break;
			case 12 :#same as 6
				echo("^x$color_code[5]");
				++$color_count;
				break;
			case 13 :#same as 5
				echo("^x$color_code[4]");
				++$color_count;
				break;
			case 14 :#same as 4
				echo("^x$color_code[3]");
				++$color_count;
				break;
			case 15 :#same as 3
				echo("^x$color_code[2]");
				++$color_count;
				break;
			case 16 :#same as 2
				echo("^x$color_code[1]");
				$color_count = 1;
				break;
			default:
				break;
		}
		return $color_count;
}

function PrintSpecial($char)
{
	switch ($char) {
		case "A":
			print "á";
			break;
		case "B":
			print "â";
			break;
		case "C":
			print "ã";
			break;
		case "D":
			print "ä";
			break;
		case "E":
			print "å";
			break;
		case "F":
			print "æ";
			break;
		case "G":
			print "ç";
			break;
		case "H":
			print "è";
			break;
		case "I":
			print "é";
			break;
		case "J":
			print "ê";
			break;
		case "K":
			print "ë";
			break;
		case "L":
			print "ì";
			break;
		case "M":
			print "í";
			break;
		case "N":
			print "î";
			break;
		case "O":
			print "ï";
			break;
		case "P":
			print "ð";
			break;
		case "Q":
			print "ñ";
			break;
		case "R":
			print "ò";
			break;
		case "S":
			print "ó";
			break;
		case "T":
			print "ô";
			break;
		case "U":
			print "õ";
			break;
		case "V":
			print "ö";
			break;
		case "W":
			print "÷";
			break;
		case "X":
			print "ø";
			break;
		case "Y":
			print "ù";
			break;
		case "Z":
			print "ú";
			break;
		case "0":
			print "°";
			break;
		case "1":
			print "±";
			break;
		case "2":
			print "²";
			break;
		case "3":
			print "³";
			break;
		case "4":
			print "´";
			break;
		case "5":
			print "µ";
			break;
		case "6":
			print "¶";
			break;
		case "7":
			print "·";
			break;
		case "8":
			print "¸";
			break;
		case "9":
			print "¹";
			break;
		default:
			print "$char";
			break;
	}
}
?>
