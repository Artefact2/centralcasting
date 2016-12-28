<?php

namespace HeroesOfLegend;

return new NamedTable("864", "Deity", DiceRoller::from("d20+CuMod"), [
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
	"15" => [ "Evil version of god:", TableInvoker("864", new RerollFilter(DiceRoller::from("d20+CuMod"), function($r) {
		return $r !== 15;
	}))],
	"16" => "War god",
	"17" => "Love goddess",
	"18" => "Underworld deity",
	"19" => "God of wisdom and knowledge",
	"20" => "Healing god",
	"21" => "Trade god",
	"22" => "Luck goddess",
	"23" => "Night goddess",
	"24" => "God of thieves",
	"25-" => [ "Decadent version of god:", function(State $s) {
		$reroll = Roll("d20+CuMod", $s);
		if($reroll >= 25) {
			$s->invokeTable("864", new RerollFilter(DiceRoller::from("d20+CuMod"), function($r) {
				return $r < 25;
			}));
			return "Disguised evil version of god:";
		}
		$s->invokeTable("864", new TrivialRoller($reroll));
	}],
]);
