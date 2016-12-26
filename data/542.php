<?php

namespace HeroesOfLegend;

SubentryCreator(
	"542", "Ah Love!", null,
	Repeater(Roll("d3"), function(State $s) {
		$ac = $s->getActiveCharacter();
		if(!$ac->hasSpouse()) return;
		$s->invoke("542A");
		$c = $ac->getActiveEntry()->getChildren();
		$lc = end($c);
		assert($lc instanceof Entry && $lc->getSourceID() === "542A");

		foreach($lc->getLines() as $line) {
			if(substr($line, -4) !== " (E)") continue;
			$lc->replaceLine($line, substr($line, 0, -4));
			$lc->addLine("And relationship was terminated");
			$ac->setSpouse(null);
		}
	})
)($s);
