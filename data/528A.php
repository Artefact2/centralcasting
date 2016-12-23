<?php

namespace HeroesOfLegend;

return new NamedTable("528A", "Cause of Destruction", DiceRoller::from("d6"), [
	"1" => "Deadly disease",
	"2-3" => "Terrible fire",
	"4-5" => "War",
	"6" => [ "Someone's actions", Invoker("750") ],
]);
