<?php

namespace HeroesOfLegend;

/* XXX "reroll conflicting results" (easier said than done) */
/* XXX gender? */

return new NamedTable("750", "Other", DiceRoller::from("d20"), [
	"1" => [ "Government official", Invoker("752") ], /* XXX not always applicable for low CuMods */
	"2" => "Friend (possibly companion, GM decides)",
	"3" => "Outcast (beggar, hermit, leper, prostitute, etc.)",
	"4" => [ "Wielder of magic:", function(State $s) {
		/* XXX not always applicable for low CuMods */
		LineAdder([
			/* Hahaha. Very funny, book. */
			"A wondrous wizard", "An amazing alchemist",
			"A powerful priest", "A daring druid",
		][Roll("d4-1")])($s);
		}],
	"5" => "Mentor (wise person who guides character)",
	"6" => "Thief",
	"7" => [ "Noble person", Invoker("758") ],
	"8" => [ "Monster", Invoker("756") ],
	"9" => "Neighbor (GM decides)",
	"10" => "Character's lover", /* XXX not always applicable */
	"11" => [ "Someone known primarily by occupation", Invoker("420-423") ],
	"12" => "Wild animal (of choice)",
	"13" => "Invader (foreign warrior)",
	"14" => "Common soldier",
	"15" => [ "Criminal", Invoker("755") ],
	"16" => [ "Adventurer", Invoker("757") ],
	"17" => [ "Relative", Invoker("753") ],
	"18" => [ "Rival", Invoker("762") ],
	"19" => [ "Nonhuman", Invoker("751") ],
	"20" => [ "Several others together", Repeater(Roll("d3"), Invoker("750")) ], /* XXX reroll conflicts */
]);
