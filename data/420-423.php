<?php

/* Yes, -2, this is not a typo */
if($s->char->CuMod <= -2) {
	/* Primitive */
	Invoke($s, "420");
} else if($s->char->CuMod <= 0) {
	/* Nomad */
	Invoke($s, "421");
} else if($s->char->CuMod <= 2) {
	/* Barbarian */
	Invoke($s, "422");
} else {
	/* Civilized */
	Invoke($s, "423");
}