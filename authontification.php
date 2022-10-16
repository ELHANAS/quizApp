
<?php 
$mssg = "";
$style = "";
if(isset($_GET["message"])){
    $mssg =$_GET["message"];
   $style = "bg-danger";
}
if(isset($_GET["style"])){
    $style = $_GET["style"];
}

require "header.html" ?>

    <div class="container  my-5 mx-auto rounded p-5 " id="loginContainer"  >
        <form action="router/loginConroleur.php" method="post">
            <?php echo "<h4 class=' h4 py-3 $style text-white text-center'> $mssg </h4>" ; ?>
            <label for="email"class="form-label" >Email : </label>
            <input type="text" class="form-control" placeholder="xxxxxxx" name="email" id="email">@gmail.com<br><br>
            <label for="password" class="form-label">Mot de passe : </label>
            <input type="password" class="form-control" placeholder="*******" name="password" id="password"><br><br>
            <input type="radio" name="type" class="form-check-input" id="formateur" value="formateur">
            <label for="formateur" class="form-label">Foramteur </label><br>
            <input type="radio" name="type" class="form-check-input" id="stagiaire" value="stagiaire">
            <label for="stagiaire" class="form-label">Stagiaire </label><br>
            <button class="btn  btn-primary w-100 " type="submit">LOGIN</button>
        </form>
    </div>

<?php require "footer.html" ?>