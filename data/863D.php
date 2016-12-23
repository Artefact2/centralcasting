<?php

namespace HeroesOfLegend;

return new NamedTable("863D", "Piece of Clothing", DiceRoller::from("d8"), [
	"1" => "Hat",
	"2" => "Pair of shoes",
	"3" => "Belt",
	"4" => "Cape",
	"5" => "Tunic",
	"6" => "Trousers",
	"7" => "Pair of stockings or hose",
	"8" => [ "Part(s) of a set or costume:", Repeater(Roll("d4"), TableInvoker("863D", DiceRoller::from("d7"))) ],
]);
