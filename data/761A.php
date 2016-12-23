<?php

namespace HeroesOfLegend;

return new NamedTable("761A", "Who?", DiceRoller::from("d100"), [
	"1-11" => "Childhood friend",
	"12-22" => [ "Family member", Invoker("753") ],
	"23-33" => [ "Nonhuman", Invoker("751") ],
	"34-44" => [ "Stranger", Invoker("750") ],
	"45-55" => "Intelligent, articulate inanimate object (statue, magical item, etc.)",
	"56-66" => "Kid (".Roll("d6+6")." years old)",
	"67-77" => "A sibling (".(Roll("d2") === 1 ? 'older' : 'younger').")",
	"78-88" => [ "Adventurer", Invoker("757") ],
	"89-99" => [ "Former enemy or rival", Invoker("762") /* Another book typo! */ ],
	"100" => "GM special 978#761A",
]);
