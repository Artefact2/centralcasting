<?php

namespace HeroesOfLegend;

return new NamedTable("215A", "Runaway", DiceRoller::from("d10"), [
	"1" => "And never returns",
	"2" => "And returns after ".Roll("d8")." day(s)",
	"3" => "And returns after ".Roll("d12")." month(s)",
	"4" => "And returns after ".Roll("d6")." year(s)",
	"5" => "To a distant land",
	"6" => "And joins the circus",
	"7" => [ "And falls into the hands of criminals", Combiner(DarksideTrait(), Invoker("534")) ],
	"8" => [ "And lives with nonhumans", Invoker("751") ],
	"9" => "And wanders the land, +1 rank in survival skills",
	"10" => [ "Combine events below (discard conflicts):", Repeater(Roll("d3+1"), Invoker("215A")) ],
]);
