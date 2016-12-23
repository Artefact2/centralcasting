<?php

namespace HeroesOfLegend;

return new NamedTable("877B", "Horse Skill", DiceRoller::from("d8"), [
	"1" => "Increase horse riding/fighting skill (+1 rank)",
	"2" => "Care for a horse (clean, curry, etc.)",
	"3" => "Break a horse to riding",
	"4" => "Trick riding (easily do dangerous/foolish things)",
	"5" => "Tell a good horse from bad",
	"6" => "Horse medicine (animal first aid)",
	"7" => "Train horse for combat",
	"8" => [ "Improve skill (+".Roll("d3")." rank(s)):", TableInvoker("877B", DiceRoller::from("d7")) ],
]);
