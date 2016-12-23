<?php

namespace HeroesOfLegend;

return new NamedTable("761B", "Why?", DiceRoller::from("d10"), [
	"1" => "Character saves his life",
	"2" => [ "Seek a similar goal", function(State $s) {
			if(Roll("d100") <= 30) {
				$s->invoke("762C");
				return "Seek a similar goal (friendly rival)";
			}
		}],
	"3" => "Parents were companions in adventure",
	"4" => [ "Share the same enemy", Invoker("762") ],
	"5" => "In trouble at the same place and time",
	"6" => "Companion sees character as hero and wishes to learn from him",
	"7" => "Companion originally wanted to steal from character",
	"8" => "Companion feels need to protect character",
	"9" => "Mysterious voices and feelings told companion to seek character and join him",
	"10" => "GM special 978#761B",
]);
