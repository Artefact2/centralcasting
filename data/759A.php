<?php

namespace HeroesOfLegend;

return new NamedTable("759A", "Unusual Pet Type", new DiceRoller("d20"), [
	"1-2" => "Dog",
	"3-4" => "Cat",
	"5" => "Bunny rabbit",
	"6" => "Lizard",
	"7" => "Monkey",
	"8" => "Raccoon",
	"9" => "Rat or mouse",
	"10" => "Snake",
	"11" => "Hawk",
	"12" => "Rodent (other than rat, mouse)", /* Ferrets aren't rodents! */
	"13" => "Ferret",
	"14" => "Songbird",
	"15" => function(State $s) {
		return Roll("d6") >= 5 ? "Fish (can survive out of water)" : "Fish";
	},
	"16" => "Puppy",
	"17" => "Mini dragon",
	"18" => "Big cat (lion, tiger, etc.)",
	"19" => "Baby bear (stays a baby)",
	"20" => "Something alien",
]);
