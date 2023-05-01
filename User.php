<?php

class User {
    private $user_id;
    
    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }
    
    public function getUserId() {
        return $this->user_id;
    }
}

?>
