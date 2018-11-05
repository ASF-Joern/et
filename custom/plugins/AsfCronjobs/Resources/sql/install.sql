INSERT IGNORE INTO `s_crontab` (`name`, `action`, `elementID`, `data`, `next`, `start`, `interval`, `active`, `disable_on_error`, `end`, `inform_template`, `inform_mail`, `pluginID`) VALUES
  ('ASF Artikel Import/Update', 'Shopware_CronJob_AsfCronjobsArticleCron', NULL, '', NOW(), NULL, 1, 1, 1, NOW(), '', '', ?);
INSERT IGNORE INTO `s_crontab` (`name`, `action`, `elementID`, `data`, `next`, `start`, `interval`, `active`, `disable_on_error`, `end`, `inform_template`, `inform_mail`, `pluginID`) VALUES
  ('ASF Bilderupdate', 'Shopware_CronJob_AsfCronjobsImagesCron', NULL, '', NOW(), NULL, 1, 1, 1, NOW(), '', '', ?);
