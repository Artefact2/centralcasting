<?php

namespace HeroesOfLegend;

return new NamedTable("751", "Nonhuman", DiceRoller::from("d20"), [
	"1-4" => "Elf",
	"5-8" => "Dwarf",
	"9-11" => "Halfling",
	"12-15" => "Half Elf",
	"16" => "Beastman (minotaur, centaur, satyr, etc.)",
	"17" => "Reptileman (dragon, serpent men, etc.)",
	"18" => "Orc",
	"19-20" => "Half Orc",
]);
