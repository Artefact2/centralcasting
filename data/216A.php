<?php

namespace HeroesOfLegend;

return new NamedTable("216A", "Special Event of Childhood", DiceRoller::from("d20"), [
	"1" => "Kindly neighbor schools character, +1 rank in own language literacy",
	"2" => [ "Become emotionally attached to a toy", Combiner(
		LineAdder("And cannot bear to depart from it for ".Roll("2d10")." years"),
		RandomTrait()
	)],
	"3" => "Character collects things (petty rocks, animal skulls, dolls, sticks, leaves, etc.)",
	"4" => [ "Close friendship with a sibling (or cousin), either next oldest or next youngest", LightsideTrait() ],
	"5" => [ "Character has imaginary friend", RandomTrait() ],
	"6" => [ "Character is child prodigy at an unusual skill, rank 6 at:", Invoker("876") ],
	"7" => "Character learns use of a weapon (of choice, rank 1, culture appropriate)",
	"8" => [ "Character and friend discover a secret hiding place near home", LineAdder("And it is still there as an adult") ],
	"9" => "Character becomes proficient (rank 3) at sporting event (track and field or ball game)",
	"10" => [ "Old warrior and friend of family tells the character grand tales of adventure", LightsideTrait() ],
	"11" => [ "Character becomes well-known/famous for event:", Combiner(RandomTrait(), Invoker("215")) ],
	"12" => [ "Grandparent dies in presence of character", Combiner(
		RandomTrait(),
		LineAdder(Roll("d10") >= 8 ? 'And entrusts character with a secret (GM decides)' : null)
	)],
	"13" => [ "Character witnesses crime committed by ".Roll("d4")." person(s)", Combiner(
		LineAdder("And is seen by them"),
		RandomTrait(),
		Invoker("875")
	) ],
	"14" => [ "Race-specific event", Combiner(NeutralTrait(), Invoker("530-533")) ],
	"15" => [ "Exotic event occurs", Combiner(RandomTrait(), Invoker("544")) ],
	"16" => [ "Characters discovers a near-exact twin noble", Combiner(RandomTrait(), Invoker("758")) ],
	"17" => [ "Tragedy occurs", Combiner(DarksideTrait(), Invoker("528")) ],
	"18" => [ "Something wonderful occurs", Combiner(LightsideTrait(), Invoker("529")) ],
	"19" => Invoker("216B"),
	"20" => [ "Character acquires hobby", Invoker("427") ],
]);
