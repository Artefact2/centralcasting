<?php

$table = function($roll = null) use(&$s, &$table) {	
	Table($s, "539", "Enslaved event", $roll ?? Roll(20), [
		"1" => [ "Character escaped", Invoker($s, "539A") ],
		"2" => [ "Willingly freed by owner", Invoker($s, "539B") ],
		"3" => [ "Ruler of the land declared slavery illegal, got free with ".Roll(100)." gp", function() use(&$s) {
				$s->char->enslaved = false;
			}],
		"4" => [ "Bought my freedom, remain as employee for ".Roll(4)." year(s)", function() use(&$s) {
				$s->char->enslaved = false;
			}],
		"5" => [ "Owner dies", Invoker($s, "539C") ],
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
						$s->char->entries[] = [ "", "", "Now have ".($f = Roll(6))." low-ability NPC follower(s)" ];
						for($i = 0; $i < $f; ++$i) Invoke($s, "761C");
					}
				} else {
					$s->char->entries[] = [ "", "", "Tortured and received a permanent injury" ];
					Invoke($s, "870");
				}
			}],
		"13" => "Promoted to a position of authority",
		"14" => "Become owner's favorite, senior slave in the household, another slaves becomes rival", /* XXX 762 */
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
		"19-20" => [ "Enslaved for ".Roll(4)." more year(s)", TableReroller($s, $table, Roller(1, 20, 1), Roll(3)) ],
		"21" => [ "Exotic event frees character", function() use(&$s) {
				/* XXX 544 */
				$s->char->enslaved = false;
			}],
	]);
};

/* XXX: generate owner */

$s->char->enslaved = true;
$s->char->entries[] = [ "539", "Enslaved", "for ".Roll(6)." year(s)" ];

$events = Roll(3);
for($i = 0; $i < $events; ++$i) {
	$table();
}

/* XXX: occupation */

if($s->char->enslaved === true) {
	$table(Roll(4));
}

/* XXX: social status */

unset($s->char->enslaved);
