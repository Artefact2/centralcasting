<?php

namespace HeroesOfLegend;

$ac = $s->getActiveCharacter();
$l = $ac->getNumTraits('L');
$d = $ac->getNumTraits('D');
$n = $ac->getNumTraits('N');

if($l >= max($d, $n) + 2) {
	$alignment = "Lightsided";
} else if($d >= max($l, $n) + 2) {
	$alignment = "Darksided";
} else {
	$alignment = "Neutral";
}

SubentryCreator("318C", "Alignment", $alignment)($s);
