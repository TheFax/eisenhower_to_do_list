<?php
session_start();
require "header.php";
?>

<body>

    <div class="container">


        <div class="row">
            <div class="col-sm-12 col-md-9 m-auto">

                <h2 class="display-4 mx-auto mt-2 text-center">To-do</h2>

                <form class="mt-4" action="item_add.php" method="post">
                    <div class="form-group">
                        <div class="form-group row">
                            <label for="select_category" class="col-sm-2 col-form-label">Category</label>
                            <div class="col-sm-10">
                                <table>
                                    <tr>
                                        <td align="right">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio1">Urgent and
                                                    important </label>
                                                <input class="form-check-input" type="radio" name="category"
                                                    id="inlineRadio1" value="1-DO">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="category"
                                                    id="inlineRadio3" value="2-PLAN" checked>
                                                <label class="form-check-label" for="inlineRadio3">Important</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="right">
                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label" for="inlineRadio2">Urgent </label>
                                                <input class="form-check-input" type="radio" name="category"
                                                    id="inlineRadio2" value="3-DELEGATE">
                                                
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="category"
                                                    id="inlineRadio4" value="4-DEFAULT">
                                                <label class="form-check-label" for="inlineRadio4">Not important</label>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text_title" class="col-sm-2 col-form-label">Title</label>
                            <div class="col-sm-10">
                                <input id="text_title" class="form-control form-control-lg" type="text" name="title"
                                    autocomplete="off" maxlength="50" placeholder="Task title" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="text_description" class="col-sm-2 col-form-label">Description</label>
                            <div class="col-sm-10">
                                <input id="text_description" class="form-control " type="text" name="description"
                                    maxlength="200" autocomplete="off" placeholder="Task description">
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <input class="btn btn-success btn-block" type="submit" name="addtask" value="Add Task">
                    </div>
                </form>

            </div>
        </div>

        <!-- ################### show messages ################### -->
        <?php
        if (isset($_SESSION['message'])) {
            if ($_SESSION['status'] == 'warning') {
                echo '<div class="alert alert-warning text-dark  mx-auto mt-4" role="alert" style="width:66%;">';
            } else if ($_SESSION['status'] == 'danger') {
                echo '<div class="alert alert-danger text-dark  mx-auto mt-4" role="alert" style="width:66%;">';
            } else if ($_SESSION['status'] == 'success') {
                echo '<div class="alert alert-success text-dark  mx-auto mt-4" role="alert" style="width:66%;">';
            } else {
                echo '<div class="alert alert-info text-dark  mx-auto mt-4" role="alert" style="width:66%;">';
            }
            echo $_SESSION['message'];
            echo '</div>';
            unset($_SESSION['message']);
            unset($_SESSION['status']);
        }
        ?>

        <!-- =================================== table =========================== -->

        <table class="col-sm-12 table table-sm table-borderless table-striped text-center mx-auto mt-3 table-hover">
            <thead class="bg-dark text-white text-center">
                <tr>
                    <th style="width:10%;">ID</th>
                    <th class="text-left" style="width:60%;">Task</th>
                    <th style="width:20%;">Category</th>
                    <th style="width:20%;">Actions</th>
                </tr>
            </thead>

            <?php
            require_once "db_class.php";
            $my_db = new sql_class;
            $items_list = $my_db->readAll();

            if (count($items_list) != 0) {
                // E' presente almento un item
                foreach ($items_list as $row) {
                    ?>
                    <tr>
                        <td>
                            <?= $row['id'] ?>
                        </td>
                        <td class="text-left">
                            <?= $row['task_title'] ?>
                        </td>
                        <td>
                            <?= $row['task_category'] ?>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a class="btn btn-sm btn-success" href="item_done.php?id=<?php echo $row['id']; ?>"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                                    </svg></a>
                                <a class="btn btn-sm btn-warning" href="item_edit.php?id=<?php echo $row['id']; ?>"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z" />
                                    </svg></a>
                                <a class="btn btn-sm btn-danger" href="item_delete.php?id=<?php echo $row['id']; ?>"><svg
                                        xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                        class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z" />
                                    </svg></a>
                            </div>
                        </td>
                    </tr>
                    <?php
                }
            } else {
                // Nessun item è presente
                ?>
                <tr>
                    <td colspan="0" class="text-center">No task</td>
                </tr>
                <?php
            }
            ?>
        </table>

</body>

</html>