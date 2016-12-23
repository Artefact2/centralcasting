<?php

namespace HeroesOfLegend;

return new NamedTable("318A", "Personality Trait Check", DiceRoller::from("d100"), [
	"1-50" => null,
	"51-65" =>  Combiner(NeutralTrait(),   Invoker("318B", "318D")),
	"66-80" =>  Combiner(LightsideTrait(), Invoker("647", "318D")),
	"81-95" =>  Combiner(DarksideTrait(),  Invoker("648", "318D")),
	"96-100" =>                            Invoker("649"),
]);
