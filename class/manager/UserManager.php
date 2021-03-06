<?php
include './include/cnx.php';

include_once './trait/ManagerCnx.php';

class UserManager
{
    use ManagerCnx;

    public function createUser(Users $user)
    {
        if (empty($user->getName()) || empty($user->getFirstname()) || (empty($user->getEmail()) || (empty($user->getMdp())))) {
            echo 'Pour s\'enregistrer il faut remplir tous les champs';
        } else {
            $sql = "INSERT INTO USER (name, firstname, email, mdp) VALUES (:name, :firstname, :email, SHA1(:mdp))";

            $req = $this->cnx->prepare($sql);

            $req->bindValue(':name', $user->getName(), PDO::PARAM_STR);
            $req->bindValue(':firstname', $user->getFirstname(), PDO::PARAM_STR);
            $req->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
            $req->bindValue(':mdp', $user->getMdp(), PDO::PARAM_STR);

            $verif =$req->execute();

            if ($verif) {
                echo '<p class="bg-info text-center">Données enregistrées</p>';
            } else {
                echo '<p class="bg-warning text-center">Une erreur s\'est produite. Veuillez réessayer</p>';
            }
        }
    }
    public function readAllUser()
    {
        $sql = 'SELECT * FROM user';
        $req = $this->cnx->prepare($sql);
        $req->execute();

        while ($data = $req->fetch(PDO::FETCH_ASSOC)) {
            $user = new Users();
            $user->setId($data['id']);
            $user->setName($data['name']);
            $user->setFirstname($data['firstname']);
            $user->setEmail($data['email']);
            $user->setMdp($data['mdp']);

            $users[] = $user;
        }
        if (!empty($users)) {
            return $users;
        } else {
            $message = 'Il n\'y a pas d\'internaute enregistré pour le moment';
            return $message;
        }
    }
}
