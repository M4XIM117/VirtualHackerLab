echo "Starte Konvertierung..."
for file in *.md
    echo "Konvertiere $file in www/Versuche/" 

    pandoc $file -f markdown -t html5 

end

echo "feddig"
