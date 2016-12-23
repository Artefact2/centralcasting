<?php

namespace HeroesOfLegend;

return new NamedTable("421A", "Nomad Occupation", DiceRoller::from("d20"), [
	"1-2" => [ "Craftsman", Invoker("424A") ],
	"3-12" => "Herder",
	"13-16" => "Hunter",
	"17-18" => "Warrior (full-time)",
	"19" => [ "Merchant", Invoker("425") ],
	"20" => [ "Special occupation", Invoker("421B") ],
]);
