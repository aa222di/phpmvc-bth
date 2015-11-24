<?php
namespace Anax\Questions;
 
/**
 * Model for Users.
 *
 */
class Questions extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for users.
     *
     * @return boolean true or false if saving went okey.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('questions')->execute();
 
        $this->db->createTable(
            'questions',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'userId' => ['integer', 'not null'],
                'subject' => ['char(255)'],
                'text' => ['text'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

     
        $now = gmdate('Y-m-d H:i:s');
     
        $this->create([
            'userId' => '1',
            'subject' => 'Rubrik 1',
            'text' => 'Test, fråga ett',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '1',
            'subject' => 'Rubrik 2',
            'text' => 'test fråga två',
            'created' => $now
        ]);

    }
}