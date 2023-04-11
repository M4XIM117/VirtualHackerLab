INSERT INTO meta_data_users (position, login_time, logout_time, created_at, updated_at)
VALUES
    (Point(48.482172, 9.186701), '2021-08-20 06:03:00', '2021-08-20 07:03:00', '2021-08-20 06:03:00', '2021-08-20 07:03:00'),
    (Point(48.483023, 9.187599), '2021-08-10 13:05:00', '2021-08-20 13:13:00', '2021-08-20 13:05:00', '2021-08-20 13:13:00'),
    (Point(48.482305, 9.187599), '2021-08-13 16:03:00', '2021-08-20 16:10:00', '2021-08-20 16:03:00', '2021-08-20 16:10:00'),
    (Point(48.483023, 9.187883), '2021-08-10 13:03:00', '2021-08-21 07:03:00', '2021-08-20 13:03:00', '2021-08-21 07:03:00'),
    (Point(48.483023, 9.187599), '2021-08-10 06:03:00', '2021-08-20 06:15:00', '2021-08-20 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.484033, 9.189943), '2021-08-20 02:03:00', '2021-08-20 07:44:00', '2021-08-20 02:03:00', '2021-08-20 07:44:00'),
    (Point(48.483997, 9.190372), '2021-08-01 00:00:00', '2021-08-01 05:30:00', '2021-08-01 00:00:00', '2021-08-20 05:30:00');

INSERT INTO users (phone_number, country_code, system_language, device_id, meta_data_user_id, created_at, updated_at)
VALUES
    (1234567890, '+49', 'de', 'D8E1BB8EBE98BB16C8C03C8CFFDD62FEC406C0F71713BBA9BCCED60DD61E32A2', 1, current_timestamp, current_timestamp),
    (1876543290, '+49', 'de', '625D992507FC4ECBA8A895F97FAED3EB717960E7205F3611EC358A5164980284', 2, current_timestamp, current_timestamp),
    (1243658709, '+49', 'zh', '998846384102CBFDF955B8CB9D8957A52C26EA59A6CE1180C21B6A9C0091B18C', 3, current_timestamp, current_timestamp),
    (1234569870, '+49', 'en', '971325B44FECBDA42A00C0F48CDA19424755F4DBC87CAC4BD447D8D0B7BB3776', 4, current_timestamp, current_timestamp),
    (1425367980, '+49', 'jpn', '10E118F148DE551E11650130F8C1528820C662F636985FA464CBA8C82A884CFF', 5, current_timestamp, current_timestamp),
    (1602938475, '+49', 'de', '66D324FD185DA39B279076E6D924704D96E9293E6FA946E295B4665B2A0EEDB8', 6, current_timestamp, current_timestamp),
    (1067892345, '+49', 'de', '7A5B524435E26798C6F62B0D4932EB7A4D1C353F3891A02CF68FB4AA1139F224', 7, current_timestamp, current_timestamp);

INSERT INTO user_informations (user_id, first_name, last_name, username, status, created_at, updated_at)
VALUES
    (1, 'Jeremy', 'Dieter', 'Jere', 'Whitehat', current_timestamp, current_timestamp),
    (2, 'Pascal', 'Ferdinand', 'Ferdi', 'Kein Bock auf Vorlesung...', current_timestamp, current_timestamp),
    (3, 'Noa Viivi', 'Juárez', 'Noa Viivi Juárez', 'Blackhat', current_timestamp, current_timestamp),
    (4, 'Jaylyn Lourens', 'Conner', 'Conni', '...', current_timestamp, current_timestamp),
    (5, 'Nakato', 'Perry', 'Nakato', 'Beschäftigt', current_timestamp, current_timestamp),
    (6, 'Kristina', 'Eberle', 'Kristina', '', current_timestamp, current_timestamp),
    (7, 'Günay', 'Claesson', 'Clae', 'Im Fitnessstudio', current_timestamp, current_timestamp);

INSERT INTO meta_data_messages (position, call_duration, created_at, updated_at)
VALUES
    (Point(48.482172, 9.186701), 12.23,'2021-08-20 06:03:00', '2021-08-20 07:03:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 13:05:00', '2021-08-20 13:13:00'),
    (Point(48.482305, 9.187599), 120.30, '2021-08-13 16:03:00', '2021-08-20 16:10:00'),
    (Point(48.483023, 9.187883), null, '2021-08-10 13:03:00', '2021-08-21 07:03:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.484033, 9.189943), null, '2021-08-20 02:03:00', '2021-08-20 07:44:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483023, 9.187599), null, '2021-08-10 06:03:00', '2021-08-20 06:15:00'),
    (Point(48.483997, 9.190372), null, '2021-08-01 00:00:00', '2021-08-01 05:30:00'),
    (Point(48.482172, 9.186701), null,'2021-08-20 06:03:00', '2021-08-20 07:03:00'),
    (Point(48.482172, 9.186701), null,'2021-08-20 06:03:00', '2021-08-20 07:03:00'),
    (Point(48.482172, 9.186701), null,'2021-08-20 06:03:00', '2021-08-20 07:03:00'),
    (Point(48.482172, 9.186701), null,'2021-08-20 06:03:00', '2021-08-20 07:03:00'),
    (Point(48.482172, 9.186701), null,'2021-08-20 06:03:00', '2021-08-20 07:03:00');

INSERT INTO messages (chat_id, sender_id, receiver_id, reply_to_id, deleted_at, text, meta_data_messages_id, created_at, updated_at)
VALUES
    (1, 1, 2, null, null, 'Jo, check mal bitte alte IT-Sicherheit Klausur?', 2, current_timestamp, current_timestamp),
    (3, 3, 2, null, null, 'Lass mal nicht in die Vorlesung gehen?', 4, current_timestamp, current_timestamp),
    (1, 3, 2, null, null, 'Ja man, pls!', 5, current_timestamp, current_timestamp),
    (1, 1, 2, 1, current_timestamp, 'und Datenbanken', 6, current_timestamp, current_timestamp),
    (7, 7, 6, null, null, 'Nacher dann ins Irish? 19 Uhr?', 8, current_timestamp, current_timestamp),
    (2, 2, 6, null, null, 'Wie klingt New York als Reiseziel?', 7, current_timestamp, current_timestamp),
    (1, 2, 1, null, null, 'Bin grad nicht zuHause, nacher.', 9, current_timestamp, current_timestamp),
    (3, 4, 3, null, null, 'Started A Call', 3, current_timestamp, current_timestamp),
    (6, 6, 2, null, null, 'Hätte ich richtig lust drauf!', 10, current_timestamp, current_timestamp),
    (1, 1, 2, null, null, 'Danke, vergiss aber bitte nicht... :(', 15, current_timestamp, current_timestamp),
    (1, 1, 2, null, null, 'wie die letzten Male...', 11, current_timestamp, current_timestamp),
    (5, 5, 3, null, null, 'Jo Vivi', 12, current_timestamp, current_timestamp),
    (4, 4, 2, null, null, '19 Uhr steigt im Irish ne Party', 13, current_timestamp, current_timestamp),
    (1, 2, 1, null, null, 'chill, war nur ein mal!', 14, current_timestamp, current_timestamp),
    (7, 6, 7, null, null, 'Hollst mich dann um 17 Uhr am Aquarium ab?', 16, current_timestamp, current_timestamp),
    (1, 1, 6, null, null, 'heute am Start?', 17, current_timestamp, current_timestamp),
    (4, 4, 7, null, null, 'Started A Call', 1, current_timestamp, current_timestamp),
    (5, 3, 5, null, null, '*Viivi', 18, current_timestamp, current_timestamp),
    (3, 5, 3, null, current_timestamp, 'Lass mal nacher die Applikation hier via webshell hacken :D', 19, current_timestamp, current_timestamp),
    (7, 7, 1, null, null, 'Servus, Freunde der Sonne :D', 20, current_timestamp, current_timestamp),
    (7, 7, 1, 20, null, 'Guten Tag Freund der Sonne :D', 21, current_timestamp, current_timestamp);
