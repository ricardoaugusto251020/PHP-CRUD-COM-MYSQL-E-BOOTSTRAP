<?php
require_once 'connect.php';
require_once 'header.php';

if(isset($_POST['addnew'])) {
    $errors = [];

    //Validar entrada
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    if(empty($firstname) || empty($lastname) || empty($address) || empty($contact)){
        $errors[] = "Please fill out all required fields";
    }

    // Insira dados se não houver erros
    if(empty($errors)){
        $sql = "INSERT INTO users (firstname, lastname, address, contact) VALUES (?, ?, ?, ?)";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssss", $firstname, $lastname, $address, $contact);
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Successfully added new user</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        foreach($errors as $error){
            echo "<div class='alert alert-danger'>$error</div>";
        }
    }
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box">
                <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;Add New User</h3>
                <form action="" method="POST">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" name="firstname" class="form-control"><br>
                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" id="lastname" class="form-control"><br>
                    <label for="address">Address</label>
                    <textarea rows="4" name="address" class="form-control"></textarea><br>
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" class="form-control"><br>
                    <input type="submit" name="addnew" class="btn btn-success" value="Add New">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>
