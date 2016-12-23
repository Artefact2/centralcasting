<?php

namespace HeroesOfLegend;

$nt = new NamedTable("539B", "Freedom consequence", DiceRoller::from("d10"), [
	"1" => [ "Befriended by owner", SubtableInvoker(DiceRoller::from("d8"), [
		"1-4" => "Owner becomes good friend",
		"5-7" => [ "Owner becomes patron", Invoker("543") ],
		"8" => [ "Owner becomes companion", Invoker("761C") ],
	])],
	"2" => [ "Owner converted to religion that abhors slavery", LineAdder("Get paid ".Roll("2d10")." gp and set free") ],
	"3-4" => "Reunited with relatives, including former enslaved relatives",
	"5" => "Owner dies, will says to free slaves and divide property (".Roll("2d10")." other slaves)",
	"6-7" => [ "Unable to find work and enlisted in the military", Invoker("535") ],
	"8" => [ "Another slave remains as companion", Invoker("761C") ],
	"9" => [ "Saved owner's life, freed and got gift as reward", Invoker("863") ],
	"10" => Repeater(Roll("d3"), TableInvoker("539B", DiceRoller::from("d9"))),
]);

$nt->addPostExecuteHook(function(State $s) {
	$s->getActiveCharacter()->free();
});

return $nt;
