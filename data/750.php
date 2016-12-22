<?php

/* XXX "reroll conflicting results" (easier said than done) */

$table = function($roll = null) use(&$s, &$table) {
	/* XXX m/f ? */
	Table($s, "750", "Other", $roll ?? Roll(20), [
		"1" => [ "Government official", Invoker($s, "752") ], /* XXX not always applicable for low CuMods */
		"2" => "Friend (possibly companion, GM decides)",
		"3" => "Outcast (beggar, hermit, leper, prostitute, etc.)",
		"4" => [ "Wielder of magic:", function() use(&$s) {
				$s->char->entries[] = [ "", "", [
					/* Hahaha. Very funny, book. */
					"A wondrous wizard", "An amazing alchemist",
					"A powerful priest", "A daring druid",
				][Roll(4) - 1] ];
				/* XXX not always applicable for low CuMods */
			}],
		"5" => "Mentor (wise person who guides character)",
		"6" => "Thief",
		"7" => [ "Noble person", Invoker($s, "758") ],
		"8" => [ "Monster", Invoker($s, "756") ],
		"9" => "Neighbor (GM decides)",
		"10" => "Character's lover", /* XXX not always applicable */
		"11" => [ "Someone known primarily by occupation", Invoker($s, "420-423") ],
		"12" => "Wild animal (of choice)",
		"13" => "Invader (foreign warrior)",
		"14" => "Common soldier",
		"15" => [ "Criminal", Invoker($s, "755") ],
		"16" => [ "Adventurer", Invoker($s, "757") ],
		"17" => [ "Relative", Invoker($s, "753") ],
		"18" => [ "Rival", Invoker($s, "762") ],
		"19" => [ "Nonhuman", Invoker($s, "751") ],
		"20" => [ "Several others together", Repeater(Roll(3), $table) ], /* XXX reroll conflicts */
	]);
};
$table();
