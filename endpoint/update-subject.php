<?php
include('../conn/conn.php');

$updateSubjectID = $_POST['tbl_subject_id'];
$updateSubjectName = $_POST['subject_name'];
$updateSubjectTeacher = $_POST['subject_teacher'];

try {
    $stmtCheck = $conn->prepare("SELECT * FROM `tbl_subject` WHERE `subject_name` = :subject_name");
    $stmtCheck->execute([
        'subject_name' => $updateSubjectName,
    ]);

    $existingSubject = $stmtCheck->fetch(PDO::FETCH_ASSOC);

    if (empty($existingSubject)) {
        $stmtUpdate = $conn->prepare("UPDATE `tbl_subject` SET `subject_name` = :subject_name, `subject_teacher` = :subject_teacher WHERE `tbl_subject_id` = :subject_id");
        $stmtUpdate->bindParam(':subject_name', $updateSubjectName, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':subject_teacher', $updateSubjectTeacher, PDO::PARAM_STR);
        $stmtUpdate->bindParam(':subject_id', $updateSubjectID, PDO::PARAM_INT);
        $stmtUpdate->execute();

        echo "
        <script>
            alert('Materia actualizada correctamente');
            window.location.href = 'http://localhost/tareas-colegios/index.php';
        </script>
        ";
    } else {
        echo "
        <script>
            alert('Materia ya existe actualmente');
            window.location.href = 'http://localhost/tareas-colegios/index.php';
        </script>
        ";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
