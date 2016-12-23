<?php

namespace HeroesOfLegend;

return new NamedTable("865", "Color", DiceRoller::from("d20"), [
	"1" => "Red (crimson, scarlet or blood red)",
	"2" => "Red orange (sunset orange)",
	"3" => "Orange",
	"4" => "Yellow orange",
	"5" => "Yellow",
	"6" => "Yellow green (citrine)",
	"7" => "Green",
	"8" => "Blue green (aquamarine, tourquoise)",
	"9" => "Blue",
	"10" => "Blue violet (royal blue)",
	"11" => "Violet (purple, lavender)",
	"12" => "Red violet (magenta, hot pink)",
	"13" => "Pink",
	"14" => "White (snow while, off white, ivory)",
	"15" => "Black (ebony, true black)",
	"16" => "Gray",
	"17" => "Maroon (reddish or purplish brown)",
	"18" => "Silver",
	"19" => "Gold",
	"20" => function(State $s) {
		$s->invokeTable("865", DiceRoller::from("d19"));
		return Roll("d2") === 1 ? 'Lighter (pastel tint) version of:' : 'Darker sade of:';
	},
]);
