<?php

$table = function() use(&$s, &$table) {
	Table($s, "215B", "Family Change Event", Roller(6), [
		"1" => [ "Change culture level", function() use(&$s) {
				$s->char->CuMod = 0;
				Invoke($s, "102");
			}],
		"2" => [ "Change social status", function() use(&$s) {
				$s->char->SolMod = 0;
				Invoke($s, "103");
			}],
		"3" => "Change locale (relative distance: ".Roll(10)."/10)",
		"4" => [ "Head of household change occupations", Invoker($s, "420-423") ],
		"5" => [ "Parents split up", Combiner(
			EntryAdder($s, "Character goes with ".(Roll(2) === 1 ? 'mother' : 'father')),
			EntryAdder($s, Roll(6) <= 4 ? "Mother remarries within ".Roll(3)." year(s)" : null),
			EntryAdder($s, Roll(6) <= 4 ? "Father remarries within ".Roll(3)." year(s)" : null)
		)],
		"6" => [ null, Repeater(2, $table) ],
	], TABLE_REROLL_DUPLICATES);
};
$table();
