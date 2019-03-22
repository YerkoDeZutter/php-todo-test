<?php

include('config\db_connect.php');

$_sql = 'SELECT title, id, done FROM todo ORDER BY id';

$_result = mysqli_query($_conn, $_sql);

$_todos = mysqli_fetch_all($_result, MYSQLI_ASSOC);


if(isset($_POST['submit'])){

  foreach ($_todos as $_todo) {
    if(isset($_POST['done'.$_todo['id']])){
      $_todoId = $_todo['id'];

      echo 'done'.$_todoId.' edited <br />';

      $_sql = "UPDATE todo SET done='checked' WHERE id=".$_todo['id'];

      $_result = mysqli_query($_conn, $_sql);

    } else {
      $_sql = "UPDATE todo SET done='' WHERE id=".$_todo['id'];

      $_result = mysqli_query($_conn, $_sql);
    }
  }

  header('Location: index.php');

}

foreach ($_todos as $_todo) {

  if(isset($_POST['delete'.$_todo['id']])){
    $_id_to_delete = mysqli_real_escape_string($_conn, $_POST['id_to_delete'.$_todo['id']]);

    $_sql = "DELETE FROM todo WHERE id = $_id_to_delete";

    echo $_sql;

    if(mysqli_query($_conn, $_sql)){
      header('Location: index.php');
    } else {
      echo "ERROR!!! ERROR!!!";
    }
  }

}



if(isset($_POST['add'])){

  $_new_todo = $_POST['addToDo'];

  $_sql = "INSERT INTO todo(title) VALUES('$_new_todo')";

  if(mysqli_query($_conn, $_sql)){
    header('Location: index.php');
  } else {
    echo "ERROR!!! ERROR!!!";
  }
}


  // mysqli_free_result($_result);

  mysqli_close($_conn);

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css">
    <title>ToDo</title>
  </head>
  <body>

    <form class="" action="" method="post">

    <ul>
      <?php foreach ($_todos as $_todo): ?>

        <li>
          <input type="checkbox" name="<?php echo "done".$_todo['id']; ?>" <?php echo $_todo['done'] ?> value="Car">
          <?php echo $_todo['title']; ?>
          <input type="hidden" name="<?php echo 'id_to_delete'.$_todo['id']; ?>" value="<?php echo $_todo['id']; ?>">
  				<input type="submit" name="<?php echo 'delete'.$_todo['id']; ?>" value="X" class="">
        </li>

      <?php endforeach; ?>
    </ul>

    <input type="submit" name="submit" value="Submit">

  </form>

  <br>
  <br>
  <br>
  <br>

  <form class="" action="" method="post">

    <label for="">Add a todo to the todo list: </label>
    <input type="text" name="addToDo" value="">

    <input type="submit" name="add" value="Add">

  </form>

  </body>
</html>
