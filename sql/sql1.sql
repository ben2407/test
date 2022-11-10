//Der Kunde mit höchsten Kredit

SELECT kredit.kontoId, kunde.nachname, Max(schuldenInEuro) FROM mydb.kredit
JOIN konto ON kredit.kontoId = konto.kontoId
JOIN kunde ON konto.kundeId = kunde.kundeId;

//Filiale mit niedrigsten Kreditbeträgen

SELECT filiale.name, Min(schuldenInEuro) FROM mydb.kredit
JOIN konto ON kredit.kontoId = konto.kontoId
JOIN kunde ON konto.kundeId = kunde.kundeId
JOIN filiale ON kunde.filialeId = filiale.filialeId;

//Alle Kredite samt zugehöriger Filiale

SELECT kredit.kreditId, kredit.schuldenInEuro, filiale.name FROM mydb.kredit
JOIN konto ON kredit.kontoId = konto.kontoId
JOIN kunde ON konto.kundeId = kunde.kundeId
JOIN filiale ON kunde.filialeId = filiale.filialeId;

//Kreditsumme pro Filiale

SELECT SUM(kredit.schuldenInEuro), filiale.name FROM kredit
JOIN konto ON kredit.kontoId = konto.kontoId
JOIN kunde ON konto.kundeId = kunde.kundeId
JOIN filiale ON kunde.filialeId = filiale.filialeId
GROUP BY filiale.name;


//svi koji imaju vecu placu od prosjeka
SELECT * FROM `lehrer` WHERE `L_Gehalt` > (SELECT AVG(`L_Gehalt`) FROM `lehrer`)

//1
SELECT * FROM schule.klassen
where K_Abteilung = 3;

//2
SELECT * FROM klassen WHERE K_Nr LIKE '1%';

//3
SELECT * FROM klassen WHERE K_Vorstand = 'GT';

//4
SELECT * FROM schule.schuljahre where Year(Sja_Datumvon) = '2009' order by Sja_Datumvon;

//6
SELECT * FROM schule.staaten WHERE Sta_Euland is NULL;

//7
SELECT * FROM schule.lehrer WHERE L_Geschlecht = 1 && L_Gehalt > 700;

//8
SELECT * FROM schule.schueler WHERE S_Klasse LIKE '%HBG%' order by S_Zuname, S_Vorname asc;

//9
SELECT * FROM schueler
WHERE S_Klasse LIKE '%HIF%' && S_Vorname IN ('Michael', 'Alexander');

//10
ALTER TABLE lehrer ADD Stundengehaltdifferenz int AS (L_Stundengewuenscht - L_Stundengehalten)
SELECT * FROM lehrer WHERE Stundengehaltdifferenz < 0;

//11
SELECT Abt_Name, lehrer.L_Vorname, lehrer.L_Zuname FROM schule.abteilungen
JOIN lehrer ON abteilungen.Abt_Leiter = lehrer.L_Nr
WHERE lehrer.L_Nr = 'ZLA';

//12
SELECT DISTINCT klassen.K_Nr, klassen.K_Jahrsem FROM schule.schueler
join klassen ON schueler.S_Klasse = klassen.K_Nr
where schueler.S_Postleitzahl = '1210' || schueler.S_Postleitzahl = '1220';

//13
SELECT K_Nr, abteilungen.Abt_Name from klassen
JOIN abteilungen ON klassen.K_Abteilung = abteilungen.Abt_ID;

//14
SELECT lehrer.L_Vorname, lehrer.L_Zuname FROM schule.abteilungen
JOIN lehrer ON abteilungen.Abt_Leiter = lehrer.L_Nr;
