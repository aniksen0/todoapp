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
    $sql="SELECT do from do where addid=:addid";
    $data=$conn->prepare($sql);
    $data->execute(array(
       ':addid'=>$_SESSION['addid']
    ));
    $rows = $data->fetchAll(PDO::FETCH_ASSOC);

}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="main.css" rel="stylesheet">
</head>
<body>

<div id="myDIV" class="header">
  <h2 style="margin:5px">Welcome <?php echo $_SESSION['name'];
      echo $_SESSION['addid']; ?> </h2>
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
            echo $row['do'];
            echo "</li>";

        }
    }
    ?>

</ul>



</body>
</html>
