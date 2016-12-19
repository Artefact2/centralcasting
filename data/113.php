<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "113", "Unusual Birth Circumstance", $roll ?? function() { return Roll(100); }, [
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
		"39-41" => [ "*Born at exactly midnight", function() use(&$s) {
				$subtable = function() use(&$s) {
					Table($s, "113M", "Midnight Birth Consequence", function() { return Roll(10); }, [
						"1" => "+d6 to Magical Ability attribute the hour after midnight",
						"2-3" => "Night vision",
						"4-5" => "Extremely pale skin (1 HP lost per hour of exposure to bright daylight)",
						"6" => "-d6 to Magical Ability attribute the hour after noon",
						"7" => "+1 rank to any stealth skills",
						"8-9" => "+2 to Magical Ability attribute after sunset",
						"10" => "-2 to Magical Ability attribute during daylight",
					], TABLE_REROLL_DUPLICATES);
				};
				$sub = Roll(3);
				while(--$sub >= 0) $subtable();
			}],
		"42-44" => [ "*Born at exactly noon", function() use(&$s) {
				$subtable = function() use(&$s) {
					Table($s, "113N", "Noon Birth Consequence", function() { return Roll(10); }, [
						"1" => "+d6 to Magical Ability attribute the hour after noon",
						"2-3" => "No night vision (blind in darkness)",
						"4-5" => "Extremely tanned skin (+1 natural armor)",
						"6" => "-d6 to Magical Ability attribute the hour after midnight",
						"7" => "-1 rank to any stealth skills",
						"8-9" => "+2 to Magical Ability attribute during daylight",
						"10" => "-2 to Magical Ability attribute after sunset",
					], TABLE_REROLL_DUPLICATES);
				};
				$sub = Roll(3);
				while(--$sub >= 0) $subtable();
			}],
		"46-48" => [ "*Seer declares character will be afflicted by long forgotten ancient family curse", function() use(&$s) {
				/* XXX 868 */
			}],
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
		"63-64" => "*Birth happens immediately after a tragedy", /* XXX 528 */
		"65-69" => "*Born with unusual birthmark", /* XXX 866 */
		"70-75" => "*Born with curse", /* XXX 686 */
		"76-81" => "*Born with blessing", /* XXX 869 */
		"82-85" => "Character has a ".(Roll(2) === 1 ? 'male' : 'female')." fraternal twin",
		"86" => "Character is one of a set of identical triplets",
		"87-88" => "*Old hag (witch) prophesies character's death", /* XXX 545 */
		"89-93" => "*Born with unusual physical affliction", /* XXX 874 */
		"94" => "Born with phychic powers", /* XXX 873 1d3 */
		"95-99" => [ "Mysterious stranger bestows a gift on the character at birth", function() use(&$s) {
				Invoke($s, "863");
			}],
		"100" => [ null, function() use(&$s, &$table) {
				TableForgetRerollInfo($s, "113", "100");
				$reroll = function() { return Roll(100) + 20; };
				$table($reroll);
				$table($reroll);
		}],
		"101-105" => "*Mother was reputed to be a virgin",
		"106-110" => [ "*Character is offspring of a mortal and a demon", function() use(&$s) {
				$s->char->entries[] = [ "", "", "Every attribute gets +d3 or -d3, 50/50 chance" ];
				/* XXX 874 */
				/* XXX 868 */
				/* XXX 648 */
			}],
		"111-120" => [ "*Character is offspring of avatar of god and a mortal", function() use(&$s) {
				$s->char->entries[] = [ "", "", "+3 to attributes related to inherited god-like qualities" ];
				/* XXX 874 */
				Invoke($s, "863");
				/* XXX 869 */
				Invoke($s, "864");
			}],
	], TABLE_REROLL_DUPLICATES);
};
$table();
