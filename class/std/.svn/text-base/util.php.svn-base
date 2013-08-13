<?php

class stdUtil {
  static function gcd($a, $b) {
    if ($a == 0 || $b == 0)
      return abs(max(abs($a), abs($b)));
    $r = $a % $b;
    return ($r != 0) ? self::gcd($b, $r) : abs($b);
  }
  
  static function array_shift_n(array $a, $n) {
    for($i = 0; $i < $n; $i++) {
      $item = array_shift($a);
      array_push($a, $item);
    }
    return $a;
  }
}

?>
