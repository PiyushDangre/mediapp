<?php require 'header.php' ;?>

<?php
// Initialize the session
session_start();
require_once "Classes/PHPExcel.php";

        $tmpfname = "data/data.xlsx";
		$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
		$excelObj = $excelReader->load($tmpfname);
		$worksheet = $excelObj->getSheet(0);
       // $lastRow = $worksheet->getHighestRow();
        $dump = $worksheet-> toArray(null);
        
        /*
        * This function traverses the php array to find the key value pair.
        */
        function get_key_by_string($needle, $haystack) {
            $keys = array();
            foreach ($haystack as $key => $value) {
                // Create fullname to match
                $fullname = strtolower(trim(trim($value[1]).trim($value[2]))); 
                $needle = strtolower(str_replace(' ', '', $needle));

                if (strpos($fullname, $needle) !== false) { 
                   // echo "Match Found-"." ".$needle." ".$fullname ;
                    array_push($keys, $key);
                }        
                }
                return $keys;
            }

            function get_key_by_MRN($needle, $haystack) {
                $keys = array();
                foreach ($haystack as $key => $value) {
                    // Create fullname to match
                    $mrn = trim($value['0']); 
                    $needle = strtolower(str_replace(' ', '', $needle));
    
                    if (strpos($mrn, $needle) !== false) { 
                       // echo "Match Found-"." ".$needle." ".$fullname ;
                        array_push($keys, $key);
                    }        
                    }
                    return $keys;
                }

        /*
        *This function traverses PHP array to find the corresponding row of a key
        */
        function get_person_from_key_array($keys, $dump){
            $persons = array();
            foreach($keys as $key=> $value){
                $person = array();
                $person['Key'] = $key;
                $person['MRN'] = $dump[$value][0];
                $person['FirstName'] = $dump[$value][1];
                $person['LastName'] = $dump[$value][2];
                $person['Date'] = $dump[$value][3];
                $person['Age'] = $dump[$value][4];
                $person['Sex'] = $dump[$value][5];
                $person['Weight'] = $dump[$value][6];
                $person['Sport'] = $dump[$value][7];
                array_push($persons, $person);
            }
            return $persons;
        }

        //Test
    //    $test = get_key_by_MRN('1021       ', $dump);
       
    //     echo var_dump($test);
        
        // Initializing variables
        $searchbyname = '' ;
        $searchbymrn = '';
        $personsByName = array();
        $personsByMRN = array();

        // Global persons array
        $persons = array();

        // Display search results for search by name
        if(isset($_POST['searchbyname']) && !empty($_POST['searchbyname'])){
            $searchbyname = $_POST['searchbyname'] ; 
            $persons = get_person_from_key_array(get_key_by_string( $searchbyname, $dump), $dump) ;
 //          echo var_dump($personsByName) ;
        }

        // Display search results for search by MRN
        if(isset($_POST['searchbymrn']) && !empty($_POST['searchbymrn'])){
            $searchbymrn = $_POST['searchbymrn'] ; 
            $persons = get_person_from_key_array(get_key_by_MRN( $searchbymrn, $dump), $dump) ;
         // echo var_dump($personsByMRN) ;
        }

        // echo var_dump(get_key_by_string("Natasha", $dump)) ;
        // echo var_dump(get_person_from_key_array(get_key_by_string("nick", $dump), $dump)) ;
        // echo "</pre>";
        //echo var_dump($persons);
?>
<div class="container">
    <div class="row">
        <div class="col-md-7">
                        <div class="panel panel-default">
                                <div class="panel-heading"><b><span class="glyphicon glyphicon-search"></span>&nbsp;Search Patient</b></div>
                                <div class="panel-body">
                                           
                                            <p>Search patient below by Name or MRN.</p>
                                            <ul class="nav nav-tabs" style="margin-top:20px;">
                                                <li class="active"><a data-toggle="tab" href="#home"><span class="glyphicon glyphicon-search" style="margin-right:5px;"></span>Name</a></li>
                                                <li><a data-toggle="tab" href="#menu1"><span class="glyphicon glyphicon-search" style="margin-right:5px;"></span>MRN</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="home" class="tab-pane fade in active">
                                                    <form action="dashboard.php" method="post">
                                                    <div style="margin-top:20px;">
                                                        <input id="searchbyname" type="text" class="form-control" name="searchbyname" placeholder="Search" ></div>
                                                        <button type="submit" class="btn btn-primary btn-block" style="margin-top:7px;"> <span><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;Search</span></button>
                                                    </form>
                                                </div>
                                                <div id="menu1" class="tab-pane fade">
                                                    <form action="dashboard.php" method="post">
                                                    <div style="margin-top:20px;">
                                                        <input id="searchbymrn" type="number" class="form-control" name="searchbymrn" placeholder="Search" ></div>
                                                        <button type="submit" class="btn btn-success btn-block" style="margin-top:7px;"> <span><i class="glyphicon glyphicon-search"></i>&nbsp;&nbsp;Search</span></button>
                                                    </form>
                                                    </div>        
                                            </div>
                                      
                                        </div>
                                
                                </div>  <!-- Search patient div ends-->
                    
                            <div class="panel panel-default">
                                <div class="panel-heading"><b><span class="glyphicon glyphicon-list"></span>&nbsp;Search Results</b></div>
                                <!-- Search Results panel body starts -->
                                <div class="panel-body">
                                <!-- Table starts -->
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>MRN</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Date</th>
                                            <th>Age</th>
                                            <th>Sex</th>
                                            <th>Weight</th>
                                            <th>Sport</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
                                        // Table data iteration starts here
                                        // Iterating global $persons array
                                        if (isset($persons) && !empty($persons)){
                                            foreach($persons as $key => $value){
                                                echo "
                                                <tr>
                                                <td>".$value['MRN']."</td>
                                                <td>".$value['FirstName']."</td>
                                                <td>".$value['LastName']."</td>
                                                <td>".$value['Date']."</td>
                                                <td>".$value['Age']."</td>
                                                <td>".$value['Sex']."</td>
                                                <td>".$value['Weight']."</td>
                                                <td>".$value['Sport']."</td>
                                                </tr>
                                                ";
                                            }
                                        }else{
                                            echo "
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>No Results</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            " ; 
                                        }
                                        ?>
                                        </tbody>
                                    </table><!--Table ends-->
                                </div><!-- Search Results panel body Ends -->
                            </div> <!--Search Result panel Ends-->
        </div>  <!--Col-md-7 ends-->
            
        <!-- Image display panel col-md-7 starts-->
        <div class="col-md-5">     
            <div class="panel panel-default">
                <div class="panel-heading"><b><span class="glyphicon glyphicon-picture"></span>&nbsp;Image Display</b></div>
                <!-- Image display Panel Body Starts -->
                <div class="panel-body">
                    <img src="images/image005.jpg" style="margin-left:10%;">
                </div>
                <!-- Image display Panel Body Ends -->
            </div>
                
             <!-- Concussion1 panel starts-->
                <div class="panel panel-default">
                    <div class="panel-heading"><b>Concussion 1</b></div>
                    <!-- Concussion1  Panel Body Starts -->
                    <div class="panel-body">
                    Concussion 1 Text
                    </div>
                    <!-- Concussion1 Panel Body Ends -->
                </div>
                 <!-- Concussion1 panel ends-->

                <!-- Concussion2 panel starts-->
                <div class="panel panel-default">
                <div class="panel-heading"><b>Concussion 2</b></div>
                <!-- Concussion2  Panel Body Starts -->
                <div class="panel-body">
                Concussion 2 Text
                </div>  <!-- Concussion2 Panel Body Ends -->
            </div> <!-- Concussion2 panel ends--> 
        </div> <!-- col-md-5 ends -->
    </div> <!-- ROW 1 ENDS -->
</div><!--Container ends-->
<?php require 'footer.php' ; ?>
