-- INSERT DATA INTO `users` TABLE --

INSERT INTO `users` (`id`,`name`,`firstname`,`birth`,`email`,`password`,`phone`,`postcode`,`city`,`country`,`avatar_path`,`role_id`,`created_at`,`updated_at`) VALUES
(1,'Jean','Bernard','1968-12-25','admin@gmail.com','password','06 06 06 06 06','85000','Ville','France','avatar_path',1,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP()),
(2,'Jean','Dupont','1968-12-25','customer@gmail.com','password','06 06 06 06 06','85000','Ville','France','avatar_path',2,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP()),
(3,'Jean','Bernard','1968-12-25','pro@gmail.com','password','06 06 06 06 06','85000','Ville','France','avatar_path',3,CURRENT_TIMESTAMP(),CURRENT_TIMESTAMP());