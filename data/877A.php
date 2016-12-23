<?php

namespace HeroesOfLegend;

return new NamedTable("877A", "Combat Skill", DiceRoller::from("d10"), [
	"1" => "Improve weapon skill (of choice, +1 rank)",
	"2" => "First aid",
	"3" => "Disarm opponent with similar weapon",
	"4" => "Shield tricks (increase protection)",
	"5" => "Military strategy", /* XXX can't figure out the book here */
	"6" => "Learn to use additional weapon (of choice, rank 2)",
	"7" => "See weaknesses (+1 attack bonus per rank after d3 rounds)",
	"8" => "Endurance exercices (+1 Constitution per 2 ranks)",
	"9" => "Repair armor (all kinds)",
	"10" => [ "Improve skill (+".Roll("d3")." rank(s)):", TableInvoker("877A", DiceRoller::from("d9")) ],
]);
