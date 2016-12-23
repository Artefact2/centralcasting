<?php

namespace HeroesOfLegend;

return new NamedTable("109", "Time of Birth", DiceRoller::from("d1"), [
	"1" => gmdate("F \\t\\h\\e jS \\a\\t g a", time() + Roll("d365*86400") + Roll("d86400")),
]);
