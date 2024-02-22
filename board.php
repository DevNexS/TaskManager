<?php
    // Sāk jaunu sesiju vai atjauno esošo sesiju
    session_start();
    
    // Pārbauda, vai lietotājs ir pierakstījies sistēmā
    if(!(isset($_SESSION['logged-in']))){
        // Ja nav pierakstījies, pāradresē uz ieejas lapu
        header('Location: login.php');
        exit();
    }

    // Pārbauda, vai ir saņemts nepieciešamais GET parametrs
    if(!(isset($_GET['sn']))){
        // Ja nav saņemts parametrs, pāradresē uz galveno lapu
        header('Location: index.php');
        exit();
    }

    // Iekļauj datubāzes savienojumu
    require_once "connect.php";

    // Izveido jaunu datubāzes savienojumu
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    // Pārbauda, vai nav bijis savienojuma kļūdas
    if($connection->connect_errno!=0){
        echo "Kļūda: ".$connection->connect_errno . "<br>";
        echo "Apraksts: " . $connection->connect_error;
        exit();
    }

    // Iegūst nepieciešamo GET parametru
    $shortName = $_GET['sn'];
?>

<?php include 'header.php';?>

<?php
    // Izveido SQL vaicājumu, lai iegūtu informāciju par projektu
    $sql = "SELECT * FROM `projects` WHERE `Short name` = '$shortName'";
    
    // Izpilda SQL vaicājumu un pārbauda rezultātu
    if($result = $connection->query($sql)){
        $rowsCount = $result->num_rows;
        if($rowsCount > 0){
            // Iegūst rezultātu asociatīvajā masīvā
            $row = $result->fetch_assoc();
            $result->free_result();
        }
        else{
            // Ja nav rezultātu, izvada kļūdas paziņojumu
            echo '<span class="error-msg">SQL kļūda</span>';
        } 
    }
?>

<div class=''>
<div class="container projectListContainer">
<h1>Uzdevumu saraksts</h1>
    <div class="lg-12 ">
    <h2>Aktuālais projekts: <strong><?php echo $row['Full name']; ?></strong></h2><br>
    <div class="whoami">
        <?php echo 'Esi ielogojies kā <strong>' . $_SESSION['username'] . '</strong> <a href="logout.php">[Iziet]</a>'; ?>
    </div><br>
        <a class="back" href="index.php">&lt;--- Atpakaļ uz projektu sarakstu</a>
    <div class="lg-12 createBoard">
        <a href="newTask.php?sn=<?php echo $shortName ?>" class="btn bg-gray-800 rounded-sm font-medium text-white uppercase focus:outline-none hover:bg-gray-700 hover:shadow-none shadow-lg" >Izveidot uzdevumu</a>
    </div>
    </div>
    
    
    <div class="task-list">

    <div class="flex flex-wrap -mx-3 mb-5">
  <div class="w-full max-w-full px-3 mb-6  mx-auto">
    <div class="relative flex-[1_auto] flex  break-words min-w-0 bg-clip-border rounded-[.95rem] bg-white m-5 shadow-xl">
        <div class="lg-3 backlog font-semibold text-[0.95rem] text-secondary-dark">
            <h3>Gaildīšana</h3>
            <div>
                
                <?php
    
                    $sql1 = "SELECT * FROM tasks WHERE project_short_name = '$shortName' AND state = '1'";
                    $sql2 = "SELECT * FROM tasks WHERE project_short_name = '$shortName' AND state = '2'";
                    $sql3 = "SELECT * FROM tasks WHERE project_short_name = '$shortName' AND state = '3'";
                    $sql4 = "SELECT * FROM tasks WHERE project_short_name = '$shortName' AND state = '4'";
           
                    if($result = $connection->query($sql1)){
                        $projectsCount = $result->num_rows;
                        if($projectsCount>0){

                            while ($row = mysqli_fetch_array($result)) {
                                $tn = $row['project_task_num'];
                                echo "
                                <div class='task mb-6'>
                                <a href='#'>
                                <div class='bg-white text-black w-full max-w-md flex flex-col rounded-2xl shadow-xl p-4'>
                                <div class='flex items-center justify-between'>
                                  <div class='flex items-center space-x-4'>
                                    <div class='rounded-full w-16 text-center  bg-info-light text-info'>". $row['project_short_name'] . "-". $row['project_task_num'] ."</div>
                                    <div class='text-md font-bold ml-2'>" . ($row['task_name']) . "</div>
                                  </div>
                                  <div class='flex items-center space-x-4'>
                                    <div class'text-gray-500 hover:text-gray-300 cursor-pointer'>
                                      <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9' />
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                                <div class='mt-4 text-gray-500 font-bold text-sm truncate' id='descr' onclick='favourite(this)'>
                                  " . ($row['task_desc']) . "
                                </div>
                                </a>
                                <select class='mt-4 changeStatus' onchange='location = this.value'>
                                <option class='no-display' selected='selected'>Gaida</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=1'>Gaida</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=2'>Procesā</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=3'>Pārbaudās</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=4'>Izpildīts</option>
                                </select>
                              </div>
                              <script>
                              let i=0;
                              function favourite(elmnt){
                                  i++;//increment
                                  if (i == 1) {
                                      elmnt.classList.replace('truncate', 'truncate-none'); //pievieno klasi
                                  }
                                  if (i == 2) {
                                      elmnt.classList.replace('truncate-none', 'truncate'); //izņem klasi
                                      i = 0;
                                  }
                              }
</script>
</div>
                                ";
                            }
                            $result->free_result();
                        }
                    }      
                ?>
            </div>
            
        </div>
        <div class="lg-3 inprogress font-semibold text-[0.95rem] text-secondary-dark">
            <h3>Procesā</h3>
            <div>
                <?php
                    if($result = $connection->query($sql2)){
                        $projectsCount = $result->num_rows;
                        if($projectsCount>0){

                            while ($row = mysqli_fetch_array($result)) {
                                $tn = $row['project_task_num'];
                                echo "
                                <div class='task mb-6'>
                                <a href='#'>
                                <div class='bg-white text-black w-full max-w-md flex flex-col rounded-xl shadow-lg p-4'>
                                <div class='flex items-center justify-between'>
                                  <div class='flex items-center space-x-4'>
                                    <div class='rounded-full  w-16 text-center text-danger bg-danger-light'>". $row['project_short_name'] . "-". $row['project_task_num'] ."</div>
                                    <div class='text-md font-bold ml-2'>" . ($row['task_name']) . "</div>
                                  </div>
                                  <div class='flex items-center space-x-4'>
                                    <div class'text-gray-500 hover:text-gray-300 cursor-pointer'>
                                      <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9' />
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                                <div class='mt-4 text-gray-500 font-bold text-sm truncate' onclick='favourite(this)'>
                                  " . ($row['task_desc']) . "
                                </div>
                                </a>
                                <select class='mt-4 changeStatus' onchange='location = this.value'>
                                <option class='no-display' selected='selected'>Procesā</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=2'>Procesā</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=1'>Gaida</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=3'>Pārbaudās</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=4'>Izpildīts</option>
                                </select>
                              </div>
                              <script>
                              let i=0;
                              function favourite(elmnt){
                                  i++;//increment
                                  if (i == 1) {
                                      elmnt.classList.replace('truncate', 'truncate-none'); //add fill in class
                                  }
                                  if (i == 2) {
                                      elmnt.classList.replace('truncate-none', 'truncate'); //remove fill in class
                                      i = 0;//resets
                                  }
                              }
                            </script>
                              </div>
                                ";
                            }
                            $result->free_result();
                        }
                    }
                ?>
            </div>
        </div>
        <div class="lg-3 test font-semibold text-[0.95rem] text-secondary-dark">
            <h3>Testēšana</h3>
            <div>
                <?php
                    if($result = $connection->query($sql3)){
                        $projectsCount = $result->num_rows;
                        if($projectsCount>0){

                            while ($row = mysqli_fetch_array($result)) {
                                $tn = $row['project_task_num'];
                                echo "
                                <div class='task mb-6'>
                                <a href='#'>
                                <div class='bg-white text-black w-full max-w-md flex flex-col rounded-xl shadow-lg p-4'>
                                <div class='flex items-center justify-between'>
                                  <div class='flex items-center space-x-4'>
                                    <div class='rounded-full  w-16 text-center text-warning bg-warning-light'>". $row['project_short_name'] . "-". $row['project_task_num'] ."</div>
                                    <div class='text-md font-bold ml-2'>" . ($row['task_name']) . "</div>
                                  </div>
                                  <div class='flex items-center space-x-4'>
                                    <div class'text-gray-500 hover:text-gray-300 cursor-pointer'>
                                      <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9' />
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                                <div class='mt-4 text-gray-500 font-bold text-sm truncate' onclick='favourite(this)'>
                                  " . ($row['task_desc']) . "
                                </div>
                                </a>
                                <select class='mt-4 changeStatus' onchange='location = this.value'>
                                <option class='no-display' selected='selected'>Pārbaudās</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=3'>Pārbaudās</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=1'>Gaida</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=2'>Procesā</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=4'>Izpildīts</option>
                                </select>
                              </div>
                              <script>
                              let i=0;
                              function favourite(elmnt){
                                  i++;//increment
                                  if (i == 1) {
                                      elmnt.classList.replace('truncate', 'truncate-none'); //add fill in class
                                  }
                                  if (i == 2) {
                                      elmnt.classList.replace('truncate-none', 'truncate'); //remove fill in class
                                      i = 0;//resets
                                  }
                              }
                            </script>
                              </div>
                                ";
                            }
                            $result->free_result();
                        }
                    }
                ?>
            </div>
        </div>
        <div class="lg-3 done font-semibold text-[0.95rem] text-secondary-dark">
            <h3>Izpildits</h3>
            <div>
                <?php
                    if($result = $connection->query($sql4)){
                        $projectsCount = $result->num_rows;
                        if($projectsCount>0){

                            while ($row = mysqli_fetch_array($result)) {
                                $tn = $row['project_task_num'];
                                echo "
                                <div class='task mb-6'>
                                <a href='#'>
                                <div class='bg-white text-black w-full max-w-md flex flex-col rounded-xl shadow-lg p-4'>
                                <div class='flex items-center justify-between'>
                                  <div class='flex items-center space-x-4'>
                                    <div class='rounded-full  w-16 text-center text-success bg-success-light'>". $row['project_short_name'] . "-". $row['project_task_num'] ."</div>
                                    <div class='text-md font-bold ml-2'>" . ($row['task_name']) . "</div>
                                  </div>
                                  <div class='flex items-center space-x-4'>
                                    <div class'text-gray-500 hover:text-gray-300 cursor-pointer'>
                                      <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9' />
                                      </svg>
                                    </div>
                                  </div>
                                </div>
                                <div class='mt-4 text-gray-500 font-bold text-sm truncate' onclick='favourite(this)'>
                                  " . ($row['task_desc']) . "
                                </div>
                                </a>
                                <select class='mt-4 changeStatus' onchange='location = this.value'>
                                <option class='no-display' selected='selected'>Izpildīts</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=4'>Izpildīts</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=1'>Gaida</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=2'>Procesā</option>
                                <option value='changeStatus.php?sn=$shortName&tn=$tn&status=3'>Pārbaudās</option>
                                </select>
                              </div>
                              <script>
                              let i=0;
                              function favourite(elmnt){
                                  i++;//increment
                                  if (i == 1) {
                                      elmnt.classList.replace('truncate', 'truncate-none'); //add fill in class
                                  }
                                  if (i == 2) {
                                      elmnt.classList.replace('truncate-none', 'truncate'); //remove fill in class
                                      i = 0;//resets
                                  }
                              }
                            </script>
                              </div>
                                ";
                            }
                            $result->free_result();
                        }
                    }
                ?>
            </div>
        </div>
    </div>
  </div>
</div>

<?php $connection->close(); ?>
<?php include 'footer.php';?>
