<?php

Table($s, "113B", "Noon Birth Consequence", Roller(10), [
	"1" => "+d6 to Magical Ability attribute the hour after noon",
	"2-3" => "No night vision (blind in darkness)",
	"4-5" => "Extremely tanned skin (+1 natural armor)",
	"6" => "-d6 to Magical Ability attribute the hour after midnight",
	"7" => "-1 rank to any stealth skills",
	"8-9" => "+2 to Magical Ability attribute during daylight",
	"10" => "-2 to Magical Ability attribute after sunset",
], TABLE_REROLL_DUPLICATES);
