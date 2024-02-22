<?php
  // Sākam sesiju
  session_start();

  // Ja lietotājs jau ir pierakstījies, pāradresē uz index.php
  if (isset($_SESSION['logged-in'])) {
      header("Location:index.php");
  }

  // Iekļaujam datubāzes savienojumu
  include_once('connect.php');
  
  // Ja ir nospiests iesniegšanas pogu
  if (isset($_POST['submit'])) {
    // Iegūstam lietotājvārdu un paroli no POST datiem
    $username = $_POST['username'];
    $password = md5($_POST['password']);
 
    // Veicam vaicājumu, lai atrastu lietotāju ar ievadīto lietotājvārdu un paroli
    $query = mysqli_query($con, "SELECT * FROM `user` WHERE `username` = '$username' && `password` = '$password'") or die(mysqli_error());
    
    // Iegūstam rezultātu rindu skaitu
    $rows = mysqli_num_rows($query);
    
    // Iegūstam datus par lietotāju
    $fetch = mysqli_fetch_array($query);
 
    // Ja ir atrasts lietotājs ar ievadīto lietotājvārdu un paroli
    if($rows > 0){
      // Iestatām sesijas mainīgos
      $_SESSION['logged-in'] = true;
      $_SESSION['username'] = $fetch['username'];
      
      // Pāradresējam uz index.php
      header("location: index.php");
    }else{
      // Ja lietotājs nav atrasts, izvadam kļūdas ziņojumu
      echo "<center><label class='text-danger'>Nederīgs lietotājvārds vai parole!</label></center>";
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
            <h2 class="leading-relaxed">Login</h2>
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
              <a href="register.php" class="bg-red-400 text-black flex justify-center items-center w-full px-4 py-3 rounded-md focus:outline-none">Reģistrācija</a>
              <button type="submit" name="submit" class="bg-blue-500 text-black flex justify-center items-center w-full px-4 py-3 rounded-md focus:outline-none">Pieteikties</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
        </form>
    </div>
</div>
<?php include 'footer.php';?>