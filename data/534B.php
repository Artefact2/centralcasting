<?php

namespace HeroesOfLegend;

return new NamedTable("534B", "Crime Type", DiceRoller::from("d6"), [
	"1" => "Petty theft (outside of any organised guild)",
	"2" => "Organised guild thievery (not a crime network, just stealing and smuggling)",
	"3" => [ "Organised crime (in an organised network, rules, morals etc)", Combiner(
		LineAdder("Character gains ".Roll("d4")." rank(s) in weapon of choice"),
		SubentryCreator("534Z", "Crimes Committed Regularly", null, Repeater(Roll("d4"), Invoker("875A")))
	)],
	"4" => [ "Independent criminal in a specialised activity", SubtableInvoker(DiceRoller::from("d10"), [
		"1" => "Prostitution",
		"2" => "Hired thug",
		"3" => "Burglary",
		"4" => "Smuggling",
		"5" => "Violating curfew",
		"6" => "Stealing livestock",
		"7" => "Selling drugs",
		"8" => "Robbing money lenders and stores",
		"9" => "Kidnapping",
		"10" => Repeater(Roll("d2+1"), function(State $s) use(&$spec) { $spec->execute($s); }),
	], RandomTable::REROLL_DUPLICATES, $spec)],
	"5" => [ "Piracy", Repeater(Roll("d3"), Invoker("534D")) ],
	"6" => "Banditry (part of a gang, roams countryside)",
]);
