<?php

$s->char->enslaved = false;
$table = function($roll = null) use(&$s, &$table) {
	Table($s, "539A", "Escape consequence", $roll ?? Roll(8), [
		"1" => "Offered ".(Roll(10) * 100)." gp reward",
		"2" => "Accompanied by ".Roll(6)." slaves",
		"3" => "Government pays a bounty of ".(Roll(10) * 10)." gp for escaped slaves",
		"4" => [ "Aided by relative", Invoker($s, "753") ],
		"5" => "Forced to kill the owner during escape, own life will be forfeit if caught",
		"6" => [ "Stole an item of value during escape, owner wants it back desperately", Invoker($s, "863") ],
		"7" => "Owner (or spouse) secretely in love with character and helps escape without his/her knowledge",
		"8" => [ null, TableReroller($s, $table, Roller(7), Roll(2) + 1) ],
	]);
};
$table();
