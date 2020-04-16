<?php

namespace App\Model;

class PotionManager extends AbstractManager
{

    const TABLE = 'potion';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function selectAllOrdered(): array
    {
        $potions = $this->pdo->query("SELECT * FROM $this->table ORDER BY score DESC")->fetchAll();
        return $potions;
    }

    public function selectByCategory(int $id)
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM $this->table WHERE category_id=:id ORDER BY score DESC");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function updateScore(int $id)
    {
        $potion = $this->selectOneById($id);
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `score` = :score WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->bindValue('score', $potion['score'] + 1, \PDO::PARAM_STR);
        $statement->execute();
        return $potion = $this->selectOneById($id);
    }

    public function postComment($form){
        $statement = $this->pdo->prepare(
            "INSERT INTO comment (`description`, `potion_id`, `author`) VALUES (:description, :potion_id, :author)"
        );
        $statement->bindValue('description', $form['description']);
        $statement->bindValue('potion_id', intval($form['id']), \PDO::PARAM_INT);
        $statement->bindValue('author', $form['name'], \PDO::PARAM_STR);
        
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }
}
