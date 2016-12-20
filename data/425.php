<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "425", "Merchant", $roll ?? (Roll(20) + $s->char->SolMod), [
		"-0" => "Pawnshop",
		"1" => "Caravan master",
		"2" => "Trader",
		"3" => "Tavernkeeper",
		"4" => "Innkeeper",
		"5" => "Dry goods seller",
		"6" => "Curio merchant",
		"7" => "Snake oil salesman",
		"8" => "Book seller",
		"9" => "Clothing seller",
		"10" => "Weapon shop",
		"11" => "Fishmonger",
		"12" => "Green grocer",
		"13" => "Wine merchant",
		"14" => "Importer",
		"15" => "Furniture dealer",
		"16" => "Slaver",
		"17" => "Carpet and tapestries dealer",
		"18" => "Livestock trader",
		"19" => "Shipping agent",
		"20" => "Silk merchant",
		"21" => "Art dealer",
		"22" => "Gem merchant",
		"23" => "Real estate broker",
		"24" => "Lumber merchant",
		"25-28" => [ "Master merchant, runs several businesses below:",
		             TableReroller($s, $table, Roller(1, 20, $s->char->SolMod), Roll(6) + 1) ],
		"29-33" => [ "Monopoly (in large city or small country):", TableReroller($s, $table, Roller(1, 20, 4)) ],
	]);
};
$table();
