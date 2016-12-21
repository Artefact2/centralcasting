<?php

/*<<< Name: Player Character >>>*/

Invoke($s, "101");
Invoke($s, "102");
Invoke($s, "103");
Invoke($s, "104");
Invoke($s, "106");
Invoke($s, "107");
Invoke($s, "109");
Invoke($s, "110");
Invoke($s, "112");
Invoke($s, "114");

$s->char->ageRange = Character::CHILD;
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
