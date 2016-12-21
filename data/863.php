<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "863", "Gift or Legacy", $roll ?? Roll(20), [
		"1" => [ "Weapon", Invoker($s, "863A") ],
		"2" => [ "Guardianship of a young NPC ward", Invoker($s, "761") ],
		"3" => [ "Unusual pet", Invoker($s, "759") ],
		"4" => [ "Piece of jewelry", Invoker($s, "863B") ],
		"5" => "Tapestry",
		"6" => "Anachronistic device (flashlight, sewing machine, Tardis, etc.)",
		"7" => "Key",
		"8" => "Locked or sealed book",
		"9" => "Shield",
		"10" => "Sealed bottle",
		"11" => "Tarnished old helmet",
		"12" => "Bound wooden staff",
		"13" => "Riding animal (horse, etc.)",
		"14" => [ "Deed to a property", Invoker($s, "863C") ],
		"15" => "Musical instrument",
		"16" => [ "Piece of clothing", Invoker($s, "863D") ],
		"17" => [ "Pouch of papers containing...", Invoker($s, "863E") ],
		"18" => [ "Sealed trunk", function() use(&$s, &$table) {
				if(Roll(100) > 60) return "Sealed trunk (empty)";

				TableReroller($s, $table, Roller(20), Roll(3) + 1, [18])();
				return "Sealed trunk containing...";
			}],
		"19" => "Chain mail hauberk",
		"20" => [ "Magic and great plot significance version of...", TableReroller($s, $table, Roller(19)) ],
	]);
};
$table();
