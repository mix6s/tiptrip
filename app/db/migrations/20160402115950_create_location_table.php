<?php

use Phinx\Migration\AbstractMigration;

class CreateLocationTable extends AbstractMigration
{
	public function up()
	{
		$table = $this->table('location');
		$table
			->addColumn('latitude', 'float')
			->addColumn('longitude', 'float')
			->addColumn('deleted', 'integer', ['default' => 0])
			->save();
	}

	public function down()
	{
		$this->dropTable('location');
	}
}
