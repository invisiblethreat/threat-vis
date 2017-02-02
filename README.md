threat-vis
==========

Feed a list of IP addresses to an app, have it generate a world map of associated countries.

Requirements
------------
* MySQL
* PHP
* Access to cron would be nice, but not essential

What it does
------------
This generates a heat-map of the world based on IP addresses. In the current implementation it
uses IP addresses collected by the [Artillery Project][1]. A current implementation can be seen
at [InvisibleThreat][2]. This generates the page on the fly, but modifications could easily be 
made to generate a static page each day via cron.

[1]: https://www.trustedsec.com/downloads/artillery/ "Artillery Project"
[2]: https://www.invisiblethreat.ca/daily_threat_vis/ "InvisibleThreat"

Future Improvements
-------------------
* Better documentation
