<?php

namespace HeroesOfLegend;

SubentryCreator("540", "Imprisoned!", null, Combiner(
	function(State $s) {
		$s->getActiveCharacter()->setImprisoned(true);
		
		$aep = $s->getActiveCharacter()->getActiveEntry()->getParent();
		$c = $aep->getChildren();
		$lc = end($c);
		if($c instanceof Entry && in_array($c->getSourceID(), [ "875", "875A" ], true)
			|| in_array($aep->getSourceID(), [ "875", "875A" ], true)
		) {
			/* Already committed crime */
			return;
		}

		/* XXX may not always cause a prison sentence! */
		SubentryCreator("540Z", "For What?", null, Invoker("875A"))($s);
	},
	Repeater(Roll("d3"), function(State $s) {
		if($s->getActiveCharacter()->isImprisoned()) {
			$s->invoke("540A");
		}
	})
))($s);
