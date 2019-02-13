<?php
function findinside($start, $end, $string) {
    preg_match_all('/' . preg_quote($start, '/') . '([^\.)]+)'. preg_quote($end, '/').'/i', $string, $m);
	return $m[1];
}

### MONEY FORMATTER
function format_money($number) {
	$number=sprintf("%.2f", $number);
	$stringlength=strlen($number);
	if ($stringlength < 7) {return $number;}
	$number=substr($number,0,$stringlength-6).",".substr($number,$stringlength-6,6);
	return $number;
}
?>