<?php

Table($s, "426B", "Achievement Level (NPCs ONLY)", Roll(20), [
	"1-2" => [ "Apprentice", function() {
		if(Roll(20) >= 19) {
			return "Apprentice (acknowledged failure)";
		}
	}],
	"3-14" => "Journeyman",
	"15-17" => "Skilled Tradesman",
	"18-19" => "Master Craftsman",
	"20" => [ "Grand Master", function() {
		$r = Roll(20);
		if($r === 19) {
			return "Grand Master (legendary skill)";
		}
		if($r === 20) {
			return "Grand Master (mythical skill)";
		}
	}],
]);
