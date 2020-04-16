<?php

namespace App\Model;

/**
 *
 */
class PanierManager extends AbstractManager
{
    const TABLE = 'panier';

    public function __construct()
    {
        parent::__construct(self::TABLE);
    }

    public function insert(array $item): int
    {
        // prepared request
        $statement = $this->pdo->prepare(
            "INSERT INTO " . self::TABLE 
            . " (`magicien_id`, `potion_id`, `qty`) 
            VALUES (:title, :potion_id, :qty)"
        );
        $statement->bindValue('magicien_id', $item['magicien_id'], \PDO::PARAM_INT);
        $statement->bindValue('potion_id', $item['potion_id'], \PDO::PARAM_INT);
        $statement->bindValue('qty', $item['qty'], \PDO::PARAM_INT);
        
        if ($statement->execute()) {
            return (int)$this->pdo->lastInsertId();
        }
    }

    public function delete(int $id): void
    {
        // prepared request
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }

    public function update(array $item):bool
    {
        // prepared request
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $item['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $item['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}