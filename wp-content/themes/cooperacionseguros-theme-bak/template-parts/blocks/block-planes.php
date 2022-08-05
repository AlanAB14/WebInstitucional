<?php

/**
 * Bloques para mostrar planes, separados en fragments
 */


if (basename(get_permalink()) == 'seguro-de-vida-individual') {
  get_template_part('template-parts/planes/fragment-planes-vida');
} else if (basename(get_permalink()) == 'seguro-de-autos-y-pick-ups') {
  get_template_part('template-parts/planes/fragment-planes-autos');
} else if (basename(get_permalink()) == 'seguro-de-motos') {
  get_template_part('template-parts/planes/fragment-planes-motos');
}
