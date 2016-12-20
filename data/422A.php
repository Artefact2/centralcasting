<?php

Table($s, "422A", "Barbarian Occupation", Roll(20), [
	"1-2" => [ "Craftsman", Invoker($s, "424A") ],
	"3-8" => "Farmer",
	"9-11" => "Fisherman",
	"12-13" => "Herder",
	"14-15" => "Hunter",
	"16-17" => "Warrior",
	"18" => [ "Craftsman", Invoker($s, "424B") ],
	"19" => [ "Merchant", Invoker($s, "425") ],
	"20" => [ "Special occupation", Invoker($s, "422B") ],
]);

Invoke($s, "426");
