<?php
require_once 'connect.php';
require_once 'header.php';

// Verifica se o formulário foi enviado
if(isset($_POST['update'])){
    // Verifica se todos os campos obrigatórios foram preenchidos
    if(empty($_POST['firstname']) || empty($_POST['lastname']) || empty($_POST['address']) || empty($_POST['contact'])){
        echo "Please fill out all required fields";
    } else {
        // Obtém os valores dos campos do formulário
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $address = $_POST['address'];
        $contact = $_POST['contact'];

       // Prepara a consulta SQL para atualizar os dados do usuário

        $sql = "UPDATE users SET firstname=?, lastname=?, address=?, contact=? WHERE user_id=?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("ssssi", $firstname, $lastname, $address, $contact, $_POST['userid']);

       // Executa a consulta e verifica se foi bem-sucedida
        if($stmt->execute()){
            echo "<div class='alert alert-success'>Successfully updated user</div>";
        } else {
            echo "<div class='alert alert-danger'>Error: There was an error while updating user info</div>";
        }
        $stmt->close();
    }
}
// Obtém o ID do usuário da URL ou define como 0 se não estiver definido

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Prepara a consulta SQL para selecionar os dados do usuário
$sql = "SELECT * FROM users WHERE user_id=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows < 1){
    header('Location: index.php');
    exit;
}

$row = $result->fetch_assoc();
$stmt->close();
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="box">
                <h3><i class="glyphicon glyphicon-plus"></i>&nbsp;MODIFY User</h3>

                <form action="" method="POST">
                    <input type="hidden" value="<?php echo $row['user_id']; ?>" name="userid">
                    <label for="firstname">Firstname</label>
                    <input type="text" id="firstname" name="firstname" value="<?php echo $row['firstname']; ?>" class="form-control"><br>
                    <label for="lastname">Lastname</label>
                    <input type="text" name="lastname" id="lastname" value="<?php echo $row['lastname']; ?>" class="form-control"><br>
                    <label for="address">Address</label>
                    <textarea rows="4" name="address" class="form-control"><?php echo $row['address']; ?></textarea><br>
                    <label for="contact">Contact</label>
                    <input type="text" name="contact" id="contact" value="<?php echo $row['contact']; ?>" class="form-control"><br>
                    <br>

                    <input type="submit" name="update" class="btn btn-success" value="Update">
                </form>
            </div>
        </div>
    </div>
</div>

<?php
require_once 'footer.php';
?>
