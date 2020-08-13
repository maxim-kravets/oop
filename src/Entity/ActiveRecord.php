<?php


namespace MaximKravets\OOP\Entity;


use MaximKravets\OOP\Service\Database;

abstract class ActiveRecord
{
    public static function getTableName(): string
    {
        $array = explode('\\',static::class);
        $name = array_pop($array);

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $name, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    public function getTableNameNonStatic(): string
    {
        $array = explode('\\',static::class);
        $name = array_pop($array);

        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $name, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        return implode('_', $ret);
    }

    public static function all()
    {
        return Database::getInstance()->query('SELECT * FROM '.self::getTableName());
    }

    public static function find(int $id)
    {
        return Database::getInstance()->query('SELECT * FROM '.self::getTableName().' WHERE id='.$id);
    }

    public function save()
    {
        $properties = get_object_vars($this);
        $columns = implode(', ', array_keys($properties));

        $values = [];
        foreach (array_values($properties) as $value) {
            if (is_string($value)) {
                $values[] = "'$value'";
            }
        }

        $values = implode(', ', $values);

        $query = 'INSERT INTO '.$this->getTableNameNonStatic().'('.$columns.')'.' VALUES ('.$values.')';

        Database::getInstance()->query($query);
    }

}