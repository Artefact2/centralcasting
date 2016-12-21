<?php

$table = function() use(&$s, &$table) {
	Table($s, "419B", "Apprenticeship Event", Roller(10), [
		"1" => [ "Master noted for strong, often annoying personality", function() use(&$s) {
				$s->char->entries[] = [ "", "", "Character cannot stand to be around anyone acting in the same manner" ];
				Invoke($s, "318A");
				if(end($s->char->entries)[0] === '318A') {
					/* Rolled 1-50 */
					Invoke($s, "649");
				}
			}],
		"2" => [ "Character accidentally breaks master's valuable collection of sculptured ceramic chamber pots",
		         EntryAdder($s, "Apprenticeship ends after ".Roll(4)." year(s)") ],
		"3" => "Character stumbled upon a lost secret of the craft, master takes credit but only part of secret was revealed",
		"4" => "Character continues to study with master for additional ".Roll(6)." year(s)",
		"5" => "Character discovers master's shop is a front office for vast criminal network",
		"6" => "Master is world-renowned with legendary skill",
		"7" => "Other apprentice becomes character's best friend",
		"8" => [ "Exotic event occurs in the master's shop", Combiner(
			EntryAdder($s, Roll(2) === 1 ? 'Affects the character' : 'Affects the master'),
			Invoker($s, "544")
		)],
		"9" => [ "Character accompanies master on long, eventful journeys", Repeater(Roll(3), Invoker($s, "217")) ], /* XXX reroll "conflicts" */
		"10" => Repeater(2, $table), /* XXX reroll "conflicts" */
	], TABLE_REROLL_DUPLICATES);
};
$table();
