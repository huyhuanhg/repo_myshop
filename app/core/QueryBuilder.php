<?php


namespace app\core;


trait QueryBuilder
{
    private $columns;
    private $from;
    private $distinct = false;
    private $joins;
    private $wheres;
    private $groups;
    private $havings;
    private $orders;
    private $limit;
    private $offset;

    public static function table($table)
    {
        return new self($table);
    }

    public function select($cols)
    {
        $this->columns = is_array($cols) ? $cols : func_get_args();
        return $this;
    }

    public function distinct()
    {
        $this->distinct = true;
        return $this;
    }

    public function join($table, $first, $operator, $second, $type = 'INNER')
    {
        $this->joins[] = [$table, "$this->from.$first", $operator, "$table.$second", $type];
        return $this;
    }

    public function leftJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'LEFT');
    }

    public function rightJoin($table, $first, $operator, $second)
    {
        return $this->join($table, $first, $operator, $second, 'RIGHT');
    }

    private function addWhere($column, $operator, $value, $logicalOperator = 'AND')
    {
        if (strtoupper($operator) === 'IS' && strtoupper($value) === 'NULL') {
            $this->wheres[$logicalOperator][] = [$column, $operator, $value];
        } else {
            $this->wheres[$logicalOperator][] = [$column, $operator, is_string($value) ? "'" .
                str_replace("'", "\'", $value) . "'" : $value];
        }
    }

    public function where()
    {
        $num_args = func_num_args();
        $arg_list = func_get_args();
        if (is_callable(reset($arg_list))) {
            $logicalOperator = "AND";
            if ($num_args === 2) {
                $logicalOperator = end($arg_list);
            }
            $closures = reset($arg_list);
            $copy = new $this;
            $closures($copy);
            $this->wheres[$logicalOperator][] = $copy->wheres;
        } else {
            list($column, $operator, $value, $logicalOperator) = $arg_list;
            if ($num_args === 3) {
                $logicalOperator = 'AND';
            }
            $this->addWhere($column, $operator, $value, $logicalOperator);
        }
        return $this;
    }

    public function orWhere($column, $operator, $value)
    {
        $arg_list = func_get_args();
        array_push($arg_list, 'OR');
        return call_user_func_array([$this, 'where'], $arg_list);
    }

    public function isNull($column, $logicalOperator = 'AND')
    {
        return $this->where($column, 'IS', 'NULL', $logicalOperator);
    }

    public function groupBy($columns)
    {
        $this->groups = is_array($columns) ? $columns : func_get_args();
        return $this;
    }


    public function having($column, $operator, $value, $logicalOperator = 'AND')
    {
        if (strtoupper($operator) === 'IS' && strtoupper($value) === 'NULL') {
            $this->havings[$logicalOperator][] = [$column, $operator, $value];
        } else {
            $this->havings[$logicalOperator][] = [$column, $operator, is_string($value) ? "'" .
                str_replace("'", "\'", $value) . "'" : $value];
        }
        return $this;
    }

    public function orHaving($column, $operator, $value)
    {
        return $this->having($column, $operator, $value, 'OR');
    }

    public function orderBy($column, $direction = 'ASC')
    {
        $this->orders[] = [$column, $direction];
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    private function insertWhere($array)
    {
        $sql = '';
        if (array_key_exists('AND', $array)) {
            foreach ($array['OR'] as $where) {
                if (array_key_exists('AND', $where) || array_key_exists('OR', $where)) {
                    $sql .= " (";
                    $sql .= $this->insertWhere($where);
                    $sql .= ") OR";
                } else {
                    $sql .= " $where[0] $where[1] $where[2] OR";
                }
            }
            foreach ($array['AND'] as $wk => $where) {
                if (array_key_exists('AND', $where) || array_key_exists('OR', $where)) {
                    $sql .= " (";
                    $sql .= $this->insertWhere($where);
                    $sql .= ")";
                } else {
                    $sql .= " $where[0] $where[1] $where[2]";
                }

                if ($wk < count($array['AND']) - 1) {
                    $sql .= " AND";
                }
            }
        } else {
            foreach ($array['OR'] as $wk => $where) {
                if (array_key_exists('AND', $where) || array_key_exists('OR', $where)) {
                    $sql .= " (";
                    $sql .= $this->insertWhere($where);
                    $sql .= ")";
                } else {
                    $sql .= " $where[0] $where[1] $where[2]";
                }
                if ($wk < count($array['OR']) - 1) {
                    $sql .= " OR";
                }
            }
        }
        return $sql;
    }

    private function handleWhere($sql)
    {
        $sql = " WHERE";
        $sql .= $this->insertWhere($this->wheres);
        return $sql;
    }

    private function addHaving($sql)
    {
        $sql .= " HAVING";
        if (array_key_exists('AND', $this->havings)) {
            foreach ($this->havings['OR'] as $having) {
                $sql .= " $having[0] $having[1] $having[2] OR";
            }
            foreach ($this->havings['AND'] as $hk => $having) {
                $sql .= " $having[0] $having[1] $having[2]";
                if ($hk < count($this->havings['AND']) - 1) {
                    $sql .= " AND";
                }
            }
        } else {
            foreach ($this->havings['OR'] as $hk => $having) {
                $sql .= " $having[0] $having[1] $having[2]";
                if ($hk < count($this->havings['OR']) - 1) {
                    $sql .= " OR";
                }
            }
        }
        return $sql;
    }

    public function get()
    {
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }
        $sql = $this->distinct ? 'SELECT DISTINCT ' : 'SELECT ';
        if (isset($this->columns) && is_array($this->columns)) {
            $sql .= implode(', ', $this->columns);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->from;

        if (isset($this->joins) && is_array($this->joins)) {
            foreach ($this->joins as $join) {
                $sql .= " $join[4] JOIN $join[0] ON $join[1] $join[2] $join[3]";
            }
        }

        if (isset($this->wheres) && is_array($this->wheres)) {
            $sql .= $this->handleWhere($sql);
        }

        if (isset($this->havings) && is_array($this->havings)) {
            $sql = $this->addHaving($sql);
        }

        if (isset($this->groups) && is_array($this->groups)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groups);
        }


        if (isset($this->orders) && is_array($this->orders)) {
            $sql .= " ORDER BY";
            foreach ($this->orders as $ok => $order) {
                $sql .= " $order[0] $order[1]";
                if ($ok < count($this->orders) - 1) {
                    $sql .= ",";
                }
            }
        }
        if (isset($this->limit)) {
            $sql .= " LIMIT $this->limit";
        }
        if (isset($this->offset)) {
            $sql .= " OFFSET $this->offset";
        }
        return $this->query($sql);
    }

    public function insert($data)
    {
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }
        $columns = implode(', ', array_keys($data));

        $values = implode(', ', array_map([$this, 'handleString'], $data));
        $sql = "INSERT INTO $this->from ($columns) VALUES ($values);";
        return $this->query($sql);
    }

    public function update($data)
    {
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }
        $data = array_map([$this, 'handleString'], $data);
        $data = array_map([$this, 'handleDataUpdate'], array_keys($data), $data);
        $sql = "UPDATE $this->from SET " . implode(', ', $data);

        if (isset($this->wheres) && is_array($this->wheres)) {
            $sql .= $this->handleWhere($sql);
        }
        return $this->query("$sql;");
    }

    public function delete()
    {
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }
        $sql = "DELETE FROM $this->from";
        if (isset($this->wheres) && is_array($this->wheres)) {
            $sql .= $this->handleWhere($sql);
        }
        return $this->query("$sql;");
    }


    private function handleString($value)
    {
        if (is_string($value) && !preg_match("~b'[0-1]'~is", $value)) {
            return "'" . str_replace("'", "\'", $value) . "'";
        }
        return $value;
    }

    private function handleDataUpdate($key, $value)
    {
        return "$key = $value";
    }


//function to test Query builder
    public function show(){
        if (!isset($this->from) || empty($this->from)) {
            return false;
        }
        $sql = $this->distinct ? 'SELECT DISTINCT ' : 'SELECT ';
        if (isset($this->columns) && is_array($this->columns)) {
            $sql .= implode(', ', $this->columns);
        } else {
            $sql .= '*';
        }
        $sql .= ' FROM ' . $this->from;

        if (isset($this->joins) && is_array($this->joins)) {
            foreach ($this->joins as $join) {
                $sql .= " $join[4] JOIN $join[0] ON $join[1] $join[2] $join[3]";
            }
        }

        if (isset($this->wheres) && is_array($this->wheres)) {
            $sql .= $this->handleWhere($sql);
        }

        if (isset($this->havings) && is_array($this->havings)) {
            $sql = $this->addHaving($sql);
        }

        if (isset($this->groups) && is_array($this->groups)) {
            $sql .= ' GROUP BY ' . implode(', ', $this->groups);
        }


        if (isset($this->orders) && is_array($this->orders)) {
            $sql .= " ORDER BY";
            foreach ($this->orders as $ok => $order) {
                $sql .= " $order[0] $order[1]";
                if ($ok < count($this->orders) - 1) {
                    $sql .= ",";
                }
            }
        }
        if (isset($this->limit)) {
            $sql .= " LIMIT $this->limit";
        }
        if (isset($this->offset)) {
            $sql .= " OFFSET $this->offset";
        }
        die($sql);
    }
}
