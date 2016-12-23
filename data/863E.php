<?php

namespace HeroesOfLegend;

return new NamedTable("863E", "Paper", DiceRoller::from("d10"), [
	"1" => "Ancient ancestor's letter to his descendants",
	"2" => "Map",
	"3" => "Undelivered letter",
	"4" => "Diagrams and plans for a mysterious invention",
	"5" => "Scroll of magic spells",
	"6" => "Wild story of adventure",
	"7" => "Last will and testament, character is an heir",
	"8" => "Treasure map",
	"9" => "Character's true (and colorful) family history",
	"10" => Repeater(Roll("d3"), TableInvoker("863E", DiceRoller::from("d9"))),
]);
