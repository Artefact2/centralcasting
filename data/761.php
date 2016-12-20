<?php

Table($s, "761A", "Who is the companion?", Roll(100), [
	"1-11" => "Childhood friend",
	"12-22" => [ "Family member", Invoker($s, "753") ],
	"23-33" => [ "Nonhuman", Invoker($s, "751") ],
	"34-44" => "Stranger", /* XXX 750 */
	"45-55" => "Intelligent, articulate inanimate object (statue, magical item, etc.)",
	"56-66" => "Kid (".(Roll(6) + 6)." years old)",
	"67-77" => "A sibling (".(Roll(2) === 1 ? 'older' : 'younger').")",
	"78-88" => "Adventurer", /* XXX 757 */
	"89-99" => "Former enemy or rival", /* XXX 758 */
	"100" => "GM special 978#761A",
]);

Table($s, "761B", "Why become a companion?", Roll(10), [
	"1" => "Character saves his life",
	"2" => [ "Seek a similar goal", function() use(&$s) {
			if(Roll(100) <= 30) {
				/* XXX 762C */
				return "Seek a similar goal (friendly rival)";
			}
		}],
	"3" => "Parents were companions in adventure",
	"4" => "Share the same enemy", /* XXX 762 */
	"5" => "In trouble at the same place and time",
	"6" => "Companion sees character as hero and wishes to learn from him",
	"7" => "Companion originally wanted to steal from character",
	"8" => "Companion feels need to protect character",
	"9" => "Mysterious voices and feelings told companion to seek character and join him",
	"10" => "GM special 978#761B",
]);

Invoke($s, "761C");
