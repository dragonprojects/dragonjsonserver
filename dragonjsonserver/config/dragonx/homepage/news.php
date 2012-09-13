<?php
/**
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled with this
 * package in the file LICENSE.txt. It is also available through the
 * world-wide-web at this URL: http://dragonjsonserver.de/license. If you did
 * not receive a copy of the license and are unable to obtain it through the
 * world-wide-web, please send an email to license@dragonjsonserver.de. So we
 * can send you a copy immediately.
 *
 * @copyright Copyright (c) 2012 DragonProjects (http://dragonprojects.de)
 * @license http://framework.zend.com/license/new-bsd New BSD License
 * @author Christoph Herrmann <developer@dragonjsonserver.de>
 */

/**
 * @return array
 */
return array(
    'perpage' => 4,
    'perrow' => 2,
    'news' => array(
        array(
            'title' => 'Version 1.6.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.6.0 ist abgeschlossen und als Download '
                . 'verfügbar.',
            'timestamp' => 0,
        ),
        array(
            'title' => 'Version 1.5.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.5.0 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurde die Accountverwaltung '
                . 'durch ein für Homepage und API gemeinsames '
                . 'Sessionmanagement abgeschlossen und durch die Möglichkeit '
                . 'der temporären Profile abgerundet.',
            'timestamp' => 1347036792,
        ),
        array(
            'title' => 'Version 1.4.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.4.0 ist abgeschlossen und als Download '
                . 'verfügbar. Geändert hat sich vor allem das Layout der '
                . 'Homepage mit insbesondere die Startseite, das Pagination, '
                . 'die Formulare und die Hinweismeldungen. Des Weiteren sind '
                . 'nun auch die Ressourcenabfragen für Navigationselemente '
                . 'und Controlleraufrufe nutzbar sowie die "Sofort loslegen" '
                . 'Möglichkeit.',
            'timestamp' => 1346854222,
        ),
        array(
            'title' => 'Version 1.3.1 zum Download verfügbar',
            'content' =>
                  'Die Version 1.3.1 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurde ein Fehler bei der '
                . 'automatischen Weiterleitung behoben wenn man ohne '
                . 'eingeloggten Account auf die Startseite des '
                . 'Administrationsbereiches zugreifen wollte.',
            'timestamp' => 1346720647,
        ),
        array(
            'title' => 'Version 1.3.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.3.0 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version gab es einige Verbesserungen der '
                . 'vorhandenen Pakete, die Auftrennung der Homepage in einen '
                . 'öffentlichen und administrativen Bereich und die Grundlage '
                . 'für die Benutzerverwaltung durch Ressourcen und Rollen. '
                . 'Des Weiteren wurde die Accountverwaltung erweitert sodass '
                . 'nun Accounts nach der Registrierung validiert, geändert '
                . 'und gelöscht werden können.',
            'timestamp' => 1346707689,
        ),
        array(
            'title' => 'Version 1.2.6 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.6 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurde ein Fehler beim Senden des '
                . 'HTTP Headers bei Multirequests sowie die Probleme '
                . 'der Abfrage der Clientnachrichten bei Multirequests '
                . 'behoben. Clientnachrichten werden nun nur beim letzten '
                . 'Request angefordert und der letzten Antwort bearbeitet.',
            'timestamp' => 1345752151,
        ),
        array(
            'title' => 'Version 1.2.5 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.5 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurden Fehler beim Laden von '
                . 'Records und RecordLists aus dem ZendDbAdapter Storage '
                . 'wodurch Records nicht richtig auf NULL gesetzt wurden und '
                . 'es zu Fehlermeldungen kommen konnte. Des Weiteren war die '
                . 'Erstellung des RSS Feeds fehlerhaft und wurde korrigiert. ',
            'timestamp' => 1345584896,
        ),
        array(
            'title' => 'Version 1.2.4 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.4 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurde vor allem ein Fehler im '
                . 'Paket Account behoben. Der Fehler trat auf, wenn bei einem '
                . 'Service keine API Dokumentation mit einer Annotation '
                . 'zur Ermittlung der Notwendigkeit eines gültigen Accounts '
                . 'vorhanden war.',
            'timestamp' => 1345467048,
        ),
        array(
            'title' => 'Version 1.2.3 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.3 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurde in den Paketen Log und '
                . 'Cronjob SQL Fehler bei der Neuinstallation behoben.',
            'timestamp' => 1345414897,
        ),
        array(
            'title' => 'Version 1.2.2 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.2 ist abgeschlossen und als Download '
                . 'verfügbar. In der Version wurde das Diagramm zur '
                . 'Architektur auf den aktuellen Stand gebracht mit den '
                . 'beiden Paketen Storage und Clientmessage.',
            'timestamp' => 1345413861,
        ),
        array(
            'title' => 'Version 1.2.1 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.1 ist abgeschlossen und als Download '
                . 'verfügbar. Es gab zwei Fehler die behoben wurden. Zum '
                . 'Einen gab es einen SQL Fehler im Paket Log beim '
                . 'Übertragen der Daten in die neue Tabellenstruktur und '
                . 'zum Anderen war die abstrakte Klasse für die Keys der '
                . 'Clientnachrichten nicht als abstrakt definiert.',
            'timestamp' => 1345412535,
        ),
        array(
            'title' => 'Version 1.2.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.2.0 ist abgeschlossen und als Download '
                . 'verfügbar. Weitreichende Änderungen ergab vor allem der '
                . 'Umstieg auf die Storage Engine. Diese ermöglicht es wie '
                . 'ein ORM Records in die Datenbank oder andere Datenquellen '
                . 'zu speichern. Im Gegensatz zu ORMs wird dabei jedoch nicht '
                . 'auf SQL verzichtet sondern effektiv unterstützt. Ein '
                . 'weiteres neues Feature ist die Accountverwaltung für die '
                . 'Homepage mit der man sich nun Registrieren und Anmelden '
                . 'kann sowie die Möglichkeit sein Passwort zurück zu setzen. ',
            'timestamp' => 1345397367,
        ),
        array(
            'title' => 'Version 1.1.1 zum Download verfügbar',
            'content' =>
                  'Die Version 1.1.1 ist abgeschlossen und als Download '
                . 'verfügbar. Darin wurden zwei Fehler behoben. Zum Einen '
                . 'wird beim Einfügen von Datensätzen per "_insert", "_query" '
                . 'und "_insertupdate" immer die Last Insert ID zurückgegeben '
                . 'wenn mindestens ein Datensatz hinzugefügt wurde und zum '
                . 'Anderen ist ein Fehler im DragonJsonClient behoben der '
                . 'alle Daten der Vorbelegung in die Ausgabe des Requests '
                . 'mit angezeigt hat.',
            'timestamp' => 1344451518,
        ),
        array(
            'title' => 'Version 1.1.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.1.0 ist abgeschlossen und als Download '
                . 'verfügbar. Die größten Neuerungen sind die neuen Pakete '
                . 'DragonX_Log und DragonX_Cronjob, die Unterstützung von '
                . 'Multirequests (Bündelung mehrerer Serviceanfragen in einem '
                . 'HTTP Request) und die Verwaltung der Datenbankstruktur '
                . 'durch Installationsplugins.',
            'timestamp' => 1342988194,
        ),
        array(
            'title' => 'Version 1.0.0 zum Download verfügbar',
            'content' =>
                  'Die Version 1.0.0 ist abgeschlossen und als Download '
                . 'verfügbar. Mit im Downloadpaket der Projektvorlage '
                . 'enthalten sind alle Grundfunktionalitäten zur Erstellung '
                . 'eines Json Servers, der generische Json Client und '
                . 'optionale Pakete für die Homepage, die Datenbank und einer '
                . 'einfachen Accountverwaltung.',
            'timestamp' => 1341663737,
        ),
        array(
            'title' => 'Projektstart von DragonJsonServer',
            'content' =>
                  'Die Grundstruktur des Projektes steht, die Demo ist '
                . 'funktionsfähig, die Anmeldung bei Google Code ist '
                . 'abgeschlossen, die Domain ist in Arbeit, die Open Source '
                . 'Lizenz ist ausgewählt. Kurz: Das Projekt ist gestartet. '
                . 'Die nächsten Tage noch die letzten Arbeiten an '
                . 'einer ersten Version durchführen und der erste Download '
                . 'kann Online gestellt werden.',
            'timestamp' => 1339186768,
        ),
    )
);