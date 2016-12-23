<?php

namespace HeroesOfLegend;

return new NamedTable("427C", "Degree of Interest", DiceRoller::from("d10"), [
	"1-2" => "Casual",
	"3-7" => "Sporadic and variable",
	"8-9" => "Devoted",
	"10" => "Consuming passion",
]);
