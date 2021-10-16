<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    public function run()
    {
        $this->db->query("INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
		(1, 'user', 'User'),
		(2, 'admin', 'Administrator'),
		(3, 'super-admin', 'Super admin')");
    }
}
