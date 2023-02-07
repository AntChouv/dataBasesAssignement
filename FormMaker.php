<?php

class FormMaker {

    public function newCustomerForm() {
        ?>
        <div class="container">  
            <h2>Εισαγωγή Πελάτη</h2>
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> "  method="post">  <!<!-- htmlspecialchars ειναι για προστασία ωστε να μη εισάγει καποιος κώδικα στο url($_SERVER[PHP_SELF]) καλεί την ίδια σελίδα --> 
                <div class="form-group">         
                    <label for="name">Όνομα:</label>             
                    <input type="text" class="form-control" id="name" placeholder="Δώστε όνομα" name="name" required>             
                </div>         
                <div class="form-group">         
                    <label for="lastName">Επώνυμο:</label>             
                    <input type="text" class="form-control" id="lastName" placeholder="Δώστε Επώνυμο" name="lastName" required>  
                </div>  
                <div class="form-group">  
                    <label for="address">Διεύθυνση:</label>             
                    <input type="text" class="form-control" id="address" placeholder="Δώστε Διεύθυνση" name="address" required="">  
                </div>                  
                <div class="form-group">         
                    <label for=" school">Κατηγορία πελάτη:</label>             
                    <select class="form-control" id=" school" name="customerKind" required> 
                        <option value=""></option>
                        <option value="Δημότης">Δημότης</option>                 
                        <option value="Φοιτητής">Φοιτητής</option>
                        <option value="Επισκέπτης">Επισκέπτης</option>
                    </select>             
                </div>                         
                <button type="submit" class="btn btn-primary">Υποβολή</button>         
            </form>  
        </div>  
        <?php
    }

    public function setUserNamePassWordForm() {
        ?>
        <div class="container">  
            <h2>Στοιχεία σύνδεσης</h2>
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> "  method="post">  <!<!-- htmlspecialchars ειναι για προστασία ωστε να μη εισάγει καποιος κώδικα στο url($_SERVER[PHP_SELF]) καλεί την ίδια σελίδα --> 
                <div class="form-group">
                    <?php $this->selectCustomerAndKeepSelectedAfterSubmit(); ?>                    
                </div>  
                <div class="form-group">         
                    <label for="username">Όνομα χρήστη:</label>             
                    <input type="text" class="form-control" id="username" placeholder="Δώστε όνομα χρήστη" name="username" required>             
                </div>         
                <div class="form-group">         
                    <label for="password">Κωδικός χρήστη:</label>             
                    <input type="password" class="form-control" id="password" placeholder="Δώστε κωδικό χρήστη" name="password" required>  
                </div>                                  
                <div class="form-group">         
                    <label for="userKind">Κατηγορία χρήστη:</label>             
                    <select class="form-control" id="userKind" name="userKind" required> 
                        <option value=""></option>
                        <option value="superUser">Διαχειριστής</option>                 
                        <option value="customer">Πελάτης</option>
                    </select>             
                </div>
                <script type="text/javascript">
                    document.getElementById('userKind').value = "<?php echo $_POST['userKind']; ?>";
                </script>
                <button type="submit" class="btn btn-primary" name="setUserNamePassWord">Υποβολή</button>         
            </form>  
        </div>  
        <?php
    }

    public function newBicycleForm() {
        ?>
        <h1>Νέο Ποδήλατο</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post"> 
                <div class="form-group">
                    <label for="ammount">Όνομα Ποδηλάτου:</label>             
                    <input type="text" class="form-control" id="ammount" placeholder="Δώστε όνομα ποδηλάτου" name="bicycleName" required>  
                </div>                                     
                <button type="submit" class="btn btn-primary" name="newBicycle">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }

    public function newParkingSpotForm() {
        ?>
        <h1>Νέο Parking Spot</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post"> 
                <div class="form-group">
                    <?php // $this->selectDockingStation();  ?>
                    <label for="ammount">Όνομα Parking spot:</label>             
                    <input type="text" class="form-control" id="parkingSpot" placeholder="Δώστε όνομα Parking Spot" name="parkingSpotName" required>  
                </div>                                     
                <button type="submit" class="btn btn-primary" name="newParkingSpot">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }

    public function newRentalForm() {
        ?>
        <h1>Έναρξη ενοικίασης</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post"> 
                <div class="form-group">
                    <?php
                    $this->selectCustomerNotInActiveRental();
                    $this->selectParkingSpotWithBicycle();
                    ?>                    
                </div>                                     
                <button type="submit" class="btn btn-primary" name="rentalStart">Υποβολή</button>         
            </form>                
        </div> 
        <?php
    }

    public function newReturnForm() {
        ?>
        <h1>Λήξη ενοικίασης</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post"> 
                <div class="form-group">
                    <?php
                    $this->selectCustomerWithActiveRental();
                    $this->selectFreeAssignedParkingSpot();
                    ?>                    
                </div>                                     
                <button type="submit" class="btn btn-primary" name="rentalFinish">Υποβολή</button>         
            </form>                
        </div> 
        <?php
    }

    public function newDockingStationForm() {
        ?>
        <h1>Νέο Docking Station</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post"> 
                <div class="form-group">
                    <label for="ammount">Όνομα Docking Station:</label>             
                    <input type="text" class="form-control" id="dockingStation" placeholder="Δώστε όνομα Docking Station" name="location" required>  
                </div>                                     
                <button type="submit" class="btn btn-primary" name="newDockingStation">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }
    
    public function newPaymentForm($ammount) {        
        ?>
        <h1>Πληρωμή</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post"> 
                <div class="form-group">
                    <?php $this->selectCustomerWhowOwesAndKeepSelectedAfterSubmit(); ?>
                    <label for="ammount">Ποσό:</label>             
                    <input type="number" class="form-control" id="newPayment" placeholder="<?php echo $ammount ?>" name="ammount" required step="0.01">  
                </div>                                     
                <button type="submit" class="btn btn-primary" name="newPayment">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }

    public function addTelephoneForm() {
        ?>
        <h1>Εισαγωγή τηλεφώνου</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post">  
                <?php $this->selectCustomer(); ?>
                <div class="form-group">         
                    <label for="telephone">Τηλέφωνο:</label>             
                    <input type="tel" class="form-control" id="telephone" placeholder="Δώστε τηλέφωνο" name="telephone">             
                </div>                                         
                <button type="submit" class="btn btn-primary">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }

    public function addParkingSpotToDockingStationForm() {
        ?>
        <h1>Εισαγωγή θέσης στάθμευσης σε Docking Station</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post" >  
                <?php $this->selectDockingStation(); ?>
                <?php $this->selectNotAssignedParkingSpot(); ?>                                                    
                <button type="submit" class="btn btn-primary" name="parkingSpotToDockingStation">Υποβολή</button>         
            </form>                
        </div>  
        <?php
        //$this->addFormValidation();
    }

    public function addBicycleToParkingSpotForm() {
        ?>
        <h1>Εισαγωγή ποδηλάτου σε θέση στάθμευσης</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post" >  
                <?php $this->selectFreeBicycle(); ?>
                <?php $this->selectFreeAssignedParkingSpot(); ?>                                                    
                <button type="submit" class="btn btn-primary" name="bicycleToParkingSpot">Υποβολή</button>         
            </form>                
        </div>
        <?php
    }

    public function selectDate() {
        ?>
        <div class="form-group">  
            <label for="date">Ημερομηνία:</label>             
            <input type="date" class="form-control" id="date" placeholder="Ημερομηνία" name="date" required>  
        </div> 
        <?php
    }
    
     public function selectDateNotRequired() {
        ?>
        <div class="form-group">  
            <label for="date">Ημερομηνία:</label>             
            <input type="date" class="form-control" id="date" placeholder="Ημερομηνία" name="date">  
        </div> 
        <?php
    }

    public function selectCustomer() {
        $customerList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="customer">Πελάτης:</label>  
            <select class="form-control" id="customerId" name="customerId" required>             
                <?php
                $result = $customerList->getCustomers();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['customerId'] . '">' . $row['name'] . ' ' . $row['lastName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }
    
    public function selectCustomerWithSelectAllOption() {
        $customerList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="customer">Πελάτης:</label>  
            <select class="form-control" id="customerId" name="customerId" required>             
                <?php
                $result = $customerList->getCustomers();
                echo '<option value=""></option>';
                echo '<option value="6974004099">Όλοι</option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['customerId'] . '">' . $row['name'] . ' ' . $row['lastName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }

    public function selectCustomerAndKeepSelectedAfterSubmit() {
        $customerList = new DbHandler();
        $customerName = $_POST['name'];
        ?>
        <div class="form-group">         
            <label for="customer">Πελάτης:</label>  
            <select class="form-control" id="customerId" name="customerId" required>             
                <?php
                $result = $customerList->getCustomers();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['customerId'] . '" >' . $row['name'] .$row['lastName'] .'</option>';
                }
                ?>                
            </select> 
            <script type="text/javascript">
                document.getElementById('customerId').value = "<?php echo $_POST['customerId']; ?>";
            </script>            
        </div>
        <?php
    }
    
    public function selectCustomerWhowOwesAndKeepSelectedAfterSubmit() {
        $customerList = new DbHandler();
        $customerName = $_POST['name'];
        ?>
        <div class="form-group">         
            <label for="customer">Πελάτης:</label>  
            <select class="form-control" id="customerId" name="customerId" required>             
                <?php
                $result = $customerList->getCustomersWhoOwe();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['customerId'] . '" >' . $row['name'] .$row['lastName'] . '</option>';
                }
                ?>                
            </select> 
            <script type="text/javascript">
                document.getElementById('customerId').value = "<?php echo $_POST['customerId']; ?>";
            </script>            
        </div>
        <?php
    }

    public function selectCustomerWithActiveRental() {
        $customerList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="customer">Πελάτης:</label>  
            <select class="form-control" id="customerId" name="customerId" required>             
                <?php
                $result = $customerList->getCustomersWithActiveRental();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['customerId'] . '">' . $row['name'] . ' ' . $row['lastName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }
    
    public function selectCustomerNotInActiveRental() {
        $customerList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="customer">Πελάτης:</label>  
            <select class="form-control" id="customerId" name="customerId" required>             
                <?php
                $result = $customerList->getCustomersNotInActiveRental();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['customerId'] . '">' . $row['name'] . ' ' . $row['lastName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }

    public function selectFreeBicycle() {
        $bicycleList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="bicycle">Ποδήλατο:</label>  
            <select class="form-control" id="customerId" name="bicycleId" required>             
                <?php
                $result = $bicycleList->getFreeBicycles();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['bicycleId'] . '">' . $row['bicycleName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }

    public function selectParkingSpotWithBicycle() {
        $parkingSpotList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="parkingSpot">Parking Spot:</label>  
            <select class="form-control" id="customerId" name="parkingSpotId" required>             
                <?php
                $result = $parkingSpotList->getParkingSpotsWithBicycles();
                echo '<option value=""></option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['parkingSpotId'] . '">' . $row['parkingSpotName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }

    public function selectNotAssignedParkingSpot() {
        $parkingSpotList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="parkingSpot">Parking Spot:</label>  
            <select class="form-control" id="customerId" name="parkingSpotId" required>             
                <?php
                $result = $parkingSpotList->getNotAssignedParkingSpots();
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['parkingSpotId'] . '">' . $row['parkingSpotName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }

    public function selectFreeAssignedParkingSpot() {
        $parkingSpotList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="parkingSpot">Parking Spot:</label>  
            <select class="form-control" id="customerId" name="parkingSpotId" required>             
                <?php
                $result = $parkingSpotList->getFreeAssignedParkingSpots();
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['parkingSpotId'] . '">' . $row['parkingSpotName'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }

    public function selectDockingStation() {
        $dockingStationList = new DbHandler();
        ?>
        <div class="form-group">         
            <label for="customer">Docking Station:</label>  
            <select class="form-control" id="dockingStationId" name="dockingStationId" required>             
                <?php
                $result = $dockingStationList->getDockingStations();
                echo '<option value=""></option>';
                echo '<option value="6974004099">Όλα</option>';
                while ($row = $result->fetch_assoc()) {
                    echo'<option value="' . $row['dockingStationId'] . '">' . $row['location'] . '</option>';
                }
                ?>
            </select>             
        </div>
        <?php
    }
    
    public function getCustomersBalancesForm() {        
        ?>
        <h1>Αναζήτηση πληρωμών</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post">  
                <?php $this->selectCustomerWhowOwesAndKeepSelectedAfterSubmit(); ?>
                <?php $this->selectDate(); ?>                                              
                <button type="submit" class="btn btn-primary" name="getStudentBalances">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }
    
    public function getRentalsForm() {
        ?>
        <h1>Αναζήτηση Ενοικιάσεων</h1>
        <div class="container">  
            <form action="<?php htmlspecialchars($_SERVER[PHP_SELF]) ?> " method="post">  
                <?php $this->selectCustomerWithSelectAllOption(); ?>
                <?php $this->selectDateNotRequired(); ?>                                              
                <button type="submit" class="btn btn-primary" name="getCustomerRentals">Υποβολή</button>         
            </form>                
        </div>  
        <?php
    }

    public function loginForm() {
        ?>    
        <div class="container">
            <form action="authenticate.php" class="needs-validation" novalidate method="post">
                <div class="form-group">
                    <label for="uname">Username:</label>
                    <input type="text" class="form-control" id="uname" placeholder="Enter username" name="username" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="password" required>
                    <div class="valid-feedback">Valid.</div>
                    <div class="invalid-feedback">Please fill out this field.</div>
                </div>            
                <button type="submit" class="btn btn-primary" name="login">Submit</button>
            </form>
        </div>        
        <?php
        $this->addFormValidation();
    }

    public function addFormValidation() {
        ?>
        <script>
            // Disable form submissions if there are invalid fields
            (function () {
                'use strict';
                window.addEventListener('load', function () {
                    // Get the forms we want to add validation styles to
                    var forms = document.getElementsByClassName('needs-validation');
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener('submit', function (event) {
                            if (form.checkValidity() === false) {
                                event.preventDefault();
                                event.stopPropagation();
                            }
                            form.classList.add('was-validated');
                        }, false);
                    });
                }, false);
            })();
        </script> 
        <?php
    }

}
