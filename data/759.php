<?php

namespace HeroesOfLegend;

SubentryCreator(
	"759", "Unusual Pet", null,
	function(State $s) {
		$s->invoke("759A");

		if(Roll("d20") >= 15) {
			LineAdder("Special abilities of pet are unknown to character")($s);
		} else {
			$s->getActiveCharacter()->forgetVisitedTableRange("760", null);
			Repeater(Roll("d3"), Invoker("760"))($s);
		}
	}
)($s);
