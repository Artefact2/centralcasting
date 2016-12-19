<?php

$table = function($roll = null) use(&$s, &$table) {	
	Table($s, "539", "Enslaved event", $roll ?? Roll(20), [
		"1" => [ "Character escaped", function() use(&$s) {
				$s->char->enslaved = false;
				$subtable = function($subroll = null) use(&$s, &$subtable) {
					Table($s, "539E", "Escape consequence", $subroll ?? Roll(8), [
						"1" => "Offered ".(Roll(10) * 100)." gp reward",
						"2" => "Accompanied by ".Roll(6)." slaves",
						"3" => "Government pays a bounty of ".(Roll(10) * 10)." gp for escaped slaves",
						"4" => [ "Aided by relative", function() use(&$s) { Invoke($s, "753"); } ],
						"5" => "Forced to kill the owner during escape, own life will be forfeit if caught",
						"6" => [ "Stole an item of value during escape, owner wants it back desperately", function() use(&$s) {
								Invoke($s, "863");
							}],
						"7" => "Owner (or spouse) secretely in love with character and helps escape without his/her knowledge",
						"8" => [ null, function() use(&$s, &$subtable) {
								$n = Roll(2) + 1;
								for($i = 0; $i < $n; ++$i) {
									$subtable(Roll(7));
								}
							}],
					]);
				};
				$subtable();
			}],
		"2" => [ "Willingly freed by owner", function() use(&$s) {
				$s->char->enslaved = false;
				$subtable = function($subroll = null) use(&$s, &$subtable) {
					Table($s, "539F", "Freedom consequence", $subroll ?? Roll(10), [
						"1" => [ "Befriended by owner", function() use(&$s) {
								Table($s, "", "Friend type", Roll(8), [
									"1-4" => "Owner becomes good friend",
									"5-7" => "Owner becomes patron", /* XXX 543 */
									"8" => "Owner becomes companion", /* XXX 761 */
								]);
							}],
						"2" => "Owner converted to religion that abhors slavery ; paid ".Roll(2, 10)." gp and set free",
						"3-4" => "Reunited with relatives, including former enslaved relatives",
						"5" => "Owner dies, will says to free slaves and divide property (".Roll(2, 10)." other slaves)",
						"6-7" => "Unable to find work and enlisted in the military", /* XXX 535 */
						"8" => "Another slave remains as companion", /* XXX 761 */
						"9" => [ "Saved owner's life, freed and got gift as reward", function() use(&$s) {
								Invoke($s, "863");
							}],
						"10" => [ null, function() use(&$s, &$subtable) {
								$n = Roll(3);
								for($i = 0; $i < $n; ++$i) {
									$subtable(Roll(9));
								}
							}],
					]);
				};
				$subtable();
			}],
		"3" => [ "Ruler of the land declared slavery illegal, got free with ".Roll(100)." gp", function() use(&$s) {
				$s->char->enslaved = false;
			}],
		"4" => [ "Bought my freedom, remain as employee for ".Roll(4)." year(s)", function() use(&$s) {
				$s->char->enslaved = false;
			}],
		"5" => [ "Owner dies", function() use(&$s, &$table) {
				Table($s, "539D", "Death consequence", Roll(6), [
					"1" => "Sold to a new owner", /* XXX */
					"2" => [ "Freed", function() use(&$s, &$table) { $table(2); } ],
					"3" => [ "ALL owner possesions must be buried with him, but character escapes", function() use(&$s, &$table) {
							$table(1);
						}],
					"4" => [ "All slaves now owned by owner's relative", function() use(&$s) { Invoke($s, "753"); } ],
					"5" => [ "Accused of killing the owner, escapes but death hangs over head", function() use(&$s) {
							/* XXX 545 */
							$s->char->enslaved = false;
						}],
					"6" => [
						"Freed by owners will and became heir ; assume control of all property and slaves",
						function() use(&$s) {
							if(Roll(10) < 5) {
								$s->char->enslaved = false;
								return;
							}
							$s->char->entries[] = [
								"", "",
								"But family has will voided, back to enslavement"
							];
						},
					]
				]);
			}],
		"6-7" => "Improves occupational skill by 1 rank", /* XXX */
		"7-8" => "Improve occupational skill by ".(Roll(3) + 1)." rank(s)", /* XXX */
		"9" => "Often beaten by owner",
		"10" => "Learn an additional occupation at rank 1 from owner's culture", /* XXX */
		"11" => "Become sexual plaything of the owner", /* XXX */
		"12" => [ "Participates in a slave revolt", function() use(&$s, &$table) {
				if($leader = (Roll(6) === 6)) {
					$s->char->entries[] = [ "", "", "And led the revolt" ];
				}
				if($success = (Roll(6) >= 5)) {
					$s->char->entries[] = [ "", "", "And revolt succeeded" ];
					$s->char->enslaved = false;
				} else {
					$s->char->entries[] = [ "", "", "But revolt failed" ];
				}
				if($killed = (Roll(6) === 6)) {
					$s->char->entries[] = [ "", "", "And owner is killed" ];
					if(!$success) $table(5);
				}
				if($success) {
					$table(1);
					if($leader) {
						$s->char->entries[] = [ "", "", "Now have ".Roll(6)." low-ability NPC follower(s)" ];
						/* XXX 761C */
					}
				} else {
					$s->char->entries[] = [ "", "", "Tortured and received a permanent injury" ];
					Invoke($s, "870");
				}
			}],
		"13" => "Promoted to a position of authority",
		"14" => [ "Become owner's favorite, senior slave in the household, another slaves becomes rival", function() use(&$s) {
				/* XXX 762 */
			}],
		"15" => "Used as breeding stock", /* XXX */
		"16" => "Resold ".Roll(3)." time(s)", /* XXX */
		"17" => [ "Branded", function() use(&$s) {
				Invoke($s, "867");
				if(Roll(6) >= 5) {
					return "Branded (very recognisable slave brand)";
				} else {
					return "Branded (not recognisable unless inspected closely)";
				}
			}],
		"18" => [ "Escape attempt fails, gets branded and beaten", function() use(&$s, &$table) {
				$table(17);
				if(Roll(6) === 6) {
					Invoke($s, "870");
				}
			}],
		"19-20" => [ "Enslaved for ".Roll(4)." more year(s)", function() use(&$s, &$table) {
				$add = Roll(3);
				for($i = 0; $i < $add; ++$i) {
					$table(Roll(20) + 1);
				}
			}],
		"21" => [ "Exotic event frees character", function() use(&$s) {
				/* XXX 544 */
				$s->char->enslaved = false;
			}],
	]);
};

/* XXX: generate owner */

$s->char->enslaved = true;
$s->char->entries[] = [ "539", "Enslaved", "for ".(Roll(6))." year(s)" ];

$events = Roll(3);
for($i = 0; $i < $events; ++$i) {
	$table();
}

/* XXX: occupation */

if($s->char->enslaved === true) {
	$table(Roll(4));
}

/* XXX: social status */
