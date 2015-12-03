<?php
namespace Anax\User;
 
/**
 * Model for Users.
 *
 */
class User extends \Anax\MVC\CDatabaseModel
{

    public static $loginSession = 'User::Login';
    
     /**
     * Setup table for users.
     *
     * @return boolean true or false if saving went okey.
     */
    public function setup()
    {
        $this->db->dropTableIfExists('user')->execute();
        $this->db->createTable(
            'user',
            [
                'id' => ['integer', 'primary key', 'not null', 'auto_increment'],
                'acronym' => ['varchar(20)', 'unique', 'not null'],
                'email' => ['varchar(80)', 'not null'],
                'password' => ['varchar(255)', 'not null'],
                'text' => ['text'],
            ]
        )->execute();
     
        $this->create([
            'acronym' => 'Amanda',
            'email' => 'amanda.aberg@hotmail.com',
            'password' => password_hash('admin', PASSWORD_DEFAULT),
            'text' => 'Hej! Jag är sidans administratör och en flitig hamburgerätare. Har varit vegetarian i mer än tio år och älskar att förfina recept för vegetariska burgare.'
        ]);
     
        $this->create([
            'acronym' => 'Doe',
            'email' => 'doe@dbwebb.se',
            'password' => password_hash('doe', PASSWORD_DEFAULT),
            'text' => 'Hej! Jag är en exempelanvändare och finns här för att visa hur frågor, svar och kommentarer kan se ut',
        ]);

        $this->create([
            'acronym' => 'Toeswade',
            'email' => 'toeswade@dbwebb.se',
            'password' => password_hash('toeswade', PASSWORD_DEFAULT),
            'text' => 'Hej! Jag är en exempelanvändare och finns här för att visa hur frågor, svar och kommentarer kan se ut',
        ]);

    }

    /**
     * Find user and try to login
     *
     * @return this
     */
    public function login($acronym, $password)
    {
        $this->db->select()
                 ->from($this->getSource())
                 ->where("acronym = ?");
     
        $this->db->execute([$acronym]);
        $res = $this->db->fetchInto($this);

        if($res) {
            if(password_verify($password, $res->password)) {
                $this->session->set(self::$loginSession, $res->id);
                return true;
            }
            else {

                return false;
            }
        }
        else {
            return false;
        }
    }

    /**
     * Logout user
     *
     * @return this
     */
    public function logout()
    {
        unset($_SESSION[self::$loginSession]);
    }


    /**
     * Get currently logged in user
     *
     * @return obj User
     */
    public function getLoggedInUser()
    {
        if($this->isUserLoggedIn()) {
            $id = $this->session->get(self::$loginSession);
            $user = $this->find($id);
            return $user;
        }
    }


    /**
     * Is user logged in
     *
     * @return boolean
     */
    public function isUserLoggedIn()
    {
        return $this->session->has(self::$loginSession);
    }


}