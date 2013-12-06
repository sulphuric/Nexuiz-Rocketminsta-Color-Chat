#created by NARKASUR aka H2SO4 on 2013/12/06
#!"--SomePath--\xampp\perl\bin\perl.exe"

    local ($buffer, @pairs, $pair, $name, $value, %FORM);
    # Read in text
    $ENV{'REQUEST_METHOD'} =~ tr/a-z/A-Z/;
    if ($ENV{'REQUEST_METHOD'} eq "GET")
    {
	$buffer = $ENV{'QUERY_STRING'};
    }
    # Split information into name/value pairs
    @pairs = split(/&/, $buffer);
    foreach $pair (@pairs)
    {
	($name, $value) = split(/=/, $pair);
	$value =~ tr/+/ /;
	$value =~ s/%(..)/pack("C", hex($1))/eg;
	$FORM{$name} = $value;
    }
    $say = $FORM{say};




$length = length($say);


print "Content-type:text\r\n\r\n";
print "set speak_var ";
$color_count = 1;


my $char = "defaulttext";
my $trimmed_char = "";
print "\"";
$space = 0;
TrimAlreadyExistingColorCodes();



for($i = 0; $i <$length; ++$i)
{
	$char = substr($trimmed_char, $i,1);
	if($char eq " ")
	{
		$space = 1;
	}
	if($space == 0) {
		if($color_count == 1 )
		{
			print "^x700";
			++$color_count;
		}
		elsif($color_count == 2 )
		{
			print "^xA10";
			++$color_count;
		}
		elsif($color_count == 3 )
		{
			print "^xE20";
			++$color_count;
		}
		elsif($color_count == 4 )
		{
			print "^xF21";
			++$color_count;
		}
		elsif($color_count == 5  ) 
		{
			print "^xF33";
			++$color_count;
		}
		elsif($color_count == 6 ) 
		{
			print "^xF76";
			++$color_count;
		}
		elsif($color_count == 7 ) 
		{
			print "^xF77";
			++$color_count;
			
		}
		elsif($color_count == 8 )
		{
			print "^xFAA";
			++$color_count;
		}
		elsif($color_count == 9 )
		{
			print "^xFEE";
			++$color_count;
		}
		#reverse color
		elsif($color_count == 10 )#same as 8
		{
			print "^xFAA";
			++$color_count;
		}
			elsif($color_count == 11 )#same as 7
		{
			print "^xF77";
			++$color_count;
		}
			elsif($color_count == 12 )#same as 6
		{
			print "^xF76";
			++$color_count;
		}
			elsif($color_count == 13 )#same as 5
		{
			print "^xF33";
			++$color_count;
		}
			elsif($color_count == 14 )#same as 4
		{
			print "^xF21";
			++$color_count;
		}
			elsif($color_count == 15 )#same as 3
		{
			print "^xE20";
			++$color_count;
		}
			elsif($color_count == 16 )#same as 2
		{
			print "^xA10";
			$color_count = 1;
		}
	}
	else
	{
		$space = 0;
	}
	
	if($char eq "\$")
	{
		$prev_char="\$";
		next;
	}
	
	if($prev_char eq "\$")
	{
	
		if( $char eq "{")
		{
			last;
		}
		else
		{
			print "$prev_char";
			$prev_char = "x";
		}
	}
	
		if($char eq "A"){
		print "á";}
		elsif($char eq "B"){
		print "â";}
		elsif($char eq "C"){
		print "ã";}
		elsif($char eq "D"){
		print "ä";}
		elsif($char eq "E"){
		print "å";}
		elsif($char eq "F"){
		print "æ";}
		elsif($char eq "G"){
		print "ç";}
		elsif($char eq "H"){
		print "è";}
		elsif($char eq "I"){
		print "é";}
		elsif($char eq "J"){
		print "ê";}
		elsif($char eq "K"){
		print "ë";}
		elsif($char eq "L"){
		print "ì";}
		elsif($char eq "M"){
		print "í";}
		elsif($char eq "N"){
		print "î";}
		elsif($char eq "O"){
		print "ï";}
		elsif($char eq "P"){
		print "ð";}
		elsif($char eq "Q"){
		print "ñ";}
		elsif($char eq "R"){
		print "ò";}
		elsif($char eq "S"){
		print "ó";}
		elsif($char eq "T"){
		print "ô";}
		elsif($char eq "U"){
		print "õ";}
		elsif($char eq "V"){
		print "ö";}
		elsif($char eq "W"){
		print "÷";}
		elsif($char eq "X"){
		print "ø";}
		elsif($char eq "Y"){
		print "ù";}
		elsif($char eq "Z"){
		print "ú";}
		elsif($char eq  "0"){
		print "°";}
		elsif($char eq  "1"){
		print "±";}
		elsif($char eq  "2"){
		print "²";}
		elsif($char eq  "3"){
		print "³";}
		elsif($char eq  "4"){
		print "´";}
		elsif($char eq  "5"){
		print "µ";}
		elsif($char eq  "6"){
		print "¶";}
		elsif($char eq  "7"){
		print "·";}
		elsif($char eq  "8"){
		print "¸";}
		elsif($char eq  "9"){
		print "¹";}
		else
		{
			print "$char";
		}
	
}


print "\"";

use Scalar::Util qw(looks_like_number);

sub TrimAlreadyExistingColorCodes{
	
	$color_code_position = 0;
	$stringlength = length($say);
	$position_B = $stringlength;  # A........B..A............B
	$position_A = 0;  # A........^1.A............^xCF0.A......
	$position_B_memory = $position_B; #need to reset if color code verification fails
	for($j = 0; $j <$length; ++$j)
	{
		$temp_char = substr($say, $j,1);
		
		if($temp_char eq "^")
		{
			$color_code_position  = 1 ;
		}
		elsif($color_code_position == 1 )
		{
		
			if($temp_char <= 9 && $temp_char >=0 && looks_like_number($temp_char))
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
			elsif ($temp_char eq x)
			{
				$color_code_position  = 2;
			}
			else
			{
				$color_code_position = 0;
	
			}
			
		}
		elsif($color_code_position == 2 || $color_code_position == 3 || $color_code_position == 4 || $color_code_position == 5)
		{
		
			if( (0 <= $temp_char && $temp_char <= 9 && looks_like_number($temp_char)) || $temp_char eq "A" || $temp_char eq "B" || $temp_char eq "C"|| $temp_char eq "D"|| $temp_char eq "E"|| $temp_char eq "F")
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
}
1;





