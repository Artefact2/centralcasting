<?php

$s->char->unusualBirthOccurences = 0;

Table($s, "112", "Unusual Birth", Roll(100) + $s->char->BiMod, [
	"-60" => null,
	"61-76" => [ null, function() use(&$s) { $s->char->unusualBirthOccurences = 1; }],
	"77-85" => [ null, function() use(&$s) { $s->char->unusualBirthOccurences = 2; }],
	"86-92" => [ "GM selects one unusual birth occurence", function() use(&$s) { $s->char->unusualBirthOccurences = 1; }],
	"93-94" => [ null, function() use(&$s) { $s->char->unusualBirthOccurences = 3; }],
	"95-97" => [ "GM selects", function() use(&$s) {
			$gmc = Roll(2);
			$s->char->unusualBirthOccurences = 3 - $gmc;
			return "GM selects $gmc unusual birth occurence(s)";
		}],
	"98" => [ null, function() use(&$s) { $s->char->unusualBirthOccurences = 4; }],
	"99-" => [ "GM selects", function() use(&$s) {
			$gmc = Roll(3);
			$s->char->unusualBirthOccurences = 4 - $gmc;
			return "GM selects $gmc unusual birth occurence(s)";
		}],
]);

while(--$s->char->unusualBirthOccurences >= 0) {
	/* XXX 113 */
	//Invoke($s, "113");
}
