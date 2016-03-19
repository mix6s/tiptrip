<?php

use Phinx\Migration\AbstractMigration;

class CreateUsersTable extends AbstractMigration
{
   public function up()
   {
	   $users = $this->table('users');
	   $users
		   ->addColumn('password', 'string', ['limit' => 40,])
		   ->addColumn('password_salt', 'string', ['limit' => 40, 'null' => true])
		   ->addColumn('email', 'string', ['limit' => 100, 'null' => true])
		   ->addColumn('phone', 'string', ['limit' => 10, 'null' => true])
		   ->addColumn('nickname', 'string', ['limit' => 20, 'null' => true])
		   ->addColumn('created_at', 'datetime')
		   ->addColumn('updated_at', 'datetime')
		   ->addColumn('deleted', 'boolean', ['null' => true])
		   ->addIndex(['email'], ['unique' => true])
		   ->addIndex(['phone'], ['unique' => true])
		   ->save();
   }

	public function down()
	{
		$this->dropTable('users');
	}
}
