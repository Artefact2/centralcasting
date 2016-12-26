<?php

namespace HeroesOfLegend;

return new NamedTable("870A", "Brain Damage Consequence", DiceRoller::from("d8"), [
	"1" => "-".Roll("d3")." Intelligence",
	"2" => "All skills lose one rank",
	"3" => Invoker("649B"),
	"4" => Invoker("649"),
	"5" => "-".Roll("d3")." Dexterity",
	"6" => "Increase one skill by ".Roll("d8")." rank(s), all others lose d6 ranks",
	"7-8" => Repeater(Roll("d3+1"), Invoker("870A")),
]);
