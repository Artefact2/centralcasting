<?php

namespace HeroesOfLegend;

return new NamedTable("105", "Reason of Illegitimate Birth", DiceRoller::from("d20+CuMod"), [
	"-12" => "Mother was a common prostitute and unmarried",
	"13-14" => [ "Mother was raped, remained unmarried", function(State $s) {
		LineAdder("Father's identity is ".(Roll("d100") <= 15 ? 'known' : 'unknown'))($s);
	}],
	"15-23" => [ "Mother was unmarried", function(State $s) {
		LineAdder("Father's identity is ".(Roll("d100") <= 15 ? 'known' : 'unknown'))($s);
	}],
	"24-27" => [ "Mother was a courtesan (prostitute to Nobility)", function(State $s) {
		LineAdder("Father's identity is ".(Roll("d100") <= 50 ? 'known' : 'unknown'))($s);
	}],
]);
