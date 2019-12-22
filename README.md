# acme-check

THIS PROJECT WAS IMPROVED AND IS NOW KNOWN AS "dig-acme"! Find it here!

https://github.com/jaywire/dig-acme


This PHP script is an internal project for my own environment, but the purpose of this script is to check for a valid "_acme-challenge" CNAME record when using DNS-01 validation with LetsEncrypt. DNS-01 validation will follow a CNAME as if it were a TXT record, as long as you use the same formatting as required for the TXT record. 

_acme-challenge.domain.dev

You can then point this to a record within your own DNS zone. 

This is useful in a situation where you may not control the DNS zone you are managing. Due to the volatility of LetsEncrpyt Certificates, it can be troublesome to coordinate with the person(s) who control another domain and have them place the TXT validation record, and also count on them to place it correctly. Having them place a CNAME record once is much easier in this case. 

The only thing you will need to do is adjust the variable for $dmgdev to something within your DNS zone. I suggest creating a TXT record for the domain.dev._acme-dns.yourzone.com and placing your TXT value here. (This can be automated, but that isn't the purpose of this script at this time.)

By the above logic, that means your value for $dmgdev is ._acme-dns.yourzone.com


For now, this script will do the following:

1. Validate the domain through a RegEx. If no valid domain is provided, it will continue to loop you through the process until a valid domain that passes the check is provided.
2. Check the domain for a CNAME record with a HOST value in the proper format: _acme-challenge.domain.dev
3. Check the TARGET portion against your provided values $domain and $dmgdev - domain.dev._acme-dns.yourzone.com
4. Check for issues such as empty arrays or mismatched records and provide some guidance towards what the issue could be. 


# To Use:

Place the file with no extension (acme) in your usr/bin/ directory and make sure you have proper perms set (0755) before running. To run, type "acme" into your terminal. 


