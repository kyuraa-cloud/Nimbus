<?php
session_start();
require "../../config/db.php";

$title = "My Task";
$active = "task";

$userId = $_SESSION['user_id'];

$q = mysqli_query($conn, "SELECT * FROM tasks WHERE user_id = $userId ORDER BY due_date ASC");
$tasks = [];
while ($row = mysqli_fetch_assoc($q)) {
    $tasks[] = $row;
}

ob_start();
?>

<h2 style="color:#2F2843; font-weight:700;">My Task</h2>
<p style="color:#6c5a8d;">Manage and track your tasks</p>

<div class="row mt-4">

    <!-- TASK LIST -->
    <div class="col-lg-8">

        <?php if (count($tasks) > 0): ?>
            <?php foreach ($tasks as $task): ?>

                <div class="task-card">

                    <div class="task-left d-flex flex-column">

                        <?php
                            // START DATE SAFE LOGIC
                            $startDate = (
                                empty($task['start_date']) ||
                                $task['start_date'] == '0000-00-00'
                            )
                            ? "No Start Date"
                            : date("M d, Y", strtotime($task['start_date']));
                        ?>

                        <span><?= $startDate ?></span>
                        <span><?= htmlspecialchars($task['name']) ?></span>
                    </div>


                    <div class="d-flex align-items-center gap-2">

                        <!-- PRIORITY BADGE -->
                        <div class="badge-item
                            <?= $task['priority'] == 'high' ? 'tag-high' : ($task['priority'] == 'medium' ? 'tag-medium' : 'tag-low') ?>">
                            <?= strtoupper($task['priority']) ?>
                        </div>

                        <!-- STATUS BADGE -->
                        <div class="badge-item tag-status">
                            <?= strtoupper($task['status']) ?>
                        </div>

                        <!-- EDIT BUTTON -->
                        <button class="badge-item btn-edit"
                                data-bs-toggle="modal"
                                data-bs-target="#editModal<?= $task['id'] ?>">
                            Edit
                        </button>

                        <!-- DELETE BUTTON -->
                        <button class="badge-item btn-delete"
                                data-bs-toggle="modal"
                                data-bs-target="#delete<?= $task['id'] ?>">
                            Delete
                        </button>

                    </div>
                </div>

                <!-- EDIT MODAL -->
                <div class="modal fade" id="editModal<?= $task['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="update_task.php?id=<?= $task['id'] ?>" method="POST">

                            <div class="modal-content p-3">
                                <h5 class="fw-bold">Edit Task</h5>

                                <label>Start Date</label>
                                <input type="date" name="start_date" 
                                    value="<?= $task['start_date'] ?>" 
                                    class="form-control mb-2">

                                <label>Due Date</label>
                                <input type="date" name="due_date" 
                                    value="<?= $task['due_date'] ?>" 
                                    class="form-control mb-2">

                                <label>Task Name</label>
                                <input type="text" name="name" value="<?= $task['name'] ?>" class="form-control mb-2" required>

                                <label>Priority</label>
                                <select name="priority" class="form-select mb-2">
                                    <option value="high"   <?= $task['priority']=='high'?'selected':'' ?>>High</option>
                                    <option value="medium" <?= $task['priority']=='medium'?'selected':'' ?>>Medium</option>
                                    <option value="low"    <?= $task['priority']=='low'?'selected':'' ?>>Low</option>
                                </select>

                                <label>Status</label>
                                <select name="status" class="form-select mb-3">
                                    <option value="to do"        <?= $task['status']=='to do'?'selected':'' ?>>To Do</option>
                                    <option value="in progress"  <?= $task['status']=='in progress'?'selected':'' ?>>In Progress</option>
                                    <option value="done"         <?= $task['status']=='done'?'selected':'' ?>>Done</option>
                                </select>

                                <button class="add-btn">Update Task</button>
                            </div>

                        </form>
                    </div>
                </div>

                <!-- DELETE MODAL -->
                <div class="modal fade" id="delete<?= $task['id'] ?>" tabindex="-1">
                    <div class="modal-dialog">
                        <form action="delete_task.php?id=<?= $task['id'] ?>" method="POST">
                            <div class="modal-content p-3">

                                <h5 class="fw-bold">Delete Task</h5>
                                <p>This action cannot be undone. Delete this task?</p>

                                <div class="d-flex justify-content-end gap-2 mt-3">

                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        Cancel
                                    </button>

                                    <button class="btn btn-danger">Delete</button>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="task-card">
                <span class="text-muted">No tasks found.</span>
            </div>

        <?php endif; ?>

    </div>

    <!-- ADD TASK FORM -->
    <div class="col-lg-4">

        <div class="add-task-card">
            <h5 class="fw-bold mb-3" style="color:#3F2E5C;">Add Task</h5>

            <form action="store_task.php" method="POST">

                <label>Start Date</label>
                <input type="date" name="start_date" class="form-control mb-3" required>

                <label>Due Date</label>
                <input type="date" name="due_date" class="form-control mb-3" required>

                <label>Task Name</label>
                <input type="text" name="name" class="form-control mb-3" required>

                <label>Priority</label>
                <select name="priority" class="form-select mb-3">
                    <option value="high">High</option>
                    <option value="medium">Medium</option>
                    <option value="low">Low</option>
                </select>

                <label>Status</label>
                <select name="status" class="form-select mb-4">
                    <option value="to do">To Do</option>
                    <option value="in progress">In Progress</option>
                    <option value="done">Done</option>
                </select>

                <button class="add-btn">+ Add Task</button>

            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include "../layouts/user_layout.php";
