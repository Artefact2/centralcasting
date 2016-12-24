<?php

namespace HeroesOfLegend;

SubentryCreator("114", "Parents & NPCs", null, function(State $s) {
	$ac = $s->getActiveCharacter();
	if(!($ac->hasMother() || $ac->hasFather() || $ac->hasGuardian())) return;
	
	$s->invoke("114A");

	Repeater(Roll("d3"), $s->getActiveCharacter()->getType() === Character::PC ? function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->hasMother() && $ac->hasFather()) {
			$which = Roll("d6") <= 4 ? "head of household (usually Father)" : "other parent (usually Mother)";
			SubentryCreator("114Z", "To", $which, Invoker("114B"))($s);
		} else {
			$s->invoke("114B");
		}
	} : Invoker("114B"))($s);
})($s);
