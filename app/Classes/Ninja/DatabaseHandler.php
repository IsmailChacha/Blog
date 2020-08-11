<?php
namespace Ninja
{
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

		// INSERT INTO DATABASE
		public function insert(array $data)
		{
			$sql = "INSERT INTO $this->table SET ";
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

		// UPDATE DATABASE
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

		// DELETE FROM DATABASE
		public function delete(array $conditions)
		{
			//CONSTRUCT THE QUERY
			$sql = "DELETE FROM $this->table";
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

      $affected_rows = $this->executeQuery($sql, $conditions);
			return $affected_rows;
		}

		public function deleteWhere(array $conditions)
		{
			//CONSTRUCT THE QUERY
			$sql = "DELETE FROM $this->table";
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

			$affected_rows = $this->executeQuery($sql, $conditions);
			return $affected_rows;
		}

		// FETCH ALL FROM TABLE WITH/OUT CONDITIONS
		public function findAll (array $conditions = [], $orderBy = null, $limit = null, $offset = null):array
		{
			if(empty($conditions))
			{
				$sql = "SELECT * FROM $this->table";
			} else 
			{
				//CONSTRUCT THE QUERY
				$sql = "SELECT * FROM $this->table";

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

			if($limit !== null)
			{
				$sql .= ' LIMIT ' . $limit;
			}

			if($offset !== null)
			{
				$sql .= ' OFFSET ' .$offset;
			}

			$results = $this->executeQuery($sql, $conditions);
			return $results->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
		}

		//FETCH RECORDS BY PRIMARY KEY
		public function findById($id)
    {
      $sql = "SELECT * FROM $this->table WHERE $this->primarykey = :$this->primarykey";
			$conditions = ["$this->primarykey" => $id];
			$results = $this->executeQuery($sql, $conditions);
			return $results->fetchObject($this->className, $this->constructorArgs);
		}
		
    public function  save(array $record)
    {
      try
      {
				//RETURN ENTITY OBJECT REPRESENTING THE DATE THAT'S BEEN INSERTED /UPDATED
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
			//WRITE DATA INTO THE OBJECT REPRESENTING RECORD
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
			$sql = "SELECT 
							A.*, U.FirstName 
							FROM Articles as A
							JOIN Users AS U 
							ON A.AuthorId=U.Id 
							WHERE A.Published=:Published
							AND A.Title LIKE :Title OR A.Body LIKE :Body OR A.Description LIKE :Description OR A.Keywords LIKE :Keywords";

			$conditions = ['Published' => 1, 'Title'=> $match, 'Body'=> $match, 'Description' => $match, 'Keywords' => $match];
			// display($conditions);
			$stmt = $this->executeQuery($sql, $conditions);
			$results = $stmt->fetchAll(\PDO::FETCH_CLASS, $this->className, $this->constructorArgs);
			return $results;
		}

		// TOTAL
		public function total(array $conditions = []):int
    {
			if(empty($conditions))
			{
				$sql = "SELECT COUNT(*) FROM $this->table";
			} else 
			{
				$sql = "SELECT COUNT(*) FROM $this->table WHERE";
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
		
		// SELECT ONE FUNCTION
		public function findOne (array $conditions = [])
		{
			$sql = "SELECT * FROM $this->table";
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
			$result = $stmt->fetchObject($this->className, $this->constructorArgs);
			return $result;  
		}
	}
}