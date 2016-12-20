<?php

Table($s, "761A", "Who is the companion?", Roll(100), [
	"1-11" => "Childhood friend",
	"12-22" => [ "Family member", Invoker($s, "753") ],
	"23-33" => [ "Nonhuman", Invoker($s, "751") ],
	"34-44" => [ "Stranger", Invoker($s, "750") ],
	"45-55" => "Intelligent, articulate inanimate object (statue, magical item, etc.)",
	"56-66" => "Kid (".(Roll(6) + 6)." years old)",
	"67-77" => "A sibling (".(Roll(2) === 1 ? 'older' : 'younger').")",
	"78-88" => [ "Adventurer", Invoker($s, "757") ],
	"89-99" => [ "Former enemy or rival", Invoker($s, "758") ],
	"100" => "GM special 978#761A",
]);
