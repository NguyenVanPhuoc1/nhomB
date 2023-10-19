<?php

require_once 'BaseModel.php';
require_once 'idor_code.php';

class UserModel extends BaseModel {

    public function findUserById($id) {
        var_dump(decodeID($id));
        $decodedID = decodeID($id);

            $sql = 'SELECT * FROM users WHERE id = ' . $decodedID;
            $user = $this->select($sql);
        return $user;
    }
    

    public function findUser($keyword) {
        $sql = 'SELECT * FROM users WHERE user_name LIKE %'.$keyword.'%'. ' OR user_email LIKE %'.$keyword.'%';
        $user = $this->select($sql);

        return $user;
    }

    /**
     * Authentication user
     * @param $userName
     * @param $password
     * @return array
     */
    public function auth($userName, $password) {
        $md5Password = md5($password);
        $sql = 'SELECT * FROM users WHERE name = "' . $userName . '" AND password = "'.$md5Password.'"';

        $user = $this->select($sql);
        return $user;
    }

    /**
     * Delete user by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id) {
        $sql = 'DELETE FROM users WHERE id = '.decodeID($id);
        return $this->delete($sql);

    }

    /**
     * Update user
     * @param $input
     * @return mixed
     */
    public function updateUser($input) {
        $sql = 'UPDATE users SET 
                name = "' . mysqli_real_escape_string(self::$_connection, $input['name']) .'", 
                password="'. md5($input['password']) .'",version=" '. ++$input['version'] .'"
                WHERE id = ' . decodeID($input['id']);

        $user = $this->update($sql);

        return $user;
    }

    /**
     * Insert user
     * @param $input
     * @return mixed
     */
    public function insertUser($input) {
        $sql = "INSERT INTO `app_web1`.`users` (`name`, `password`) VALUES (" .
                "'" . $input['name'] . "', '".md5($input['password'])."')";

        $user = $this->insert($sql);

        return $user;
    }

    /**
     * Search users
     * @param array $params
     * @return array
     */
    public function getUsers($params = []) {
        //Keyword
        if (!empty($params['keyword'])) {
            // Prepare the SQL statement
            $sql = self::$_connection->prepare('SELECT * FROM users WHERE name LIKE ?');
            
            // Check if the prepare was successful
            if ($sql) {
                // Create a search pattern with wildcards
                $keyword = '%' . $params['keyword'] . '%';
                
                // Bind the parameter to the statement
                $sql->bind_param('s', $keyword);

                // Execute the statement
                $sql->execute();

                $users = array();
                $users = $sql -> get_result()-> fetch_all(MYSQLI_ASSOC);
            } else {
                // Handle the prepare error
                $users = [];
            }

            // $users = $this->query($sql);
        } else {
            $sql = 'SELECT * FROM users';
            $users = $this->select($sql);
        }

        return $users;
    }
}