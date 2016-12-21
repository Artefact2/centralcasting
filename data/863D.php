<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "863D", "Piece of clothing", $roll ?? Roll(8), [
		"1" => "Hat",
		"2" => "Pair of shoes",
		"3" => "Belt",
		"4" => "Cape",
		"5" => "Tunic",
		"6" => "Trousers",
		"7" => "Pair of stockings or hose",
		"8" => [ "Part(s) of a set or costume:", TableReroller($s, $table, Roller(7), Roll(4)) ],
	]);
};
$table();
