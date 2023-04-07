<?php

class DB {

    protected $instance;
    
    public function __construct($instance)
    {
        $this->instance = $instance;
    }

    public function get($sql, $values = array())
    {
        $query = $this->instance->prepare($sql);
        $query->execute($values);

        $num_results = $query->rowCount();
        if($num_results == 0) { return []; }
        if($num_results == 1) { return $query->fetch(PDO::FETCH_ASSOC); }
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_all($sql, $values = array())
    {
        $query = $this->instance->prepare($sql);
        $query->execute($values);

        $num_results = $query->rowCount();
        if($num_results == 0) { return []; }

        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($sql, $values)
    {
        $query = $this->instance->prepare($sql);
        if($query->execute($values))
        {
            return $this->instance->lastInsertId();
        }
        return 0;
    }
}

?>