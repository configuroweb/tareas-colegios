<?php
include('../conn/conn.php');

if (isset($_GET['task'])) {
    $task = $_GET['task'];

    try {

        $query = "DELETE FROM `tbl_task` WHERE `tbl_task_id` = '$task'";

        $stmt = $conn->prepare($query);

        $query_execute = $stmt->execute();

        if ($query_execute) {
            echo "
            <script>
                alert('Tarea eliminada correctamente');
                window.location.href = 'http://localhost/tareas-colegios/index.php';
            </script>
            ";
        } else {
            echo "
            <script>
                alert('Error eliminar tarea');
                window.location.href = 'http://localhost/tareas-colegios/index.php';
            </script>
            ";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
