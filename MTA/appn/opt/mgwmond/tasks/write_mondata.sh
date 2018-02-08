#!/bin/bash

data_dir=/MTA/datos/mgwmond/state/queues
data_dir2=/MTA/datos/mgwmond/state/services
mon_file=/MTA/datos/appn/onlog/remotemon
tail -f $mon_file | while read line
do 
	l=`echo $line | sed 's/\.internaldomain//g' | grep -oE "]: .*"`

	echo $line | grep "MintMon"
	if [ $? -eq 0 ]
	then
        	file=`echo $l | awk '{printf "%s_%s", tolower($3),tolower($4)}'`
        	value=`echo $l | awk '{printf "%s" ,$5}'`
		echo "$value" > $data_dir/$file
        	value_services=`echo $l | awk '{printf "q_%s:%s%s%s",$5,$6,$7,$8}'`
		echo "$value_services" > $data_dir2/$file
	else
		file=`echo $l | awk '{printf "%s_%s" ,$2, $3}'`
		value=`echo $l | awk '{printf "%s" ,$4}'`
		echo "$value" > $data_dir/$file
		value_services=`echo $l | awk '{printf "%s" ,$5}'`
		echo "$value_services" > $data_dir2/$file
	fi

done


