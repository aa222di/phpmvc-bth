<?php
namespace Anax\Answers;
 
/**
 * Model for Users.
 *
 */
class Answers extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for users.
     *
     * @return boolean true or false if saving went okey.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('answers')->execute();
 
        $this->db->createTable(
            'answers',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'userId' => ['integer', 'not null'],
                'questionId' => ['integer', 'not null'],
                'text' => ['text'],
                'created' => ['datetime'],
                'updated' => ['datetime'],
                'deleted' => ['datetime'],
            ]
        )->execute();

     
        $now = gmdate('Y-m-d H:i:s');
     
        $this->create([
            'userId' => '2',
            'questionId' => '1',
            'text' => 'Svar på fråga ett',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '2',
            'questionId' => '2',
            'text' => 'Svar på fråga två',
            'created' => $now
        ]);

    }

    public function getAnswersforQuestion($id) {
           $this->db->select()
             ->from($this->getSource())
             ->where("questionId = ?");
            $this->db->execute([$id]);
            $this->db->setFetchModeClass(__CLASS__);
            return $this->db->fetchAll();
    }
}