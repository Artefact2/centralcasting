<?php

/*<<< Name: Special Event of Childhood & Adolescence >>>*/

switch($s->char->ageRange) {
case Character::CHILD:
	Invoke($s, "216A");
	break;

case Character::ADOLESCENT:
	Invoke($s, "216B");
	break;

default:
	assert(false);
}
