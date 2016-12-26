<?php

namespace HeroesOfLegend;

$s->getActiveCharacter()->setPatron(Character::NPC("Patron"));

SubentryCreator(
	"543", "Patron", null,
	Invoker("7101", "543A", "543B", "543C")
)($s);
