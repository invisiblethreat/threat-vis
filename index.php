<?php

        $server   = ''; // MySQL hostname
        $username = ''; // MySQL username
        $password = ''; // MySQL password
        $dbname   = ''; // MySQL db name


        $db = mysql_connect($server, $username, $password) or die(mysql_error());
              mysql_select_db($dbname) or die(mysql_error());
        
        $bans = array();

        $lines = file('banlist.txt');
        foreach ($lines as $lnum => $line) {
                $l=rtrim($line);
                $sql = 'SELECT 
                            c.country 
                        FROM 
                            ip2nationCountries c,
                            ip2nation i 
                        WHERE 
                            i.ip < INET_ATON("'.$l.'") 
                            AND 
                         c.code = i.country 
                        ORDER BY 
                        i.ip DESC 
                        LIMIT 0,1';
                list($cc) = mysql_fetch_row(mysql_query($sql));

                if ($cc != "")
                        if(empty($bans["$cc"]))
                        {
                                $bans["$cc"] = 1;
                        }
                        else
                        {
                                $bans["$cc"]++;
                        }

        }

?>

<html><title>Threat Vis</title>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">

<style type="text/css">
body { background-color:#555555; }
a:link {color:#FFFFFF;text-decoration:none}
a:hover {color:#F10000;text-decoration:none}
a:visited {color:#F10000;text-decoration:none}
</style>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
        ['Country','Bans'],
      <?php
        foreach ($bans as $key => $value)
                    print"['$key', $value],\n";
        ?>
        ]);

        var options = {
                        backgroundColor : '#555555',
                        colors : ['#FFFFFF', '#FF0000']
                        };

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    </script>

</head>

<body>
<div style="text-align:center; vertical-align:middle;padding-top:40px;">
        <img src="/it4.png">
<br><br>
<div style="font-family:arial,sans-serif; color:#FFFFFF;text-align:left; padding-left:100px;padding-right:100px;"> 
This is a visualization of the threat feed for the <a href="https://www.trustedsec.com/downloads/artillery/">Project Artillery</a>. The <a href="http://www.ip2nation.com/">ip2nation database</a> is utilized to resolve the IP addresses to countries.
<br>
<div style="padding-top:20px; padding-left:50px;">
Last check for updates: <?php print date("r",filemtime('last_check'));?> 
<br>
Artillery banlist.txt last update: <?php print date("r",filemtime('banlist.txt'));?> 
<br>
ip2nation.sql last update: <?php print date("r",filemtime('ip2nation.sql'));?>

</div>
</div>

<center>    <div id="chart_div" style="width: 900px; height: 500px; padding-top:20px;"></div></center>

</div>
</body>
</html>
