<?php

$s->char->LegitMod = 0;

$illegit = function() use(&$s) {
	$s->char->LegitMod = Roll(1, 4);
	if($s->char->SolMod >= 0) {
		$s->char->SolMod -= $s->char->LegitMod;
	}

	$s->char->TiMod = 0;

	Invoke($s, "105");
};

Table($s, "104", "Birth Legitimacy", ($roll = Roll(1, 20)) + $s->char->CuMod, [
	"-18" => [ "Legitimate", function() use(&$s, $roll, &$illegit) {
			if($roll === 20) {
				/* An unmodified roll of 20 means that the character
				 * is not considered legitimate. */
				$illegit();
				return "Illegitimate";
			}
		} ],
	"19-" => [ "Illegitimate", $illegit ],
]);
