<?php

$s->char->BiMod = 0;

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "110", "Place of Birth", $roll ?? (Roll(20) + $s->char->LegitMod), [
		"1-6" => [ "In character's family home", CharIncrementer($s, "BiMod", -5) ],
		"7-9" => [ "In hospital or healers guild hall", CharIncrementer($s, "BiMod", -7) ],
		"10" => [ "In carriage while travelling", CharIncrementer($s, "BiMod", 1) ],
		"11" => [ "In common barn", CharIncrementer($s, "BiMod", 1) ],
		"12-13" => [ "In a foreign land", Combiner(
			CharIncrementer($s, "BiMod", 2),
			TableReroller($s, $table, Roller(1, 20, $s->char->LegitMod), 1, [ 12, 13 ])
		)],
		"14" => [ "In cave", CharIncrementer($s, "BiMod", 5) ],
		"15" => [ "In middle of field", CharIncrementer($s, "BiMod", 1) ],
		"16" => [ "In forest", CharIncrementer($s, "BiMod", 2) ],
		"17-24" => [ "Exotic location", Invoker($s, "111") ],
	]);
};
$table();
