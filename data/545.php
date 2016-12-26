<?php

namespace HeroesOfLegend;

SubentryCreator(
	"545", "Death Situation",
	Roll("d10") === 10 ? "Character is linked with death in some unfavorable manner" : null,
	Invoker("545A")
)($s);
