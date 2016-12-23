<?php

namespace HeroesOfLegend;

/*<<< Name: Occupation Check >>>*/

$cumod = $s->getActiveCharacter()->getModifier('CuMod');

/* Yes, -2, this is not a typo */
if($cumod <= -2) {
	/* Primitive */
	$s->invoke("420A");
} else if($cumod <= 0) {
	/* Nomad */
	$s->invoke("421A");
} else if($cumod <= 2) {
	/* Barbarian */
	$s->invoke("422A");
} else {
	/* Civilized */
	$s->invoke("423A");
}

$s->invoke("426");
