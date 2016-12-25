<?php

namespace HeroesOfLegend;

/*<<< Name: Special Event of Childhood & Adolescence >>>*/

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
