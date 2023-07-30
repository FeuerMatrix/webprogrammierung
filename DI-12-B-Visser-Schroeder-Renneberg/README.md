
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

#### Seiten

index
: Startseite

hauptseite
: Auf dieser Seite werden alle Beiträge angezeigt\
Es kann eine Suche in der Seite sowie eine Sortierung vorgenommen werden\
Es werden nur die ersten 20 Treffer angezeigt

anmeldung
: Auf dieser Seite findet die Anmeldung statt

beitrag
: Hier wird ein Beitrag angezeigt\
Angezeigte Bilder können durch Klick vergrößert/verkleinert werden\
Angemeldete Nutzer können Kommentare schreiben\
Besitzer von Beiträgen und Kommentaren können diese editieren oder löschen\
Wenn OpenStreetMap aktiviert und ein Positionsmarker gesetzt ist, wird eine Karte mit der Position des Beitrags angezeigt

beitragErstellen
: Angemeldete Nutzer können hier einen Beitrag erstellen\
Der Beitrag kann anonym verfasst werden\
Ein Bild kann angefügt werden\
Wenn OpenStreetMap aktiviert ist, kann ein Positionsmarker gesetzt werden\
Zudem kann man hier bereits erstellte Beiträge editieren, dort kommt man über die Seite des Beitrags hin

confirmEmail
: Hier wird angezeigt, ob die Bestätigung der Email-Addresse erfolgreich war

drittAnbieter
: Hier gibt es Informationen zu OpenStreetMap\
Zustimmung für OpenStreetMap kann gegeben und widerrufen werden

pwChange
: Hier kann ein angemeldeter Nutzer sein Passwort ändern

pwReset
: Hier kann ein Nutzer sein Passwort ändern, falls er dies vergessen hat\
Der Nutzer kommt hier hin indem er versucht, sich erneut zu registrieren, und dann den Link der Email anklickt

registrieren
: Hier kann ein Nutzer sich einen Account erstellen\
Die Email-Addresse fungiert als Nutzername

datenschutz
: Hier gibt es Informationen zu Cookies und Datenschutz

impressum
: Hier findet sich das Impressum der Seite

nutzungsbedingungen
: Hier finden sich die Nutzungsbedingungen der Seite

registrierenFertig
: Hier wird die erfolgreiche Registrierung bestätigt und der Nutzer wird auf die gesendete Bestätigungs-Email verwiesen

#### Features, die nicht direkt eine Seite sind

Navbar
: Hier kann man zwischen den wichtigsten Seiten wechseln
Zudem kann man:
: 1. sich abmelden
: 2. den Nutzer löschen

: Bei genügend kleinem Anzeigegerät muss die Navbar durch Klick auf das entsprechene Symbol ausgeklappt werden

Footer
: Hier kann man zwischen verschiedenen Seiten mit Informationen über die Webseite wechseln

Registrierungsemail
: Die Registrierungsemail wird im Browserfenster geöffnet, ist allerdings eine Textdatei
Man muss darin den Link anklicken um zu bestätigen, dass die Email-Addresse einem selbst gehört

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

Die Email wird in email.txt im Verzeichnis "php/registrieren" gespeichert.

#### XSS und htmlspecialchars

Um nicht so viele verstreute htmlspecialchars() zu haben und keine der Umwandlungen zu vergessen, wird diese Umwandlung <strong> in dem Auslesen aus der Datenbank </strong> vorgenommen. In Ausnahmesituationen konvertiert der PHP Code diese für eine einzelne Zeile mit htmlspecialchars_decode() um.