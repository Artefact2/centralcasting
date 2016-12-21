<?php

Table($s, "216A", "Special Event of Childhood", Roll(20), [
	"1" => "Kindly neighbor schools character, +1 rank in own language literacy",
	"2" => [ "Become emotionally attached to a toy, cannot bear to depart from it for ".Roll(2, 10)." years", RandomTrait($s) ],
	"3" => "Character collects things (petty rocks, animal skulls, dolls, sticks, leaves, etc.)",
	"4" => [ "Close friendship with a sibling (or cousin), either next oldest or next youngest", LightsideTrait($s) ],
	"5" => [ "Character has imaginary friend", RandomTrait($s) ],
	"6" => [ "Character is child prodigy at an unusual skill, rank 6 at:", Invoker($s, "876") ],
	"7" => "Character learns use of a weapon (of choice, rank 1, culture appropriate)",
	"8" => "Character and friend discover a secret hiding place near home (still there as an adult)",
	"9" => "Character becomes proficient (rank 3) at sporting event (track and field or ball game)",
	"10" => [ "Old warrior and friend of family tells the character grand tales of adventure", LightsideTrait($s) ],
	"11" => [ "Character becomes well-known/famous for event:", Combiner(RandomTrait($s), Invoker($s, "215")) ],
	"12" => [ "Grandparent dies in presence of character", Combiner(
		RandomTrait($s),
		EntryAdder($s, Roll(10) >= 8 ? 'And entrusts character with a secret (GM decides)' : null)
	)],
	"13" => [ "Character witnesses crime committed by ".Roll(4)." person(s) and is seen by them", Combiner(RandomTrait($s), Invoker($s, "875")) ],
	"14" => [ "Race-specific event", Combiner(NeutralTrait($s), Invoker($s, "530-533")) ],
	"15" => [ "Exotic event occurs", Combiner(RandomTrait($s), Invoker($s, "544")) ],
	"16" => [ "Characters discovers a near-exact twin noble", Combiner(RandomTrait($s), Invoker($s, "758")) ],
	"17" => [ "Tragedy occurs", Combiner(DarksideTrait($s), Invoker($s, "528")) ],
	"18" => [ "Something wonderful occurs", Combiner(LightsideTrait($s), Invoker($s, "529")) ],
	"19" => [ null, Invoker($s, "216B") ],
	"20" => [ "Character acquires hobby", Invoker($s, "427") ],
]);
