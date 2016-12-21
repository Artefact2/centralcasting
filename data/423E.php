<?php

Table($s, "423E", "Special Occupation", Roll(20), [
	"1" => "Assassin (works secretly)",
	"2" => "Gladiator (professional killer, works in public)",
	"3" => [ "Adventurer", Invoker($s, "757") ],
	"4" => [ "Career criminal", Invoker($s, "755") ],
	"5" => [ "Priest", Combiner(Invoker($s, "864"), Invoker($s, "541B")) ],
	"6" => "Wizard (might be charlatan)",
	"7" => [ "Jack of all trades (rank 2 in following occupations)", Repeater(Roll(3) + 1, Invoker($s, "423A")) ],
	"8" => "Entertainer (bard, minstrel, skald, juggler, actor, tumbler, etc.)",
	"9" => "Printer (prints books)",
	"10" => [ "Private detective/spy", Invoker($s, "534") ],
	"11" => [ "Professional (guild) thief", Invoker($s, "534") ],
	"12" => "Astrologer/diviner/fortune teller (might be priest)",
	"13" => "Rumormonger (collects and spreads information for a price, also a story teller)",
	"14" => [ "Prophet (speaks for a god, not necessarily a priest)", Combiner(
		Invoker($s, "541B"),
		EntryAdder($s, [
			"Doomsayer (-".Roll(3)." social status)",
			"Oracle (sees word of god in vapors of burnt offering".(Roll(2) === 1 ? ', not right in the head' : '').")",
			"Hermit (reclusive holy man, can foresee future, often denounces actions of others)",
			"Seer (religious fortune teller, sees future through his god for a price)",
		][Roll(4) - 1])
	)],
	"15" => "Chariot/horse racer",
	"16" => "Professional gambler",
	"17" => "Healer/herbalist (uses plants and plant lore to heal wounds/illnesses)",
	"18" => "Scientist (biologist, geologist, astronomer, etc. rarely believes in gods)",
	"19" => "Veterinarian",
	"20" => "Ship builder",
]);
