#!/bin/bash
for user in "cem" "nicole" "bilal" "maxim"; do 
	useradd -m -s /bin/bash $user; 
	password="$(shuf -n 1 /usr/share/wordlists/passwords.txt)"; 
	echo "$user:$password" | chpasswd; 
	echo Creating user "$user"...; 
done ;

echo 'All done!'
