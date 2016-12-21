<?php

Table($s, "318A", "Personality Trait Check", Roll(100), [
	"1-50" => null,
	"51-65" => [ null, Combiner(NeutralTrait($s), Invoker($s, "318B")) ],
	"66-80" => [ null, Combiner(LightsideTrait($s), Invoker($s, "647")) ],
	"81-95" => [ null, Combiner(DarksideTrait($s), Invoker($s, "648")) ],
	"96-100" => [ null, Invoker($s, "649") ],
]);
