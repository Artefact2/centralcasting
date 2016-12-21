<?php

$table = function() use(&$s, &$table) {
	Table($s, "215A", "Runaway", Roll(10), [
		"1" => "And never returns",
		"2" => "And returns after ".Roll(8)." day(s)",
		"3" => "And returns after ".Roll(12)." month(s)",
		"4" => "And returns after ".Roll(6)." year(s)",
		"5" => "To a distant land",
		"6" => "And joins the circus",
		"7" => [ "And falls into the hands of criminals", Combiner(DarksideTrait($s), Invoker($s, "534")) ],
		"8" => [ "And lives with nonhumans", Invoker($s, "751") ],
		"9" => "And wanders the land, +1 rank in survival skills",
		"10" => [ null, Combiner(
			EntryAdder($s, "Combine events below (discard conflicts):"),
			TableReroller($s, $table, null, Roll(3) + 1)
		)],
	]);
};
$table();
