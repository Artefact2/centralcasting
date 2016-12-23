<?php

namespace HeroesOfLegend;

return new NamedTable("112", "Unusual Birth", DiceRoller::from("d100+BiMod"), [
	"-60" => null,
	"61-76" => Invoker("113"),
	"77-85" => Repeater(2, Invoker("113")),
	"86-92" => [ "GM selects one unusual birth occurence", Invoker("113") ],
	"93-94" => Repeater(3, Invoker("113")),
	"95-97" => function(State $s) {
		$gmc = Roll("d2");
		Repeater(3 - $gmc, Invoker("113"));
		return "GM selects $gmc unusual birth occurence(s)";
	},
	"98" => Repeater(4, Invoker("113")),
	"99-" => [ "GM selects", function(State $s) {
		$gmc = Roll("d3");
		Repeater(4 - $gmc, Invoker("113"));
		return "GM selects $gmc unusual birth occurence(s)";
	}],
]);
