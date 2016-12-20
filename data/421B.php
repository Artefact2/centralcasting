<?php

Table($s, "421B", "Special Nomad Occupation", Roll(10), [
	"1" => "Priest/shaman",
	"2" => "Healer/herbalist",
	"3" => [ "Adventurer", Invoker($s, "757") ],
	"4" => [ "Career criminal", Invoker($s, "755") ],
	"5" => "Tentmaker",
	"6" => "Weapon master",
	"7" => "Counselor/Philosopher",
	"8" => [ "Civilized occupation", Invoker($s, "423A") ],
	"9" => "Horsemaster",
	"10" => "Entertainer (minstrel, juggler, tumbler, etc.)",
]);
