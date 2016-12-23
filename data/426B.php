<?php

namespace HeroesOfLegend;

return new NamedTable("426B", "Achievement Level (NPCs Only)", DiceRoller::from("d20"), [
	"1-2" => [ "Apprentice", function() {
		if(Roll("d20") >= 19) {
			return "Apprentice (acknowledged failure)";
		}
	}],
	"3-14" => "Journeyman",
	"15-17" => "Skilled Tradesman",
	"18-19" => "Master Craftsman",
	"20" => [ "Grand Master", function() {
		$r = Roll("d20");
		if($r === 19) {
			return "Grand Master (legendary skill)";
		}
		if($r === 20) {
			return "Grand Master (mythical skill)";
		}
	}],
]);
