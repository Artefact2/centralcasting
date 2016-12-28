<?php

namespace HeroesOfLegend;

return new NamedTable("869", "Blessing", new DiceRoller("d20"), [
	"1" => Repeater(Roll("d4"), Invoker("647")),
	"2" => "+".Roll("d6")." Appearance",
	"3" => "Love affairs never end with death of lover (reroll deaths if necessary)",
	"4" => "Never fumbles any skill",
	"5" => "Character easily establishes rapport of trust, friendship or love with members of opposite sex",
	"6" => "Character has innate ability to sence presence of lycanthropy within 20 feet",
	"7" => [ "One body location (or pair) is incredibly beautiful, even legendary in its beauty", Invoker("867") ],
	"8" => "Character can onjy join good/lightside religions, all others will reject him",
	"9" => [ "Character gains unique talent", Invoker("869B") ],
	"10" => [ "Character is born with natural talent (rank 5)", SubtableInvoker(new DiceRoller("d6"), [
		"1" => "Weapon skill (of choice)",
		"2" => "Singing",
		"3" => "Artistic ability",
		"4" => "Money management",
		"5" => "Magic use",
		"6" => "Mechanical ability",
	])],
	"11" => "Character acts like a Good Luck Talisman (+1 skill ranks/roll bonus to friends within 20 feet)",
	"12" => [ "Character has phychic ability", Invoker("873") ],
	"13" => "Character is partially immune to evil creature attacks (-d3 ranks in evil creature attacks, 70% chance of doing min damage)",
	"14" => "Character is naturally lucky (".Roll("d3*5")."% more margin to pass saves/skill/combat rolls)",
	"15" => "Character is unaffected by disease",
	"16" => "Character is partially immune to magical effects (".Roll("d8*5")."% immunity)",
	"17" => "Character can turn undead (60% chance of d6 undead fleeing)",
	"18" => [ "Blessing balances out with a curse", Combiner(
		TableInvoker("869", new RerollFilter(new DiceRoller("d20"), function($r) { return $r !== 18; })),
		Invoker("868")
	)],
	"19" => "Character is a natural learner (learn all skills at 1 rank higher than normal)",
	"20" => [ "Combine blessings in a logical manner:", Repeater(Roll("d3"), Invoker("869")) ],
]);
