<?php

$table = function() use(&$s, &$table) {
	Table($s, "870", "Serious Wound", Roller(20), [
		"1" => [ "Impressive facial scar", function() {
			if(Roll(100) <= 50) {
				return "Impressive facial scar (+1 Charisma)";
			} else {
				return "Impressive facial scar (-1 Charisma)";
			}
		}],
		"2" => [ "Impressive body scars", Invoker($s, "867") ],
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
		"7" => [ "Brain damage caused by head injury", Invoker($s, "870A") ],
		"8" => "Injury causes constant pain, -1 Dexterity, -1 Strength, Intelligence check to concentrate",
		"9" => "Knee injury, slow and constant limp, Intelligence check to concentrate, -25% movement speed",
		"10" => [ "Body part permanently severed", Invoker($s, "870B") ],
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
				TableForgetRerollInfo($s, "870", "20");
				$count = Roll(2) + 1;
				while(--$count >= 0) {
					$table();
				}
			}],
	], TABLE_REROLL_DUPLICATES);
};
$table();
