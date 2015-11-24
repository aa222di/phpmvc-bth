<?php
namespace Anax\Tags;
 
/**
 * Model for Users.
 *
 */
class Tags extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for users.
     *
     * @return boolean true or false if saving went okey.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('tags')->execute();
 
        $this->db->createTable(
            'tags',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'name' => ['varchar(80)', 'not null'],
            ]
        )->execute();

        $this->create([
            'name' => 'mat',
        ]);
     
        $this->create([
            'name' => 'grönsaker',
        ]);

    }
}