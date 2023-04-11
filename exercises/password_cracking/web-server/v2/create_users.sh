#!/bin/bash
for user in "cem" "nicole" "bilal" "maxim"; do 
	useradd $user; 
	password="$(shuf -n 1 /usr/share/wordlists/fasttrack.txt)"; 
	echo "$user:$password" || chpasswd; 
	echo Creating user "$user"...; 
done ;

echo 'All done!'
