echo "Starte Konvertierung..."
for file in *.md
    echo "Konvertiere $file in www/Versuche/" 

    pandoc $file -f markdown -t html5 -o ../www/Versuche/Anleitungen/"${file%.*}.html" $file
done

echo "feddig"
