<?php

namespace HeroesOfLegend;

return new NamedTable("537", "Special Force", new DiceRoller("d10"), [
	"1-2" => [ "Medium Infantry: ranger (wilderness master, can operate behind enemy lines)", Combiner(
		LineAdder("Gain 1 rank of wilderness survival every 2 years of service"),
		LineAdder("Learn ".Roll("d4")." more combat skill(s) of choice (877)")
	)],
	"3-4" => [ "Light Infantry: scout (wilderness master, non-combat information gathering behind enemy lines)", Combiner(
		LineAdder("Gain 1 rank of wilderness survival every 2 years of service"),
		LineAdder("Learn ".Roll("d2")." more combat skill(s) of choice (877)")
	)],
	"5" => [ "Heavy Infantry: monster squad (specially trained to fight unnatural enemies)", Combiner(
		LineAdder("Learn ".Roll("d4")." more combat skill(s) of choice (877)"),
		LineAdder("Encounter monsters (756) every 2 years of service")
	)],
	"6-7" => [ "Medium Infantry: marine (trained for ship to ship/shore fighting)",
	           LineAdder("Learn ".Roll("d4")." more combat skill(s) of choice (877)") ],
	"8" => [ "Medium Infantry: suicide squad (missions with high risk of dying)",
	           LineAdder("Learn ".Roll("d4")." more combat skill(s) of choice (877)") ],
	"9" => "War machines (design, build and use catapults, onagers, ballista etc.)",
	"10" => [ "Light Infantry: espionage (infiltrate enemy and get key information)", Combiner(
		LineAdder("Learn 1 more combat skill of choice (877)"),
		LineAdder("Gain ".Roll("d4+1")." rank(s) in disguise, ".Roll("d4")." rank(s) in thieving skills")
	)],
]);
