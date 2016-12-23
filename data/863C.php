<?php

namespace HeroesOfLegend;

/* NB: book says to roll d10 but has no value for 8 */
return new NamedTable("863C", "Property Deed", DiceRoller::from("d9"), [
	"1" => "Tract of land in the country",
	"2" => "Ancient castle",
	"3" => "Country manor",
	"4" => "Elegant town house",
	"5" => "Temple",
	"6" => "Factory",
	"7" => "Ancient ruins",
	"8" => "Inn",
	"9" => "Apartment building",
]);
