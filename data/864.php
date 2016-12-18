<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "864", "Deity", $roll ?? (Roll(1, 20) + $s->char->CuMod), [
		"-1" => "Ancestor worship",
		"2" => "Beast gods",
		"3" => "Hunting god",
		"4" => "Trickster",
		"5-6" => "Earth goddess (Mother Earth)",
		"7-8" => "Agricultural goddess",
		"9-10" => "Ruling deity",
		"11" => "Sea (water) god",
		"12" => "Sun (fire) god",
		"13" => "Moon goddess",
		"14" => "Storm (air) god",
		"15" => [ "Evil god (see below)", function() use(&$s, &$table) {
				do {
					$reroll = Roll(1, 20) + $s->char->CuMod;
				} while($reroll === 15);
				$table($reroll);
			}],
		"16" => "War god",
		"17" => "Love goddess",
		"18" => "Underworld deity",
		"19" => "God of wisdom and knowledge",
		"20" => "Healing god",
		"21" => "Trade god",
		"22" => "Luck goddess",
		"23" => "Night goddess",
		"24" => "God of thieves",
		"25-" => [ "Decadent god (see below)", function() use(&$s, &$table) {
				$reroll = Roll(1, 20) + $s->char->CuMod;
				if($reroll >= 25) return "Disguised evil god";
				else $table($reroll);
			}],
	]);
};
$table();
