<?php
namespace Ninja
{
	// DOES ALL DATABASE TRANSACTIONS
	class DatabaseHandler
	{
		//CLASS VARIABLES
    private $pdo;
		private $table;
		private $primarykey;
		private $usernameColumn;
		private $className;
		private $constructorArgs;
		
		//INITIALIZE CLASS VARIABLES
    public function __construct(\PDO $pdo, string $table, string $primarykey, string $usernameColumn = '', string $className = '\stdClass', array $constructorArgs = [])
    {
      $this->pdo = $pdo;
      $this->table = $table;
			$this->primarykey = $primarykey;
			$this->usernameColumn = $usernameColumn;
			$this->className = $className;
			$this->constructorArgs = $constructorArgs;
		}

		//EXECUTE QUERY
		private function executeQuery($sql, $data = [])
		{
			$stmt = $this->pdo->prepare($sql);
			$stmt->execute($data);
			return $stmt;
		}

		// INSERT RECORD
		public function insert(array $data)
		{
			$sql = "INSERT INTO $this->table SET ";
			// CONSTRUCT THE QUERY
			$i = 0;
			foreach($data as $key => $value)
			{
				if($i === 0)
				{
					$sql .= "$key = :$key";
				} else 
				{
					$sql .= ", $key = :$key";
				}
				$i++;
			}
			$this->executeQuery($sql, $data);
      return $this->pdo->lastInsertId();
		}

		// UPDATE RECORD
		public function update(array $data)
		{
			//CONSTRUCT THE QUERY
			$sql = "UPDATE $this->table SET ";
			$i = 0;
			foreach($data as $key => $value)
			{
				if($i === 0)
				{
					$sql .= "$key = :$key";
				} else 
				{
					$sql .= ",  $key = :$key";
				}
				$i++;
			}
			$sql .= " WHERE $this->primarykey = :value";
			$data['value'] = $data["$this->primarykey"];
			$this->executeQuery($sql, $data);
      return $this->pdo->lastInsertId();
		}

		// DELETE RECORD
		public function delete(array $conditions)
		{
			$sql = "DELETE FROM $this->table";
			//CONSTRUCT THE QUERY
			$i = 0;
			foreach($conditions as $key => $value)
			{
				if($i === 0)
				{
					$sql .= " WHERE $key = :$key";
				}else 
				{
					$sql .= " AND $key = :$key";
				}
				$i++;
			}

      return $this->executeQuery($sql, $conditions);
		}

		public function deleteWhere(array $conditions)
		{
			$sql = "DELETE FROM $this->table";
			//CONSTRUCT THE QUERY
			$i = 0;
			foreach($conditions as $key => $value)
			{
				if($i === 0)
				{
					$sql .= " WHERE $key = :$key";
				}else 
				{
					$sql .= " AND $key = :$key";
				}
				$i++;
			}

			return $this->executeQuery($sql, $conditions);
		}

		// FETCH RECORDS 
		// TAKES OPTIONAL PARAMS: $CONDITIONS, $ORDER, $LIMIT, & $OFFSET
		public function findAll (array $conditions = [], $orderBy = null, $limit = null, $offset = null):array
		{
			if(empty($conditions))
			{
				$sql = "SELECT * FROM $this->table";
			} else 
			{
				$sql = "SELECT * FROM $this->table";
				//CONSTRUCT THE QUERY

				$i = 0;
				foreach($conditions as $key => $value)
				{
					if($i === 0)
					{
						$sql = $sql . " WHERE $key = :$key";
					} else 
					{
						$sql = $sql . " AND $key = :$key";
					}
					$i++;
				}
			}

			// DEFINE THE ORDER
			if($orderBy !== null)
			{
				$sql .= ' ORDER BY ' . $orderBy;
			}

			// DEFINE THE LIMIT
			if($limit !== null)
			{
				$sql .= ' LIMIT ' . $limit;
			}

			// DEFINE THE OFFSET
			if($offset !== null)
			{
				$sql .= ' OFFSET ' .$offset;
			}

			$results = $this->executeQuery($sql, $conditions);
			return $results->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		}

		//FETCH RECORDS BY ID
		public function findById($id)
    {
      $sql = "SELECT * FROM $this->table WHERE $this->primarykey = :$this->primarykey";
			$conditions = ["$this->primarykey" => $id];
			$results = $this->executeQuery($sql, $conditions);
			return $results->fetchObject($this->className, $this->constructorArgs);
		}
		
		// SAVE RECORD. CALLS EITHER INSERT() OR UPDATE()
    public function  save(array $record)
    {
      try
      {
				//RETURN ENTITY OBJECT REPRESENTING THE RECORD THAT'S JUST BEEN INSERTED /UPDATED
				$entity = new $this->className(...$this->constructorArgs);
				if($record[$this->primarykey] == '')
        {
					$record[$this->primarykey] = null;
        }
          $insertId = $this->insert($record);
          $entity->{$this->primarykey} = $insertId;
      } catch(\PDOException $e)
      {
        $insertId = $this->update($record);
        $entity->{$this->primarykey} = $insertId;
      }

			$entity->{$this->primarykey} = $insertId;
			//COPY DATA INTO THE OBJECT REPRESENTING RECORD
			foreach($record as $key => $value)
			{
				if(!empty($value))
				{
					$entity->$key = $value;
				}
			}
			return $entity;
		}

		// SEARCH FUNCTIONALITY 
		public function searchPosts ($term):array
		{
			$match = '%' .$term. '%';
			$sql = "SELECT * FROM $this->table WHERE Published = :Published AND Title LIKE :Title";

			$conditions = ['Published' => 1, 'Title' => $match];
			$stmt = $this->executeQuery($sql, $conditions);
			$results = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
			return $results;
		}

		// FIND TOTAL RECORDS 
		public function total(array $conditions = []):int
    {
			if(empty($conditions))
			{
				$sql = "SELECT COUNT(*) FROM $this->table";
			} else 
			{
				$sql = "SELECT COUNT(*) FROM $this->table WHERE";
				// CONSTRUCT THE QUERY
				$i=0;
				foreach($conditions as $key => $value)
				{
					if($i === 0)
					{
						$sql .= " $key = :$key";
					} else 
					{
						$sql .= " AND $key = :$key";
					}
					$i++;
				}
			}
			
			$results = $this->executeQuery($sql, $conditions);
			$row = $results->fetch();
      return $row[0];
		}
		
		// FIND ONE RECORD
		public function findOne (array $conditions = [])
		{
			$sql = "SELECT * FROM $this->table";
			// CONSTRUCT THE QUERY
			$i = 0;
			foreach($conditions as $key => $value)
			{
				if($i === 0)
				{
					$sql .= " WHERE $key = :$key";
				} else 
				{
					$sql .= " AND $key = :$key";
				}
				$i++;
			}
			$stmt = $this->executeQuery($sql, $conditions); 
			return $stmt->fetchObject($this->className, $this->constructorArgs);
		}
	}
}