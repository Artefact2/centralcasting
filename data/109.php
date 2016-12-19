<?php

$s->char->entries[] = [
	"109", "Time of Birth", gmdate("F \\t\\h\\e jS \\a\\t g a", time() + 86400 * Roll(365) + Roll(86400))
];
