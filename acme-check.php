#!/usr/bin/php

<?php


function validDom($domain) {
    if(!preg_match("/^(?!\-)(?:[a-zA-Z\d\-]{0,62}[a-zA-Z\d]\.){1,126}(?!\d+)[a-zA-Z\d]{1,63}$/i", $domain) ) {
    return false;
    }
return $domain;
}//end validDom function.

echo "What domain are we validating? ";

//$domain = rtrim(fgets(STDIN));

while(validDom($domain) == false) {
    // take input
    $domain = rtrim(fgets(STDIN));
    if(validDom($domain) == false){
        echo "Please enter a valid domain. Do not include the protocol (http, https): ";
    }
}

echo "\n";

$acme = '_acme-challenge.';
$dmgdev = '._acme-dns.example.com';

$result = dns_get_record($acme.$domain, DNS_CNAME);
$badhost = dns_get_record($acme.$domain.".".$domain, DNS_CNAME);
print_r($result);

// success // CNAME host error // CNAME target mismatch // check amount of records is > 1 // check if any records exist at all
if (count($result) == 1 && $acme.$domain == $result[0]["host"] && $domain.$dmgdev == $result[0]["target"]) {
echo "SUCCESS! ".$domain." HAS A VALID ACME-CHALLENGE RECORD!\n\nRETURNED HOST: ".$result[0]["host"]."\nEXPECTED HOST: ".$acme.$domain."\n\nRETURNED TARGET: ".$result[0]["target"]."\nEXPECTED TARGET: ".$domain.$dmgdev."\n\n".$result[0]["host"]." is an alias of ".$result[0]["target"]."\n\n";
} elseif (count($result) == 0 && $acme.$domain.".".$domain == $badhost[0]["host"]) {
    echo "FAILED! ".$domain." HAS AN INVALID ACME-CHALLENGE RECORD!\nPLEASE CHECK THE HOST PORTION OF THE RECORD!\n\nEXPECTED HOST: ".$acme.$domain."\nRETURNED HOST: ".$badhost[0]["host"]."\n\n";
    } elseif (count($result) == 1 and $domain.$dmgdev != $result[0]["target"]) {
        echo "FAILED! ".$domain." HAS AN INVALID ACME-CHALLENGE RECORD!\nPLEASE CHECK THE TARGET PORTION OF THE RECORD!\n\nEXPECTED TARGET: ".$domain.$dmgdev."\nRETURNED TARGET: ".$result[0]["target"]."\n\n";
    } elseif (count($result) > 1) {
        echo "Hmmm.. ".$domain." returned more than 1 matching result. Please see the Systems team and provide this entire error message: \n\n".print_r($result)."\n\n";
    } elseif (count($result) == 0) {
        echo "Hey buddy, I'm so sorry.. ".$domain." has no valid records. I know you'll find me one with records. :) \n\n";
    }

?>
