<?php

$installer = $this;

$installer->startSetup();
$tableName = $installer->getTable('bss_testimonials');
if ($installer->getConnection()->isTableExists($tableName) != true) {
	$table = $installer->getConnection($tableName)
	    ->newTable()
	    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
	        'identity'  => true,
	        'unsigned'  => true,
	        'nullable'  => false,
	        'primary'   => true,
	        ), 'Id')
	    ->addColumn('customer_email', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
	        'nullable'  => false,
	        ), 'Customer Email')
	    ->addColumn('comment', Varien_Db_Ddl_Table::TYPE_TEXT, null, array(
	        'nullable'  => false,
	        ), 'Comment')
	    ->addColumn('create_at', Varien_Db_Ddl_Table::TYPE_TIMESTAMP, null, array(
	        'nullable'  => false,
	        ), 'Create At');
	$installer->getConnection()->createTable($table);
}
$installer->endSetup(); 