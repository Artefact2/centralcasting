<?php

namespace HeroesOfLegend;

return new NamedTable("422A", "Barbarian Occupation", DiceRoller::from("d20"), [
	"1-2" => [ "Craftsman", Invoker("424A") ],
	"3-8" => "Farmer",
	"9-11" => "Fisherman",
	"12-13" => "Herder",
	"14-15" => "Hunter",
	"16-17" => "Warrior",
	"18" => [ "Craftsman", Invoker("424B") ],
	"19" => [ "Merchant", Invoker("425") ],
	"20" => [ "Special occupation", Invoker("422B") ],
]);
