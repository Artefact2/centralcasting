<?php

Table($s, "420A", "Primitive Occupation", Roll(20), [
	"1-9" => "Fisherman",
	"10-18" => "Hunter",
	"19" => "Warrior",
	"20" => [ "Special occupation", Invoker($s, "420B") ],
]);

Invoke($s, "426");
