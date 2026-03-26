USE laravel;

/* ============================================================
   Reset testdata Userstory: Verwijder product uit assortiment
   - Oude einddatums verwijderen
   - Nieuwe datums plaatsen (happy + unhappy scenario)
   ============================================================ */

START TRANSACTION;

INSERT INTO Product (Id, Naam, Barcode, IsActief) VALUES
    (1,  'Mintnopjes',     '8719587231278', b'1'),
    (2,  'Schoolkrijt',    '8719587326713', b'1'),
    (3,  'Honingdrop',     '8719587327836', b'1'),
    (4,  'Zure Beren',     '8719587321441', b'1'),
    (7,  'Witte Muizen',   '8719587328256', b'1'),
    (10, 'Winegums',       '8719587327527', b'1'),
    (11, 'Drop Munten',    '8719587322345', b'1'),
    (14, 'Drop ninja''s',  '8719587323277', b'1')
ON DUPLICATE KEY UPDATE
    Naam = VALUES(Naam),
    Barcode = VALUES(Barcode),
    IsActief = VALUES(IsActief);

DELETE FROM ProductEinddatumLevering;

INSERT INTO ProductEinddatumLevering (Id, ProductId, EinddatumLevering) VALUES
    (1,  1,  '2026-02-15'),
    (2,  2,  '2026-03-20'),  -- Schoolkrijt: verleden t.o.v. 26-03-2026 => verwijderen mag
    (3,  3,  '2026-06-15'),  -- Honingdrop: toekomst t.o.v. 26-03-2026 => verwijderen mag NIET
    (4,  4,  '2026-01-30'),
    (5,  7,  '2026-04-10'),
    (6, 10,  '2026-03-05'),
    (7, 11,  '2026-05-25'),
    (8, 14,  '2026-02-09');

COMMIT;
