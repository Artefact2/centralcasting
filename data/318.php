<?php

namespace HeroesOfLegend;

$ac = $s->getActiveCharacter();

SubentryCreator(
	"318", "Alignment & Attitude", null,
	Repeater($ac->getNumTraits('L'), Invoker("647", "318D")),
	Repeater($ac->getNumTraits('D'), Invoker("648", "318D")),
	Repeater($ac->getNumTraits('N'), Invoker("318B", "318D")),
	Repeater($ac->getNumTraits('R'), Invoker("318A")),
	Invoker("318C")
)($s);
