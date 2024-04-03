<?php

namespace App\Models\Api;

use CodeIgniter\Model;

class ApiModel extends Model
{
    public function insert_table($data, $table, $id = null)
    {
        try {
            $db = \Config\Database::connect();
            $query = $db->table($table);
            
            if ($id === null) {
                $query->insert($data);
            } else {
                $idd = $table . '_id'; // Construct the ID field name
                $query->where($idd, $id)->update($data);
            }

            if ($db->affectedRows() === 0) {
                return ("No records were affected."); // Throw exception if no records affected
            }

            return true; // Return true if insertion or update succeeds
        } catch (CodeIgniter\Database\Exceptions\DatabaseException $e) {
            return $e->getMessage(); // Return the error message
        }
    }

}
