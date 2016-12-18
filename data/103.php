<?php

$s->char->SolMod = 0;
$s->char->TiMod = 0;

if(Roll(1, 100) + $s->char->CuMod >= 99) {
	Invoke($s, "758");
	$s->char->SolMod += 5;
}

$table = function($roll = null) use(&$s, &$table) {
	$TiMod = Roll(1, 100) >= 95 ? 0 : $s->char->TiMod;
	
	Table($s, "103", "Social Status", ($roll ?? (Roll(1, 100) + $s->char->CuMod)) + $TiMod, [
		"-12" => [ "Destitute", function() use(&$s) { $s->char->SolMod += -3; } ],
		"13-40" => [ "Poor", function() use(&$s) { $s->char->SolMod += -1; } ],
		"41-84" => "Comfortable",
		"85" => [ null, function() use(&$s, &$table) { $table(Roll(1, 100)); } ],
		"86-94" => [ "Well-to-Do", function() use(&$s) { $s->char->SolMod += 2; } ],
		"95-98" => [ "Wealthy", function() use(&$s) {
				$s->char->SolMod += 4;
				if(Roll(1, 100) <= $s->char->TiMod + 1) {
					$s->char->SolMod += 4;
					return "Extremely Wealthy";
				}
			} ],
		"99-" => [ null, function() use(&$s, &$table) { $table(); } ],
	]);
};
$table();
