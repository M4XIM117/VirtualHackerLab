echo "Starte Konvertierung..."
for file in *.md
do
    echo "Konvertiere $file zu HTML" 
    pandoc $file -f markdown -t html5 -o "${file%.*}.html"
done

echo "Erledigt"

