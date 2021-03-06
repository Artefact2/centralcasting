<?php

namespace HeroesOfLegend;

$pc = $s->getRootCharacter();
$pc->getRootEntry()->setSourceName('Player Character');

$pc->setName('Player Character');
$pc->setType(Character::PC);
$pc->setAgeRange(Character::CHILD);

SubentryCreator(
	"100", "Birth Events", null,
	Invoker("101", "102", "103", "104", "106", "107", "109", "110", "112", "114")
)($s);

SubentryCreator(
	"200", "Childhood Event(s), age ".Roll("d12")." (human equivalent)", null,
	Invoker("215")
)($s);

$pc->setAgeRange(Character::ADOLESCENT);
SubentryCreator(
	"200", "Adolescent Event(s), age ".Roll("d6+12")." (human equivalent)", null,
	Invoker("215")
)($s);

$pc->setAgeRange(Character::ADULT);
SubentryCreator(
	"200", "Adulthood Event(s)", null,
	Invoker("217")
)($s);

$s->invoke("318");

SubentryCreator("300", "Done!", "Now what?", function(State $s) {
	LineAdder("Reread 'Motivations' (page 8)")($s);
	LineAdder("Reread 'Linking Events' (page 11)")($s);
	LineAdder("Write up your character history (page 12)")($s);
})($s);
