<?php
  
  // Iekļauj datubāzes savienojumu
      
  include_once('connect.php');

  // Izveido datubāzes savienojumu
  $con = new mysqli($host, $db_user, $db_password, $db_name);

  // Pārbauda, vai forma ir nosūtīta
  if (isset($_POST['submit'])) {
      
      $errorMsg = "";
      
      // Iegūst un apstrādā lietotāja ievadīto lietotājvārdu un paroli
      $empLogin = mysqli_real_escape_string($con, $_POST['username']);
      $empPassword = mysqli_real_escape_string($con, $_POST['password']);
      $empPassword = md5($empPassword);

      // Izveido SQL vaicājumu, lai pārbaudītu, vai lietotājvārds jau pastāv datubāzē
      $sql = "SELECT * FROM `user` WHERE `username` = '$empLogin'";
      // $sql = "SELECT * FROM users WHERE login = '$login'";
      $execute = mysqli_query($con,$sql);
        
      // Pārbauda paroles garumu un lietotājvārda un pastāvēšanu datubāzē
      if(empty($_POST["username"]) || empty($_POST["password"])) {
          $errorMsg  = "Jāaizpilda visi ievades lauki";
      }else if($execute->num_rows > 0){
          $errorMsg = "Šis lietotājvārds jau eksistē";
      }else if(strlen($_POST['password']) < 6){
        $errorMsg  = "Parolei jābūt vismaz sešu rakstzīmju garai";
      }else{
          // Izveido SQL vaicājumu, lai pievienotu jaunu lietotāju datubāzē
          $query= "INSERT INTO `user`(`id`, `username`, `password`) VALUES (NULL,'$empLogin','$empPassword')";
          $result = mysqli_query($con, $query);

          // Pārbauda, vai vaicājums ir izpildījies veiksmīgi
          if ($result == true) {
              header("Location:login.php");
          }else{
              $errorMsg  = "Jūs neesat reģistrējies..Lūdzu, mēģiniet vēlreiz";
          }
      }
  }

?>

<?php include 'header.php';?>

<div class="container loginContainer">
<div class="relative py-3 sm:max-w-xl sm:mx-auto">
    <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
      <div class="max-w-md mx-auto">
        <form method="post" action="">
        <div class="flex items-center space-x-5">
          <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">i</div>
          <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
            <h2 class="leading-relaxed">Register</h2>
            <p class="text-sm text-gray-500 font-normal leading-relaxed">Projekts būs redzams visiem pārējiem lietotājiem.</p>
          </div>
        </div>
        <div class="divide-y divide-gray-200">
          <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
            <div class="flex flex-col">
              <label for="username" class="leading-loose">Lietotājvārds:</label>
              <input id="username" name="username" type="username" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="">
            </div>
            <div class="flex flex-col">
              <label for="password" class="leading-loose">Parole:</label>
              <input id="password" name="password" type="password" class="px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-sm border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder="">
            </div>
          </div>
          <div class="pt-4 flex items-center space-x-4">
              <a href="login.php" class="bg-red-400 text-black flex justify-center items-center w-full px-4 py-3 rounded-md focus:outline-none">Pieteikties</a>
              <button type="submit" name="submit" class="bg-blue-500 text-black flex justify-center items-center w-full px-4 py-3 rounded-md focus:outline-none">Reģistrācija</button>
          </div>
          <?php
            if (isset($errorMsg)) {
                echo "<div class='alert alert-danger alert-dismissible'>
                        <button type='button' class='close' data-dismiss='alert'>&times;</button>
                        $errorMsg
                      </div>";
            }
        ?>
        </div>
      </div>
    </form>
  </div>
</div>
        </form>
        <?php
            if(isset($_SESSION['loginError'])){
                echo $_SESSION['loginError'];
            }
        ?>
    </div>
</div>
<?php include 'footer.php';?>