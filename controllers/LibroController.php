<?php
include 'db.php'; 

class LibroController {
    private $conn;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
    }

    public function agregarLibro($titulo, $editorial, $isbn, $fechaPublicacion) {
        $stmt = $this->conn->prepare("INSERT INTO libros (Titulo, Editorial, ISBN, FechaPublicacion) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $titulo, $editorial, $isbn, $fechaPublicacion);
        if (!$stmt->execute()) {
            throw new Exception("Error al agregar libro: " . $stmt->error);
        }
    }

    public function eliminarLibro($libroID) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM Libros WHERE LibroID = ?");
        $stmt->execute([$libroID]);
    }

    public function modificarLibro($libroID, $titulo, $editorial, $isbn, $fechaPublicacion) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE Libros SET Titulo = ?, Editorial = ?, ISBN = ?, FechaPublicacion = ? WHERE LibroID = ?");
        $stmt->execute([$titulo, $editorial, $isbn, $fechaPublicacion, $libroID]);
    }

    public function mostrarLibros() {
        $sql = "SELECT l.LibroID, l.Titulo, l.Editorial, l.ISBN, l.FechaPublicacion, 
                       GROUP_CONCAT(a.Nombre SEPARATOR ', ') AS Autores
                FROM Libros l
                LEFT JOIN LibrosAutores la ON l.LibroID = la.LibroID
                LEFT JOIN Autores a ON la.AutorID = a.AutorID
                GROUP BY l.LibroID";
        
        $result = $this->conn->query($sql);
        $libros = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $libros[] = $row;
            }
        }
        return $libros;
    }
    public function agregarAutor($nombreAutor) {
        // Asegúrate de que el nombre del autor no esté vacío
        if (empty($nombreAutor)) {
            throw new Exception("El nombre del autor no puede estar vacío.");
        }

        // Preparar la consulta para agregar el autor
        $stmt = $this->conn->prepare("INSERT INTO autores (Nombre) VALUES (?)");
        $stmt->bind_param("s", $nombreAutor);
        $stmt->execute();

        // Retornar el ID del autor agregado
        return $this->conn->insert_id; // Devuelve el último ID insertado
    }

    public function agregarAutorALibro($libroID, $autorID) {
        // Asegúrate de que los IDs no sean nulos
        if (empty($libroID) || empty($autorID)) {
            throw new Exception("El ID del libro o del autor no puede estar vacío.");
        }

        // Preparar la consulta para agregar la relación entre libro y autor
        $stmt = $this->conn->prepare("INSERT INTO libro_autor (LibroID, AutorID) VALUES (?, ?)");
        $stmt->bind_param("ii", $libroID, $autorID);
        $stmt->execute();
    }

    public function mostrarAutores() {
        $sql = "SELECT AutorID, Nombre FROM Autores";
        $result = $this->conn->query($sql);
        $autores = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $autores[] = $row;
            }
        }
        return $autores;
    }

    public function buscarLibros($busqueda) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM Libros WHERE Titulo LIKE ? OR ISBN LIKE ?");
        $stmt->execute(["%$busqueda%", "%$busqueda%"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
