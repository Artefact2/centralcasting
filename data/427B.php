<?php

namespace HeroesOfLegend;

$ranks = Roll("d4");

$ac = $s->getActiveCharacter();
if($ac->getAgeRange() === Character::CHILD) $ranks -= 2;

$solmod = $ac->getModifier('SolMod');
if($solmod <= -2) {
	$ranks -= 1;
} else if($solmod >= 4) {
	if($solmod >= 8) {
		$ranks += 1;
	}

	$ranks += 1;
}

if($ac->getModifier('TiMod') > 0) $ranks += 2;

$cumod = $ac->getModifier('CuMod');
if($cumod <= -2) {
	$ranks -= 2;
} else if($cumod <= 0) {
	$ranks -= 1;
} else if($cumod >= 4) {
	$ranks += 1;
}

SubentryCreator("427B", "Hobby Proficiency", "rank ".max(1, $ranks))($s);
