<?php

DEFINE('PATH', $_SERVER['DOCUMENT_ROOT'] . '/entropia/');
DEFINE('MAX_FINISHERS', 20);
DEFINE('MAX_OTHER_CREATURES', 100);
DEFINE('USE_HEALING', false);
DEFINE('SQL', 'mysql');
DEFINE('DEBUG', false);

$LOCALE = 'en';
$LANG_HEADER = 'header';
$LANG_INFO = 'info';
$LANG_SEARCH = 'search';
$LANG_ERROR = 'error';
$LANG_DETAILS = 'details';
$LANG_HELP = 'help';

$filter_names = array(
  'weapon_name',
  'weapon_class',
  'weapon_type',
  'cost',
  'health_effective',
  'time',
  'cost_per_sec',
  'weapon_decay_per_sec',
  'damage',
  'damage_per_pec',
  'weapon_damage',
  'range',
  'weapon_attacks',
  'weapon_dps',
  'weapon_decay',
  'weapon_burn',
  'weapon_markup',
  'weight',
  'power',
  'maxtt',
  'mintt',
  'uses',
  'dmgstb',
  'dmgcut',
  'dmgimp',
  'dmgpen',
  'dmgshr',
  'dmgbrn',
  'dmgcld',
  'dmgacd',
  'dmgelc',
  'sib',
  'hitprof',
  'hitrec',
  'hitmax',
  'dmgprof',
  'dmgrec',
  'dmgmax',
  'source',
  'discovered',
  'found',
);

$filter_matches = array(
  '=',
  '!=',
  '&lt;',
  '&gt;',
  'regex',
  'approx',
);

$enhancer_names = array(
  0 => "enhancer-none",
  1 => "enhancer-accuracy",
  2 => "enhancer-damage",
  3 => "enhancer-economy",
  4 => "enhancer-range",
  5 => "enhancer-skill",
);

$to_roman = array(
  1 => 'I',
  2 => 'II',
  3 => 'III',
  4 => 'IV',
  5 => 'V',
  6 => 'VI',
  7 => 'VII',
  8 => 'VIII',
  9 => 'IX',
  10 => 'X',
);
  
$result = null;

$saaid = null;
$seaid = null;

$scid = null;
$selected_type = null;
$selected_class = null;
$wname = null;

$filter_name = null;
$filter_match = null;
$filter_value = null;

?>

