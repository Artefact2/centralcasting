<?php

namespace HeroesOfLegend;

return new NamedTable("877C", "Forestry Skill", DiceRoller::from("d10"), [
	"1" => "Tracking (following tracks)",
	"2" => "Find food (plant & animal)",
	"3" => "Hiding in cover",
	"4" => "Trailing (following someone unseen)",
	"5" => "Camouflage (making hiding places)",
	"6" => "Find water (and know if it is drinkable)",
	"7" => "Make traps & deadfalls with natural items",
	"8" => "Making own shelter (against cold & damp)",
	"9" => "Suvival specialisation (forest, jungle, desert, mountain or winter)",
	"10" => [ "Improve skill (+".Roll("d3")." rank(s)):", TableInvoker("877C", DiceRoller::from("d9")) ],
]);
