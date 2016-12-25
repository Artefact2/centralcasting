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

		$r = Roll("d6");
		if($r === 6) $add = 2;
		else if($r >= 4) $add = -2;
		else $add = 0;
		
		ModifierIncreaser("CuMod", $add);
		Invoker("420-423");
		ModifierIncreaser("CuMod", -$add);
	}],
	"17-18" => [ "Both parents in household have an occupation", function(State $s) {
		$ac = $s->getActiveCharacter();
		if(!$ac->hasMother() || !$ac->hasFather()) {
			$s->invoke("114A");
			return '';
		}

		SubentryCreator("114Y", "Mother", null, Invoker("420-423"))($s);
		SubentryCreator("114Y", "Father", null, Invoker("420-423"))($s);
	}],
	"19" => [ "Head of household is/was an adventurer", Invoker("757") ],
	"20" => [ "Head of household has no visible occupation, money just seems to be available when needed",
	          LineAdder("See GM special 978#114")
	],
]);
