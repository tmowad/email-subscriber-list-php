<?php

function generate_random_digit() {
  $digit = mt_rand(0, 35);
  if ($digit > 9) {
    $digit = chr($digit - 10 + ord('a'));
  } else {
    settype($digit, "string");
  }
  return $digit;
}

function generate_random_key() {
  $key = '';
  for ($i = 0; $i < 30; $i++) {
    $key .= generate_random_digit();
  }
  return $key;
}

?>