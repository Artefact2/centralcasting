<?php

namespace HeroesOfLegend;

SubentryCreator("530-533", "Race Event Check", null, function(State $s) {
	$race = $s->getActiveCharacter()->getRootEntry()->findDescendantByID("101");
	if($race === null) $race = "Human";
	else $race = $race->getLines()[0];

	switch($race) {
	case "Elf":
		$s->invoke("530");
		break;

	case "Dwarf":
		$s->invoke("531");
		break;

	case "Halfling":
		$s->invoke("532");

	case "Human":
	case "Half Elf":
		LineAdder("Encounter (and befriend) nonhumans:")($s);
		$s->invoke("751");
		break;

	default:
		/* XXX may be inaccurate, are other races considered monsters? */
		$s->invoke("533");
		break;
	}
})($s);
