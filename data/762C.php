<?php

namespace HeroesOfLegend;

return new NamedTable("762C", "What?", DiceRoller::from("d10"), [
	"1-3" => "Friendly (can still be friends)",
	"4-5" => "Jealous (dislikes character, does not wish physical harm)",
	"6-7" => "Intense (hates character, wishes physical harm)",
	"8" => "Fierce (hates character bitterly, wishes physical harm)",
	"9" => "Deadly (fatal hatred, wishes character death and downfall)",
	"10" => "Obsessive (focuses entire life on character's ultimate destruction)",
]);
