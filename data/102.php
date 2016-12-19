<?php

Table($s, "102", "Cultural Background", Roll(10), [
	"1" => [ "Primitive", function() use(&$s) { $s->char->CuMod = -3; } ],
	"2-3" => [ "Nomad", function() use(&$s) { $s->char->CuMod = 0; } ],
	"4-6" => [ "Barbarian", function() use(&$s) { $s->char->CuMod = 2; } ],
	"7-9" => [ "Civilized", function() use(&$s) { $s->char->CuMod = 4; } ],
	"10" => [ "Civilized-Decadent", function() use(&$s) { $s->char->CuMod = 7; } ],
]);