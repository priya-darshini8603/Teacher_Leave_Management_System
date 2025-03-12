<?php
    include '../includes/dbconn.php';
    
    $tid=$_SESSION['tid'];
    $sql = "SELECT FirstName,LastName,teacherid from  tblteachers where id=:tid";
    $query = $dbh -> prepare($sql);
    $query->bindParam(':tid',$tid,PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
    $cnt=1;

    if($query->rowCount() > 0){
        foreach($results as $result)
    {    ?>
        <p style="color:white;"><?php echo htmlentities($result->FirstName." ".$result->LastName);?></p>
        <span><?php echo htmlentities($result->teacherid)?></span>
<?php }
    } 
?>