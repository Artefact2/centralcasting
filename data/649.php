<?php

namespace HeroesOfLegend;

SubentryCreator("649", "Exotic Feature (Optional)", null, Invoker("649A"), function(State $s) {
	/* Remove useless 649A child */
	$ac = $s->getActiveCharacter();
	$ae = $ac->getActiveEntry();

	foreach($ae->getChildren() as $c) {
		assert($c->getSourceID() === "649A");
		foreach($c->getChildren() as $ch) {
			$ae->appendChild($ch);
		}
		assume($ae->removeChild($c) === true);
	}
})($s);
