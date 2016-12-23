<?php

namespace HeroesOfLegend;

return new NamedTable("114A", "Occupation", DiceRoller::from("d20"), [
	"1-12" => [ "Head of household has one occupation", Invoker("420-423") ],
	"13-14" => [ "Head of household has one full-time occupation and another part-time occupation", Combiner(
		LineAdder("Full-time occupation:"),
		Invoker("420-423"),
		LineAdder("Part-time occupation:"),
		ModifierIncreaser("CuMod", -2),
		Invoker("420-423"),
		ModifierIncreaser("CuMod", 2)
	)],
	"15-16" => [ "Head of household has no occupation, other parent works", function(State $s) {
		$ac = $s->getActiveCharacter();
		if(!$ac->hasMother() || !$ac->hasFather()) {
			$s->invoke("114A");
			return '';
		}

		$sub = 0;
			
		switch(Roll(6)) {
		case 6:
			$sub = -2;
			break;

		case 4:
		case 5:
			$sub = 2;
			break;
		}

		$s->char->CuMod -= $sub;
		Invoke($s, "420-423");
		$s->char->CuMod += $sub;
	}],
	"17-18" => [ "Both parents in household have an occupation", function(State $s) {
		$ac = $s->getActiveCharacter();
		if(!$ac->hasMother() || !$ac->hasFather()) {
			$s->invoke("114A");
			return '';
		}

		LineAdder("Mother:")($s);
		$s->invoke("420-423");
		LineAdder("Father:")($s);
		$s->invoke("420-423");
	}],
	"19" => [ "Head of household is/was an adventurer", Invoker("757") ],
	"20" => [ "Head of household has no visible occupation, money just seems to be available when needed",
	          LineAdder("See GM special 978#114")
	],
]);
