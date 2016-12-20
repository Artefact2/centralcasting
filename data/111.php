<?php

$table = function() use(&$s, &$table) {
	Table($s, "111", "Exotic Birth Location", Roll(20), [
		"1-2" => [ "Combine results below in a workable way", Combiner(
			CharIncrementer($s, "BiMod", 5),
			TableReroller($s, $table, null, 2)
		)],
		"3" => [ "Temple of good deity", Combiner(
			CharIncrementer($s, "BiMod", 15),
			Invoker($s, "864")
		)],
		"4" => [ "On the battlefield", function() use(&$s) {
				$s->char->BiMod += 8;
				return Roll(6) === 6 ? "On the battlefield" : "In camp following a battlefield";
			}],
		"5" => [ "Alley", CharIncrementer($s, "BiMod", 5) ],
		"6" => [ "Brothel (mother was not necessarily a prostitute)", CharIncrementer($s, "BiMod", 2) ],
		"7" => [ "Palace of local ruler (mayor, baron, etc.)", CharIncrementer($s, "BiMod", 2) ],
		"8" => [ "Palace of country ruler (king, emperor, etc.)", CharIncrementer($s, "BiMod", 5) ],
		"9" => [ "Palace of powerful evil person, ruler or creature", CharIncrementer($s, "BiMod", 15) ],
		"10" => [ "Bar, tavern or alehouse", CharIncrementer($s, "BiMod", 2) ],
		"11" => [ "Sewers", CharIncrementer($s, "BiMod", 10) ],
		"12" => [ "Thieves den", CharIncrementer($s, "BiMod", 5) ],
		"13" => [ "Home of friendly non-humans", Combiner(
			CharIncrementer($s, "BiMod", 2),
			Invoker($s, "751")
		)],
		"14" => [ "GM special 978#111", CharIncrementer($s, "BiMod", 25) ],
		"15" => [ "Temple of evil or malignant deity", Combiner(
			CharIncrementer($s, "BiMod", 20),
			Invoker($s, "864")
		)],
		"16" => [ "Other plane (soon transported after birth)", CharIncrementer($s, "BiMod", 15) ],
		"17" => [ "Other time period (soon transported after birth)", CharIncrementer($s, "BiMod", 10) ],
		"18" => [ "Ship at sea", CharIncrementer($s, "BiMod", 2) ],
		"19" => [ "Prison cell", CharIncrementer($s, "BiMod", 9) ],
		"20" => [ "Wizard's laboratory", CharIncrementer($s, "BiMod", 20) ],
	]);
};
$table();
