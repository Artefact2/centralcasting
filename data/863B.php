<?php

/* NB: book says to roll d10 but has no value for 8 */
$table = function($roll = null) use(&$s, &$table) {
	Table($s, "863B", "Jewelry", $roll ?? Roll(9), [
		"1" => "Amulet",
		"2" => "Necklace",
		"3" => "Earrings",
		"4" => "Tiara",
		"5" => "Torc (one piece neck ring)",
		"6" => "Arm band",
		"7" => "Ring",
		"8" => "Pin or brooch",
		"9" => [ "Extremely valuable piece", TableReroller($s, $table, Roller(8)) ],
	]);
};
$table();
