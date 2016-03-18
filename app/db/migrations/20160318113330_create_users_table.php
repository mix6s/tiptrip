<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
   public function up()
   {
	   $users = $this->table('users');
	   $users->addColumn('username', 'string', ['limit' => 100])
		   ->addColumn('password', 'string', ['limit' => 40])
		   ->addColumn('password_salt', 'string', ['limit' => 40])
		   ->addColumn('email', 'string', ['limit' => 100])
		   ->addColumn('phone', 'string', ['limit' => 10])
		   ->addColumn('nickname', 'string', ['limit' => 20])
		   ->addColumn('created_at', 'datetime')
		   ->addColumn('updated_at', 'datetime')
		   ->addIndex(['username', 'email', 'phone'], ['unique' => true])
		   ->save();
   }

	public function down()
	{
		$this->dropTable('users');
	}
}
