<?php

use Phinx\Migration\AbstractMigration;

class CreateTripTable extends AbstractMigration
{
	public function up()
	{
		$table = $this->table('direction');
		$table
			->addColumn('title', 'string', ['limit' => 255])
			->addColumn('active', 'integer', ['null' => true, 'default' => 0])
			->save();

		$table = $this->table('trip');
		$table
			->addColumn('title', 'string', ['limit' => 255])
			->addColumn('hotel_title', 'string', ['limit' => 255])
			->addColumn('price', 'float')
			->addColumn('image', 'string', ['null' => true])
			->addColumn('specification', 'jsonb', ['null' => true])
			->addColumn('direction_id', 'integer')
			->addColumn('winner_id', 'integer', ['null' => true])
			->addColumn('attempt_id', 'integer', ['null' => true])
			->addColumn('multiplicity', 'integer')
			->addColumn('created_at', 'datetime')
			->addColumn('updated_at', 'datetime')
			->addColumn('start_dt', 'datetime')
			->addColumn('end_dt', 'datetime')
			->addColumn('ended_status', 'string', ['limit' => 20, 'null' => true])
			->addColumn('active', 'integer', ['null' => true, 'default' => 0])
			->save();
	}

	public function down()
	{
		$this->dropTable('direction');
		$this->dropTable('trip');
	}
}
