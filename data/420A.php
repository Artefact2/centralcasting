<?php

namespace HeroesOfLegend;

return new NamedTable("420A", "Primitive Occupation", DiceRoller::from("d20"), [
	"1-9" => "Fisherman",
	"10-18" => "Hunter",
	"19" => "Warrior",
	"20" => [ "Special occupation", Invoker("420B") ],
]);
