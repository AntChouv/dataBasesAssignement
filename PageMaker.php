<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PageMaker
 *
 * @author Antonis
 */
class PageMaker {

    public function displayHeadMatter() {
        ?>
        <!DOCTYPE html>
        <html lang="el">
            <head>
                <title>Καρλόβασι Bike Sharing</title>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
                <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
                <script src="myJavaScripts.js.js"></script>
            </head>
            <body>
                <div>
                <?php
            }

            public function displayMenu($dockingStationList) {
                ?>
                <nav class="navbar navbar-expand-md bg-dark navbar-dark">
                    <a class="navbar-brand" href="index.php">Καρλόβασι BikeSharing</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="collapsibleNavbar">
                        <ul class="navbar-nav">                            


                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=rentalStart">Ενοικίαση </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=rentalFinish">Επιστροφή</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="index.php?action=payment">Πληρωμή</a>
                            </li>
                            <?php
                            if ($_SESSION['userKind'] == 'superUser') {
                                //echo $_SESSION['userKind'].'sssssssssssssss';
                                ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                        Αναφορές
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="index.php?action=customersBalance">Υπόλοιπα πελατών</a>
                                        <a class="dropdown-item" href="index.php?action=rentals">Ενοικιάσεις</a>
                                        <a class="dropdown-item" href="index.php?action=payments">Εισπράξεις</a>
                                        <!-- <a class="dropdown-item" href="index.php?action=newParkingSpot">Νέα Θέση Στάθμευσης</a>
                                        <a class="dropdown-item" href="index.php?action=parkingSpotToDockingStation">Θέση Στάθμευσης σε DS</a>
                                        <a class="dropdown-item" href="index.php?action=newDockingStation">Νέο Docking Station </a>
                                        <a class="dropdown-item" href="index.php?action=bicycleToParkingSpot">Ποδήλατο σε θέση στάθμευσης </a> -->

                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
                                        Διαχείριση
                                    </a>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="index.php?action=customer">Νέος Χρήστης</a>
                                        <a class="dropdown-item" href="index.php?action=setUserNamePassWord">Πληροφορίες σύνδεσης</a>
                                        <a class="dropdown-item" href="index.php?action=telephone">Τηλέφωνο</a>
                                        <a class="dropdown-item" href="index.php?action=newBicycle">Νέο Ποδήλατο</a>
                                        <a class="dropdown-item" href="index.php?action=newParkingSpot">Νέα Θέση Στάθμευσης</a>
                                        <a class="dropdown-item" href="index.php?action=parkingSpotToDockingStation">Θέση Στάθμευσης σε DS</a>
                                        <a class="dropdown-item" href="index.php?action=newDockingStation">Νέο Docking Station </a>
                                        <a class="dropdown-item" href="index.php?action=bicycleToParkingSpot">Ποδήλατο σε θέση στάθμευσης </a>

                                    </div>
                                </li>
                                <?php
                            }
                            ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="index.php?action=parkingSpotToDockingStation" id="navbardrop" data-toggle="dropdown">
                                    Διαθεσιμότητα ποδηλάτων
                                </a>
                                <div class="dropdown-menu">
                                    <?php
                                    while ($row = $dockingStationList->fetch_assoc()) {

                                        echo '<a class="dropdown-item" href="index.php?action=parkingSpots&dockingStationId=' . $row['dockingStationId'] . '">' . $row['location'] . '</a>';
                                    }
                                    ?>                                    
                                </div>
                            </li>

                        </ul>
                    </div>  
                </nav>
                <?php
            }

            public function displayCustomersBalance($customerBalancesResource) {

                //if (is_resource($customerBalancesResource)) {
                ?>
                <h3>Υπόλοιπα Πελατών</h3>
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Επώνυμο</th>
                                <th>Όνομα</th> 
                                <th>Υπόλοιπο</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <?php
                            $i = 1;
                            $sum = 0;
                            while ($row = $customerBalancesResource->fetch_assoc()) {

                                echo '<tr>';
                                echo'<td>' . $i . '</td>';
                                echo'<td>' . $row['name'] . '</td>';
                                echo '<td>' . $row['lastName'] . '</td>';
                                echo '<td>' . $row['customerBalance'] . '</td>';
                                echo '</tr>';
                                $sum += $row['customerBalance'];
                                $i++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>Σύνολο</td>
                                <td><?php echo $sum; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                // }
            }

            public function displayRentals($rentalsResource) {

                //if (is_resource($customerBalancesResource)) {
                ?>
                <h3>Ενοικιάσεις</h3>
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>   
                                <th>Ημερομηνία</th>
                                <th>Επώνυμο</th>
                                <th>Όνομα</th>
                                <th>Διάρκεια</th>

                            </tr>
                        </thead>
                        <tbody>                            
                            <?php
                            $i = 1;
                            $sum = 0;
                            while ($row = $rentalsResource->fetch_assoc()) {

                                echo '<tr>';
                                echo'<td>' . $i . '</td>';
                                echo'<td>' . $row['date'] . '</td>';
                                echo'<td>' . $row['lastName'] . '</td>';
                                echo '<td>' . $row['name'] . '</td>';
                                echo '<td>' . $row['dif'] . '</td>';
                                echo '</tr>';
                                //$sum += $row['customerBalance'];
                                $i++;
                            }
                            ?>                                
                        </tbody>
                    </table>
                </div>
                <?php
                // }
            }

            public function displayCustomersPayments($customerPaymentsResource) {

                //if (is_resource($customerBalancesResource)) {
                ?>
                <h3>Εισπράξεις</h3>
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Ημερομηνία</th>
                                <th>Επώνυμο</th>
                                <th>Όνομα</th> 
                                <th>Ποσό</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <?php
                            $i = 1;
                            $sum = 0;
                            while ($row = $customerPaymentsResource->fetch_assoc()) {

                                echo '<tr>';
                                echo'<td>' . $i . '</td>';
                                echo'<td>' . $row['date'] . '</td>';
                                echo'<td>' . $row['lastName'] . '</td>';
                                echo '<td>' . $row['name'] . '</td>';
                                echo '<td>' . $row['ammount'] . '</td>';
                                echo '</tr>';
                                $sum += $row['ammount'];
                                $i++;
                            }
                            ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Σύνολο</td>
                                <td><?php echo $sum; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <?php
                // }
            }

            public function showDockingStationParkingSpotsAvailability($parkingSpotResource) {
                //if (isset($_POST['getcustomerPayments'])) {
                ?>
                <div class="table-responsive-sm">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th></th>                                
                                <th>Θέση Στάθμευσης</th> 
                                <th>Κατάσταση</th>
                            </tr>
                        </thead>
                        <tbody>                            
                            <?php
                            $i = 1;

                            while ($row = $parkingSpotResource->fetch_assoc()) {
                                echo '<tr>';
                                echo'<td>' . $i . '</td>';
                                echo '<td>' . $row['parkingSpotName'] . '</td>';
                                if (is_null($row['bicycleId'])) {
                                    echo '<td class="bg-success text-white">Ελεύθερο</td>';
                                } else {
                                    echo '<td class="bg-primary text-white">Ποδήλατο</td>';
                                }
                                echo '</tr>';
                                $i++;
                            }
                            ?>                                
                        </tbody>
                    </table>
                </div>
                <?php
                //}
            }

            public function displayFrontPage() {
                ?>
                <div class="container">
                    <h5>Εφαρμογή ενοικίασης κοινοχρήστων ποδηλάτων Κοινότητας Καρλοβασίων</h5>
                    <p></p>
                    <img class="img-fluid" src="images/bikesharing.png" alt="bike sharing" width="" height=""> 
                </div>
                <div class="container">
                    <iframe class="responsive-iframe" src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d7257.146714034538!2d26.697132785099228!3d37.79375856753002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1sen!2sgr!4v1611661752228!5m2!1sen!2sgr" width= "100%" height="100%"  frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
                </div>
                <?php
            }

            public function displayEndMatter() {
                ?>
                </div>
            </body>
        </html>
        <?php
    }

}
