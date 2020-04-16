<?php

/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

/**
 *
 */
class MagicienManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'magicien';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    /**
     * @param array $magicien
     * @return int
     */
    public function insert(array $magicien): int
    {
        // prepared request
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`email`, `password`) VALUES (:email, :password)");
        $statement->bindValue('email', $magicien['email'], \PDO::PARAM_STR);
        $statement->bindValue('password', $magicien['password'], \PDO::PARAM_STR);

        if ($statement->execute()) {
            return (int) $this->pdo->lastInsertId();
        }
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function getPanier(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM panier WHERE magicien_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function checkMagicienConnection($login)
    {
        $statement = $this->pdo->prepare("SELECT * FROM magicien WHERE email=:email");
        $statement->bindValue('email', $login['email'], \PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetch();
        if (!empty($result)) {
            if ($result['password'] === $login['password']) {
                return $result;
            } else {
                return "Incorrect password";
            }
        } else {
            return 'Magicien not found';
        }
    }

    public function getHistory($id)
    {
        $statement = $this->pdo->prepare("SELECT * FROM panier WHERE magicien_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetchAll();
    }
}
