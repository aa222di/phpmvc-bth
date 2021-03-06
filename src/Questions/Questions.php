<?php
namespace Anax\Questions;
 
/**
 * Model for Questions.
 *
 */
class Questions extends \Anax\MVC\CDatabaseModel
{

     /**
     * Setup table for questions.
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
            'subject' => 'Bästa tipsen för perfekt konsistens?',
            'text' => 'Hej! Jag undrar vilka era bästa tips för en bra, tuggvänlig, icke-torr konsistens är? Vill helst undvika att använda för mycket mjöl och ägg om det är möjligt.',
            'created' => $now
        ]);
     
        $this->create([
            'userId' => '2',
            'subject' => 'Burgare baserade på hirs?',
            'text' => 'Har hört att hirs, för att inte tala om quinoa, ska vara vädligt nyttig och skulle gärna vilja ha lite tips på bra burgerrecept med dessa ingredienser!',
            'created' => $now
        ]);

    }


    public function getQuestionsForUser($id) {
        $this->db->select()
        ->from($this->getSource())
        ->where("userId = ?");
        $this->db->execute([$id]);
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }

    public function getLatestQuestions($limit) {
        $this->db->select()
        ->from($this->getSource())
        ->orderby('created DESC')
        ->limit($limit);
        $this->db->execute();
        $this->db->setFetchModeClass(__CLASS__);
        return $this->db->fetchAll();
    }
}