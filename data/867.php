<?php

namespace HeroesOfLegend;

return new NamedTable("867", "Body Location", DiceRoller::from("d20"), [
	"1" => "Right foot",
	"2" => "Left foot",
	"3" => "Right leg",
	"4" => "Left leg",
	"5-6" => "Abdomen",
	"7-8" => "Buttocks",
	"9" => "Back",
	"10-13" => "Chest",
	"14" => "Right arm",
	"15" => "Left arm",
	"16" => "Right hand",
	"17" => "Left hand",
	"18" => "Head",
	"19-20" => "Face",
]);
