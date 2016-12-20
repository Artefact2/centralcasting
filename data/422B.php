<?php

Table($s, "422B", "Special Barbarian Occupation", Roll(20), [
	"1-7" => [ "Civilized occupation", Invoker($s, "423A") ],
	"8-9" => "Priest/Shaman",
	"10" => "Healer/Herbalist",
	"11" => "Adventurer", /* XXX 757 */
	"12" => "Career criminal", /* XXX 755 */
	"13" => "Ship builder",
	"14" => "Barbarian wizard, witch or warlock (more feared than respected)",
	"15" => "Counselor/Philosopher",
	"16" => "Horsemaster",
	"17" => "Explorer",
	"18" => "Entertainer (bard, juggler, tumbler, actor, poet, etc.)",
	"19" => "Forester (warrior, guide and hunter who knows the forest)",
	"20" => [ "Craftsman", Invoker($s, "424C") ],
]);
