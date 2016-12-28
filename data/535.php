<?php

namespace HeroesOfLegend;

SubentryCreator("535", "Military Experience", "Enlisted in military for 4 years", function(State $s) {
	$ac = $s->getActiveCharacter();
	$ac->setEnlistedInMilitary(true);
	
	$s->invoke("535A");
	$se = $ac->getActiveEntry()->getLatestChild();
	assert($se !== null && $se->getSourceID() === "535A");
	$service = $se->getLines()[0];
	
	if($ac->getMilitaryRank() === 0) {
		if($service[0] === "*") {
			if($ac->getModifier('TiMod') > 0) {
				/* Nobles in these branches are always officers */
				$s->invokeTable("538", new DiceRoller("d6+13"));
			} else {
				$s->invoke("538");
			}

			$se->replaceLine($service, $service = substr($service, 1));
		} else {
			$s->invoke("538");
		}
	}

	$s->invoke("877");

	if(Roll("d10") <= 8) {
		LineAdder("Army serves ruler of land")($s);
	} else {
		LineAdder("Army serves a patron")($s);
		$s->invoke("543");
	}

	Repeater(
		Roll("d3"),
		function(State $s) {
			if($s->getActiveCharacter()->isEnlistedInMilitary()) {
				$s->invoke("535B");
			}
		}
	)($s);
	
	/* XXX getting out has benefits */
	$ac->setEnlistedInMilitary(false);
})($s);
