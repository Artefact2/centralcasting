<?php

namespace HeroesOfLegend;

return new NamedTable("543A", "Who?", DiceRoller::from("d10"), [
	"1-2" => [ "Government official", Invoker("752") ],
	"3" => [ "Family member", Invoker("753") ], /* Book typo! (763) */
	"4" => [ "Nonhuman", Invoker("751") ],
	"5" => [ "Foreigner", Invoker("750") ],
	"6-7" => [ "Noble person", Invoker("758") ],
	"8-9" => [ "Head of craft guild", Invoker([
		"424A", "424B", "424C",
	][Roll("d3-1")])],
	"10" => function(State $s) {
		$r = Roll("d10");
		if($r === 10) {
			$s->invoke("864");
			return "Deity";
		}
		$s->invokeTable("543A", new TrivialRoller($r));
	},
]);
