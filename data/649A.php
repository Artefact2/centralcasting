<?php

namespace HeroesOfLegend;

return new NamedTable("649A", "Exotic Feature Category", DiceRoller::from("d20"), [
	"1-4" => Invoker("649B"),
	"5-7" => Invoker("649C"),
	"8-10" => Invoker("649D"),
	"11-17" => Invoker("649E"),
	"18-19" => Invoker("649F"),
	"20" => Repeater(Roll("d3+1"), Invoker("649A")),
]);
