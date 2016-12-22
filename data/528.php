<?php

/* XXX reroll nonsensical rolls (which implies keeping a LOT more state) */

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "528", "Tragedy", Roll(20) + $s->char->SolMod, [
		"m2" => [ "Wild carnivorous beasts attack", function() use(&$s) {
				$s->char->entries[] = [ "", "", "And character gets severely injured" ];
				Invoke($s, "870");
				$frags = Roll(4);
				$s->char->entries[] = [ "", "", "And devour ".$frags." family member(s)/guardian/friend(s)" ];
				Repeater($frags, Invoker($s, "753"))();
			}],
		"m1" => [ null, TableReroller($s, $table, Roller(20)) ],
		"0" => [ "Imprisoned for a crime character did not commit", Invoker($s, "875", "540") ],
		"1" => [ "One of character's children dies", function() use(&$s, &$table) {
				Table($s, "", "Cause of Death", Roll(6), [
					"1-2" => "Accident",
					"3" => "Fire",
					"4-5" => "Disease",
					"6" => [ "Someone's actions", Invoker($s, "750", "545") ], /* Typo in the book (443->545) */
				]);
			}],
		"2" => [ "Parents/guardian unable to pay taxes and get imprisoned", Invoker($s, "546") ],
		"3" => [ "Favorite pet dies painfully", function() use(&$s) {
				if(Roll(6) <= 4) return;
				$s->char->entries[] = [ "", "", "And the death was caused by someone else" ];
				Invoke($s, "750");
			}],
		"4" => [ "Character gets orphaned!", Invoker($s, "546") ],
		"5" => [ "Village/small town/part of city is wiped out", function() use(&$s) {
				if(Roll(6) === 6) {
					$s->char->entries[] = [ "", "", "(Optional) And entire city is destroyed" ];
				}
				/* XXX family can die here */
				Invoke($s, "528A");
			}],
		"6" => [ "Character responsible for someone's death", Invoker($s, "750", "545") ],
		"7" => [ "Character gets orphaned!", Invoker($s, "546") ],
		"8" => [ "Family/guardian(s) is wiped out", function() use(&$s) {
				/* XXX close family can die here */
				Invoke($s, "528A");
			}],
		"9" => [ "Favorite (possibly valuable) possession vanishes", function() use(&$s) {
				Table($s, "", "How?", Roll(6), [
					"1-3" => "It was lost",
					"4-5" => "It was stolen",
					"6" => "It was stolen and fake left in its place",
				]);
			}],
		"10" => [ "Character's parent(s) outlawed and goes into hiding", function() use(&$s) {
				Table($s, "", "Which parent?", Roll(6), [
					"1-3" => [ "Father", EntryAdder($s, Roll(6) <= 2 ? "And rest of family follows him" : null) ],
					"4" => [ "Mother", EntryAdder($s, Roll(6) <= 4 ? "And rest of family follows her" : null) ],
					"5-6" => [ "Both parents", EntryAdder($s, Roll(6) <= 5 ? "And rest of family follows them" : null) ],
				]);
				if(Roll(6) <= 4) return;
				$s->char->entries[] = [ "", "", "And parents hide in a different culture level" ];
				/* XXX only change CuMod if character actually follows */
				$s->char->CuMod = 0;
				Invoke($s, "103");
			}],
		"11" => [ "Character sold into slavery", Invoker($s, "539") ],
		"12" => [ "Character receives severe injury", function() use(&$s) {
				Invoke($s, "870");
				Table($s, "", "Cause of Injury?", Roll(8), [
					"1-4" => "Accident",
					"5" => "Terrible fire",
					"6" => "Animal attack",
					"7-8" => [ "Attacked by someone else", Invoker($s, "750") ],
				]);
			}],
		"13" => [ (Roll(2) === 1 ? "Mother/female guardian" : "Father/male guardian")." dies", function() use(&$s) {
				/* XXX reroll if no/one parent */
				Table($s, "", "Cause of death?", Roll(6), [
					"1-4" => "Accident",
					"5-6" => [ "Someone's actions", Invoker($s, "750", "545") ],
				]);
			}],
		"14" => "Banned from performing primary occupation, cast out of any guild associated with occupation",
		"15" => [ "Something terrible happens to lover", function() use(&$s) {
				/* XXX reroll if no lover */
				Table($s, "", "Cause of death?", Roll(10), [
					"1" => "Lover is unfaithful, leaves character heartbroken",
					"2" => [ "Lover attempts to kill ch aracter and disappears", function() use(&$s) {
							if(Roll(6) === 6) {
								$s->char->entries[] = [ "", "", "And character gets severely injured" ];
								Invoke($s, "870");
							}
						}],
					"3" => "Lover tries to kill character, dies in attempt",
					"4" => "Lover dies of disease",
					"5" => "Lover dies in a fire",
					"6" => "Lover dies in an accident",
					"7" => "Lover killed by own jealous former lover",
					"8" => "Lover disappears and is never seen again",
					"9" => "Lover comes out as homosexual",
					"10" => [ "Lover is imprisoned for a crime", Invoker($s, "875") ],
				]);
			}],
		"16" => "Disease almost kills character and leaves horrible scars, -".Roll(4)." Charisma, -".Roll(4)." Appearance",
		"17" => [ "War ravages homeland, more tragedies occur", function() use(&$s, &$table) {
				Table($s, "", "", Roll(6), [
					"1-2" => [ null, Repeater(1, $table) ],
					"3-4" => [ null, Repeater(2, $table) ],
					"5" => [ null, Repeater(Roll(3), $table) ],
					"6" => [ "If 14 or older, character conscripted into military duty", Combiner(
						Repeater(Roll(3), $table),
						Invoker($s, "535")
					)],
				]);
			}],
		"18" => [ "Fire destroys character's home, all belongings are destroyed", function() use(&$s) {
				if(Roll(6) === 6) {
					$s->char->entries[] = [ "", "", "And social status drops by one level" ];
					if($s->char->SolMod >= -1) $s->char->SolMod -= 2;
				}
			}],
		"19" => [ "Character is cursed", Invoker($s, "868") ],
		"20" => [ "Best friend dies", Invoker($s, "545") ],
		"21" => [ "Family estate destroyed", function() use(&$s) {
				Table($s, "", "Cause of Destruction", Roll(6), [
					"1" => "A revolt",
					"2-3" => "A terrible fire",
					"4" => "An unexplainable incident",
					"5" => "War",
					"6" => [ "Someone's actions", function() use(&$s) {
							Invoke($s, "750");
							$s->char->entries[] = [ "", "", "And all belongings are destroyed" ];
							if(Roll(6) === 6) {
								$s->char->entries[] = [ "", "", "And social status drops by one level" ];
								$s->char->SolMod -= 2;
							}
						}],
				]);
			}],
		"22" => [ "Imprisoned for crime character did not commit", Invoker($s, "875", "540") ],
		"23" => [ null, TableReroller($s, $table, Roller(20)) ],
		"24" => [ "Family loses all its wealth", function() use(&$s) {
				$s->char->SolMod = 0;
				$s->char->TiMod = 0;
				Invoke($s, "103"); /* XXX "substract 30 from the roll" */
			}],
		"25" => [ "Character is disinherited by parents", function() use(&$s) {
				$s->char->SolMod = 0;
				$s->char->TiMod = 0;
				Invoke($s, "103"); /* XXX substract 10, or 45 if no primary occupation (rank >= 3) */
			}],
		"26-27" => [ "Character forced in political marriage", function() use(&$s) {
				/* XXX figure out when to show this */
				$s->char->entries[] = [ "", "", "And previous spouse (if applicable) \"disappears\"" ];
				$s->char->entries[] = [ "", "", "And new spouse dislikes character" ];
			}],
		"28-29" => "Severe inflation, money loses 9/10th of its value", /* XXX it's complicated */
		"30-31" => [ null, TableReroller($s, $table, Roller(20)) ],
		"32" => [ "Main source of income is utterly destroyed", function() use(&$s) {
				$s->char->entries[] = [ "", "", "And social status drops by one level" ];
				$s->char->SolMod -= 2;
			}],
		"33" => [ "Family stripped of all titles and land by ruler", function() use(&$s) {
				$s->char->SolMod = 0;
				$s->char->TiMod = 0;
				/* XXX "substract 10 to the roll" */
				Invoke($s, "103");
				if(Roll(6) === 6) {
					$s->char->entries[] = [ "", "", "And family is outlawed" ]; /* XXX "see 10" */
				}
			}],
	]);
};
$table();
