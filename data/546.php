<?php

namespace HeroesOfLegend;

SubentryCreator(
	"546", "Death of Parent or Guardian", null,
	function(State $s) {
		$ac = $s->getActiveCharacter();
		$m = $ac->hasMother();
		$f = $ac->hasFather();
		$g = $ac->hasGuardian();

		if($m && $f) {
			if(Roll("d2") === 1) {
				$ac->getMother()->kill();
				LineAdder("Mother dies")($s);
			} else {
				$ac->getFather()->kill();
				LineAdder("Father dies")($s);
			}
			LineAdder("Other remaining parent remains in possession of any property and most of the money")($s);
		} else if($m) {
			$ac->getMother()->kill();
			LineAdder("Mother dies")($s);
		} else if($f) {
			$ac->getFather()->kill();
			LineAdder("Father dies")($s);
		} else if($g) {
			$ac->getGuardian()->kill();
			LineAdder("Guardian dies")($s);
		} else {
			fixme("consistency", "no parent or guardian left");
			LineAdder("<<<No parent or guardian to kill?!>>>")($s);
		}
		
		$s->invoke("546A", "546B");
	}
)($s);
