<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "106", "Family", $roll ?? (Roll(1, 20) + $s->char->CuMod), [
		"-8" => "Mother and Father only",
		"9-12" => [ "Extended family", function() use(&$s) {
				$s->char->entries[] = [
					"", "Family",
					"Mother, Father, ".Roll(1, 4)." Grandparent(s), ".Roll(1, 4)." Aunts/Uncles/Cousins",
				];
			}],
		"13" => (Roll(1, 2) === 1 ? "Maternal" : "Paternal")." grandparents only",
		"14" => [ "Single grandparent", function() {
			switch(Roll(1, 4)) {
			case 1: return "Maternal grandmother only";
			case 2: return "Maternal grandfather only";
			case 3: return "Paternal grandmother only";
			case 4: return "Paternal grandfather only";
			}
		}],
		"15" => (Roll(1, 2) === 1 ? "Maternal" : "Paternal")." aunt and uncle",
		"16" => [ "Single aunt or uncle", function() {
			switch(Roll(1, 4)) {
			case 1: return "Maternal aunt only";
			case 2: return "Maternal uncle only";
			case 3: return "Paternal aunt only";
			case 4: return "Paternal uncle only";
			}
		}],
		"17-18" => "Mother only",
		"19" => "Father only",
		"20" => [ "Guardian", function() use(&$s, &$table) {
				if(Roll(1, 20) <= 8) {
					Invoke($s, "754");
				} else {
					do {
						$reroll = Roll(1, 20) + $s->char->CuMod;
					} while($reroll >= 20);
					$table($reroll);
					return "Orphaned at birth and adopted";
				}
			}],
		"21-24" => [ "None known, left to self", function() use(&$s) {
				$s->char->SocMod = -3;
				EditCharacter($s->char, "103", "Destitute");
			}],
		"25-27" => [ "None known, raised in Orphanage", function() use(&$s) {
				$s->char->SocMod = -1;
				EditCharacter($s->char, "103", "Poor");
			}],
	]);
};
$table();
