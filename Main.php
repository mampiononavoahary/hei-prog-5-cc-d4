<?php
declare(strict_types=1);

class UserNotFoundException extends Exception {}

class Logger {
    public function log(string $message) {
        file_put_contents('error.log', $message.PHP_EOL, FILE_APPEND);
    }
}

const USERS = [
    "1" => "Julien",
    "2" => "Rajerison",
    "3" => "Jul",
];

class UserRepository {
    public function findUser(string $id):?string {
        return USERS[$id] ?? null;
    }

    public function getUserById(string $id):string {
            $user = $this->findUser($id);
            if (!$user) {
                throw new UserNotFoundException("User with $id not found !");
            }

            return $user;
    }
}

class Controller {
    public function getCurrentUser(string $id) : string 
    {
        $log = new Logger();
        try {
            $repository = new UserRepository();
            return $repository->getUserById($id);
            
        } catch (UserNotFoundException $e) {
            $message = $e->getMessage();
            $log->log($message);
            return $message;
        }
    }
}

$main = new Controller();
print_r($main->getCurrentUser("2"));
