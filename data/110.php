<?php

$s->char->BiMod = 0;

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "110", "Place of Birth", $roll ?? (Roll(20) + $s->char->LegitMod), [
		"1-6" => [ "In character's family home", function() use(&$s) { $s->char->BiMod += -5; } ],
		"7-9" => [ "In hospital or healers guild hall", function() use(&$s) { $s->char->BiMod += -7; } ],
		"10" => [ "In carriage while travelling", function() use(&$s) { $s->char->BiMod += 1; } ],
		"11" => [ "In common barn", function() use(&$s) { $s->char->BiMod += 1; } ],
		"12-13" => [ "In a foreign land", function() use(&$s, &$table) {
				$s->char->BiMod += 2;
				do {
					$reroll = Roll(20) + $s->char->LegitMod;
				} while($reroll === 12 || $reroll === 13);
				$table($reroll);
			}],
		"14" => [ "In cave", function() use(&$s) { $s->char->BiMod += 5; } ],
		"15" => [ "In middle of field", function() use(&$s) { $s->char->BiMod += 1; } ],
		"16" => [ "In forest", function() use(&$s) { $s->char->BiMod += 2; } ],
		"17-24" => [ null, function() use(&$s) {
				Invoke($s, "111");
			} ],
	]);
};
$table();
