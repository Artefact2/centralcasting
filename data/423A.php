<?php

Table($s, "423A", "Civilized Occupation", Roll(10) + $s->char->SolMod, [
	"m2"    => [ null, Invoker($s, "421A") ],
	"m1-5"  => [ null, Invoker($s, "423B") ],
	"6"     => [ null, Invoker($s, "422A") ],
	"7"     => [ null, Invoker($s, "423E") ],
	"8-11"  => [ null, Invoker($s, "423C") ],
	"12-14" => [ null, Invoker($s, "423D") ],
	"15"    => [ null, Invoker($s, "423E") ],
	"16-23" => [ null, Invoker($s, "423D") ],
]);
