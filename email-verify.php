<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Verify Your Email</title>
        <link href="Css/email-verify.css" 
              rel="stylesheet" 
              type="text/css"/>
    </head>
    <body>
        <form method="POST">
            <div class="title">
                <b>Email Validation</b>
            </div>

            <div class="email-form">
                <div class="design">
                    <div class="field">
                        <label id="email-label">Enter your email: </label>
                        <input type="email" id="email-field" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$"> <br><br>
                        <button class="btn" type="submit" onclick="myFunction()">Submit</button>                        
                    </div>
                </div>
            </div>   
        </form>
        <script>
            function myFunction() {
                alert("Submit Successsfully!")
            }
        </script>
    </body>
</html>
