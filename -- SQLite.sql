-- SQLite
INSERT INTO membre (id, pseudo, password, civilite, nom, prenom, email, statut, roles, date_enregistrement)
VALUES
(1, 'admin', '$2y$13$DkrsPfRiRvk84vfWLoUfEuEK3PkvECtvp7iDd/NWEmd2/tEaTijk6', 'M', 'Admin', 'Administrateur', 'administrateur@admin.fr', 1, '["ROLE_ADMIN","ROLE_MEMBRE"]', '2020-01-01 12:00:00'),
(2, 'root', '$2y$13$UsOs0OGgH8rB8wjdUQ2MtebMUSY4HpiTlz5L/w5JRISQB3bzg7gLq', 'F', 'Root', 'Racine', 'racine@root.fr', 1, '["ROLE_ADMIN","ROLE_MEMBRE"]', '2020-01-01 12:00:00'),
(3, 'membre', '$2y$13$42/f/hEtlcD.TdML/uBDouiVjj9PotZKNXM7G0o4eesMwz20d.wOK', 'M', 'Membre', 'Utilisateur', 'utilisateur@membre.fr', 0, '["ROLE_MEMBRE"]', '2020-01-01 12:00:00'),
(4, 'user', '$2y$13$4xd1GBdcHj9QrZefY4q5keqJ2G83XZa0hSTQskXNzX.SgVHcrd1bC', 'F', 'User', 'Visiteur', 'visiteur@user.fr', 0, '["ROLE_MEMBRE"]', '2020-01-01 12:00:00');