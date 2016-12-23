<?php

namespace HeroesOfLegend;

return new NamedTable("113A", "Midnight Birth Consequence", DiceRoller::from("d10"), [
	"1" => "+d6 to Magical Ability attribute the hour after midnight",
	"2-3" => "Night vision",
	"4-5" => "Extremely pale skin (1 HP lost per hour of exposure to bright daylight)",
	"6" => "-d6 to Magical Ability attribute the hour after noon",
	"7" => "+1 rank to any stealth skills",
	"8-9" => "+2 to Magical Ability attribute after sunset",
	"10" => "-2 to Magical Ability attribute during daylight",
], RandomTable::REROLL_DUPLICATES);
