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
					'title' => 'Мальдивы',
					'active' => 1,
				],
				[
					'title' => 'Куба',
					'active' => 1,
				],
				[
					'title' => 'Индонезия',
					'active' => 1,
				],
				[
					'title' => 'ОАЭ',
					'active' => 1,
				],
				[
					'title' => 'Европа',
					'active' => 1,
				],
				[
					'title' => 'Азия',
					'active' => 1,
				],
				[
					'title' => 'Америка',
					'active' => 1,
				],
			]
		)->save();

		$this->table('trip')->insert(
			[
				[
					'title' => 'Мальдивы, Мале',
					'hotel_title' => 'Palm Beach Resort and Spa Maldives',
					'price' => 274555,
					'direction_id' => $this->fetchRow("SELECT id FROM direction WHERE title = 'Азия'")['id'],
					'multiplicity' => 1000,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => '2016-07-15',
					'end_dt' => '2016-07-25',
					'active' => 1,
					'image' => '/demo/male.jpg',
				],
				[
					'title' => 'Куба, Варадеро',
					'hotel_title' => 'Iberostar Laguna Azul',
					'price' => 191295,
					'direction_id' => $this->fetchRow("SELECT id FROM direction WHERE title = 'Америка'")['id'],
					'multiplicity' => 500,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => '2016-04-16',
					'end_dt' => '2016-04-21',
					'active' => 1,
					'image' => '/demo/cuba.jpg',
				],
				[
					'title' => 'Индонезия, о. Бали ',
					'hotel_title' => 'Grand Mirage Resort & Thalasso Bali',
					'price' => 366527,
					'direction_id' => $this->fetchRow("SELECT id FROM direction WHERE title = 'Азия'")['id'],
					'multiplicity' => 1500,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => '2016-04-11',
					'end_dt' => '2016-04-22',
					'active' => 1,
					'image' => '/demo/bali.jpg',
				],
				[
					'title' => 'ОАЭ, Дубай',
					'hotel_title' => 'Movenpick Hotel Jumeirah Beach',
					'price' => 198069,
					'direction_id' => $this->fetchRow("SELECT id FROM direction WHERE title = 'Азия'")['id'],
					'multiplicity' => 500,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => '2016-05-16',
					'end_dt' => '2016-05-23',
					'active' => 1,
					'image' => '/demo/dubai.jpg',
				],
				[
					'title' => 'Франция, Париж',
					'hotel_title' => 'Marriott Hotel Champs-Elysees',
					'price' => 395185,
					'direction_id' => $this->fetchRow("SELECT id FROM direction WHERE title = 'Европа'")['id'],
					'multiplicity' => 1500,
					'created_at' => date('Y-m-d H:i'),
					'updated_at' => date('Y-m-d H:i'),
					'start_dt' => '2016-06-03',
					'end_dt' => '2016-06-13',
					'active' => 1,
					'image' => '/demo/paris.jpg',
				],
			]
		)->save();
    }
}
