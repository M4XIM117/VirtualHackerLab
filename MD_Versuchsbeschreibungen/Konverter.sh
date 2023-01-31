echo "Starte Konvertierung..."
for file in *.md
do
    echo "Konvertiere $file in www/Versuche/Anleitungen" 

    pandoc $file -f markdown -t html5 -c style.css --toc -o ../www/Versuche/Anleitungen/"${file%.*}.html" $file
done

echo "feddig"

