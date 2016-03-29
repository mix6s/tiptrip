<?php

use Phinx\Seed\AbstractSeed;

class BaseSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
		$this->table('direction')->insert(
			[
				[
					'title' => 'Европа',
					'active' => 1,
				],
				[
					'title' => 'Египет',
					'active' => 1,
				]
			]
		)->save();

		$this->table('trip')->insert(
			[
				[
					'title' => 'Trip 1',
					'hotel_title' => 'hotel trip 1',
					'price' => 50000,
					'direction_id' => 1,
					'multiplicity' => 250,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => date('Y-m-d H:i'),
					'end_dt' => date('Y-m-d H:i'),
					'active' => 1,
				],
				[
					'title' => 'Trip 2',
					'hotel_title' => 'hotel trip 2',
					'price' => 20000,
					'direction_id' => 2,
					'multiplicity' => 100,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => date('Y-m-d H:i'),
					'end_dt' => date('Y-m-d H:i'),
					'active' => 1,
				]
			]
		)->save();
    }
}
