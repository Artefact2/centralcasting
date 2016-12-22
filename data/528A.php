<?php

Table($s, "528A", "Cause of Destruction", Roll(6), [
	"1" => "Deadly disease",
	"2-3" => "Terrible fire",
	"4-5" => "War",
	"6" => [ "Someone's actions", Invoker($s, "750") ],
]);
