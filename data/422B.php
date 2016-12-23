<?php

namespace HeroesOfLegend;

return new NamedTable("422B", "Special Barbarian Occupation", DiceRoller::from("d20"), [
	"1-7" => [ "Civilized occupation", Invoker("423A") ],
	"8-9" => "Priest/Shaman",
	"10" => "Healer/Herbalist",
	"11" => [ "Adventurer", Invoker("757") ],
	"12" => [ "Career criminal", Invoker("755") ],
	"13" => "Ship builder",
	"14" => "Barbarian wizard, witch or warlock (more feared than respected)",
	"15" => "Counselor/Philosopher",
	"16" => "Horsemaster",
	"17" => "Explorer",
	"18" => "Entertainer (bard, juggler, tumbler, actor, poet, etc.)",
	"19" => "Forester (warrior, guide and hunter who knows the forest)",
	"20" => [ "Craftsman", Invoker("424C") ],
]);
