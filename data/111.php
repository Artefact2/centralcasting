<?php

namespace HeroesOfLegend;

return new NamedTable("111", "Exotic Birth Location", DiceRoller::from("d20"), [
	"1-2" => [ "Combine results below in a workable way", Combiner(
		ModifierIncreaser("BiMod", 5),
		Repeater(2, Invoker("111"))
	)],
	"3" => [ "Temple of good deity", Combiner(
		ModifierIncreaser("BiMod", 15),
		Invoker("864")
	)],
	"4" => function(State $s) {
		$s->getActiveCharacter()->increaseModifier('BiMod', 8);
		return Roll("d6") === 6 ? "On the battlefield" : "In camp following a battlefield";
	},
	"5" => [ "Alley", ModifierIncreaser("BiMod", 5) ],
	"6" => [ "Brothel (mother was not necessarily a prostitute)", ModifierIncreaser("BiMod", 2) ],
	"7" => [ "Palace of local ruler (mayor, baron, etc.)", ModifierIncreaser("BiMod", 2) ],
	"8" => [ "Palace of country ruler (king, emperor, etc.)", ModifierIncreaser("BiMod", 5) ],
	"9" => [ "Palace of powerful evil person, ruler or creature", ModifierIncreaser("BiMod", 15) ],
	"10" => [ "Bar, tavern or alehouse", ModifierIncreaser("BiMod", 2) ],
	"11" => [ "Sewers", ModifierIncreaser("BiMod", 10) ],
	"12" => [ "Thieves den", ModifierIncreaser("BiMod", 5) ],
	"13" => [ "Home of friendly non-humans", Combiner(
		ModifierIncreaser("BiMod", 2),
		Invoker("751")
	)],
	"14" => [ "GM special 978#111", ModifierIncreaser("BiMod", 25) ],
	"15" => [ "Temple of evil or malignant deity", Combiner(
		ModifierIncreaser("BiMod", 20),
		Invoker("864")
	)],
	"16" => [ "Other plane (soon transported after birth)", ModifierIncreaser("BiMod", 15) ],
	"17" => [ "Other time period (soon transported after birth)", ModifierIncreaser("BiMod", 10) ],
	"18" => [ "Ship at sea", ModifierIncreaser("BiMod", 2) ],
	"19" => [ "Prison cell", ModifierIncreaser("BiMod", 9) ],
	"20" => [ "Wizard's laboratory", ModifierIncreaser("BiMod", 20) ],
]);
