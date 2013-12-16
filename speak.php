
<?php
header('Content-type: text/plain');

if(empty($_GET ["say"]) || empty($_GET ["type"]))
	return;

$say = $_GET["say"];


$possible_null_char = substr($say, 0,6);
if(strcmp($possible_null_char, "--NULL") == 0)
{
	print "cprint ^1 No input; echo ^1 No input";
	return;
}




$type = $_GET["type"];


$length = strlen($say);

if($type == 1)
	print "say ";
elseif($type == 2)
	print "say_team ";
$color_count = 1;

$char = "A";//some garbage character other than white space
$trimmed_char = "";
//print "\"";
$space = 0;
$trimmed_char = TrimAlreadyExistingColorCodes($say);


$prev_char = "x";//some garbage value other than $
for($i = 0; $i <$length; ++$i)
{
	$char = substr($trimmed_char, $i,1);
	if(strcmp ( $char, " " ) == 0)
	{
		$space = 1;
	}
	
	
	if($space == 0) {
	//Add color
	switch ($color_count){
		case 1 :
			print "^x700";
			++$color_count;
			break;
		case 2 :
			print "^xA10";
			++$color_count;
			break;
		case 3 :
			print "^xE20";
			++$color_count;
			break;
		case 4 :
			print "^xF21";
			++$color_count;
			break;
		case 5  :
			print "^xF33";
			++$color_count;
			break;
		case 6 :
			print "^xF76";
			++$color_count;
			break;
		case 7 :
			print "^xF77";
			++$color_count;
			break;
		case 8 :
			print "^xFAA";
			++$color_count;
			break;
		case 9 :
			print "^xFEE";
			++$color_count;
			break;
		#reverse color
		case 10 :#same as 8
			print "^xFAA";
			++$color_count;
			break;
		case 11 :#same as 7
			print "^xF77";
			++$color_count;
			break;
		case 12 :#same as 6
			print "^xF76";
			++$color_count;
			break;
		case 13 :#same as 5
			print "^xF33";
			++$color_count;
			break;
		case 14 :#same as 4
			print "^xF21";
			++$color_count;
			break;
		case 15 :#same as 3
			print "^xE20";
			++$color_count;
			break;
		case 16 :#same as 2
			print "^xA10";
			$color_count = 1;
			break;
		default:
			break;
		}
	}
	else
	{
		$space = 0;
	}
		
	if(strcmp($char, "\$") == 0)
	{
		$prev_char="\$";
		continue;
	}

	if(strcmp($prev_char , "\$") == 0)
	{
	
		if( strcmp($char , "{") == 0)
		{
			break;
		}
		else
		{
			print "$prev_char";
			$prev_char = "x";
		}
	}

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


function TrimAlreadyExistingColorCodes($say){
	$trimmed_char = " ";
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
				$position_B =$stringlength;
				$color_code_position = 0;
			}
				
		}
	}
	
	$trimmed_char = $trimmed_char.substr($say, $position_A, $position_B - $position_A);
	return $trimmed_char;
}

?>
