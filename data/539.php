<?php

namespace HeroesOfLegend;

/* XXX: generate owner */
/* XXX: occupation */
/* XXX: social status */

$s->getActiveCharacter()->setEnslaved(true);

SubentryCreator(
	"539", "Enslaved!", "for ".Roll("d6")." year(s) (if applicable)",
	Repeater(Roll("d3"), Invoker("539D")),
	function(State $s) {
		$ac = $s->getActiveCharacter();
		while($ac->isEnslaved()) {
			$s->invokeTable("539D", DiceRoller::from("d4"));
		}
	}
)($s);
