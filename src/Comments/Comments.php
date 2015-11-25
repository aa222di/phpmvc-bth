<?php
namespace Anax\Comments;
 
/**
 * Model for Users.
 *
 */
class Comments extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for users.
     *
     * @return boolean true or false if saving went okey.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('comments')->execute();
 
        $this->db->createTable(
            'comments',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'userId' => ['integer', 'not null'],
                'questionId' => ['integer'],
                'answerId' => ['integer'],
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
            'text' => 'Kommentar på fråga ett',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '2',
            'questionId' => '2',
            'text' => 'Kommentar på fråga två',
            'created' => $now
        ]);

        $this->create([
            'userId' => '2',
            'questionId' => '2',
            'text' => 'Kommentar två på fråga två',
            'created' => $now
        ]);

        $this->create([
            'userId' => '1',
            'answerId' => '1',
            'text' => 'Kommentar på svar',
            'created' => $now
        ]);

        $this->create([
            'userId' => '1',
            'answerId' => '1',
            'text' => 'Kommentar igen på samma svar',
            'created' => $now
        ]);

    }

    public function getCommentsForAnswer($id) {
           $this->db->select()
             ->from($this->getSource())
             ->where("answerId = ?");
            $this->db->execute([$id]);
            $this->db->setFetchModeClass(__CLASS__);
            return $this->db->fetchAll();
    }

    public function getCommentsForQuestion($id) {
           $this->db->select()
             ->from($this->getSource())
             ->where("questionId = ?");
            $this->db->execute([$id]);
            $this->db->setFetchModeClass(__CLASS__);
            return $this->db->fetchAll();
    }
}