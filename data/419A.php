<?php

namespace HeroesOfLegend;

return new NamedTable("419A", "Type of Occupation", DiceRoller::from("d10"), [
	"1-2" =>  Invoker("424A"),
	"3-4" =>  Invoker("424B"),
	"5-6" =>  Invoker("424C"),
	"7-10" => Invoker("420-423"),
]);
