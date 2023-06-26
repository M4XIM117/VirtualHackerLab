echo "Starte Konvertierung..."
for file in *.md
do
    echo "Konvertiere $file in www/Versuche/Anleitungen" 

    pandoc $file -f markdown -t html5 -c ../www/styles/pandoc.css --toc -o "${file%.*}.html" $file
done

echo "feddig"

