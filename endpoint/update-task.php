<?php
include('../conn/conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tbl_task_id = $_POST['tbl_task_id'];
    $tbl_subject_id = $_POST['tbl_subject_id'];
    $task_name = $_POST['task_name'];
    $task_status = $_POST['task_status'];
    $task_deadline = $_POST['task_deadline'];

    try {
        $stmt = $conn->prepare("UPDATE `tbl_task` SET `tbl_subject_id` = :tbl_subject_id, `task_name` = :task_name, `task_status` = :task_status, `task_deadline` = :task_deadline WHERE `tbl_task_id` = :tbl_task_id");

        $stmt->bindParam(':tbl_subject_id', $tbl_subject_id, PDO::PARAM_INT);
        $stmt->bindParam(':task_name', $task_name, PDO::PARAM_STR);
        $stmt->bindParam(':task_status', $task_status, PDO::PARAM_STR);
        $stmt->bindParam(':task_deadline', $task_deadline);
        $stmt->bindParam(':tbl_task_id', $tbl_task_id, PDO::PARAM_INT);

        $stmt->execute();

        echo "
        <script>
            alert('Tarea actualizada correctamente');
            window.location.href = 'http://localhost/tareas-colegios/index.php';
        </script>
        ";
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "
        <script>
            Fallo actualizar tarea');
            window.location.href = 'http://localhost/tareas-colegios/index.php';
        </script>
        ";
}
