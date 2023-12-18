<?php
namespace App\Model;

class Receipt
{
    private $data;

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function saveToDatabase()
    {
          $config = require __DIR__ . '/../Config/config.php';
        $db = new \PDO(
            'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'],
            $config['database']['username'],
            $config['database']['password']
        );

        // JSON-encode the data for storage
        $jsonData = json_encode($this->data);

        // SQL query to insert data into the 'receipts' table
        $sql = "INSERT INTO receipts (data, created_at) VALUES (:data, NOW())";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':data', $jsonData, \PDO::PARAM_STR);
        
        // Execute the query
        $stmt->execute();
    }

    public function getData()
    {
        return $this->data;
    }

    public function getFormattedTotal()
    {
           if (isset($this->data['amount'])) {
            return '$' . number_format($this->data['amount'], 2);
        }

        return null;
    }

    public function getCategory()
    {
          return isset($this->data['category']) ? $this->data['category'] : null;
    }

    public static function getAllReceipts()
    {
        $config = require __DIR__ . '/../Config/config.php';
        $db = new \PDO(
            'mysql:host=' . $config['database']['host'] . ';dbname=' . $config['database']['dbname'],
            $config['database']['username'],
            $config['database']['password']
        );

        // SQL query to select all receipts
        $sql = "SELECT * FROM receipts";
        $stmt = $db->query($sql);

        // Fetch all rows as associative arrays
        $receipts = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        return $receipts;
    }
}
