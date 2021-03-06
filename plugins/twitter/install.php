<?php
	$newCron = rex_sql::factory();
	$newCron->setTable(REX_CRONJOB_TABLE);
	$newCron->setWhere(array('name'=>'Update Twitter-Timelines'));
	$newCron->select();
	
	if($newCron->getRows() === 0) {
		$newCron = rex_sql::factory();
		$newCron->setTable(REX_CRONJOB_TABLE);
		$newCron->setValue('name','Update Twitter-Timelines');
		$newCron->setValue('description','Prüft ob neue Twittereinträge auf den angegebenen Seiten vorhanden sind.');
		$newCron->setValue('type','rex_cronjob_phpcallback');
		$newCron->setValue('parameters','{"rex_cronjob_phpcallback_callback":"rex_socialhub_twitter::getEntriesByTimeline()"}');
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
	$newCron->setWhere(array('name'=>'Update Twitter-Hashtags'));
	$newCron->select();
	
	if($newCron->getRows() === 0) {
		$newCron = rex_sql::factory();
		$newCron->setTable(REX_CRONJOB_TABLE);
		$newCron->setValue('name','Update Twitter-Hashtags');
		$newCron->setValue('description','Prüft ob neue Hashtags auf Twitter vorhanden sind.');
		$newCron->setValue('type','rex_cronjob_phpcallback');
		$newCron->setValue('parameters','{"rex_cronjob_phpcallback_callback":"rex_socialhub_twitter::getEntriesByHashtag()"}');
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
?>