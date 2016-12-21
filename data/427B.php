<?php

$ranks = Roll(4);

if($s->char->ageRange === Character::CHILD) $ranks -= 2;

if($s->char->SolMod <= -2) {
	$ranks -= 1;
} else if($s->char->SolMod >= 4) {
	if($s->char->SolMod >= 8) {
		$ranks += 1;
	}

	$ranks += 1;
}

if(GetCharacterValue($s->char, "758") !== null) $ranks += 2;

if($s->char->CuMod <= -2) {
	$ranks -= 2;
} else if($s->char->CuMod <= 0) {
	$ranks -= 1;
} else if($s->char->CuMod >= 4) {
	$ranks += 1;
}

$s->char->entries[] = [ "427B", "Hobby Proficiency", "rank ".max(1, $ranks) ];
