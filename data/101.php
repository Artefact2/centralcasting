<?php

namespace HeroesOfLegend;

return new NamedTable("101", "Character Race", DiceRoller::from("d20"), [
	"1-14" => "Human",
	"15-16" => "Elf",
	"17" => "Dwarf",
	"18" => "Halfling",
	"19" => [ "Crossbreed", function(State $s) {
		$s->invoke("101");
		$s->invoke("101");

		$ent = $s->getActiveCharacter()->getActiveEntry();
		$races = [];

		foreach($ent->getChildren() as $c) {
			$r = $c->getLines()[0];
			if($r === 'Other Race') {
				$r = $c->getChildren()[0]->getLines()[0];
			} else if(preg_match('%^(.+?) with (.+?) blood$%', $r, $m)) {
				$races[] = $m[1];
				$races = array_merge($races, explode(' and ', $m[2]));
			} else {
				$races[] = $r;
			}
			$ent->removeChild($c);
		}

		$races = array_unique($races);

		if(count($races) === 1) {
			if($races[0] === 'Human') {
				$races[] = 'Elf';
			} else {
				$races[] = $races[0];
			}
			$races[0] = 'Human';
		}

		$ent->appendChild(new Entry("101", "Racial mix", sprintf(
			"%d%%/%d%% (optional)",
			$bp = Roll("d10+9")*5,
			100 - $bp
		)));

		return sprintf('%s with %s blood', array_shift($races), implode(' and ', $races));
	}],
	"20" => [ "Other Race", Invoker("101B") ],
]);
