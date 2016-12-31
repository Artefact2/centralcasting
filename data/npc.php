<?php

namespace HeroesOfLegend;

$npc = $s->getRootCharacter();
$npc->getRootEntry()->setSourceName('Non Player Character');

$npc->setName('Non Player Character');
$npc->setType(Character::NPC);
$npc->setAgeRange(Character::ADULT);
$npc->addTrait('R');
$npc->addTrait('R');
$npc->addTrait('R');

$s->invoke("7101", "101", "102", "103", "114B");
$s->invoke("318");

SubentryCreator("300", "Done!", "Now what?", Combiner(
	LineAdder("Give the NPC a name"),
	LineAdder("Decide whether the NPC is famous, well known, unknown or mysterious"),
	LineAdder("Select NPC's age (page 4)")
))($s);
