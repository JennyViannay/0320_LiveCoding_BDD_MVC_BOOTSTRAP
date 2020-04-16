<?php

namespace App\Model;

/**
 *
 */
class CategorieManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'categorie';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent::__construct(self::TABLE);
    }
}