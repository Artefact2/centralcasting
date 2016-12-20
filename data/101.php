<?php

Table($s, "101", "Character Race", Roll(20), [
	"1-14" => "Human",
	"15-16" => "Elf",
	"17" => "Dwarf",
	"18" => "Halfling",
	"19" => "Half Elf",
	"20" => [ "Other Race", Invoker($s, "101B") ],
]);
