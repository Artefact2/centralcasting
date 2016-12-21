<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "113", "Unusual Birth Circumstance", $roll ?? Roller(100), [
		"1-5" => "*Noteworth person near home died when character was born",
		"6-10" => "*Wolves and dogs set up a howling when character was born",
		"11-20" => "*Mother died in childbirth",
		"21-23" => "All glassware in house suddenly shattered",
		"24-25" => "*All milk in area soured at character birth",
		"26-27" => "Father believes child is from another man",
		"28-31" => [ "Character has identical twin", function() use(&$s) {
				if(Roll(100) <= 20) {
					$s->char->entries[] = [ "", "", "But were separated at birth" ];
				}
				if(Roll(6) === 6) {
					$s->char->entries[] = [ "", "", "And personality is drastically different" ];
				}
			}],
		"32-34" => "*Water froze or boiled by itself",
		"35-37" => "Seasonally unnatural weather occured",
		"38" => "*Unnaturally potent storms raged",
		"39-41" => [ "*Born at exactly midnight", Repeater(Roll(3), Invoker($s, "113A")) ],
		"42-44" => [ "*Born at exactly noon", Repeater(Roll(3), Invoker($s, "113B")) ],
		"45" => [ null, TableReroller($s, $table) ], /* Another error in the book! :-) */
		"46-48" => [ "*Seer declares character will be afflicted by long forgotten ancient family curse", Invoker($s, "868") ],
		"49-50" => [ "*Goose laid golden egg when character was born", function() use(&$s) {
				$r = Roll(10);
				if($r >= 7) $s->char->entries[] = [ "", "", "And still has it" ];
				if($r === 10) $s->char->entries[] = [ "", "", "And it is magical" ];
			}],
		"51-53" => "*Sky darkened when character was born (or moon and stars went dark) briefly",
		"54-55" => "*House became infested with venomous snakes the next day",
		"56" => "*All gold in house turned into lead",
		"57" => "*All metal in house turned into precious metals",
		"58-62" => "*Infant character left to die on hillside, discovered and subsequently raised by foster parents",
		"63-64" => [ "*Birth happens immediately after a tragedy", Invoker($s, "528") ],
		"65-69" => [ "*Born with unusual birthmark", Invoker($s, "866") ],
		"70-75" => [ "*Born with curse", Invoker($s, "686") ],
		"76-81" => [ "*Born with blessing", Invoker($s, "869") ],
		"82-85" => "Character has a ".(Roll(2) === 1 ? 'male' : 'female')." fraternal twin",
		"86" => "Character is one of a set of identical triplets",
		"87-88" => [ "*Old hag (witch) prophesies character's death", Invoker($s, "545") ],
		"89-93" => [ "*Born with unusual physical affliction", Invoker($s, "874") ],
		"94" => [ "Born with phychic powers", Repeater(Roll(3), Invoker($s, "873")) ],
		"95-99" => [ "Mysterious stranger bestows a gift on the character at birth", Invoker($s, "863") ],
		"100" => [ null, function() use(&$s, &$table) {
				TableForgetRerollInfo($s, "113", "100");
				$reroll = Roller(1, 100, 20);
				$table($reroll);
				$table($reroll);
		}],
		"101-105" => "*Mother was reputed to be a virgin",
		"106-110" => [ "*Character is offspring of a mortal and a demon", function() use(&$s) {
				$s->char->entries[] = [ "", "", "Every attribute gets +d3 or -d3, 50/50 chance" ];
				Invoke($s, "874");
				Invoke($s, "868");
				Invoke($s, "648");
			}],
		"111-120" => [ "*Character is offspring of avatar of god and a mortal", function() use(&$s) {
				$s->char->entries[] = [ "", "", "+3 to attributes related to inherited god-like qualities" ];
				Invoke($s, "874");
				Invoke($s, "863");
				Invoke($s, "869");
				Invoke($s, "864");
			}],
	], TABLE_REROLL_DUPLICATES);
};
$table();
