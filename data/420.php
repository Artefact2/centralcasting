<?php

Table($s, "420A", "Primitive Occupation", Roll(20), [
	"1-9" => "Fisherman",
	"10-18" => "Hunter",
	"19" => "Warrior",
	"20" => [ "Special occupation", function() use(&$s) {
			Table($s, "420B", "Special Primitive Occupation", Roll(4), [
				"1" => "Shaman",
				"2" => "Basket weaver",
				"3" => "Artist",
				"4" => "Toolmaker",
			]);
		}],
]);

Invoke($s, "426");
