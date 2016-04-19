<?php

use Phinx\Migration\AbstractMigration;

class CreateAttemptTable extends AbstractMigration
{
	public function up()
	{
		$table = $this->table('attempt');
		$table
			->addColumn('trip_id', 'integer')
			->addColumn('user_id', 'integer')
			->addColumn('created_at', 'datetime')
			->addColumn('updated_at', 'datetime')
			->addColumn('expired_at', 'datetime')
			->addColumn('count', 'integer', ['default' => 1])
			->addColumn('source_latitude', 'float')
			->addColumn('source_longitude', 'float')
			->addColumn('user_latitude', 'float', ['null' => true])
			->addColumn('user_longitude', 'float', ['null' => true])
			->addColumn('distance', 'float', ['null' => true])
			->addColumn('status', 'integer', ['null' => true, 'default' => 0])
			->save();

		$this->query(
			'CREATE OR REPLACE FUNCTION calculate_distance(source_latitude float, source_longitude float, user_latitude float, user_longitude float)
			  RETURNS float AS $$
				BEGIN
				  RETURN (6371 * acos(cos(radians(user_latitude)) * cos(radians(source_latitude)) * cos(radians(source_longitude) - radians(user_longitude)) +
                                sin(radians(user_latitude)) * sin(radians(source_latitude))));
				END
			$$ LANGUAGE plpgsql;'
		);

		$this->query(
			'CREATE OR REPLACE FUNCTION trigger_update_distance() RETURNS trigger AS \' 
			BEGIN 
			NEW.distance=calculate_distance(NEW.source_latitude, NEW.source_longitude, NEW.user_latitude, NEW.user_longitude);
			return NEW;
			END; 
			\' LANGUAGE  plpgsql;'
		);

		$this->query(
			'CREATE TRIGGER update_attempt_distance 
			BEFORE UPDATE ON attempt
			FOR EACH ROW EXECUTE PROCEDURE trigger_update_distance();'
		);
	}

	public function down()
	{
		$this->dropTable('attempt');
	}
}
