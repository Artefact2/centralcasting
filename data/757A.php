<?php

namespace HeroesOfLegend;

return new NamedTable("757A", "Adventurer Profession", DiceRoller::from("d20"), [
	"1-2" => "Wizard (magic user, adept, sorceror, illusionist, witch, warlock, mage, etc.)",
	"3-6" => "Priest (holy man, clergyman, cleric, healer, etc.)",
	"7-11" => "Warrior (fighting man, cavalier, paladin, knight, archer, man-at-arms, etc.)",
	"12-13" => "Thief (rogue, burglar, robber, second-story man, etc.)",
	"14-15" => "Ranger (woodland warrior, tracker, scout, etc.)",
	"16" => "Druid (priest of nature)",
	"17" => "Shaman (priest of spirits)",
	"18" => "Bard (wandering minstrel, and more)",
	"19" => "Martial arts monk (priest of a religion, teaches unarmed self-defense)",
	"20" => [ "Nonhuman adventurer", Combiner(Invoker("751"), TableInvoker("757A", DiceRoller::from("d19"))) ],
]);
