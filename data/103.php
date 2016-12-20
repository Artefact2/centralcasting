<?php

if(Roll(100) + $s->char->CuMod >= 99) {
	Invoke($s, "758");
	$s->char->SolMod += 5;
}

$table = function($roll = null) use(&$s, &$table) {
	$TiMod = Roll(100) >= 95 ? 0 : $s->char->TiMod;
	
	Table($s, "103", "Social Status", ($roll ?? (Roll(100) + $s->char->CuMod)) + $TiMod, [
		"-12" => [ "Destitute", CharIncrementer($s, "SolMod", -3) ],
		"13-40" => [ "Poor", CharIncrementer($s, "SolMod", -1) ],
		"41-84" => "Comfortable",
		"85" => [ null, TableReroller($s, $table, Roller(100)) ],
		"86-94" => [ "Well-to-Do", CharIncrementer($s, "SolMod", 2) ],
		"95-98" => [ "Wealthy", function() use(&$s) {
				$s->char->SolMod += 4;
				if(Roll(100) <= $s->char->TiMod + 1) {
					$s->char->SolMod += 4;
					return "Extremely Wealthy";
				}
			} ],
		"99-" => [ null, TableReroller($s, $table) ],
	]);
};
$table();
