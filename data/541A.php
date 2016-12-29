<?php

namespace HeroesOfLegend;

return new NamedTable("541A", "How?", new DiceRoller("d10"), [
	"1" => "Hostile encounter (followers of god are persecuting unbelievers)",
	"2" => "Evangelism (priests of god press their beliefs on character in hopes of gaining new follower)",
	"3" => "Curiosity (character hears stories of religion and goes to personally investigate)",
	"4" => "Inner need (character feels he/she must seek out god's religion)",
	"5" => "Voices (character hears voices inside head, speaking of god and its religion)", /* Another book typo (relgion) */
	"6" => function(State $s) {
		$ac = $s->getActiveCharacter();
		if($ac->hasMother() || $ac->hasFather() || $ac->hasGuardian()) {
			return "Parent's/guardian's religion (character has grown up with religion, now personally confronted by it)";
		}

		$s->invoke("541A");
		return '';
	},
	"7" => "Friend's religion (friend invites character to come to god's temple)",
	"8" => "Refuge (from rain, or snow, etc., temple was only warm/dry place with open door)",
	"9" => "Chance encounter (character meets intriguing follower of the god in a lonely place)",
	"10" => "Healing (priests of god healed character of injury or illness)",
]);
