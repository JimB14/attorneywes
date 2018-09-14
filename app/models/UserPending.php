<?php
// UserPending model
class UserPending
{
    // define table (required for Eloquent if using Eloquent & not 'Snake' naming)
    protected $table = 'users_pending';

    // holds database connectivity; called in model method of base Controller
    protected $db;

    // pass PDO object method
    // adding 'PDO' before the variable is 'type hinting', e.g construct(PDO $db)
    // works both ways
    public function __construct(PDO $db)
    {
        //var_dump($db);  // check if PDO object exists

        // set $db object to protected $db (see above) so it can be used in
        // any method in UserPending class
        $this->db = $db;
    }


    public function addUserPending($token, $user_id)
    {
        //echo "Connected to addUserPending method of UserPending class/model!";  exit();
        //echo __DIR__; exit();
        //var_dump($this->db); exit();

        // store CONSTANT value in variable for use in header()
        // ASSET_ROOT defined @app/init.php ~ line #24
        $asset_root = ASSET_ROOT;

        try {
            $sql = "INSERT INTO users_pending (token, user_id) VALUES (:token, :user_id)";
            $query = $this->db->prepare($sql);
            $parameters = [
              ':token' => $token,
              ':user_id' => $user_id
            ];
            return $query->execute($parameters);
        }
        catch (PDOException $e)
        {
            echo "Error inserting into users pending";
            exit();
        }
    }


    public function verifyNewUserAccount($token, $user_id)
    {
        // echo "Connected to verifyNewUserAccount in UserPending model<br><br>";
        // echo $token . "<br>";
        // echo $user_id . "<br>";

        // check for $token value in users_pending.token
        try {
            $sql = "SELECT * FROM users_pending WHERE token = :token
                    AND user_id = :user_id";
            $query = $this->db->prepare($sql);
            $parameters = [
                ':token' => $token,
                ':user_id' => $user_id
            ];
            $query->execute($parameters);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            // echo "<pre>";
            // print_r($user);
            // echo "</pre>";
            // exit();

            if(empty($user))
            {
                echo "Unable to find match. Please re-register.";
                exit();
            }
            else
            {
                // activate user account
                try {
                    $sql = "UPDATE users SET
                            active = 1
                            WHERE id = :id";
                    $query = $this->db->prepare($sql);
                    $parameters = [
                        ':id' => $user_id
                    ];
                    $query->execute($parameters);
                }
                catch (PDOException $e)
                {
                    echo "Error adding new user.";
                    exit();
                }

                // delete pending user from table to disable verify email link
                try {
                    $sql = "DELETE FROM users_pending
                            WHERE token = :token";
                    $query =  $this->db->prepare($sql);
                    $parameters = [
                        ':token' => $token
                    ];
                    $query->execute($parameters);
                }
                catch(PDOException $e)
                {
                    echo "Error deleting users pending entry";
                    exit();
                }
            }
            return true;
        }
        catch(PDOException $e)
        {
            echo "Error retrieving data from users pending";
            exit();
        }
    }
}
