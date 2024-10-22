<?php
session_start();


if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {
    $task = trim($_POST['task_input']);
    if ($task !== '') {
        $_SESSION['tasks'][] = htmlspecialchars($task);
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_task'])) {
    $taskIndex = intval($_POST['task_index']);
    if (isset($_SESSION['tasks'][$taskIndex])) {
        array_splice($_SESSION['tasks'], $taskIndex, 1); // Remove task
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        form {
            display: flex;
            margin-bottom: 20px;
        }
        input[type="text"] {
            flex-grow: 1;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button[type="submit"] {
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background-color: #218838;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            background-color: #f8f9fa;
            padding: 10px;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        button.delete {
            background: none;
            color: #e3342f;
            border: none;
            cursor: pointer;
        }
        button.delete:hover {
            color: #c82333;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Task Manager</h2>
    
    <!-- Form to add new task -->
    <form method="POST">
        <input type="text" name="task_input" placeholder="Enter a new task" required>
        <button type="submit" name="add_task">Add Task</button>
    </form>

    <!-- Task list display -->
    <ul>
        <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
            <li>
                <?php echo $task; ?>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="task_index" value="<?php echo $index; ?>">
                    <button class="delete" type="submit" name="remove_task">Delete</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

</body>
</html>
