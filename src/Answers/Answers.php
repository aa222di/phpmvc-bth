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
            'text' => 'Prova att blanda sojafärs med hemmagjord seitan. Seitan är ju enbart protein och dessutom väldigt flexibelt och levande så länge dne är rå. När du blandar dessa två får din burgare mer textur.',
            'created' => $now
        ]);

        $this->create([
            'userId' => '3',
            'questionId' => '1',
            'text' => 'Skorpmjöl, havregryn eller andra goda gryn såsom råg och vete är supergott och ger bra tuggmotstånd!',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '1',
            'questionId' => '2',
            'text' => 'Koka hirsen eller quinoan med grönssaksbuljong för att få god smak. Sedan skulle jag personligen dryga ut med seitan eller lite champijoner eller annat som ger mer textur också.',
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