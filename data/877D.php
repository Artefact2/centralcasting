<?php

namespace HeroesOfLegend;

return new NamedTable("877D", "Naval Skill", DiceRoller::from("d10"), [
	"1" => "Swimming",
	"2" => "Small boat handling",
	"3" => "Large craft sailing",
	"4" => "Coordinated rowing (as in a galley or longship)",
	"5" => "Sail making and repair",
	"6" => "Boat repair",
	"7" => "Climbing (climbing up rigging in particular)",
	"8" => "Navigation",
	"9" => "War machines (particularly ballistae & catapults)",
	"10" => [ "Improve skill (+".Roll("d3")." rank(s)):", TableInvoker("877D", DiceRoller::from("d9")) ],
]);
