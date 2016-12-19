<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "863", "Gift or Legacy", $roll ?? Roll(20), [
		"1" => [ "Weapon", function() use(&$s) {
				/* NB: book says to roll d10 but has no value for 8 */
				Table($s, "863W", "Weapon", Roll(9), [
					"1" => "Ornate dagger",
					"2" => "Ornate sword",
					"3" => "Plain sword",
					"4" => "Mace",
					"5" => "Ornate spear",
					"6" => "Well-made bow",
					"7" => "Ornate battle axe",
					"8" => "Exotic weapon (GM choice)",
					"9" => "Anachronistic weapon (gun, laser rifle, flint handaxe, etc.)",
				]);
			}],
		"2" => [ "Guardianship of a young NPC ward", function() use(&$s) { Invoke($s, "761"); }],
		"3" => [ "Unusual pet", function() use(&$s) {
				/* XXX 760 */
			}],
		"4" => [ "Piece of jewelry", function() use(&$s) {
				/* NB: book says to roll d10 but has no value for 8 */
				$subtable = function($roll = null) use(&$s, &$subtable) {
					Table($s, "863J", "Jewelry", $roll ?? Roll(9), [
						"1" => "Amulet",
						"2" => "Necklace",
						"3" => "Earrings",
						"4" => "Tiara",
						"5" => "Torc (one piece neck ring)",
						"6" => "Arm band",
						"7" => "Ring",
						"8" => "Pin or brooch",
						"9" => [ "Extremely valuable piece", function() use(&$s, &$subtable) {
								$subtable(Roll(8));
							}],
					]);
				};
				$subtable();
			}],
		"5" => "Tapestry",
		"6" => "Anachronistic device (flashlight, sewing machine, Tardis, etc.)",
		"7" => "Key",
		"8" => "Locked or sealed book",
		"9" => "Shield",
		"10" => "Sealed bottle",
		"11" => "Tarnished old helmet",
		"12" => "Bound wooden staff",
		"13" => "Riding animal (horse, etc.)",
		"14" => [ "Deed to a property", function() use(&$s) {
				/* NB: book says to roll d10 but has no value for 8 */
				Table($s, "863D", "Property deed", Roll(9), [
					"1" => "Tract of land in the country",
					"2" => "Ancient castle",
					"3" => "Country manor",
					"4" => "Elegant town house",
					"5" => "Temple",
					"6" => "Factory",
					"7" => "Ancient ruins",
					"8" => "Inn",
					"9" => "Apartment building",
				]);
			}],
		"15" => "Musical instrument",
		"16" => [ "Piece of clothing", function() use(&$s) {
				$subtable = function($roll = null) use(&$s, &$subtable) {
					Table($s, "863C", "Piece of clothing", $roll ?? Roll(8), [
						"1" => "Hat",
						"2" => "Pair of shoes",
						"3" => "Belt",
						"4" => "Cape",
						"5" => "Tunic",
						"6" => "Trousers",
						"7" => "Pair of stockings or hose",
						"8" => [ "Part(s) of a set or costume", function() use(&$s, &$subtable) {
								$pieces = Roll(4);
								for($i = 0; $i < $pieces; ++$i) $subtable(Roll(7));
							}],
					]);
				};
				$subtable();
			}],
		"17" => [ "Pouch of papers containing...", function() use(&$s) {
				$subtable = function($roll = null) use(&$s, &$subtable) {
					Table($s, "863P", "Piece of clothing", $roll ?? Roll(10), [
						"1" => "Ancient ancestor's letter to his descendants",
						"2" => "Map",
						"3" => "Undelivered letter",
						"4" => "Diagrams and plans for a mysterious invention",
						"5" => "Scroll of magic spells",
						"6" => "Wild story of adventure",
						"7" => "Last will and testament, character is an heir",
						"8" => "Treasure map",
						"9" => "Character's true (and colorful) family history",
						"10" => [ null, function() use(&$s, &$subtable) {
								$papers = Roll(3);
								for($i = 0; $i < $papers; ++$i) $subtable(Roll(9));
							}],
					]);
				};
				$subtable();
			}],
		"18" => [ "Sealed trunk", function() use(&$s, &$table) {
				if(Roll(100) > 60) return "Sealed trunk (empty)";
				$more = Roll(3) + 1;
				for($i = 0; $i < $more; ++$i) {
					do {
						$roll = Roll(20);
					} while($roll === 18);
					$table($roll);
				}
				return "Sealed trunk containing...";
			}],
		"19" => "Chain mail hauberk",
		"20" => [ "Magic and great plot significance version of...", function() use(&$s, &$table) {
				$table(Roll(19));
			}],
	]);
};
$table();
