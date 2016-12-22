<?php

namespace HeroesOfLegend;

/*<<< Name: Player Character >>>*/

$pc = $s->getRootCharacter();

$pc->setName('Player Character');
$pc->setType(Character::PC);
$pc->setAgeRange(Character::CHILD);

$s->invoke("101", "102", "103");
return;

$s->invokeTables("104", "106", "107", "109", "110", "112", "114");

$s->char->entries[] = [ "", "", "Character is now a child" ];
$s->char->entries[] = [ "", "", "At age ".Roll(12)." (human equivalent):" ];
$s->invokeTable($s, "215");

$pc->setAgeRange(Character::ADOLESCENT);
$s->char->entries[] = [ "", "", "Character is now an adolescent" ];
$s->char->entries[] = [ "", "", "At age ".(Roll(6) + 12)." (human equivalent):" ];
$s->invokeTable($s, "215");

$pc->setAgeRange(Character::ADULT);
$s->char->entries[] = [ "", "", "Character is now an adult" ];
$s->invokeTable($s, "217");

$s->invokeTable($s, "318");
