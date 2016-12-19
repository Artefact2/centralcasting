<?php

$table = function($roll = null) use(&$s, &$table) {
	Table($s, "870", "Serious Wound", $roll ?? Roll(20), [
		"1" => [ "Impressive facial scar", function() {
			if(Roll(100) <= 50) {
				return "Impressive facial scar (+1 Charisma)";
			} else {
				return "Impressive facial scar (-1 Charisma)";
			}
		}],
		"2" => [ "Impressive body scars", function() use(&$s) { Invoke($s, "867"); } ],
		"3" => [ "Eye put out", function() use(&$s) {
				$s->char->entries[] = [
					"", "", "Depth perception is gone, -1 rank in all combat/visual skills"
				];
				if(Roll(2) === 1) {
					return "Left eye put out";
				} else {
					return "Right eye put out";
				}
			}],
		"4" => "Lost ".Roll(4)." teeth",
		"5" => [ "Ear torn or cut off", function() use(&$s) {
				if(Roll(10) >= 7) {
					$s->char->entries[] = [
						"", "", "Permanent hearing loss, -2 ranks in all listening skills, -1 Appearance"
					];
				}
				if(Roll(2) === 1) {
					return "Left ear torn or cut off";
				} else {
					return "Right ear torn or cut off";
				}
			}],
		"6" => "Disfigurement, -".Roll(10)." Appearance, -".Roll(10)." Charisma",
		"7" => [ "Brain damage caused by head injury", function() use(&$s) {
				$subtable = function($roll = null) use(&$s, &$subtable) {
					Table($s, "870H", "Brain damage consequence", $roll ?? Roll(8), [
						"1" => "-".Roll(3)." Intelligence",
						"2" => "All skills lose one rank",
						"3" => [ null, function() use(&$s) { /* 649B */ } ],
						"4" => [ null, function() use(&$s) { /* 649A */ } ],
						"5" => "-".Roll(3)." Dexterity",
						"6" => "Increase one skill by ".Roll(8)." rank(s), all others lose d6 ranks",
						"7-8" => [ null, function() use(&$s, &$subtable) {
								$more = Roll(3) + 1;
								for($i = 0; $i < $more; ++$i) $subtable(); /* Only roll 1-6 or not? */
							}],
					]);
				};
				$subtable();
			}],
		"8" => "Injury causes constant pain, -1 Dexterity, -1 Strength, Intelligence check to concentrate",
		"9" => "Knee injury, slow and constant limp, Intelligence check to concentrate, -25% movement speed",
		"10" => [ "Body part permanently severed", function() use(&$s) {
				$p = Roll(2) === 1 ? 'Left' : 'Right';
				Table($s, "870P", "Body part", Roll(6), [
					"1" => "$p hand, -1 Dexterity, -1 rank in all manual skills",
					"2" => "$p arm, -1 Dexterity, -1 rank in all manual skills",
					"3" => "$p foot, -1 Dexterity, -50% movement speed",
					"4" => "$p leg, -1 Dexterity, -50% movement speed",
					"5" => "$p thumb, cannot grip weapon with this hand",
					"6" => [ "Fingers", function() {
						$p = Roll(2) === 1 ? 'left' : 'right';
						$count = Roll(3);

						$ret = $count.' finger(s) on '.$p.' hand';
						if($count >= 2) $ret .= ' (cannot grip weapon with this hand)';
						return $ret;
					}],
				]);
			}],
		"11" => "Injury heals badly, -1 Dexterity, -1 Strength",
		"12" => "Foot injury causes constant limp, -25% movement speed",
		"13" => "Lung damage (racking cough and pain), Intelligence check to concentrate, -1 Constitution",
		"14" => "Stomach injury (recurrent nausea, -d10 ranks in skills while nauseated)",
		"15" => "Kidney damage, need to drink 3-4x normal amount of water, -1 Constitution",
		"16" => "Genital injury (no sex drive)",
		"17" => "Throat injury (".(Roll(10) * 10)."% voice loss)",
		"18" => "Back injury, -".Roll(6)." Strength",
		"19" => "Liver damage, alcohol becomes poisonous, -1 Constitution",
		"20" => [ null, function() use(&$s, &$table) {
				/* Reroll without duplicates */
				$have = [];
				$count = Roll(2) + 1;
				$n = 0;

				while($n < $count) {
					$r = Roll(19);
					if(isset($have[$r])) continue;
					$have[$r] = true;
					$table($r);
					++$n;
				}
			}],
	]);
};
$table();
