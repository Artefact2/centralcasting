<?php

Table($s, "421A", "Nomad Occupation", Roll(20), [
	"1-2" => "Craftsman", /* XXX 424A */
	"3-12" => "Herder",
	"13-16" => "Hunter",
	"17-18" => "Warrior (full-time)",
	"19" => "Merchant", /* XXX 425 */
	"20" => [ "Special occupation", Invoker($s, "421B") ],
]);
