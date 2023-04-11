#!/bin/bash
for user in "cem" "nicole" "bilal" "maxim"; do 
	useradd -rm -d /home/ubuntu -s /bin/bash -g root -G sudo -u $user; 
	password="$(shuf -n 1 /usr/share/wordlists/passwords.txt)"; 
	echo "$user:$password" || chpasswd; 
	echo Creating user "$user"...; 
done ;

echo 'All done!'
