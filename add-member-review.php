<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Review Page</title>
        <link href="Css/review.css" rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    </head>
    <body>
        <?php
        include 'Header2.php';
        require_once './config/database.php';
        ?>
        <div class="HLdesign1">
            <h1>Feedback</h1>
            <h2>Please choose the <b>EVENT</b> you would like to rate</h2></div>
        <?php
        //check if the button clicked? or user input any data?
        global $id;
        global $name;
        global $event;
        global $categories;
        global $star;
        if (!empty($_POST)) {
            
            //YES, user clicked the insert button
            //retrieve ALL user input
            (isset($_POST["txtID"])) ?
                            $id = trim($_POST["txtID"]) :
                            $id = "";
            (isset($_POST["txtName"])) ?
                            $name = trim($_POST["txtName"]) :
                            $name = "";
            (isset($_POST["ddlEvent"])) ?
                            $event = trim($_POST["ddlEvent"]) :
                            $event = "";
            (isset($_POST["ddlCategories"])) ?
                            $categories = trim($_POST["ddlCategories"]) :
                            $categories = "";
            (isset($_POST["rbStar"])) ?
                            $star = trim($_POST["rbStar"]) :
                            $star = "";

            //check error/ validation
            $error["id"] = checkStudentID($id);
            $error["name"] = checkName($name);
            $error["event"] = checkEvent($event);
            $error["categories"] = checkCategories($categories);
            $error["star"] = checkStar($star);
            $error = array_filter($error);
            //check if there are any message in $error[]
            if (empty($error)) {
                //NO ERROR, INSERT RECORD
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "INSERT INTO review (StudentID,Name,Event,Categories,StarRate)
                      VALUES (?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssssi", $id, $name, $event, $categories, $star);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    //INSERT Successful
                    printf("<div class='info'>
                               Review %s has been inserted.
                               <a href='memberreview.php'>
                               Back to list</a></div>", $name);
                } else {
                    echo'<div class="error">Unable to insert!
                   [<a href="memberreview.php">Back to list</a>]</div>';
                }
            } else {
                //WITH ERROR, DISPLAY ERROR MSG
                echo"<ul class='error'>";
                foreach ($error as $value) {
                    echo"<li>$value</li>";
                }
                echo"</ul>";
            }
        }
        ?>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Student ID: </td>
                    <td><input type="text" 
                               name="txtID" 
                               value="<?php echo $id; ?>" /></td>
                </tr>
                <tr>
                    <td>Student Name: </td>
                    <td><input type="text" 
                               name="txtName" 
                               value="<?php echo $name; ?>" /></td>
                </tr>
                <tr>
                    <td>Event: </td>    
                    <td><select name="ddlEvent">
<?php
$allEvent = getAllEvent($event);
foreach ($allEvent as $key => $value) {
    printf("<option value='%s' %s>
                                        %s</option>", $key,
            ($event == $key) ? 'selected' : "",
            $value);
}
?>
                        </select>
                    </td>  
                </tr>
                <tr>
                    <td>Categories: </td>
                    <td><select name="ddlCategories">

<?php
$allCategories = getAllCategories($categories);
foreach ($allCategories as $key => $value) {
    printf("<option value='%s' %s>
                                        %s</option>", $key,
            ($categories == $key) ? 'selected' : "",
            $value);
}
?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Star-rated: </td>
                    <td>
<?php
$allStarRate = getAllStarRate($star);
foreach ($allStarRate as $key => $value) {
    printf("<input type='radio'
                               name='rbStar'
                               value='%s' %s />%s", $key,
            ($star == $key) ? 'checked' : "",
            $value);
}
?>
                    </td>
                </tr>
            </table>
        

        
        <div class="viewfeedback">
            <button type="button" onclick="window.location.href = 'memberreview.php'; return false;">View Feedback</button>
            <button type="submit" onclick="submit()">Submit</button>
        </div>
</form>
        

    </body>
    <footer>
<?php include 'Footer.php'; ?>
    </footer>
</html>