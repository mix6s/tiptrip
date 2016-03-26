<?php

use Phinx\Migration\AbstractMigration;

class CreateAccountTable extends AbstractMigration
{
	public function up()
	{
		$table = $this->table('account');
		$table
			->addColumn('uid', 'integer')
			->addColumn('amount', 'float')
			->addColumn('updated_at', 'datetime')
			->addIndex(['uid'], ['unique' => true])
			->save();
	}

	public function down()
	{
		$this->dropTable('account');
	}
}
