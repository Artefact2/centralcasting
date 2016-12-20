<?php

/*<<< Name: Occupations >>>*/

/* Yes, -2, this is not a typo */
if($s->char->CuMod <= -2) {
	/* Primitive */
	Invoke($s, "420A");
} else if($s->char->CuMod <= 0) {
	/* Nomad */
	Invoke($s, "421A");
} else if($s->char->CuMod <= 2) {
	/* Barbarian */
	Invoke($s, "422A");
} else {
	/* Civilized */
	Invoke($s, "423A");
}
