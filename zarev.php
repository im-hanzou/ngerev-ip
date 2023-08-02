<?php

$banner = "
********************************************************************
*                         Reverse IP                               *
*                        Create by Zaen                            *
********************************************************************";

echo "$banner\n";
set_time_limit(0);

function scraping($ip)
{
    $url = "http://tools.helixs.id/API/revip.php?ip=" . urlencode($ip);
    $hasil = file_get_contents($url);

    preg_match_all('/\b(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z]{2,}\b/i', $hasil, $regex);

    return $regex[0];
}

function ngesave($output)
{
    $out_file = "domain-rev.txt";
    $file = fopen($out_file, "a"); 
    fwrite($file, $output); 
    fclose($file); 
}
echo "List: ";
$input_file = trim(fgets(STDIN));

if (!file_exists($input_file)) {
    echo "File empty.\n";
    exit();
}

$ips = file($input_file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
foreach ($ips as $ip) {
    $ip = trim($ip);
    $hasil_domain = scraping($ip);
    $jumlah_domain = count($hasil_domain);

    $warna_domain = "\033[0;32m{$jumlah_domain}\033[0m";
    echo "[+] {$ip} => Total: [{$warna_domain}] domain\n";

    $output = implode(PHP_EOL, $hasil_domain) . PHP_EOL;
    ngesave($output);
}
