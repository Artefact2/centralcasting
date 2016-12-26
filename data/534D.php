<?php

namespace HeroesOfLegend;

return new NamedTable("534D", "Pirate Event", DiceRoller::from("d10"), [
	"1" => [ "Pirate captain buries his treasure on deserted island",
	         LineAdder("And character thinks it's still there") ],
	"2" => [ "Pirate crew is captured and are hung (except character)",
	         LineAdder("Character escapes captivity and vows to give up crime forever") ],
	"3" => "Character learns how to sail a big ship (".Roll("d4+1")." rank(s))",
	"4" => [ "Pirate crew mutinies and character is voted new captain",
	         LineAdder("But old captain escaped and vows revenge on the mutineers") ],
	"5" => [ "Parites discover lost island with mysterious temple", Combiner(
		LineAdder("All crew members are cursed, takes effect once a month"),
		LineAdder("To lift curse, find temple again and make sacrifices (GM decides)"),
		Invoker("868")
	)],
	"6" => "Old salt teaches character about cutlass use (+2 ranks)",
	"7" => "Raid on large treasure ship gives character ".Roll("d6*1000")." gp treasure",
	"8" => [ "Pirate captain is a woman known for taking revenge on male captives and has exotic personality", Invoker("649") ],
	"9" => [ "Character travels widely and learn ".Roll("d6+1")." foreign languages at rank 1",
	         LineAdder("(Just enough to order a drink or buy a sword)") ],
	"10" => "Character becomes captain's officer and learns location of many rival pirate fortresses",
]);
