<?php

$table = function() use(&$s) {
	$adj = [
		"Hard worker", "Lazy",
		"Ambitious", "Laid back/Casual",
		"Overbearing", "Submissive",
		"Well-liked", "Hated",
		"Patient", "Impatient",
		"Talented", "Incompetent",
		"Generous", "Stingy",
		"Fair", "Underhanded",
		"Opinionated", "A Yesman",
		"Inspired Loyalty", "Inspired Mistrust",
		"Humble", "Arrogant",
		"Trusting", "Jealous",
		"Creative", "Uncreative",
		"Adept", "Clumsy",
		"Efficient", "Inefficient",
		"Workaholic", "Slacker",
		"Productive", "Unproductive",
		"Office Politician", "Avoids politics",
		"Happy", "Unhappy",
	];

	$tdata = [];
	$i = 1;
	while($adj !== []) {
		$good = array_shift($adj);
		$bad = array_shift($adj);

		$tdata[(string)$i] = [ "Adjective", function() use($good, $bad) {
				return Roll(6) <= 4 ? $good : $bad;
			}];

		++$i;
	}

	$tdata["20"] = [
		null, function() use(&$s) {
			/* XXX 647 */
			/* XXX 648 */
			//Invoke($s, Roll(6) <= 4 ? "647" : "648");
		},
	];
	
	Table($s, "426A", "Work Attitude", Roll(20), $tdata);
};

$c = Roll(3);
while(--$c >= 0) $table();

Table($s, "426B", "Achievement Level (NPCs ONLY)", Roll(20), [
	"1-2" => [ "Apprentice", function() {
		if(Roll(20) >= 19) {
			return "Apprentice (acknowledged failure)";
		}
	}],
	"3-14" => "Journeyman",
	"15-17" => "Skilled Tradesman",
	"18-19" => "Master Craftsman",
	"20" => [ "Grand Master", function() {
		$r = Roll(20);
		if($r === 19) {
			return "Grand Master (legendary skill)";
		}
		if($r === 20) {
			return "Grand Master (mythical skill)";
		}
	}],
]);
