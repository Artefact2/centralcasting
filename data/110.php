<?php

namespace HeroesOfLegend;

return new NamedTable("110", "Place of Birth", DiceRoller::from("d20+LegitMod"), [
	"1-6" => [ "In character's family home", ModifierIncreaser("BiMod", -5) ],
	"7-9" => [ "In hospital or healers guild hall", ModifierIncreaser("BiMod", -7) ],
	"10" => [ "In carriage while travelling", ModifierIncreaser("BiMod", 1) ],
	"11" => [ "In common barn", ModifierIncreaser("BiMod", 1) ],
	"12-13" => [ "In a foreign land", Combiner(
		ModifierIncreaser("BiMod", 2),
		TableInvoker("110", new RerollFilter(DiceRoller::from("d20+LegitMod"), function($r) {
			return !in_array($r, [ 12, 13 ], true);
		}))
	)],
	"14" => [ "In cave", ModifierIncreaser("BiMod", 5) ],
	"15" => [ "In middle of field", ModifierIncreaser("BiMod", 1) ],
	"16" => [ "In forest", ModifierIncreaser("BiMod", 2) ],
	"17-24" => [ "Exotic location", Invoker("111") ],
]);
