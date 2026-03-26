USE laravel;

/* ============================================================
   Volledige reset van kern-data voor Userstory 1
   Doel:
   - verwijderde producten terugzetten
   - overzicht "uit assortiment" weer volledig maken
   - schoolkrijt = happy pad, honingdrop = unhappy pad
   ============================================================ */

START TRANSACTION;

DELETE FROM ProductPerAllergeen;
DELETE FROM ProductPerLeverancier;
DELETE FROM Magazijn;
DELETE FROM ProductEinddatumLevering;
DELETE FROM Product;

INSERT INTO Product (Id, Naam, Barcode, IsActief) VALUES
    (1,  'Mintnopjes',      '8719587231278', b'1'),
    (2,  'Schoolkrijt',     '8719587326713', b'1'),
    (3,  'Honingdrop',      '8719587327836', b'1'),
    (4,  'Zure Beren',      '8719587321441', b'1'),
    (5,  'Cola Flesjes',    '8719587321237', b'1'),
    (6,  'Turtles',         '8719587322245', b'1'),
    (7,  'Witte Muizen',    '8719587328256', b'1'),
    (8,  'Reuzen Slangen',  '8719587325641', b'1'),
    (9,  'Zoute Rijen',     '8719587322739', b'1'),
    (10, 'Winegums',        '8719587327527', b'1'),
    (11, 'Drop Munten',     '8719587322345', b'1'),
    (12, 'Kruis Drop',      '8719587322265', b'1'),
    (13, 'Zoute Ruitjes',   '8719587323256', b'1'),
    (14, 'Drop ninja''s',   '8719587323277', b'1');

INSERT INTO Magazijn (Id, ProductId, VerpakkingsEenheid, AantalAanwezig, IsActief) VALUES
    (1, 1,  5.0, 453, b'1'),
    (2, 2,  2.5, 400, b'1'),
    (3, 3,  5.0, 1,   b'1'),
    (4, 4,  1.0, 800, b'1'),
    (5, 5,  3.0, 234, b'1'),
    (6, 6,  2.0, 345, b'1'),
    (7, 7,  1.0, 795, b'1'),
    (8, 8, 10.0, 233, b'1'),
    (9, 9,  2.5, 123, b'1'),
    (10, 10, 3.0, NULL, b'1'),
    (11, 11, 2.0, 367, b'1'),
    (12, 12, 1.0, 467, b'1'),
    (13, 13, 5.0, 20,  b'1');

INSERT INTO ProductPerLeverancier
    (Id, LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering, IsActief)
VALUES
    (1,  1, 1,  '2023-04-09', 23, '2023-04-16', b'1'),
    (2,  1, 1,  '2023-04-18', 21, '2023-04-25', b'1'),
    (3,  1, 2,  '2023-04-09', 12, '2023-04-16', b'1'),
    (4,  1, 3,  '2023-04-10', 11, '2023-04-17', b'1'),
    (5,  2, 4,  '2023-04-14', 16, '2023-04-21', b'1'),
    (6,  2, 4,  '2023-04-21', 23, '2023-04-28', b'1'),
    (7,  2, 5,  '2023-04-14', 45, '2023-04-21', b'1'),
    (8,  2, 6,  '2023-04-14', 30, '2023-04-21', b'1'),
    (9,  3, 7,  '2023-04-12', 12, '2023-04-19', b'1'),
    (10, 3, 7,  '2023-04-19', 23, '2023-04-26', b'1'),
    (11, 3, 8,  '2023-04-10', 12, '2023-04-17', b'1'),
    (12, 3, 9,  '2023-04-11', 1,  '2023-04-18', b'1'),
    (13, 4, 10, '2023-04-16', 24, '2023-04-30', b'1'),
    (14, 5, 11, '2023-04-10', 47, '2023-04-17', b'1'),
    (15, 5, 11, '2023-04-19', 60, '2023-04-26', b'1'),
    (16, 5, 12, '2023-04-11', 45, NULL, b'1'),
    (17, 5, 13, '2023-04-12', 23, NULL, b'1'),
    (18, 7, 14, '2023-04-14', 20, NULL, b'1');

INSERT INTO ProductPerAllergeen (Id, ProductId, AllergeenId, IsActief) VALUES
    (1, 1,  2, b'1'),
    (2, 1,  1, b'1'),
    (3, 1,  3, b'1'),
    (4, 3,  4, b'1'),
    (5, 6,  5, b'1'),
    (6, 9,  2, b'1'),
    (7, 9,  5, b'1'),
    (8, 10, 2, b'1'),
    (9, 12, 4, b'1'),
    (10, 13, 1, b'1'),
    (11, 13, 4, b'1'),
    (12, 13, 5, b'1'),
    (13, 14, 5, b'1');

INSERT INTO ProductEinddatumLevering (Id, ProductId, EinddatumLevering, IsActief) VALUES
    (1, 1,  '2026-02-15', b'1'),
    (2, 2,  '2026-03-20', b'1'),  -- Schoolkrijt: happy
    (3, 3,  '2026-06-15', b'1'),  -- Honingdrop: unhappy
    (4, 4,  '2026-01-30', b'1'),
    (5, 7,  '2026-04-10', b'1'),
    (6, 10, '2026-03-05', b'1'),
    (7, 11, '2026-05-25', b'1'),
    (8, 14, '2026-02-09', b'1');

COMMIT;

