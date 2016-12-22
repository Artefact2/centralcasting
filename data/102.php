<?php

namespace HeroesOfLegend;

return new NamedTable("102", "Cultural Background", Roller(10), [
	"1" => [ "Primitive", ModifierIncreaser("CuMod", -3) ],
	"2-3" => "Nomad",
	"4-6" => [ "Barbarian", ModifierIncreaser("CuMod", 2) ],
	"7-9" => [ "Civilized", ModifierIncreaser("CuMod", 4) ],
	"10" => [ "Civilized-Decadent", ModifierIncreaser("CuMod", 7) ],
]);
