-- INSERT DATA INTO `appointment_horse` TABLE --

INSERT INTO `appointment_horse` (`id`,`title`,`description`,`status`,`price`,`start_date`,`end_date`,`cares`,`observations`,`appointment_id`,`horse_id`,`created_at`,`updated_at`) VALUES
(1,"Rendez-vous 1","Description de ma prise de rendez-vous avec un professionnel.","waiting",null,"2022-06-11 14:00:00","2022-06-11 14:30:00",null,null,2,1,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(2,"Rendez-vous 2","Description de ma prise de rendez-vous avec un professionnel.","waiting",null,"2022-06-11 14:30:00","2022-06-11 15:00:00",null,null,2,2,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(3,"Rendez-vous 3","Description de ma prise de rendez-vous avec un professionnel.","waiting",null,"2022-06-11 15:00:00","2022-06-11 15:30:00",null,null,2,3,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(4,"Rendez-vous 4","Description de ma prise de rendez-vous avec un professionnel.","waiting",null,"2022-06-11 15:30:00","2022-06-11 16:00:00",null,null,2,4,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(5,"Rendez-vous 5","Description de ma prise de rendez-vous avec un professionnel.","waiting",null,"2022-06-11 16:00:00","2022-06-11 16:30:00",null,null,2,5,UTC_TIMESTAMP(),UTC_TIMESTAMP()),

(6,"Rendez-vous 6","Description de ma prise de rendez-vous avec un professionnel.","rejected",null,"2022-06-12 14:00:00","2022-06-12 14:30:00",null,"Indisponibilité. Reprendre rdv.",3,6,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(7,"Rendez-vous 7","Description de ma prise de rendez-vous avec un professionnel.","rejected",null,"2022-06-12 14:30:00","2022-06-12 15:00:00",null,"Indisponibilité. Reprendre rdv.",3,7,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(8,"Rendez-vous 8","Description de ma prise de rendez-vous avec un professionnel.","rejected",null,"2022-06-12 15:00:00","2022-06-12 15:30:00",null,"Indisponibilité. Reprendre rdv.",3,8,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(9,"Rendez-vous 9","Description de ma prise de rendez-vous avec un professionnel.","rejected",null,"2022-06-12 15:30:00","2022-06-12 16:00:00",null,"Indisponibilité. Reprendre rdv.",3,9,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(10,"Rendez-vous 10","Description de ma prise de rendez-vous avec un professionnel.","rejected",null,"2022-06-12 16:00:00","2022-06-12 16:30:00",null,"Indisponibilité. Reprendre rdv.",3,10,UTC_TIMESTAMP(),UTC_TIMESTAMP()),

(11,"Rendez-vous 11","Description de ma prise de rendez-vous avec un professionnel.","accepted",null,"2022-06-16 14:00:00","2022-06-16 14:30:00",null,null,7,11,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(12,"Rendez-vous 12","Description de ma prise de rendez-vous avec un professionnel.","accepted",null,"2022-06-16 14:30:00","2022-06-16 15:00:00",null,null,7,12,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(13,"Rendez-vous 13","Description de ma prise de rendez-vous avec un professionnel.","accepted",null,"2022-06-16 15:00:00","2022-06-16 15:30:00",null,null,7,13,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(14,"Rendez-vous 14","Description de ma prise de rendez-vous avec un professionnel.","accepted",null,"2022-06-16 15:30:00","2022-06-16 16:00:00",null,null,7,14,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(15,"Rendez-vous 15","Description de ma prise de rendez-vous avec un professionnel.","accepted",null,"2022-06-16 16:00:00","2022-06-16 16:30:00",null,null,7,15,UTC_TIMESTAMP(),UTC_TIMESTAMP()),

(16,"Rendez-vous 16","Description de ma prise de rendez-vous avec un professionnel.","canceled",null,"2022-06-18 14:00:00","2022-06-18 14:30:00",null,"Mon cheval va mieux.",9,16,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(17,"Rendez-vous 17","Description de ma prise de rendez-vous avec un professionnel.","canceled",null,"2022-06-18 14:30:00","2022-06-18 15:00:00",null,"Mon cheval va mieux.",9,17,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(18,"Rendez-vous 18","Description de ma prise de rendez-vous avec un professionnel.","canceled",null,"2022-06-18 15:00:00","2022-06-18 15:30:00",null,"Mon cheval va mieux.",9,18,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(19,"Rendez-vous 19","Description de ma prise de rendez-vous avec un professionnel.","canceled",null,"2022-06-18 15:30:00","2022-06-18 16:00:00",null,"Mon cheval va mieux.",9,19,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(20,"Rendez-vous 20","Description de ma prise de rendez-vous avec un professionnel.","canceled",null,"2022-06-18 16:00:00","2022-06-18 16:30:00",null,"Mon cheval va mieux.",9,20,UTC_TIMESTAMP(),UTC_TIMESTAMP()),

(21,"Rendez-vous 21","Description de ma prise de rendez-vous avec un professionnel.","ended",200,"2022-06-20 14:00:00","2022-06-20 14:30:00","Soin 1;Soin 2;Soin 3;","Médicaments pendant une dizaine de jours.",11,21,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(22,"Rendez-vous 22","Description de ma prise de rendez-vous avec un professionnel.","ended",200,"2022-06-20 14:30:00","2022-06-20 15:00:00","Soin 1;Soin 2;Soin 3;","Médicaments pendant une dizaine de jours.",11,22,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(23,"Rendez-vous 23","Description de ma prise de rendez-vous avec un professionnel.","ended",200,"2022-06-20 15:00:00","2022-06-20 15:30:00","Soin 1;Soin 2;Soin 3;","Médicaments pendant une dizaine de jours.",11,23,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(24,"Rendez-vous 24","Description de ma prise de rendez-vous avec un professionnel.","ended",200,"2022-06-20 15:30:00","2022-06-20 16:00:00","Soin 1;Soin 2;Soin 3;","Médicaments pendant une dizaine de jours.",11,24,UTC_TIMESTAMP(),UTC_TIMESTAMP()),
(25,"Rendez-vous 25","Description de ma prise de rendez-vous avec un professionnel.","ended",200,"2022-06-20 16:00:00","2022-06-20 16:30:00","Soin 1;Soin 2;Soin 3;","Médicaments pendant une dizaine de jours.",11,25,UTC_TIMESTAMP(),UTC_TIMESTAMP());
