for user in $("Cem" "Nicole" "Bilal" "Maxim"); do \
	    useradd \$user; \
	    password=\$(shuf -n 1 /usr/share/wordlists/fasttrack.txt); \
done