USERNAMES="Cem" "Nicole" "Bilal" "Maxim"
for user in $USERNAMES; do 
	useradd \$user; 
	password=\$(shuf -n 1 /usr/share/wordlists/fasttrack.txt); 
	echo \$user:\$password | chpasswd; 
	echo Creating user \"\$user\"...; 
done