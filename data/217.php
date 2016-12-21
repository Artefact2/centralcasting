<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "217", "Significant Event of Adulthood", $roll ?? Roller(2, 20, $s->char->SolMod), [
		"m1" => [ "Free trapped predatory beast while foraging/hunting for food, returns favor later", LightsideTrait($s) ],
		"0" => [ "Learn new occupation (rank 2) to earn a living", Combiner(NeutralTrait($s), Invoker($s, "420-423")) ],
		"1-2" => [ "Something wonderful occurs", Combiner(RandomTrait($s), Invoker($s, "529")) ],
		"3-4" => [ "Tragedy occurs", Combiner(RandomTrait($s), Invoker($s, "528")) ],
		"5" => [ "Learn unusual skill", Invoker($s, "876") ],
		"6" => [ "Participate in rebellion against local authority", Combiner(RandomTrait($s), function() use(&$s) {
					if(Roll(10) >= 9) {
						$s->char->entries[] = [ "", "", "And it succeeded" ];
					} else {
						$s->char->entries[] = [ "", "", "And it failed" ];
						if(Roll(10) === 10) {
							$s->char->entries[] = [ "", "", "And character is now an outlaw" ];
						} else {
							$s->char->entries[] = [ "", "", "Only few close friends know of the character's participation" ];
						}
					}
				})],
		"7" => [ "Character serves a patron", Combiner(NeutralTrait($s), Invoker($s, "543")) ],
		"8" => [ "Character has wanderlust and decides to travel for ".Roll(6)." year(s)", Combiner(NeutralTrait($s), Invoker($s, "217A")) ],
		"9-10" => [ "Character has religious experience", Combiner(LightsideTrait($s), Invoker($s, "541")) ],
		"11" => [ "Character saves someone else's life, becomes companion", Combiner(
			LightsideTrait($s), Invoker($s, "761A"), Invoker($s, "761C"),
			function() use(&$s) {
				if(Roll(2) === 1) return;
				$s->char->entries[] = [ "", "", "And companion has opposite sex" ];
				if(Roll(10) >= 6) return;
				$s->char->entries[] = [ "", "", "And companion is in love with character" ];
			})],
		"12-13" => [ "Race-specific event", Combiner(RandomTrait($s), Invoker($s, "530-533")) ],
		"14" => [ null, Repeater(Roll(3), $table) ],
		"15" => [ "Exotic event occurs", Combiner(LightsideTrait($s), Invoker($s, "544")) ],
		"16" => "Learn use of a weapon (of choice, rank 3, appropriate to culture/societal status)",
		"17" => [ "Something bad happens to character", Combiner(DarksideTrait($s), function() use(&$s) {
					Table($s, "", "", Roll(3), [
						"1" => [ "Tragedy occurs", Invoker($s, "528") ],
						"2" => [ "Crude/tactless joke angers old woman (witch), curses character", Invoker($s, "868") ],
						"3" => [ "Character acquires rival", Invoker($s, "762") ],
					]);
				})],
		"18" => [ "Something good happens to character", Combiner(LightsideTrait($s), function() use(&$s) {
					Table($s, "", "", Roll(3), [
						"1" => [ "Old man rescued from brigands blesses character", Invoker($s, "869") ],
						"2" => [ "Something wonderful occurs", Invoker($s, "529") ],
						"3" => [ "Character acquires companion", Invoker($s, "761") ],
					]);
				})],
		"19" => [ "Character becomes well-known/famous for event:", Combiner(LightsideTrait($s), $table) ],
		"20" => [ "Character develops exotic personality trait", Invoker($s, "649") ],
		"21" => [ "Character inherits property from a relative", Combiner(
			RandomTrait($s),
			Invoker($s, "753"), /* Why not? Book doesn't say so, but makes sense */
			Invoker($s, "863C"),
			EntryAdder($s, "GM special 978#217")
		)],
		"22" => [ null, TableReroller($s, $table, Roller(2, 20, -Roll(3))) ],
		"23-24" => [ "Character becomes engaged in illegal activities", Combiner(DarksideTrait($s), Invoker($s, "534")) ], /* XXX 534A? */
		"25" => "Learn to use unusual weapon (rank 3, something alien to culture)",
		"26-28" => [ "Character joins the military", Combiner(
			RandomTrait($s),
			function() use(&$s) {
				$s->char->entries[] = [ "", "", "Reason for joining: ".([
					"character was drafted during wartime",
					"character patriotically volunteered",
					"character was rounded up by press gang who needed to meet quota",
					"character mistakenly thought he was applying for another job",
				][Roll(4) - 1])];
			},
			Invoker($s, "535")
		)],
		"29-32" => [ "Character has romantic encounter", Combiner(RandomTrait($s), Invoker($s, "542")) ],
		"33" => [ "Character acquires hobby", Invoker($s, "427") ],
		"34" => [ "Character develops jaded tastes for exotic (possibly expensive) pleasures", DarksideTrait($s) ],
		"35-36" => [ "Character accused of a crime he did not commit", Combiner(Invoker($s, "875"), Invoker($s, "217B")) ],
		"37-38" => [ null, function() use(&$s) {
				if($s->char->type === Character::PC) {
					return "Age ".Roll(6)." year(s)";
					Repeater(Roll(3), $table)();
				} else {
					$table();
				}
		}],
		"39" => "Choose any one personality trait (318B, 647, 648, or 649)",
		"40-41" => [ "Learn occupation (rank 2) or improve main occupation (+".Roll(3)." ranks".($s->char->type === Character::PC ? ' up to 6' : '').")", Combiner(NeutralTrait($s), Invoker($s, "420-423")) ],
		"42-44" => [ null, TableReroller($s, $table, Roller(2, 20, $s->char->SolMod + 5)) ],
		"45" => [ "Character is made close advisor to local ruler", NeutralTrait($s) ],
		"46-48" => [ "Character develops exotic personality trait", Invoke($s, "649") ],
		"49-50" => [ "Family sends character a personal servant (butler) as companion", Invoker($s, "761C") ],
		"51-53" => "Ruler slightly below character proposes marriage (obviously political) to take advantage",
		"54-58" => [ "Radical change in political structure, character becomes poor and loses all noble benefits",
		             EntryAdder($s, Roll(6) >= 5 ? 'And character (and family) are outlaws in the land' : null)
		],
	]);
};
$table();
