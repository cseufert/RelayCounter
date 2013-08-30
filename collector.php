<?php
/*
 * 247 Relay Challenge Log File Collector / Parser
 * @author Michael Bates <michael@mckinnonsc.vic.edu.au>
 * @package t47
 */

if(!$fp = fopen("c:\users\administrator\desktop\log.txt", 'r')) {
    die("Could not open log file.");
}
while(true) {
    if(!$pos = fopen("c:\pos.txt", 'r')) {
        echo "Could not open position file for reading.";
        usleep(20000);
        continue;
    }
    fseek($fp, (int)fread($pos, 1024));
    fclose($pos);
    if(!$pos = fopen("c:\pos.txt", 'wb+')) {
        echo "Could not open position file for writing.";
        usleep(20000);
        continue;
    }
    $line = fgets($fp);
    $newpos = ftell($fp);
    fwrite($pos, $newpos);
    if(strlen($line) > 0) {
        echo "New lap: ";
        echo $line . PHP_EOL;
        file_get_contents("http://10.128.17.3/api/lap/create?data=$line");
    }
    fclose($pos);
    usleep(20000);
}
fclose($fp);