<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "870A", "Brain damage consequence", $roll ?? Roll(8), [
		"1" => "-".Roll(3)." Intelligence",
		"2" => "All skills lose one rank",
		"3" => [ null, function() use(&$s) { /* 649B */ } ],
		"4" => [ null, function() use(&$s) { /* 649A */ } ],
		"5" => "-".Roll(3)." Dexterity",
		"6" => "Increase one skill by ".Roll(8)." rank(s), all others lose d6 ranks",
		"7-8" => [ null, TableReroller($s, $table, Roller(6), Roll(3) + 1) ],
	]);
};
$table();
