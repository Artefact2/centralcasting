<?php

namespace HeroesOfLegend;

return new NamedTable("421B", "Special Nomad Occupation", DiceRoller::from("d10"), [
	"1" => "Priest/shaman",
	"2" => "Healer/herbalist",
	"3" => [ "Adventurer", Invoker("757") ],
	"4" => [ "Career criminal", Invoker("755") ],
	"5" => "Tentmaker",
	"6" => "Weapon master",
	"7" => "Counselor/Philosopher",
	"8" => [ "Civilized occupation", Invoker("423A") ],
	"9" => "Horsemaster",
	"10" => "Entertainer (minstrel, juggler, tumbler, etc.)",
]);
