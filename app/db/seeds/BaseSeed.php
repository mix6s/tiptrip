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
    }
}
