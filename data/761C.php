<?php

namespace HeroesOfLegend;

return new NamedTable("761C", "What kind?", DiceRoller::from("d10"), [
	"1-3" => "Loyal Friend",
	"4-5" => "Bumbling Buddy",
	"6" => "Grim Ally",
	"7" => "Gung-ho Joe",
	"8" => "Groaning Griper",
	"9" => "Good ol' Boy",
	"10" => "Incurable Romantic",
]);
