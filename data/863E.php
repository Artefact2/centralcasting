<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "863E", "Paper", $roll ?? Roll(10), [
		"1" => "Ancient ancestor's letter to his descendants",
		"2" => "Map",
		"3" => "Undelivered letter",
		"4" => "Diagrams and plans for a mysterious invention",
		"5" => "Scroll of magic spells",
		"6" => "Wild story of adventure",
		"7" => "Last will and testament, character is an heir",
		"8" => "Treasure map",
		"9" => "Character's true (and colorful) family history",
		"10" => [ null, TableReroller($s, $table, Roller(9), Roll(3)) ],
	]);
};
$table();
