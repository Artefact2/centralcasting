<?php

/*<<< Name: Player Character >>>*/

$s->char->type = Character::PC;
$s->char->ageRange = Character::CHILD;

Invoke($s, "101", "102", "103", "104", "106", "107", "109", "110", "112", "114");

$s->char->entries[] = [ "", "", "Character is now a child" ];
$s->char->entries[] = [ "", "", "At age ".Roll(12)." (human equivalent):" ];
Invoke($s, "215");

$s->char->ageRange = Character::ADOLESCENT;
$s->char->entries[] = [ "", "", "Character is now an adolescent" ];
$s->char->entries[] = [ "", "", "At age ".(Roll(6) + 12)." (human equivalent):" ];
Invoke($s, "215");

$s->char->ageRange = Character::ADULT;
$s->char->entries[] = [ "", "", "Character is now an adult" ];
Invoke($s, "217");

Invoke($s, "318");
