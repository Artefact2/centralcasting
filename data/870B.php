<?php

namespace HeroesOfLegend;

$p = Roll("d2") === 1 ? 'Left' : 'Right';

return new NamedTable("870B", "Body part", DiceRoller::from("d6"), [
	"1" => "$p hand, -1 Dexterity, -1 rank in all manual skills",
	"2" => "$p arm, -1 Dexterity, -1 rank in all manual skills",
	"3" => "$p foot, -1 Dexterity, -50% movement speed",
	"4" => "$p leg, -1 Dexterity, -50% movement speed",
	"5" => "$p thumb, cannot grip weapon with this hand",
	"6" => function() {
		$p = Roll("d2") === 1 ? 'left' : 'right';
		$count = Roll("d3");

		$ret = $count.' finger(s) on '.$p.' hand';
		if($count >= 2) $ret .= ' (cannot grip weapon with this hand)';
		return $ret;
	},
]);
