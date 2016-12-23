<?php

namespace HeroesOfLegend;

return new NamedTable("423A", "Civilized Occupation", DiceRoller::from("d10+SolMod"), [
	"m2"    => Invoker("421A"),
	"m1-5"  => Invoker("423B"),
	"6"     => Invoker("422A"),
	"7"     => Invoker("423E"),
	"8-11"  => Invoker("423C"),
	"12-14" => Invoker("423D"),
	"15"    => Invoker("423E"),
	"16-23" => Invoker("423D"),
]);
