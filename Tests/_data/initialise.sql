# Test data population
#
# @package   Calligraphic Job Board
# @version   0.1 May 1, 2018
# @author    Calligraphic, LLC http://www.calligraphic.design
# @copyright Copyright (C) 2018-2019 Calligraphic, LLC
# @license   GNU General Public License version 3, or later

# User groups
TRUNCATE TABLE `#__usergroups`;

INSERT INTO `#__usergroups` (`id`, `parent_id`, `lft`, `rgt`, `title`)
VALUES
  (1, 0, 1, 22, 'Public'),
  (2, 1, 8, 15, 'Registered'),
  (3, 2, 9, 14, 'Author'),
  (4, 3, 10, 13, 'Editor'),
  (5, 4, 11, 12, 'Publisher'),
  (6, 1, 4, 7, 'Manager'),
  (7, 6, 5, 6, 'Administrator'),
  (8, 1, 20, 21, 'Super Users'),
  (9, 1, 2, 3, 'Guest'),
  (10, 1, 16, 19, 'Subscribers'),
  (11, 10, 17, 18, 'Level 1 Subscriber');

# View access levels

TRUNCATE TABLE `#__viewlevels`;

INSERT INTO `#__viewlevels` (`id`, `title`, `ordering`, `rules`)
VALUES
  (1, 'Public', 0, '[1]'),
  (2, 'Registered', 2, '[6,2,8]'),
  (3, 'Special', 3, '[6,3,8]'),
  (5, 'Guest', 1, '[9]'),
  (6, 'Super Users', 4, '[8]'),
  (7, 'Subscriber Access', 0, '[10]'),
  (8, 'Level 1 Subscriber Access', 0, '[11]');

# Users. Super User login is admin/admin

TRUNCATE TABLE `#__users`;

INSERT INTO `#__users` (`id`, `name`, `username`, `email`, `password`, `block`, `sendEmail`, `registerDate`, `lastvisitDate`, `activation`, `params`, `lastResetTime`, `resetCount`, `otpKey`, `otep`, `requireReset`)
VALUES
	(100, 'Super User', 'admin', 'admin@test.web', '$2y$10$ib5dgJyv9jVG6zCiboPOZOSzKbkt4kCUwU.wKqEujV5ZKonRzR16y', 0, 1, '2015-04-28 21:28:05', '2015-04-28 21:28:31', '0', '', '0000-00-00 00:00:00', 0, '', '', 0),
	(1000, 'User One', 'user1', 'user1@test.web', '$2y$10$vyC0MR3wtTRwD4JjvQylrOu0NGtFJ2HJSUJkpo9eDyHZO9L7.kj4m', 0, 0, '2015-04-29 18:13:57', '0000-00-00 00:00:00', '', '{}', '0000-00-00 00:00:00', 0, '', '', 0),
	(1001, 'User Two', 'user2', 'user2@test.web', '$2y$10$LpoNGSf0UMrt6BCrANfFkOD0bwxvJobHULVr4Daz0cDVkmVjwFCqO', 1, 0, '2015-04-29 18:13:57', '0000-00-00 00:00:00', '', '{}', '0000-00-00 00:00:00', 0, '', '', 0),
	(1002, 'User Three', 'user3', 'user3@test.web', '$2y$10$9ezk6XoWrpyXUXESQccRcOX65xsY0mX8NVLh6tDX7HMxbipQk/ji.', 1, 0, '2015-04-29 18:13:57', '0000-00-00 00:00:00', 'notempty', '{}', '0000-00-00 00:00:00', 0, '', '', 0),
  (1010, 'Business User', 'business', 'business@test.web', '$2y$10$vyC0MR3wtTRwD4JjvQylrOu0NGtFJ2HJSUJkpo9eDyHZO9L7.kj4m', 0, 0, '2015-04-29 18:13:57', '0000-00-00 00:00:00', '', '{}', '0000-00-00 00:00:00', 0, '', '', 0),
  (1011, 'Forced VAT Check', 'forcedvat', 'forcedvat@test.web', '$2y$10$vyC0MR3wtTRwD4JjvQylrOu0NGtFJ2HJSUJkpo9eDyHZO9L7.kj4m', 0, 0, '2015-04-29 18:13:57', '0000-00-00 00:00:00', '', '{}', '0000-00-00 00:00:00', 0, '', '', 0),
  (1020, 'Guinea Pig', 'guineapig', 'guineapig@test.web', '$2y$10$vyC0MR3wtTRwD4JjvQylrOu0NGtFJ2HJSUJkpo9eDyHZO9L7.kj4m', 0, 0, '2015-04-29 18:13:57', '0000-00-00 00:00:00', '', '{}', '0000-00-00 00:00:00', 0, '', '', 0);

# Users to user groups

TRUNCATE TABLE `#__user_usergroup_map`;

INSERT INTO `#__user_usergroup_map` (`user_id`, `group_id`)
VALUES
  (100, 8),
  (1000, 2),
  (1000, 10),
  (1001, 2),
  (1002, 2),
  (1010, 2),
  (1010, 10),
  (1011, 2),
  (1011, 10),
  (1020, 2);

# Akeeba Subscriptions: Users

TRUNCATE TABLE `#__akeebasubs_users`;

INSERT INTO `#__akeebasubs_users` (`akeebasubs_user_id`, `user_id`, `isbusiness`, `businessname`, `occupation`, `vatnumber`, `viesregistered`, `taxauthority`, `address1`, `address2`, `city`, `state`, `zip`, `country`, `params`, `notes`, `needs_logout`)
VALUES
  (1, 1010, 1, 'Η Εταιρία', 'Κατασκευή προγραμμάτων', '', 0, NULL, 'Μεγάλου Αλεξάνδρου 1', 'Γραφείο 101', 'Κωλοπετινίτσα', 'GR-ATT', '99999', 'GR', '[]', '', 0),
  (2, 1011, 1, 'Τρία Κιλά Κώδικα ΑΕ', 'Εμπορία λογισμικού', '123456789', 2, NULL, 'Μακρυγιάννη 13', '', 'Μικρό Πεύκο', 'GR-ATT', '99888', 'GR', '[]', '', 0),
  (3, 1000, 1, 'Unit Test Ltd', 'Software TEsting', '123456789', 1, NULL, '123 Someplace Drive', 'Suite 404', 'Beverly Hills', 'CA', '90210', 'US', '{"baz": "bat", "something": 12.34}', 'This is a user note', 0);
