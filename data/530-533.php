 <?php

/*<<< Name: Race Event Check >>>*/

$race = GetCharacterValue($s->char, "101", "Human");

switch($race) {
case "Elf":
	Invoke($s, "530");
	break;

case "Dwarf":
	Invoke($s, "531");
	break;

case "Halfling":
	Invoke($s, "532");

case "Human":
case "Half Elf":
	$s->char->entries[] = [ "", "", "Encounter (and befriend) nonhumans:" ];
	Invoke($s, "751");
	break;

default:
	/* XXX may be inaccurate, are other races considered monsters? */
	Invoke($s, "533");
	break;
}
