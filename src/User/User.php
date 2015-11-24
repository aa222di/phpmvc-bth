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
            'email' => ['varchar(80)'],
            'password' => ['varchar(255)'],
        ]
    )->execute();
 
    $this->create([
        'acronym' => 'admin',
        'email' => 'admin@dbwebb.se',
        'password' => password_hash('admin', PASSWORD_DEFAULT)
    ]);
 
    $this->create([
        'acronym' => 'doe',
        'email' => 'doe@dbwebb.se',
        'password' => password_hash('doe', PASSWORD_DEFAULT)
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