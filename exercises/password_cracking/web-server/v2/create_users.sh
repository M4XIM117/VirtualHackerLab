USERNAMES="Cem" "Nicole" "Bilal" "Maxim"
for user in $USERNAMES; do 
	useradd \$user; 
	password=\$(shuf -n 1 /usr/share/wordlists/fasttrack.txt);  
done