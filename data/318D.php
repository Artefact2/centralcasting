<?php

namespace HeroesOfLegend;

return new NamedTable("318D", "Trait Strength (Optional)", DiceRoller::from("d100"), [
	"1-10" => "Trivial",
	"11-29" => "Weak",
	"30-59" => "Average",
	"60-79" => "Strong",
	"80-94" => "Driving",
	"95-100" => "Obsessive",
]);
