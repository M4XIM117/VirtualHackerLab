echo "Starte Konvertierung..."
for file in *.md
do
    echo "Konvertiere $file zu HTML

    pandoc $file -f markdown -t html5 --toc -o "${file%.*}.html" $file
done

echo "feddig"

