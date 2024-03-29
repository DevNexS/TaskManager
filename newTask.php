<?php
    session_start();
    // Ja lietotājs nav pierakstījies, pāradresē uz ienākšanas lapu
    if(!(isset($_SESSION['logged-in']))){
        header('Location: login.php');
        exit();
    }
    $shortName = $_GET['sn'];
?>
<?php include 'header.php';?>
<div class="container loginContainer">
<div class="relative py-3 sm:max-w-xl sm:mx-auto">
    <div class="relative px-4 py-10 bg-white mx-8 md:mx-0 shadow rounded-3xl sm:p-10">
      <div class="max-w-md mx-auto">
        <form method="post" action="newTaskValidation.php?sn=<?php echo $shortName; ?>">
        <div class="flex items-center space-x-5">
          <div class="h-14 w-14 bg-yellow-200 rounded-full flex flex-shrink-0 justify-center items-center text-yellow-500 text-2xl font-mono">i</div>
          <div class="block pl-2 font-semibold text-xl self-start text-gray-700">
            <h2 class="leading-relaxed">Pievienot Jaunu Uzdevumu</h2>
            <p class="text-sm text-gray-500 font-normal leading-relaxed">Projekts būs redzams visiem pārējiem lietotājiem</p>
          </div>
        </div>
        <div class="divide-y divide-gray-200">
          <div class="py-8 text-base leading-6 space-y-4 text-gray-700 sm:text-lg sm:leading-7">
            <div class="flex flex-col">
              <label for="taskTitle" class="leading-loose">Nosaukums:</label>
              <textarea name="taskTitle" class="taskTitle px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-md border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder=""></textarea>
            </div>
            <div class="flex flex-col">
              <label for="taskDescription">Apraksts:</label>
              <textarea id="text" name="taskDescription" type="text" class="taskDesc px-4 py-2 border focus:ring-gray-500 focus:border-gray-900 w-full sm:text-md border-gray-300 rounded-md focus:outline-none text-gray-600" placeholder=""></textarea>
            </div>
          </div>
          <div class="pt-4 flex items-center space-x-4">
              <a href="board.php?sn=<?php echo $shortName; ?>" class="bg-red-400 text-black flex justify-center items-center w-full px-4 py-3 rounded-md focus:outline-none">Atpakaļ</a>
              <button type="submit" class="bg-blue-500 text-black flex justify-center items-center w-full px-4 py-3 rounded-md focus:outline-none">Pievienot</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
        </form>
        <?php
        // Izvada kļūdas paziņojumu, ja tāds ir
            if(isset($_SESSION['addProjectError'])){
                echo $_SESSION['addProjectError'];
                unset($_SESSION['addProjectError']);
            }
        ?>
    </div>
</div>

<?php include 'footer.php';?>