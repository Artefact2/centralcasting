<?php

Table($s, "114B", "Noteworthy Items", Roll(20), [
	"1" => [ "NPC is noted for his personality", function() use(&$s) {
			Table($s, "", "", Roll(6), [
				"1-3" => [ null, Invoker($s, "647") ],
				"4-5" => [ null, Invoker($s, "648") ],
				"6" => [ null, Invoker($s, "649") ],
			]);
		}],
	"2" => [ "NPC had unusual birth circumstance(s)", Repeater(Roll(3), Invoker($s, "113")) ],
	"3" => [ "NPC devotes time to a hobby", Invoker($s, "427") ],
	"4" => [ "NPC has unusual item", Invoker($s, "863") ],
	"5" => "NPC is creative, inventive, possibly artistic",
	"6" => [ "NPC was affected by exotic event, often spoken about", Invoker($s, "544") ],
	"7" => "NPC tells tales of legendary lost treasure, vague hints about its location",
	"8" => [ "NPC is obsessed about something", function() use(&$s) {
			Table($s, "", "", Roll(6), [
				"1" => [ "A relationship with someone", Invoker($s, "750") ],
				"2" => [ "A significant event from the past", Invoker($s, "215") ],
				"3" => [ "Working out of a personality trait", Invoker($s, Roll(2) === 1 ? "648" : "647") ],
				"4" => "Accomplishment of a motivation (figure it out)", /* XXX */
				"5" => [ "Accomplishing a future event", Invoker($s, "217") ],
				"6" => [ "Preventing a future event", Invoker($s, "217") ],
			]);
		}],
	"9" => "NPC has secret identity (select social status and occupation)", /* XXX */
	"10" => [ "NPC has patron", Invoker($s, "543") ],
	"11" => [ "NPC is military veteran", Invoker($s, "535A") ],
	"12" => [ "NPC is very religious/evangelizing, seeks to convert others", Invoker($s, "864") ],
	"13" => [ "NPC is noted for/hesitant to speak about past event:", function() use(&$s) {
			Table($s, "", "", Roll(4), [
				"1" => [ "Famous/hero for occurence of significant event", Invoker($s, "217") ],
				"2" => [ "Persecuted/villainized for occurence of significant event", Invoker($s, "217") ],
				"3" => "Important in home village/town/city",
				"4" => "But won't speak about it (GM decides, table 217)",
			]);
		}],
	"14" => [ "NPC has special relationship with family", EntryAdder($s, [
		"Particularly loving towards family",
		"Does not love family or children",
		"Is unfaithful to spouse",
		"Has married more than once, current spouse is number ".Roll(4), /* XXX is 1 meaningful? d3+1? */
	][Roll(4) - 1])],
	"15" => [ "NPC originally from different culture", function() use(&$s) {
			$origCuMod = $s->char->CuMod;

			/* Book doesn't say, but obviously same culture gets rerolled */
			while(true) {
				$s->char->CuMod = 0;
				Invoke($s, "102");

				if($s->char->CuMod === $origCuMod) {
					array_pop($s->char->entries);
					continue;
				}

				break;
			}

			$s->char->CuMod = $origCuMod;
		}],
	"16" => [ "NPC originally of different social status", function() use(&$s) {
			/* See previous case */
			
			$origSolMod = $s->char->SolMod;

			while(true) {
				$s->char->SolMod = 0;
				Invoke($s, "103");
				
				if($s->char->SolMod === $origSolMod) {
					array_pop($s->char->entries);
					continue;
				}

				break;
			}

			$s->char->SolMod = $origSolMod;
		}],
	"17" => "NPC from foreign land",
	"18" => [ "NPC has friends/ennemies", function() use(&$s) {
			$subtable = function() use(&$s, &$subtable) {
				Table($s, "", "", Roller(6), [
					"1" => [ "Has rival", function() use(&$s) {
							Invoke($s, "762");
							if($s->char->type === Character::PC && Roll(6) >= 5) {
								$s->char->entries[] = [ "", "", "Rival actively seeks out character" ];
							}
						}],
					"2" => "Has ".(Roll(10) + 2)." ennemies", /* XXX book likely wrong about generating 10+ rivals at once */
					"3" => "Has ".(Roll(10) + 2)." close friends (like family)",
					"4" => "Has ".(Roll(6) + 1)." jilted ex-lovers",
					"5" => [ "Has companion", Invoker($s, "761") ],
					"6" => [ null, TableReroller($s, $subtable, null, 2) ],
				], TABLE_REROLL_DUPLICATES);
			};
			$subtable();
		}],
	"19" => [ "NPC was horribly wounded once", Invoker($s, "870") ],
	"20" => [ "NPC noted for very exotic personality (possibly real weirdo)", Repeater(Roll(3), Invoker($s, "649")) ],
]);
