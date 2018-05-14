use login_course;

SELECT `password_reset`.`ID`,
    `password_reset`.`email`,
    `password_reset`.`selector`,
    `password_reset`.`token`,
    `password_reset`.`expires`
FROM `login_course`.`password_reset`;

SELECT `auth_tokens`.`ID`,
    `auth_tokens`.`username`,
    `auth_tokens`.`selector`,
    `auth_tokens`.`token`,
    `auth_tokens`.`expires`
FROM `login_course`.`auth_tokens`;

SELECT `users`.`ID`,
    `users`.`username`,
    `users`.`password`,
    `users`.`name`,
    `users`.`email`
FROM `login_course`.`users`;
