<?php

Table($s, "101", "Character Race", Roll(1, 20), [
	"1-14" => "Human",
	"15-16" => "Elf",
	"17" => "Dwarf",
	"18" => "Halfling",
	"19" => "Half Elf",
	"20" => [ "Other Race", function() use(&$s) {
			Table($s, "101O", "Other Races", Roll(1, 10), [
				"1-3" => "Beastman",
				"4-5" => "Reptileman",
				"6" => "Orc",
				"7-10" => "Half Orc",
			]);
		}],
]);
