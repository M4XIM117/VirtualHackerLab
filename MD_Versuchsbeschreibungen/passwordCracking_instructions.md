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
    

### Komponenten 

- ### Angreifer
    
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

- ### Angriffsziele

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
- Je nach Rechtestruktur und Betriebssystem (Linux) muss man Kommandos das Schlüsselwort 'sudo' davorstellen, um den Befehl als "Superuser" auszuführen. 
  

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

Starten sie die Virtualisierungsumgebung indem sie mit dem Befehl
```
sudo docker-compose up -d --build
```
die docker-compose.yaml ausführen. Dadurch werden die oben genannten Komponenten hochgefahren. <br>
Als letzte Ausgabe sieht man die unterschiedlichen Containernamen:
_password\_cracking\_\<Komponente>\_\<x>_ <br>
:exclamation: Die konkreten Namen benötigen wir für den Versuch.

<h2 style="color:red">  1. Part: ONLINE Passwort-Cracking (ssh) </h2>
 
- <h3 style="color:lightblue">Schritt 1.0</h3>
  Loggen sich sich in den KALI-Linux container ein mit dem Befehl:

  ```
  sudo docker exec -it <Name des Kali-Containers> bash
  ``` 
  Hier stehen Ihnen nun die oben gelisteten Tools zur Verfügung.


- <h3 style="color:lightblue">Schritt 1.1</h3>

  Nachdem Sie sich auf den Kali-Container geschalten haben wollen wir erstmal ein Netzwerk nach bekannten Hosts scannen. Zuerst wollen wir aber die IP-Range herausfinden. In diesem Versuch ist es die IP-Range der Docker-Container, welche soeben hochgefahren wurden. Da der Kali-Container ebenfalls dazugehört, können wir die Ip-Range aus der IP-Adresse ableiten, welche der Kali-Container hat.
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
  :exclamation: Beachten Sie, dass die IP-Adresse nicht 1:1 eingesetzt wurde. Mit diesem Befehl lassen wir uns bekannte Ports aus dem Subnetz _172.18.0_ über eine Range von 16 Host-IDs anzeigen.

  Nun benötigen wir für den restlichen Versuch folgende Informationen aus der Ausgabe: _(Kopieren Sie sich diese in einen Texteditor!)_
  - IP-Adresse, wo Host gefunden wurde
  - Der bekannte Port der einzelnen IP-Adressen<br> (999 & 998 sind uninteressant, nur die tabellarische Ausgabe beachten)
  - Der jeweilige Service hinter einem Port (Sie sollten ssh, http und mysql finden)
  
- <h3 style="color:lightblue">Schritt 1.2</h3>
  Nun wollen wir den Dictionary-Angriff auf den ssh-Host starten.
  
  Sie sollten im aktuellen Verzeichnis mit dem Befehl _ls_ die Datei passwords.txt sehen. Mit dem _nano_-Befehl können Sie die Datei öffnen und mal anschauen.
  Die Datei beinhaltet die 200 gängigsten Passwörter. Diese Datei verwenden wir als Input für unseren Angriffsversuch mit _Hydra_.
  
  
    
    
- <h3 style="color:lightblue">Schritt 1.3</h3>
    
   
    
- <h3 style="color:lightblue">Schritt 1.4</h3>
    
    

<h2 style="color:red">  2. Part: SQL-Injection </h2>

- <h3 style="color:lightblue">Schritt 2.1</h3>


<h2 style="color:red">  3. Part: OFFLINE Passwort-Cracking </h2>

- <h3 style="color:lightblue">Schritt 3.1</h3>


