
# Webprogrammierung Team DI-12-B

## Namen der Studierenden

- Robin Visser
- Tim Schröder
- Nils Renneberg<br>

## Betriebsvorraussetzungen
Es gibt einen voreingestellten Nutzer mit folgenden Daten:

Benutzername "tim@test.de"\
Passwort "helloworld"\
sowie einige Kommentare und Beiträge, die bereits zum Start in der Website sind. Diese sind nicht endgültig löschbar (bzw. werden automatisch wieder erzeugt). Die Beträge und Kommentare wurden vom nicht existenten Nutzer "0" erstellt. Dieser Name ist bei der Registrierung nicht verfügbar (da nur valide Email-Syntax akzeptiert wird).

## Funktionen/Sitemap

## Nicht umgesetzte Teilaufgaben

n/a

## Bekannte Fehler

n/a

## Besonderheiten über die Aufgabe hinaus

Übergibt der Nutzer ein Bild, das bereits im Speicher existiert, wird dieses Bild nicht noch einmal gespeichert und stattdessen wird die alte Referenz mitbenutzt (Das Bild wird erst gelöscht wenn alle Referenzen entfernt sind).

Directory Traversal wurde verhindert und auf sicherheitskritische Dateien (z.B. Datenbank, salt.php) kann nicht zugegriffen werden (Wurde in der Vorlesung zwar auf einer Folie erwähnt, es wurde aber keine detaillierte Möglichkeit erwähnt, es zu verhindern. Daher zählen wir es als "über die Aufgabe hinaus").

## Weitere Anmerkungen

#### Verwendete Technologien

- WAVE für Accessability
- Chromium Devtools für Resizing

#### Speicherstruktur

Die Email wird in email.txt im obersten Verzeichnis gespeichert.

#### XSS und htmlspecialchars

Um nicht so viele verstreute htmlspecialchars() zu haben und keine der Umwandlungen zu vergessen, wird diese Umwandlung <strong> in dem Auslesen aus der Datenbank </strong> vorgenommen. In Ausnahmesituationen konvertiert der PHP Code diese für eine einzelne Zeile mit htmlspecialchars_decode() um.


Um die Umwandlung von 
Später zu beachten:

- Tab Reihenfolge und Tastatur Benutzung für ausgeklappte Navbar muss gut klappen

