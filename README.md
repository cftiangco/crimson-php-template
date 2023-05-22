# This is a mini ORM for PHP
### Autor: Crimson Tiangco

### -
### Inserting a new record
```
$data = ['name' => 'John', 'age' => 25, 'email' => 'john@example.com'];
$insertedId = $orm->insert($data);
```

### Selecting records
```
$conditions = ['age' => 25];
$columns = 'name, email';
$results = $orm->select($conditions, $columns);
```

### Updating records
```
$conditions = ['id' => $insertedId];
$data = ['age' => 30];
$updatedRows = $orm->update($conditions, $data);
```

### Deleting records
```
$conditions = ['id' => $insertedId];
$deletedRows = $orm->delete($conditions);
```

