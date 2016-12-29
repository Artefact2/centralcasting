<?php

namespace HeroesOfLegend;

SubentryCreator("216", "Special Event Age Check", null, function(State $s) {

	switch($s->getActiveCharacter()->getAgeRange()) {
	case Character::CHILD:
		$s->invoke("216A");
		break;

	case Character::ADOLESCENT:
		$s->invoke("216B");
		break;

	case Character::ADULT:
		break;

	default:
		assert(false);
	}
})($s);
