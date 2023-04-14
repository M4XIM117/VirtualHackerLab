# Übungsanleitung

## **Password-Cracking & SQL-Injection**

### Allgemeines

- **Password-Cracking**
    
    Beim Password-Cracking unterscheidet man grundsätzlich zwischen Online und Offline Angriffen.
    - Online-Angriffe sind aufgrund Timeouts der Anfragen nicht so effizient wie ein Offline-Brute-Force Angriff.
    Hierbei versucht man bspw. durch eine Vielzahl an Anfragen das Passwort für einen **bekannten** Usernamen das Passwort zu erraten. Als Input verwendet man den bekannten User und eine Liste (Textdatei) mit gängigen Passwörtern, die durchgetestet werden können.
    - Bei Offline Brute-Force Angriffen sind meistens bereits Passwörter **in gehashter Form** vorhanden (Bereits erfolgreicher Angriff auf Datenbank, wo Usernamen und gehashte Passwörter abgegriffen werden konnten).
    Hierbei werden Timeouts vermieden, da der Rechner lokal Passwörter mit der gegebenen Hash-Variante durchtestet, bis die Hashes identisch sind.
    
- **SQL-Injection**
    
    - Verwendet ein Webserver für Anfragen auf die Datenbank (bspw. Login) unsichere SQL-Queries, können mit schlauen Eingabestrings die SQL-Queries so manipuliert werden, dass man einen Bypass erzeugt und vortäuscht, sich erfolgreich eingeloggt zu haben. Hierfür gibt es ebenfalls Tools, um Webformulare auf mögliche SQL-Injections zu testen.
    

## Komponenten 

- ## Angreifer
    
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

- ## Angriffsziele

  - **Ubuntu Rechner**
    
    Einfaches Ziel für den ersten Abschnitt des Versuchs, um sich mit Brute-Force vertraut zu machen. 
    Besitzt mehrere User für eine ssh-Verbindung, welche mittels Online-Cracking geknackt wird.    
        
  - **Webapplikation**
    
    Eine einfache Webseite mit Login-Formular und anschließender SQL-Abfragemöglichkeit. Hier wird SQL-Injection simuliert, um Userdaten (gehashte Passwörter) abzugreifen und anschließen offline zu knacken.
    
  - **Datenbank**
    
    Eine MySQL-Datenbank. Enthält Userdaten der Webseite.
    

### 💡Hilfreiche Befehle💡


```
sudo <eigentlicher Befehl>
```
- Je nach Rechtestruktur und Betriebssystem muss man Kommandos das Schlüsselwort 'sudo' davorstellen, um Adminrechte zu verwenden. 
```
nano <Dateiname>
```
- Nano ist ein Textbearbeitungsinstrument für Linux. Ist die angegebene Datei nicht vorhanden wird sie erzeugt. In diesem Versuch benötigen wir nano für die Bearbeitung einer HTTP-Post-Request Datei, welche als Input für die SQL-Injection verwendet wird.
```
docker-compose up -d --build
```
- -d steht für daemon: Service läuft dann im Hintergrund und blockiert nicht das Terminal
- --build: Rebuilded die Docker-Images
  
```
docker exec -it <CONTAINER-NAME> bash
```
- exec führt Befehl auf bestimmten container aus. In diesem Falle bash. Dadurch verbindet man sich mit dem Container und kann da Kommandos ausführen.
- -it: i = interactive; t = Allocate pseudo TTY


# :star: Start

Starten sie die Virualisierungsumgebung indem sich mit dem Befehl
```
sudo docker-compose up -d --build
```
die docker-compose.yaml ausführen. Dadurch werden die oben genannten Komponenten hochgefahren.


<h2 style="color:red">  1. Part: ONLINE Passwort-Cracking </h2>
 
- <h3 style="color:lightblue">1.0 Schritt:😈 (Perspektive: Angreifer/-in)</h3>
    
    Nachdem die Container hochgefahren sind benötigen für den Versuch die IP-Range der Container. 
    In unserer Beispielumgebung führen wir den Befehl
    ```
    ip address
    ```
    aus, welches uns einige Informationen gibt.
    Für uns ist interessant, welche IPv4 unter "br-...... <BROADCAST, MULTICAST, UP, LOWER_UP>" steht. 

    ___
    **_HINWEIS_**:bulb:
    Dies ist nämlich die "Bridge", welche unsere Container verbindet. <br>
    Diese IP endet mit einer .1, da es das Gateway darstellt. <br>
    Bsp: 172.18.0.1
    ___
    
    Haben wir nun die IP-Range, in welche sich unsere Docker-Container befinden, können wir den Versuch beginnen.

- <h3 style="color:lightblue">1.1 Schritt:😈 (Perspektive: Angreifer/-in)</h3>

    
    Loggen sich sich in den KALI-Linux container ein mit dem Befehl:
    ```
    sudo docker exec -it <CONTAINER-NAME> bash
    ``` 
    Hier stehen Ihnen nun die oben gelisteten Tools zur Verfügung.
    
- <h3 style="color:lightblue">1.2 Schritt:😈 (Perspektive: Angreifer/-in) </h3>
    
    
    
- <h3 style="color:lightblue">1.3 Schritt:😈 (Perspektive: Angreifer/-in) </h3>
    
   
    
- <h3 style="color:lightblue">1.4 Schritt:😈 (Perspektive: Angreifer/-in) </h3>
    
    

<h2 style="color:red">  2. Part: SQL-Injection </h2>

- <h3 style="color:lightblue">2.1 Schritt:😈 (Perspektive: Angreifer/-in) </h3>


<h2 style="color:red">  3. Part: OFFLINE Passwort-Cracking </h2>

- <h3 style="color:lightblue">3.1 Schritt:😈 (Perspektive: Angreifer/-in) </h3>


