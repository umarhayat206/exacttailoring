#!/bin/sh

perl awstats.pl -config=$1  -update
perl awstats.pl -config=$1 -output -staticlinks > index.html
perl awstats.pl -config=$1 -output=alldomains -staticlinks > awstats.$1.alldomains.html
perl awstats.pl -config=$1 -output=allhosts -staticlinks > awstats.$1.allhosts.html
perl awstats.pl -config=$1 -output=lasthosts -staticlinks > awstats.$1.lasthosts.html
perl awstats.pl -config=$1 -output=unknownip -staticlinks > awstats.$1.unknownip.html
perl awstats.pl -config=$1 -output=alllogins -staticlinks > awstats.$1.alllogins.html
perl awstats.pl -config=$1 -output=lastlogins -staticlinks > awstats.$1.lastlogins.html
perl awstats.pl -config=$1 -output=allrobots -staticlinks > awstats.$1.allrobots.html
perl awstats.pl -config=$1 -output=lastrobots -staticlinks > awstats.$1.lastrobots.html
perl awstats.pl -config=$1 -output=urldetail -staticlinks > awstats.$1.urldetail.html
perl awstats.pl -config=$1 -output=urlentry -staticlinks > awstats.$1.urlentry.html
perl awstats.pl -config=$1 -output=urlexit -staticlinks > awstats.$1.urlexit.html
perl awstats.pl -config=$1 -output=browserdetail -staticlinks > awstats.$1.browserdetail.html
perl awstats.pl -config=$1 -output=osdetail -staticlinks > awstats.$1.osdetail.html
perl awstats.pl -config=$1 -output=unknownbrowser -staticlinks > awstats.$1.unknownbrowser.html
perl awstats.pl -config=$1 -output=unknownos -staticlinks > awstats.$1.unknownos.html
perl awstats.pl -config=$1 -output=refererse -staticlinks > awstats.$1.refererse.html
perl awstats.pl -config=$1 -output=refererpages -staticlinks > awstats.$1.refererpages.html
perl awstats.pl -config=$1 -output=keyphrases -staticlinks > awstats.$1.keyphrases.html
perl awstats.pl -config=$1 -output=keywords -staticlinks > awstats.$1.keywords.html
perl awstats.pl -config=$1 -output=errors404 -staticlinks > awstats.$1.errors404.html
