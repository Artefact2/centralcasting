<?php

namespace HeroesOfLegend;

return new NamedTable("423E", "Special Occupation", DiceRoller::from("d20"), [
	"1" => "Assassin (works secretly)",
	"2" => "Gladiator (professional killer, works in public)",
	"3" => [ "Adventurer", Invoker("757") ],
	"4" => [ "Career criminal", Invoker("755") ],
	"5" => [ "Priest", Invoker("864", "541B") ],
	"6" => "Wizard (might be charlatan)",
	"7" => [ "Jack of all trades (rank 2 in following occupations)", Repeater(Roll("d3+1"), Invoker("423A")) ],
	"8" => "Entertainer (bard, minstrel, skald, juggler, actor, tumbler, etc.)",
	"9" => "Printer (prints books)",
	"10" => [ "Private detective/spy", Invoker("534") ],
	"11" => [ "Professional (guild) thief", Invoker("534") ],
	"12" => "Astrologer/diviner/fortune teller (might be priest)",
	"13" => "Rumormonger (collects and spreads information for a price, also a story teller)",
	"14" => [ "Prophet (speaks for a god, not necessarily a priest)", Combiner(
		Invoker("541B"),
		SubtableInvoker(DiceRoller::from("d4"), [
			"1" => "Doomsayer (-".Roll("d3")." social status)",
			"2" => [ "Oracle (sees word of god in vapors of burnt offering", function(State $s) {
				if(Roll("d2") === 1) LineAdder("And is not right in the head")($s);
			}],
			"3" => "Hermit (reclusive holy man, can foresee future, often denounces actions of others)",
			"4" => "Seer (religious fortune teller, sees future through his god for a price)",
		])
	)],
	"15" => "Chariot/horse racer",
	"16" => "Professional gambler",
	"17" => "Healer/herbalist (uses plants and plant lore to heal wounds/illnesses)",
	"18" => "Scientist (biologist, geologist, astronomer, etc. rarely believes in gods)",
	"19" => "Veterinarian",
	"20" => "Ship builder",
]);
