<?php
$n = readline("Masukkan nilai n: ");

if (is_numeric($n) && $n > 0) {
    echo "Output untuk n = $n:\n";
    
    for ($i = 1; $i <= $n; $i++) {
      $habisDibagi4 = ($i % 4 == 0);
      $habisDibagi5 = ($i % 5 == 0);
      $habisDibagi6 = ($i % 6 == 0);

      if ($habisDibagi4 && $habisDibagi6) {
          echo "Pemrograman Website 2024\n";
      } elseif ($habisDibagi5) {
          echo "2024\n";
      } elseif ($habisDibagi6) {
          echo "Pemrograman\n";
      } elseif ($habisDibagi4) {
          echo "Website\n";
      } else {
          echo $i . "\n";
      }
  }

} else {
    echo "Mohon masukkan bilangan bulat positif!\n";
}
?>