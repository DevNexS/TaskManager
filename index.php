<?php
    // Sākam sesiju
    session_start();

    // Pārbaudām, vai lietotājs nav pierakstījies
    if(!(isset($_SESSION['logged-in']))){
        // Ja nav pierakstījies, pāradresējam uz ienākšanas lapu un izbeidzam izpildi
        header('Location: login.php');
        exit();
    }
    
    // Pieprasam datubāzes savienojumu
    require_once "connect.php";

    // Izveidojam jaunu mysqli savienojumu, izmantojot datus no connect.php
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    // Pārbaudām, vai savienojums nav radis kļūdu
    if($connection->connect_errno!=0){
        // Ja radusies kļūda, izvadam kļūdas informāciju un pārtraucam izpildi
        echo "Kļūda: ".$connection->connect_errno . "<br>";
        echo "Apraksts: " . $connection->connect_error;
        exit();
    }
?>

<?php include 'header.php';?>

<div class="container projectListContainer">
    <h1>Saraksts ar projektiem</h1>
    <!-- Izvada informāciju par ienākšanu un iespēju iziet no sistēmas -->
    <div class="lg-6 whoami">
        <?php echo 'Esi ielogojies kā <strong>' . $_SESSION['username'] .'</strong> <a href="logout.php">[Iziet]</a>'; ?>
    </div>
    <?php
                         
                            echo'
     <div class="lg-6 createBoard">
       <a href="newProject.php" class="btn inline-block text-[.925rem] font-medium text-dark text-center cursor-pointer rounded-2xl transition-colors duration-150 ease-in-out text-light-inverse bg-light-dark border-light  shadow-none border-0 py-2 px-5 hover:bg-secondary active:bg-light focus:bg-light"> Pievienot projektu </a>
      </div>
    <div class="flex flex-wrap -mx-3 mb-5">
  <div class="w-full max-w-full px-3 mb-6  mx-auto">
    <div class="relative flex-[1_auto] flex flex-col break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5">
      <div class="relative flex flex-col min-w-0 break-words border border-dashed bg-clip-border rounded-2xl border-stone-200 bg-light/30">
        <!-- card header -->
        <div class="px-9 pt-5 flex justify-between items-stretch flex-wrap min-h-[70px] pb-0 bg-transparent">
          <h3 class="flex flex-col items-start justify-center m-2 ml-0 font-medium text-xl/tight text-dark">
            <span class="mr-3 font-semibold text-dark">PROJEKTU SARAKSTS</span>
            <span class="mt-1 font-medium text-secondary-dark text-lg/normal">Izvēlieties nepieciešamo projektu</span>
          </h3>
        </div>
        <!-- end card header -->
        <!-- card body  -->
        <div class="flex-auto block py-8 pt-6 px-9">
          <div class="overflow-x-auto">
            <table class="w-full my-0 align-middle text-dark border-neutral-200">
              <thead class="align-bottom">
                <tr class="font-semibold text-[0.95rem] text-secondary-dark">
                  <th class="pb-3 text-start min-w-[175px]">Nosaukums</th>
                  <th class="pb-3 text-end min-w-[100px]">Saīsinātais nosaukums</th>
                  <th class="pb-3 pr-12 text-end min-w-[100px]">Uzdevumu skaits</th>
                  <th class="pb-3 text-end min-w-[50px]">Pāriet</th>
                </tr>
              </thead>
              <tbody>

                <tbody>';
                        
                      
                      
                  
                ?>
<?php
    // Izveidojam SQL vaicājumu, lai iegūtu visus projektus
    $sql = "SELECT * FROM projects";

    // Pārbaudam, vai vaicājums atgriež rezultātu
    if($result = $connection->query($sql)){
        // Iegūstam projektu skaitu
        $projectsCount = $result->num_rows;

        // Pārbaudam, vai ir vismaz viens projekts
        if($projectsCount > 0){
            // Iterējam cauri katram projektam
            while ($row = mysqli_fetch_array($result)) {
                // Iegūstam projekta saīsināto nosaukumu
                $sn = $row['Short name'];

                // Izveidojam SQL vaicājumu, lai iegūtu uzdevumu skaitu šajā projektā, kuri nav stāvoklī "4"
                $sumSQL = "SELECT count(*) as tasksLeft FROM `tasks` WHERE project_short_name = '$sn' AND state != 4";
                $sumResult = $connection->query($sumSQL);
                $row2 = $sumResult->fetch_assoc();

                // Izvadam projektu informāciju HTML tabulā
                echo "
                <tr class='border-b border-dashed last:border-b-0'>
                    <td class='mb-1 font-semibold transition-colors duration-200 ease-in-out text-lg/normal text-secondary-inverse hover:text-primary'>".($row['Full name'])."</span></td>
                    <td class='p-3 pr-0 text-end'>
                        <span class='font-semibold text-light-inverse text-md/normal'>".($row['Short name'])."</span>
                    </td>
                    <td class='p-6 pr-12 text-end'>
                        <span class='text-center align-baseline inline-flex px-2 py-1 mr-auto items-center font-semibold text-base/none text-success bg-success-light rounded-lg'>
                            ".$row2['tasksLeft']."
                        </td>
                    <td class='p-3 pr-0 text-end'>
                        <a href='board.php?sn=".$row['Short name']."'>
                            <button class='ml-auto relative text-secondary-dark bg-light-dark hover:text-primary flex items-center h-[25px] w-[25px] text-base font-medium leading-normal text-center align-middle cursor-pointer rounded-2xl transition-colors duration-200 ease-in-out shadow-none border-0 justify-center'>
                                <span class='flex items-center justify-center p-0 m-0 leading-none shrink-0 '>
                                    <svg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke-width='1.5' stroke='currentColor' class='w-4 h-4'>
                                        <path stroke-linecap='round' stroke-linejoin='round' d='M8.25 4.5l7.5 7.5-7.5 7.5' />
                                    </svg>
                                </span>
                            </button>
                        </a>
                    </td>
                </tr>";
            }
            // Atbrīvojam rezultātu resursus
            $result->free_result();
        }
        else{
            // Ja nav projektu, izvadam ziņojumu
            echo "Nav projektu";
        }
    }
?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php $connection->close(); ?>
<?php include 'footer.php';?>
