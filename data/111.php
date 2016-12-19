<?php

$table = function() use(&$s, &$table) {
	Table($s, "111", "Exotic Birth Location", Roll(20), [
		"1-2" => [ null, function() use(&$s, &$table) {
				$s->char->BiMod += 5;
				$table();
				$table();
			}],
		"3" => [ "Temple of good deity", function() use(&$s) {
				$s->char->BiMod += 15;
				Invoke($s, "864");
			}],
		"4" => [ "On the battlefield", function() use(&$s) {
				$s->char->BiMod += 8;
				return Roll(6) === 6 ? "On the battlefield" : "In camp following a battlefield";
			}],
		"5" => [ "Alley", function() use(&$s) { $s->char->BiMod += 5; } ],
		"6" => [ "Brothel (mother was not necessarily a prostitute)", function() use(&$s) { $s->char->BiMod += 2; } ],
		"7" => [ "Palace of local ruler (mayor, baron, etc.)", function() use(&$s) { $s->char->BiMod += 2; } ],
		"8" => [ "Palace of country ruler (king, emperor, etc.)", function() use(&$s) { $s->char->BiMod += 5; } ],
		"9" => [ "Palace of powerful evil person, ruler or creature", function() use(&$s) { $s->char->BiMod += 15; } ],
		"10" => [ "Bar, tavern or alehouse", function() use(&$s) { $s->char->BiMod += 2; } ],
		"11" => [ "Sewers", function() use(&$s) { $s->char->BiMod += 10; } ],
		"12" => [ "Thieves den", function() use(&$s) { $s->char->BiMod += 5; } ],
		"13" => [ "Home of friendly non-humans", function() use(&$s) {
				$s->char->BiMod += 2;
				Invoke($s, "751");
			}],
		"14" => [ "GM special 978#111", function() use(&$s) { $s->char->BiMod += 25; } ],
		"15" => [ "Temple of evil or malignant deity", function() use(&$s) {
				$s->char->BiMod += 20;
				Invoke($s, "864");
			}],
		"16" => [ "Other plane (soon transported after birth)", function() use(&$s) { $s->char->BiMod += 15; } ],
		"17" => [ "Other time period (soon transported after birth)", function() use(&$s) { $s->char->BiMod += 10; } ],
		"18" => [ "Ship at sea", function() use(&$s) { $s->char->BiMod += 2; } ],
		"19" => [ "Prison cell", function() use(&$s) { $s->char->BiMod += 9; } ],
		"20" => [ "Wizard's laboratory", function() use(&$s) { $s->char->BiMod += 20; } ],
	]);
};
$table();
