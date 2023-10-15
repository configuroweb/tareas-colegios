<?php include('./conn/conn.php') ?>
<?php include('./assets/modals.php') ?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas Colegios</title>

    <!-- Style CSS -->
    <link rel="stylesheet" href="./assets/style.css">

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

</head>

<body>


    <div class="main">

        <div class="container">



            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <button class="nav-link active" id="v-pills-home-tab" data-toggle="pill" data-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Inicio</button>
                        <button class="nav-link" id="v-pills-pending-tab" data-toggle="pill" data-target="#v-pills-pending" type="button" role="tab" aria-controls="v-pills-pending" aria-selected="false">Tareas Pendientes</button>
                        <button class="nav-link" id="v-pills-in-progress-tab" data-toggle="pill" data-target="#v-pills-in-progress" type="button" role="tab" aria-controls="v-pills-in-progress" aria-selected="false">Tareas en Progreso</button>
                        <button class="nav-link" id="v-pills-completed-tab" data-toggle="pill" data-target="#v-pills-completed" type="button" role="tab" aria-controls="v-pills-completed" aria-selected="false">Tareas Completadas</button>
                        <button class="nav-link" id="v-pills-subjects-tab" data-toggle="pill" data-target="#v-pills-subjects" type="button" role="tab" aria-controls="v-pills-subjects" aria-selected="false">Materias</button>
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">

                            <!-- Botón de Agregar Tareas -->
                            <button type="button" class="btn btn-dark mb-3" data-toggle="modal" data-target="#taskModal" style="margin-left: 85%;">
                                Agregar Tarea
                            </button>

                            <!-- Tabla con todas las tareas -->
                            <table class="table table-hover task-list">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ID Tarea</th>
                                        <th scope="col">Materia</th>
                                        <th scope="col">Profesor</th>
                                        <th scope="col">Tarea</th>
                                        <th scope="col">Fecha límite</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    <?php

                                    $stmt = $conn->prepare("
                                        SELECT * FROM `tbl_task`
                                        LEFT JOIN `tbl_subject` ON
                                            `tbl_task`.`tbl_subject_id` = 
                                            `tbl_subject`.`tbl_subject_id`
                                    ");

                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {
                                        $taskID = $row['tbl_task_id'];
                                        $subjectID = $row['tbl_subject_id'];
                                        $subjectName = $row['subject_name'];
                                        $subjectTeacher = $row['subject_teacher'];
                                        $taskName = $row['task_name'];
                                        $taskDeadline = $row['task_deadline'];
                                        $taskStatus = $row['task_status'];

                                    ?>
                                        <tr>
                                            <td id="taskID-<?= $taskID ?>">
                                                <?php echo $taskID ?>
                                            </td>
                                            <td id="taskSubjectID-<?= $taskID ?>" hidden>
                                                <?php echo $subjectID ?>
                                            </td>
                                            <td id="taskSubjectName-<?= $taskID ?>">
                                                <?php echo $subjectName ?>
                                            </td>
                                            <td id="taskSubjectTeacher-<?= $taskID ?>">
                                                <?php echo $subjectTeacher ?>
                                            </td>
                                            <td id="taskName-<?= $taskID ?>">
                                                <?php echo $taskName ?>
                                            </td>
                                            <td id="taskDeadline-<?= $taskID ?>">
                                                <?php echo $taskDeadline ?>
                                            </td>
                                            <td id="taskStatus-<?= $taskID ?>">
                                                <?php echo $taskStatus ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" title="Update" onclick="update_task(<?php echo $taskID ?>)"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger" title="Delete" onclick="delete_task(<?php echo $taskID ?>)"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>

                                    <?php
                                    }

                                    ?>

                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="v-pills-pending" role="tabpanel" aria-labelledby="v-pills-pending-tab">

                            <!-- Tablas pendientes -->
                            <table class="table table-hover task-list mt-5">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ID Tarea</th>
                                        <th scope="col">Materia</th>
                                        <th scope="col">Profesor</th>
                                        <th scope="col">Task</th>
                                        <th scope="col">Fecha límite</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    <?php

                                    $stmt = $conn->prepare("
                                        SELECT * FROM `tbl_task`
                                        LEFT JOIN `tbl_subject` ON
                                            `tbl_task`.`tbl_subject_id` = 
                                            `tbl_subject`.`tbl_subject_id`
                                        WHERE
                                            `task_status` = 'Pendiente'
                                    ");

                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {
                                        $taskID = $row['tbl_task_id'];
                                        $subjectID = $row['tbl_subject_id'];
                                        $subjectName = $row['subject_name'];
                                        $subjectTeacher = $row['subject_teacher'];
                                        $taskName = $row['task_name'];
                                        $taskDeadline = $row['task_deadline'];
                                        $taskStatus = $row['task_status'];

                                    ?>
                                        <tr>
                                            <td id="taskID-<?= $taskID ?>">
                                                <?php echo $taskID ?>
                                            </td>
                                            <td id="taskSubjectID-<?= $taskID ?>" hidden>
                                                <?php echo $subjectID ?>
                                            </td>
                                            <td id="taskSubjectName-<?= $taskID ?>">
                                                <?php echo $subjectName ?>
                                            </td>
                                            <td id="taskSubjectTeacher-<?= $taskID ?>">
                                                <?php echo $subjectTeacher ?>
                                            </td>
                                            <td id="taskName-<?= $taskID ?>">
                                                <?php echo $taskName ?>
                                            </td>
                                            <td id="taskDeadline-<?= $taskID ?>">
                                                <?php echo $taskDeadline ?>
                                            </td>
                                            <td id="taskStatus-<?= $taskID ?>">
                                                <?php echo $taskStatus ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" title="Update" onclick="update_task(<?php echo $taskID ?>)"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger" title="Delete" onclick="delete_task(<?php echo $taskID ?>)"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>

                                    <?php
                                    }

                                    ?>

                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="v-pills-in-progress" role="tabpanel" aria-labelledby="v-pills-in-progress-tab">

                            <!-- Tareas en Progreso -->
                            <table class="table table-hover task-list mt-5">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ID Tarea</th>
                                        <th scope="col">Materia</th>
                                        <th scope="col">Profesor</th>
                                        <th scope="col">Tarea</th>
                                        <th scope="col">Fecha límite</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    <?php

                                    $stmt = $conn->prepare("
                                        SELECT * FROM `tbl_task`
                                        LEFT JOIN `tbl_subject` ON
                                            `tbl_task`.`tbl_subject_id` = 
                                            `tbl_subject`.`tbl_subject_id`
                                        WHERE
                                            `task_status` = 'En progreso'
                                    ");

                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {
                                        $taskID = $row['tbl_task_id'];
                                        $subjectID = $row['tbl_subject_id'];
                                        $subjectName = $row['subject_name'];
                                        $subjectTeacher = $row['subject_teacher'];
                                        $taskName = $row['task_name'];
                                        $taskDeadline = $row['task_deadline'];
                                        $taskStatus = $row['task_status'];

                                    ?>
                                        <tr>
                                            <td id="taskID-<?= $taskID ?>">
                                                <?php echo $taskID ?>
                                            </td>
                                            <td id="taskSubjectID-<?= $taskID ?>" hidden>
                                                <?php echo $subjectID ?>
                                            </td>
                                            <td id="taskSubjectName-<?= $taskID ?>">
                                                <?php echo $subjectName ?>
                                            </td>
                                            <td id="taskSubjectTeacher-<?= $taskID ?>">
                                                <?php echo $subjectTeacher ?>
                                            </td>
                                            <td id="taskName-<?= $taskID ?>">
                                                <?php echo $taskName ?>
                                            </td>
                                            <td id="taskDeadline-<?= $taskID ?>">
                                                <?php echo $taskDeadline ?>
                                            </td>
                                            <td id="taskStatus-<?= $taskID ?>">
                                                <?php echo $taskStatus ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" title="Update" onclick="update_task(<?php echo $taskID ?>)"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger" title="Delete" onclick="delete_task(<?php echo $taskID ?>)"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>

                                    <?php
                                    }

                                    ?>

                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="v-pills-completed" role="tabpanel" aria-labelledby="v-pills-completed-tab">

                            <!-- Completado Tasks Table -->
                            <table class="table table-hover task-list mt-5">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ID Tarea</th>
                                        <th scope="col">Materia</th>
                                        <th scope="col">Profesor</th>
                                        <th scope="col">Tarea</th>
                                        <th scope="col">Fecha límite</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    <?php

                                    $stmt = $conn->prepare("
                                        SELECT * FROM `tbl_task`
                                        LEFT JOIN `tbl_subject` ON
                                            `tbl_task`.`tbl_subject_id` = 
                                            `tbl_subject`.`tbl_subject_id`
                                        WHERE
                                            `task_status` = 'Completado'
                                    ");

                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {
                                        $taskID = $row['tbl_task_id'];
                                        $subjectID = $row['tbl_subject_id'];
                                        $subjectName = $row['subject_name'];
                                        $subjectTeacher = $row['subject_teacher'];
                                        $taskName = $row['task_name'];
                                        $taskDeadline = $row['task_deadline'];
                                        $taskStatus = $row['task_status'];

                                    ?>
                                        <tr>
                                            <td id="taskID-<?= $taskID ?>">
                                                <?php echo $taskID ?>
                                            </td>
                                            <td id="taskSubjectID-<?= $taskID ?>" hidden>
                                                <?php echo $subjectID ?>
                                            </td>
                                            <td id="taskSubjectName-<?= $taskID ?>">
                                                <?php echo $subjectName ?>
                                            </td>
                                            <td id="taskSubjectTeacher-<?= $taskID ?>">
                                                <?php echo $subjectTeacher ?>
                                            </td>
                                            <td id="taskName-<?= $taskID ?>">
                                                <?php echo $taskName ?>
                                            </td>
                                            <td id="taskDeadline-<?= $taskID ?>">
                                                <?php echo $taskDeadline ?>
                                            </td>
                                            <td id="taskStatus-<?= $taskID ?>">
                                                <?php echo $taskStatus ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" title="Update" onclick="update_task(<?php echo $taskID ?>)"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger" title="Delete" onclick="delete_task(<?php echo $taskID ?>)"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>

                                    <?php
                                    }

                                    ?>

                                </tbody>
                            </table>

                        </div>

                        <!-- Area de Materias -->
                        <div class="tab-pane fade" id="v-pills-subjects" role="tabpanel" aria-labelledby="v-pills-subjects-tab">

                            <!-- Botón agregar Materias -->
                            <button type="button" class="btn btn-dark mb-3" data-toggle="modal" data-target="#subjectModal" style="margin-left: 85%;">
                                Agregar Materia
                            </button>

                            <!-- Subject Table -->
                            <table class="table table-hover task-list">
                                <thead class="text-center">
                                    <tr>
                                        <th scope="col">ID Materia</th>
                                        <th scope="col">Nombre Materia</th>
                                        <th scope="col">Profesor</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">

                                    <?php

                                    $stmt = $conn->prepare("SELECT * FROM `tbl_subject`");
                                    $stmt->execute();

                                    $result = $stmt->fetchAll();

                                    foreach ($result as $row) {

                                        $subjectID = $row['tbl_subject_id'];
                                        $subjectName = $row['subject_name'];
                                        $subjectTeacher = $row['subject_teacher'];

                                    ?>

                                        <tr>
                                            <td id="subjectID-<?= $subjectID ?>">
                                                <?php echo $subjectID ?>
                                            </td>
                                            <td id="subjectName-<?= $subjectID ?>">
                                                <?php echo $subjectName ?>
                                            </td>
                                            <td id="subjectTeacher-<?= $subjectID ?>">
                                                <?php echo $subjectTeacher ?>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-secondary" title="Edit" onclick="update_subject(<?php echo $subjectID ?>)"><i class="fa-solid fa-pencil"></i></button>
                                                <button type="button" class="btn btn-danger" title="Delete" onclick="delete_subject(<?php echo $subjectID ?>)"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>

                                    <?php
                                    }

                                    ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <script>
            // Update subject function
            function update_subject(id) {
                $("#updateSubjectModal").modal("show");

                let updateSubjectID = $("#subjectID-" + id).text().trim();
                let updateSubjectName = $("#subjectName-" + id).text().trim();
                let updateSubjectTeacher = $("#subjectTeacher-" + id).text().trim();

                $("#updateSubjectID").val(updateSubjectID);
                $("#updateSubjectName").val(updateSubjectName);
                $("#updateSubjectTeacher").val(updateSubjectTeacher);
            }

            // Delete subject function
            function delete_subject(id) {

                if (confirm("Deseas eliminar esta materia?")) {
                    window.location = "./endpoint/delete-subject.php?subject=" + id;
                }

            }

            // Update task function
            function update_task(id) {
                $("#updateTaskModal").modal("show");

                let updateTaskID = $("#taskID-" + id).text().trim();
                let updateTaskSubject = $("#taskSubjectName-" + id).text().trim();
                let updateTaskName = $("#taskName-" + id).text().trim();
                let updateTaskStatus = $("#taskStatus-" + id).text().trim();
                let updateTaskDeadline = $("#taskDeadline-" + id).text().trim();

                $("#updateTaskID").val(updateTaskID);
                $("#updateTaskSubject option").each(function() {
                    let subject = $(this).text();
                    if (subject === updateTaskSubject) {
                        $(this).prop("selected", true)
                        return false;
                    }
                });
                $("#updateTaskName").val(updateTaskName);
                $("#updateTaskStatus").val(updateTaskStatus);
                $("#updateTaskDeadline").val(updateTaskDeadline);
            }

            // Delete subject function
            function delete_task(id) {

                if (confirm("Deseas eliminar esta tarea?")) {
                    window.location = "./endpoint/delete-task.php?task=" + id;
                }

            }
        </script>

        <!-- Bootstrap JS -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>


</body>

</html>