<?php

namespace HeroesOfLegend;

return new NamedTable("873", "Psychic Ability", new DiceRoller("d20"), [
	"1" => "Spell-like power (use magic spell as mental power)",
	"2" => "Psychometry (learn past history of object/person by touching it)",
	"3" => "Clairvoyance I (see/sense things occurring at distance, fuzzy view and jumbled sound, random visions)",
	"4" => "Clairvoyance II (see/sense things occurring at distance, clear view and sound, specific point of view)",
	"5" => "Clairvoyance III (feel like being in another area, like an astral image, can walk around and see/hear)",
	"6" => "Psychic Healing (can heal injuries and diseases)",
	"7" => "Hypnosis (place victim in sleeping trance and open to suggestions)",
	"8" => "Persuasion (mass hypnosis, multiple targets)",
	"9" => "Telekinesis (move inanimate objects by force of thought)",
	"10" => "Suspended animation (enter sleep-like state, stops metabolism for many days)",
	"11" => "Teleportation",
	"12" => "Mind block (shield against intruding/offensive phychic abilities)",
	"13-14" => "ESP (sense surface of other minds)",
	"15" => "Telepathy (can sense and read minds)",
	"16" => "Mind blast (can do physical damage to a foe using mental power only)",
	"17" => "Body control (temporarily increase attribute by d4 points)",
	"18" => "Mind control (take over another mind for short time)",
	"19-20" => [ "Multiple powers", Repeater(Roll("d3+1"), Invoker("873")) ],
]);
