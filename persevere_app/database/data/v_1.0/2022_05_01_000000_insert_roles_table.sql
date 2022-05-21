-- INSERT DATA INTO `roles` TABLE --

INSERT INTO `roles` (`id`,`name`,`role_name`,`description`,`created_at`,`updated_at`) VALUES
(1,'Administrateur','admin','Le rôle administrateur est le rôle le plus important, il gère tous les accès et est le modérateur de la plateforme.',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP()),
(2,'Pensionnaire','customer','Le rôle pensionnaire permet l''accès à la plateforme une fois inscrit.',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP()),
(3,'Professionnel','pro','Le rôle professionnel permet au personnel professionnel de proposer leurs services via la plateforme.',CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP());
