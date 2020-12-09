<?php
require "conn.php";
session_start();

if (isset($_POST['do']))
{
    if (empty($_POST['do']))
    {
        $_SESSION['error']="You didn't add anything";
        header("Location:MainPage.php");
        return;
    }
    else
    {
        $sql2="INSERT INTO do VALUES (:listid, :do, :addid)";
        $data=$conn->prepare($sql2);
        $data->execute(array(
            ':listid'=> null,
           ':do'=>htmlentities($_POST['do']),
            ':addid'=>$_SESSION['addid']
        ));

        $_SESSION['success']="Added";
        header("Location:MainPage.php");
        return;
    }
}
if (!isset($_SESSION['name']))
{
    header("Location:index.php");
    return;
}
else
{
    $sql="SELECT * from do where addid=:addid";
    $data=$conn->prepare($sql);
    $data->execute(array(
       ':addid'=>$_SESSION['addid']
    ));
    $rows = $data->fetchAll(PDO::FETCH_ASSOC);


}
if (isset($_POST['del']))
{
    $sql3="DELETE FROM do where listid=:id ";
    $data=$conn->prepare($sql3);
    $data->execute(array(
       ':id'=>$_POST['del']
    ));
    $_SESSION['success']="Deleted";
    header("Location:MainPage.php");
    return;

}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <link href="main.css" rel="stylesheet">
</head>
<body>

<div id="myDIV" class="header">
  <h2 style="margin:5px">Welcome  <?php echo $_SESSION['name'];?> </h2>
    <?php
      if(isset($_SESSION['success']))
      {
          echo "<p style='color:chartreuse'>".$_SESSION['success']. "</p>";
          unset($_SESSION['success']);
      }
      else if(isset($_SESSION['error']))
      {
          echo "<p style='color:white'>".$_SESSION['error']. "</p>";
          unset($_SESSION['error']);
      }

      ?>
    <form method="post">
  <input type="text" name="do" id="myInput" placeholder="Title...">
  <button type="submit" class="btn addBtn ">Add</button>
    </form>
</div>
<h4>Notes</h4>
<div class="lines"></div>
<ul class="list">
    <?php
    if (empty($rows))
    {
        echo"No list found";
    }
    else
    {

        foreach($rows as $row)
        {
            echo "<li>";
//            echo "<form method='post'>";
//            echo '<button class="btn btn-new btn-warning" name="delete" value="' . $row['listtid'] . '" type="submit"> Delete</button>';
//            echo "</form>";

            echo '<form method="post">';
            echo '<button class="btn-warning btn" name="del" value="'. $row['listid'] . '">Delete </button>';
            echo'</form>';
            //echo $row['listid'];
            echo $row['do'];
            echo "</li>";

        }
    }
    ?>

</ul>
<a href="Logout.php">
<button type="button" class="btn addBtn btn-danger">Log-Out</button>
</a>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>


</body>
</html>
