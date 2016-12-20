<?php

Table($s, "421A", "Nomad Occupation", Roll(20), [
	"1-2" => [ "Craftsman", Invoker($s, "424A") ],
	"3-12" => "Herder",
	"13-16" => "Hunter",
	"17-18" => "Warrior (full-time)",
	"19" => [ "Merchant", Invoker($s, "425") ],
	"20" => [ "Special occupation", Invoker($s, "421B") ],
]);

Invoke($s, "426");
