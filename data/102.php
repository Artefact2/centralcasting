<?php

Table($s, "102", "Cultural Background", Roll(10), [
	"1" => [ "Primitive", CharIncrementer($s, "CuMod", -3) ],
	"2-3" => "Nomad",
	"4-6" => [ "Barbarian", CharIncrementer($s, "CuMod", 2) ],
	"7-9" => [ "Civilized", CharIncrementer($s, "CuMod", 4) ],
	"10" => [ "Civilized-Decadent", CharIncrementer($s, "CuMod", 7) ],
]);
