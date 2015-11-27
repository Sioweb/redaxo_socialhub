<?php

// ALTER TABLE `rex_socialhub_hashtags` ADD `instagram_next_id` BIGINT(100) NOT NULL AFTER `hashtag`;
$fields = [
  'instagram_next_id'=>'BIGINT(100) NOT NULL AFTER `hashtag`',
];
  
$cols = rex_sql::showColumns(rex::getTablePrefix().'socialhub_hashtags');
foreach($fields as $fieldname => $fieldtype) {
  $found = false;
  foreach($cols as $field) {
    if($field['name'] === $fieldname) {
      $found = true;
      break;
    }
  }

  if(!$found) {
    $sql = rex_sql::factory();
    $sql->setQuery("ALTER TABLE `".rex::getTablePrefix().'socialhub_hashtags'."` ADD ".$fieldname." ".$fieldtype,array());
  }
}

$newCron = rex_sql::factory();
$newCron->setTable(REX_CRONJOB_TABLE);
$newCron->setWhere(array('name'=>'Update Instagram'));
$newCron->select();

if($newCron->getRows() === 0) {
  $newCron = rex_sql::factory();
  $newCron->setTable(REX_CRONJOB_TABLE);
  $newCron->setValue('name','Update Instagram');
  $newCron->setValue('description','Prüft ob neue Instagrameinträge auf den angegebenen Seiten vorhanden sind.');
  $newCron->setValue('type','rex_cronjob_phpcallback');
  $newCron->setValue('parameters','{"rex_cronjob_phpcallback_callback":"rex_socialhub_instagram::cron()"}');
  $newCron->setValue('interval','|1|h|');
  $newCron->setValue('nexttime','0000-00-00 00:00:00');
  $newCron->setValue('environment','|0|1|');
  $newCron->setValue('execution_moment',0);
  $newCron->setValue('status',0);
  $newCron->setValue('execution_start',date('Y-m-d').' 01:00:00');

  $newCron->addGlobalUpdateFields();
  $newCron->addGlobalCreateFields();
  try {
    $newCron->insert();
  } catch (rex_sql_exception $e) {
    echo rex_view::warning($e->getMessage());
  }
}

$newCron->reset();
$newCron->setTable(REX_CRONJOB_TABLE);
$newCron->setWhere(array('name'=>'Update Instagram-Hashtags'));
$newCron->select();

if($newCron->getRows() === 0) {
  $newCron = rex_sql::factory();
  $newCron->setTable(REX_CRONJOB_TABLE);
  $newCron->setValue('name','Update Instagram-Hashtags');
  $newCron->setValue('description','Prüft ob neue Hashtags auf Instagram vorhanden sind.');
  $newCron->setValue('type','rex_cronjob_phpcallback');
  $newCron->setValue('parameters','{"rex_cronjob_phpcallback_callback":"rex_socialhub_instagram::loadHashtags()"}');
  $newCron->setValue('interval','|1|h|');
  $newCron->setValue('nexttime','0000-00-00 00:00:00');
  $newCron->setValue('environment','|0|1|');
  $newCron->setValue('execution_moment',0);
  $newCron->setValue('status',1);
  $newCron->setValue('execution_start',date('Y-m-d').' 01:00:00');

  $newCron->addGlobalUpdateFields();
  $newCron->addGlobalCreateFields();
  try {
    $newCron->insert();
  } catch (rex_sql_exception $e) {
    echo rex_view::warning($e->getMessage());
  }
}