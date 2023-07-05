# **Password-Cracking & SQL-Injection**

## Allgemeines

### **Password-Cracking**
    
  Beim Password-Cracking unterscheidet man grundsätzlich zwischen Online und Offline Angriffen:

  - Online-Angriffe sind aufgrund Timeouts der Anfragen nicht so effizient wie ein Offline-Brute-Force Angriff.
  Hierbei versucht man bspw. durch eine Vielzahl an Anfragen das Passwort für einen **bekannten** Usernamen das Passwort zu erraten. Als Input verwendet man den bekannten User und eine Liste (Textdatei) mit gängigen Passwörtern, die durchgetestet werden können.
  - Bei Offline Brute-Force Angriffen sind meistens bereits Passwörter **in gehashter Form** vorhanden (Bereits erfolgreicher Angriff auf Datenbank, wo Usernamen und gehashte Passwörter abgegriffen werden konnten).
  Hierbei werden Timeouts vermieden, da der Rechner lokal Passwörter mit der gegebenen Hash-Variante durchtestet, bis die Hashes identisch sind.
    
### **SQL-Injection**
    
  - Verwendet ein Webserver für Anfragen auf die Datenbank (bspw. Login) unsichere SQL-Queries, können mit schlauen Eingabestrings die SQL-Queries so manipuliert werden, dass man einen Bypass erzeugt und vortäuscht, sich erfolgreich eingeloggt zu haben. Hierfür gibt es ebenfalls Tools, um Webformulare auf mögliche SQL-Injections zu testen.
    

## Komponenten 

### Angreifer
    
  - **Kali Linux**
    
    Eine auf Debian basierte Linux Distribution. Kali Linux stellt Programme für Penetrationstest zur Verfügung. Die auf dieser Distribution installierten Programme unterstützen den/die Angreifer/-in, in dieser Übung bei dem Webshell-Angriff.
    
    - **Hydra**
        
        Brute-Force Passwort-Cracking Werkzeug mit unterschiedlichen Funkionen. 
        Hier verwendet für den ersten einfachen online Brute-Force Angriff.
        
    - **SQL Map**
        
        Werkzeug um Formulare o.Ä. auf mögliche SQL-Injections zu testen.
    
    - **HashCat**
        
        Werkzeug um Brute-Force auf gehashte Werte durchzuführen.

    - **NMap**

        Werkzeug für Network Discovery, um Hosts zu entdecken.

### Angriffsziele

  - **Ubuntu Rechner**
    
    - Einfaches Ziel für den ersten Abschnitt des Versuchs, um sich mit Brute-Force vertraut zu machen. 
    Besitzt mehrere User für eine ssh-Verbindung, welche mittels Online-Cracking geknackt wird.    
        
  - **Webapplikation**
    
    - Eine einfache Webseite mit Login-Formular und anschließender SQL-Abfragemöglichkeit. Hier wird SQL-Injection simuliert, um Userdaten (gehashte Passwörter) abzugreifen und anschließen offline zu knacken.
    
  - **Datenbank**
    
    - Eine MySQL-Datenbank. Enthält Userdaten der Webseite.
    

### 💡Hilfreiche Befehle💡


```
sudo <eigentlicher Befehl>
```
- Je nach Rechtestruktur und Betriebssystem (Linux) muss man Kommandos das Schlüsselwort 'sudo' davorstellen, um den Befehl auszuführen. 
  

```
nano <Dateiname>
```
- Nano ist ein Textbearbeitungsinstrument für Linux. Ist die angegebene Datei nicht vorhanden wird sie erzeugt. In diesem Versuch benötigen wir nano für die Bearbeitung einer HTTP-Post-Request Datei, welche als Input für die SQL-Injection verwendet wird.

# Start

<h3 style="color:Tomato">1. Part: ONLINE Passwort-Cracking (ssh)</h2>

<h3 style="color:steelblue">Schritt 1.1 Offene Ports scannen</h3>

  Zuerst wollen wir das Netzwerk nach bekannten Hosts scannen. Hierzu benötigen wir jedoch eine IP-Range. In diesem Versuch ist es die IP-Range der Docker-Container, welche soeben hochgefahren wurden. Da der Kali-Container ebenfalls dazugehört, können wir die Ip-Range aus der IP-Adresse ableiten, welche der Kali-Container hat.
  Hierzu führen wir folgenden Befehl aus:
  ```
   ip address show eth0
  ```
  In der Ausgabe sehen wir nun einen Eintrag nach _inet_ die IP-Adresse des Containers.

  Bspw. 172.18.0.5/16
  
  Diese Information setzen wir in den nächsten Befehl _nmap_, welcher oben bereits beschrieben wurde.
  ```
  nmap 172.18.0.0-16
  ```
  ❗  Beachten Sie, dass die IP-Adresse nicht 1:1 eingesetzt wurde. Mit diesem Befehl lassen wir uns bekannte Ports aus dem Subnetz _172.18.0_ über eine Range von 16 Host-IDs anzeigen.

  Nun benötigen wir für den restlichen Versuch folgende Informationen aus der Ausgabe: _(Kopieren Sie sich diese in einen Texteditor!)_
  - IP-Adresse, wo ein Host gefunden wurde
  - Der bekannte Port der einzelnen IP-Adressen<br> (999 & 998 sind uninteressant, nur die tabellarische Ausgabe beachten)
  - Der jeweilige Service hinter einem Port (Sie sollten ssh, http und mysql finden)
  
<h3 style="color:steelblue">Schritt 1.2 </h3>
  Nun wollen wir den Dictionary-Angriff auf den ssh-Host starten.
  
  Sie sollten im aktuellen Verzeichnis mit dem Befehl _ls_ die Dateien _passwords.txt_ und _users.txt_ sehen. Mit dem _nano_-Befehl können Sie die Dateien öffnen und mal anschauen.
  Die Dateien beinhalten zum Einen 4 mögliche User, die der Host kennt, zum Anderen beinhaltet es die 200 gängigsten Passwörter. Diese Dateien verwenden wir als Input für unseren Angriffsversuch mit _Hydra_.

  Der Befehl um Hydra zu starten lautet wie folgt:
  ```
  hydra -L users.txt -P passwords.txt ssh://<IP des ssh-services> -V -f
  ```
  - auf -L folgt die Listeneingabe der User
  - auf -P folgt die Listeneingabe der möglichen Passwörter
  - -V loggt die Versuche & -f bricht hydra ab, sobald ein Passwort gefunden wurde.

Hydra zeigt einem dann abschließend Username und Passwort wenn der Versuch erfolgreich abgeschlossen wurde.
Um dies zu bestätigen können Sie nun mit den Informationen versuchen, eine ssh-Verbindung auf den Ubuntu Server herzustellen:
```
ssh <Username>@<IP des Ubuntu Containers>
```

<h3 style="color:Tomato">2. Part: SQL-Injection</h2>
Im zweiten Teil des Versuchs werden wir SQL-Injection auf einer Internetseite anwenden, um an vertrauliche Daten zu kommen. Die Internetseite, welche als Angriffsziel des Versuchs dient, ist der "password_cracking_login_vulnapp" Container.
<h3 style="color:steelblue">Schritt 2.0</h3>
  Sie können die IP-Adresse und den Port des http-Services aus Schritt 1.1 in einen neuen Tab im Webbrowser eingeben, um auf die Internetseite zu gelangen (Bspw. 172.18.0.2:80). Sie sollten ein sehr simples Loginformular sehen.
<h3 style="color:steelblue">Schritt 2.1</h3>
  Wie bereits beschrieben werden bei SLQ-Injections die Eingaben bedacht so gewählt, dass im Backend die Datenbankabfragen manipuliert werden können.
  Das DBMS in diesem Beispiel basiert auf MySQL. Das Backend-Query für das Login-Formular sieht wie folgt aus:

  ```
  SELECT * FROM user WHERE username = '<Input Username>' AND password_hash = '<Input PW>'
  ```
  Probieren Sie, ohne valide Einloggdaten zu kennen, einen erfolgreichen Login vorzutäuschen.<br>
  ___
  💡 _**Hinweis**_

  - In MySQL beginnen Kommentare mit einem #
  - Die Eingabevariablen \<Input Username> & \<Input PW> sind von Hochkommata (') eingeschlossen.
  - '1'='1' ist eine immer wahre WHERE Bedingung
  ___

<h3 style="color:steelblue">Schritt 2.2 </h3>
  Wenn Sie sich erfolgreich "angemeldet" haben, sehen Sie erneut eine Eingabemaske, diesmal jedoch nur mit einem Eingabefeld. Hier werden wir nun mit dem Tool SQLMAP SQL-Injections testen und uns die Ergebnisse direkt ausgeben lassen. SQLMAP ist in der Lage gezielt SQL-Injections auf einen Service anzuwenden, um sich so anhand der Responses Informationen über das DBMS zusammenzustellen. 

  Sie finden im Kali-Client eine Datei namens _sqli\_post\_request_. Die Datei beinhaltet den Post-Request, welcher an die Seite gesendet mit Abschicken des Formulars. Um die Datei für Ihren Versuch vorzubereiten müssen Sie in der Datei an drei Stellen _\<IP Adresse>_ mit der IP des password_cracking_login_vulnapp Containers ersetzen, die selbe IP, welche Sie in der Browser eingegeben haben (ohne :Port!).

<h3 style="color:steelblue">Schritt 2.3</h3>
  Wenn Sie die Datei vorbereitet haben, können Sie mit folgendem Befel SQLMAP auf den HTTP-Request starten:

  ```
  sqlmap -r sqli_post_request -p "name" --dump
  ```
  - _username_ wird als _testable parameter_ übergeben
  - -- dump bringt sqlmap dazu, sämtliche Informationen auszugeben, welches es abgreifen kann
  - 💡 SQLMAP stellt Ihnen Fragen bzgl. des weiteren Verlaufs.  Lesen Sie die Hinweise und antworten Sie dementsprechend.
  
  ❗ SQLMAP erkennt die Hashwerte in Kombination mit dem Spaltennamen direkt als angreifbare Passwortspalte und bietet Ihnen an, einen Dictionary-Attack zu starten. Tippen Sie _"y"_ ein. Anschließend müssen Sie auswählen, ob Sie ein eigenes Dictionary mitgeben möchten. Dies bestätigen Sie indem Sie _"2"_ eintippen (Sie können auch den Default verwenden). Die Datei liegt im aktuellen Verzeichnis und heißt _"passwords.txt"_. Tippen Sie den Pfad zu der Datei ein und lassen Sie sich die Passwörter neben den Hashwerten anzeigen.

___

🛠️<br> 
Um die Sicherheitslücke für SQL-Injection zu schließen können die Eingaben vorab validiert werden sowie in Parameter für _Prepared Statements_ einfließen. _Prepared Statements_ sind ein Best-Practice. Hier eine Zusammenfassung, wie diese aufgebaut sind und funktionieren:
https://www.w3schools.com/php/php_mysql_prepared_statements.asp<br>
Bei Passwort-Agriffen sollten man Betreiber einer Webseite oder eines Services strikte Passwortrichtlinien einsetzen, um die Nutzer zu schützen. Regelmäßige Passwortänderungen sind ebenso empfehlenswert. Außerdem konnte man in diesem Versuch gut sehen, dass der Hash-Algorithmus schnell berechnet wurde. Algorithmen wie Argon2 benötigen deutlich mehr Zeit und machen Brute-Force noch ineffizienter.<br>
🛠️<br>
___

## Sie haben das Ende der Übung erreicht 


