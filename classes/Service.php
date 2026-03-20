<?php
class Service
{
    // CONNECT TO DB
    private $conn; 

    // CONSTRUCT
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // CREATE NEW ECLAIR
     public function create($title, $desc, $img, $keywords, $category, $price)
    {
        $query = "INSERT INTO services (title, description, image, keywords, category, price) 
        VALUES (:title, :description, :image, :keywords, :category, :price)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $desc);
        $stmt->bindParam(':image', $img);
        $stmt->bindParam(':keywords', $keywords);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }
    // DELL SERVICE
    public function delete($id)
    {
        $query = "DELETE FROM services WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    // READ ALL ECLAIRS
    public function readAll()
    {
        $query = "SELECT * FROM services";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC); 
        return $stmt;
    }
    // UPDATE SERVICE
    public function update($id, $title, $desc, $keywords, $category, $img, $price)
{
    $query = "UPDATE services 
              SET title = :title, 
                  description = :description, 
                  keywords = :keywords, 
                  category = :category, 
                  image = :image,
                  price = :price 
              WHERE id = :id";

    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $desc);
    $stmt->bindParam(':image', $img);
    $stmt->bindParam(':keywords', $keywords);
    $stmt->bindParam(':category', $category);
    $stmt->bindParam(':price', $price);

    return $stmt->execute();
}
    // SEARCH FOR A SERVICE
    public function search($keyword)
    {
        $query = "SELECT * FROM services WHERE 
                    title LIKE :keyword OR 
                    description LIKE :keyword OR
                    keywords LIKE :keyword OR
                    category LIKE :keyword
                    ";
        $stmt = $this->conn->prepare($query);
        $keyword = '%' . $keyword . '%';
        $stmt->bindParam(':keyword', $keyword);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return $stmt;
    }
    // BY CATEGORY
    public function filterByCategory($category)
    {
        $stmt = $this->conn->prepare("SELECT * FROM services WHERE category = ?");
        $stmt->execute([$category]);
        return $stmt;
    }
    // GET LIST OF CATEGORIES
    public function getCategories()
    {
        $stmt = $this->conn->query("SELECT DISTINCT category FROM services WHERE category IS NOT NULL AND category != ''");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }


}
