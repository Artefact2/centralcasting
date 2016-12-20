<?php

$s->char->enslaved = false;
$table = function($roll = null) use(&$s, &$table) {
	Table($s, "539B", "Freedom consequence", $roll ?? Roll(10), [
		"1" => [ "Befriended by owner", function() use(&$s) {
				Table($s, "", "", Roll(8), [
					"1-4" => "Owner becomes good friend",
					"5-7" => "Owner becomes patron", /* XXX 543 */
					"8" => [ "Owner becomes companion", Invoker($s, "761C") ],
				]);
			}],
		"2" => "Owner converted to religion that abhors slavery ; paid ".Roll(2, 10)." gp and set free",
		"3-4" => "Reunited with relatives, including former enslaved relatives",
		"5" => "Owner dies, will says to free slaves and divide property (".Roll(2, 10)." other slaves)",
		"6-7" => "Unable to find work and enlisted in the military", /* XXX 535 */
		"8" => [ "Another slave remains as companion", Invoker($s, "761C") ],
		"9" => [ "Saved owner's life, freed and got gift as reward", Invoker($s, "863") ],
		"10" => [ null, TableReroller($s, $table, Roller(9), Roll(3)) ],
	]);
};
$table();
