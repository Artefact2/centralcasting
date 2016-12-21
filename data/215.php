<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "215", "Significant Event of Childhood & Adolescence", $roll ?? Roller(1, 20, $s->char->SolMod), [
		"m2" => [ "Country is at war, riots in streets", function() use(&$s) {
				if($s->char->CuMod <= -2) {
					/* Primitive chars reroll this */
					$table();
					return null;
				}

				$s->char->entries[] = [ "", "", "All public assistance is terminated" ];
				$s->char->entries[] = [ "", "", "Family very involved in this uprising against ruling class" ];
				RandomTrait($s)();
			}],
		"m1" => [ "Find unusual object while foraging in trash heap", Invoker($s, "863") ],
		"0" => [ null, TableReroller($s, $table, Roller(1, 20)) ],
		"1" => [ "Involved by friends in illegal activities", Combiner(DarksideTrait($s), Invoker($s, "534")) ],
		"2" => [ "Tragedy occurs", Combiner(RandomTrait($s), Invoker($s, "528")) ],
		"3" => [ "Something wonderful occurs", Combiner(LightsideTrait($s), Invoker($s, "529")) ],
		"4" => [ "Learn unusual skill", Combiner(NeutralTrait($s), Invoker($s, "876")) ],
		"5" => [ "Learn head of household occupation (or patron, or random from culture)", NeutralTrait($s) ],
		"6" => [ "Runs away from home", Combiner(RandomTrait($s), Invoker($s, "215A")) ],
		"7" => [ "Gain religious experience", Combiner(RandomTrait($s), Invoker($s, "541")) ],
		"8" => [ "Family has following attitude:", function() use(&$s) {
				Table($s, "", "", Roll(6), [
					"1" => [ "Loved by parents or guardians", LightsideTrait($s) ],
					"2" => [ "Character is unloved", DarksideTrait($s) ],
					"3" => [ "Family has great plans for character's future and expect fullfillment", RandomTrait($s) ],
					"4" => [ "Family disapproves character's friends", RandomTrait($s) ],
					"5" => [ "Family encourages character's interests", LightsideTrait($s) ],
					"6" => [ (Roll(2) === 1 ? 'Mother' : 'Father')." is distant and cold towards character", DarksideTrait($s) ],
				]);
			}],
		"9" => [ "Character serves a patron", Combiner(NeutralTrait($s), Invoker($s, "543")) ],
		"10-11" => [ "Age-specific event", Invoker($s, "216") ],
		"12" => [ "Gain friend", Combiner(LightsideTrait($s), Invoker($s, "750")) ],
		"13" => [ "Race-specific event", Combiner(NeutralTrait($s), Invoker($s, "530-533")) ],
		"14" => [ null, Repeater(Roll(3), $table) ],
		"15" => [ "Exotic event occurs", Combiner(RandomTrait($s), Invoker($s, "544")) ],
		"16" => [ "Change/upheaval occurs in family", Combiner(RandomTrait($s), Invoker($s, "215B")) ],
		"17" => [ "Something bad happens to character", Combiner(DarksideTrait($s), function() use(&$s) {
					Table($s, "", "", Roll(4), [
						"1" => [ "Sexually molested by adult", Invoker($s, "750") ],
						"2" => [ "Tragedy occurs", Invoker($s, "758") ],
						"3" => [ "Character teases/angers old woman (witch), has curse put on him", Invoker($s, "868") ],
						"4" => [ "Character acquires rival", Invoker($s, "762") ],
					]);
				})],
		"18" => [ "Something good happens to character", Combiner(LightsideTrait($s), function() use(&$s) {
					Table($s, "", "", Roll(4), [
						"1" => "Character inherits large sum of money (10x starting money)",
						"2" => [ "Blessed by fairly as reward for good dead", Invoker($s, "869") ],
						"3" => [ "Something wonderful occurs", Invoker($s, "529") ],
						"4" => [ "Character acquires companion", Invoker($s, "761") ],
					]);
				})],
		"19" => [ "Age-specific event", Invoker($s, "216") ],
		"20" => [ "Character develops jaded tastes for exotic (possibly expensive) pleasures", DarksideTrait($s) ],
		"21" => [ null, TableReroller($s, $table, Roller(1, 20, -1)) ],
		"22" => [ "Rivals force family to move to new locale, or face reprisals", NeutralTrait($s) ],
		"23" => [ "Something wonderful occurs", Combiner(LightsideTrait($s), Invoker($s, "529")) ],
		"24" => [ "Tragedy occurs", Combiner(DarksideTrait($s), Invoker($s, "528")) ],
		"25" => [ null, TableReroller(
			$s, $table,
			Roller(1, 20, $s->char->SolMod + in_array(
				GetCharacterValue($s->char, "103"),
				[ "Wealthy", "Extremely Wealthy" ],
				true
			) ? 5 : 2)
		)],
		"26" => [ "Character is bethrothed in a political marriage upon reaching majority", DarksideTrait($s) ],
		"27" => [ "Head of household made close advisor to local ruler", RandomTrait($s) ],
		"28" => [ "Family travels widely, visiting several countries", NeutralTrait($s) ],
		"29" => [ "Special tutor teaches character an unusual skill (rank 3)", Invoker($s, "876") ],
		"30" => [ "Family throws extravagant birthday party for character, one unusual gift from unknown person", Combiner(
			RandomTrait($s),
			Invoker($s, "863")
		)],
		"31" => [ "Character exhibits symptoms of exotic personality", Invoker($s, "649") ],
		"32" => [ "Family gives character ".Roll(10)." slave(s) to do with as he sees fit", RandomTrait($s) ],
		"33-" => [ "Family gives character personal estate with ".Roll(10)." sq mi property", NeutralTrait($s) ],
	]);
};
$table();
