<?php


$a = "@!empty(\$a)\n{!\$a!}\n@endempty";
preg_match_all('/@!empty\((.+?)\)/', $a, $m);
preg_match_all('/@endempty/', $a, $endissetMatches);
echo '<pre>';
echo 'Ban đầu:<br/>'.$a;
echo '</pre>';
echo '<pre>';
print_r($m);
echo '</pre>';


if (!empty($m[1])) {
    foreach ($m[1] as $key => $value) {
        $replaceFor = "<?php if(!empty(" . trim($value) . ")): ?>";
        $a = str_replace($m[0][$key], $replaceFor, $a);
        $a = str_replace($endissetMatches[0][$key], '<?php endif; ?>', $a);
    }
}
echo '<pre>';
print_r($a);
echo '</pre>';