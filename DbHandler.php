<?php

class DbHandler {

    public function connect() {
        $servername = ""; //
        $username = "";
        $password = "";
        $dbname = "icsd17217";

// Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        mysqli_set_charset($conn, "utf8");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        } else {
            // echo 'welcome ha';
        }
        return $conn;
    }

    public function login($username, $password) {
        $conn = $this->connect();
        $sql = "SELECT * FROM user WHERE username = '" . $username . "' AND password = '" . $password . "'";
        $result = $conn->query($sql);
        //echo 'from function login'.$sql;        
        if ($result->num_rows > 0) {
            // echo 'welcome';
            return $result;
        } else {
            throw new Exception('Could not log you in');
        }
    }

    public function addNewBicycle() {
        if (isset($_POST['newBicycle'])) {
            $conn = $this->connect();
            $bicycleName = $_POST['bicycleName'];
            $sql = "INSERT INTO bicycle (bicycleName) VALUES ('" . $bicycleName . "')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addNewParkingSpot() {
        if (isset($_POST['newParkingSpot'])) {
            $conn = $this->connect();
            $parkingSpotName = $_POST['parkingSpotName'];
            $sql = "INSERT INTO parkingSpot (parkingSpotName) VALUES ('" . $parkingSpotName . "')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addNewDockingStation() {
        if (isset($_POST['newDockingStation'])) {
            $conn = $this->connect();
            $location = $_POST['location'];
            $sql = "INSERT INTO dockingStation (location) VALUES ('" . $location . "')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addParkingSpotToDockingStation() {
        if (isset($_POST['parkingSpotToDockingStation'])) {
            $conn = $this->connect();
            $parkingSpotId = $_POST['parkingSpotId'];
            $dockingStationId = $_POST['dockingStationId'];
            $sql = "INSERT INTO dockingStationHasParkingSpot (dockingStationId,parkingSpotId) VALUES ($dockingStationId,$parkingSpotId)";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addBicycleToParkingSpot() {
        if (isset($_POST['parkingSpotId']) && !is_null($_POST['parkingSpotId'])) {
            $conn = $this->connect();
            $parkingSpotId = $_POST['parkingSpotId'];
            $bicycleId = $_POST['bicycleId'];
            $sql = "INSERT INTO parkingSpotHasBicycle (bicycleId,parkingSpotId) VALUES ($bicycleId,$parkingSpotId)";
            //echo $sql;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addBicycleToParkingSpotAtRentalEnd($rentalId) {
        if (isset($_POST['parkingSpotId']) && !is_null($_POST['parkingSpotId'])) {
            $conn = $this->connect();
            $parkingSpotId = $_POST['parkingSpotId'];
            $sql = "INSERT INTO parkingSpotHasBicycle (bicycleId,parkingSpotId) VALUES ((SELECT bicycleId FROM rental WHERE rentalId =$rentalId),$parkingSpotId)";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addPickUpParkingSpotToRental() {
        if (isset($_POST['rentalStart'])) {
            $conn = $this->connect();
            $parkingSpotId = $_POST['parkingSpotId'];
            $bicycleId = $_POST['bicycleId'];
            $customerId = $_POST['customerId'];
            $sql = "INSERT INTO rental (pickUpParkingSpot,customerId,bicycleId) VALUES ($parkingSpotId,$customerId,(SELECT bicycleId FROM parkingSpotHasBicycle WHERE parkingSpotId = $parkingSpotId)) ";
            //echo $sql;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function getRentalId() {
        $conn = $this->connect();
        $parkingSpotId = $_POST['parkingSpotId'];
        $customerId = $_POST['customerId'];
        $sql = "SELECT rentalId FROM rental WHERE customerId = '$customerId' AND dropOfTime IS NULL";
        $result = $conn->query($sql);
        while ($row = $result->fetch_assoc()) {
            $rentalId = $row['rentalId'];
            //echo $rentalId;
        }
        $conn->close();
        return $rentalId;
    }

    public function addDropOfParkingSpotDropOffTimeToRental($rentalId) {
        if (isset($_POST['parkingSpotId'])) {
            $conn = $this->connect();
            $parkingSpotId = $_POST['parkingSpotId'];
            //$customerId = $_POST['customerId'];
            $sql = "UPDATE rental SET dropOfParkingSpot = $parkingSpotId,dropOfTime = curtime() WHERE rentalId = $rentalId";
            //echo $sql;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function addChargeAtRentalEnd($rentalId) {
        $conn = $this->connect();
        $customerId = $_POST['customerId'];
        $sql = "SELECT EXTRACT(MINUTE FROM (SELECT TIMEDIFF((SELECT dropOfTime FROM rental WHERE rentalId = $rentalId),(SELECT pickUpTime FROM rental WHERE rentalId = $rentalId)))) AS min";
        $result = $conn->query($sql);
        $row = $result->fetch_assoc();
        if ($row['min'] > 1) {
            $customerBalance = $row['min'] * 0.5;
            $sql1 = "UPDATE customer SET customerBalance = $customerBalance WHERE customerId = $customerId";
            if ($conn->query($sql1) === TRUE) {
                ?>
                <script>
                    alert('Περάσατε το όριο των 30 λεπτών ανά ενοικίαση')
                </script>
                <?php
                //echo '<h1>Περάσατε το όριο κατά' . $row['min'] . ' λεπτά</h1>';
                // echo "Πρέπει να πληρώσετε $customerBalance ";
            } else {
                echo "Error updating record: " . $conn->error;
            }
        }
        $conn->close();
    }

    public function addPhone() {
        $conn = $this->connect();
        $customerId = $_POST['customerId'];
        $telephone = htmlspecialchars($_POST['telephone']);
        if (isset($telephone) && $telephone != '') {
            $sql = "INSERT INTO telephone (customerId,telephoneNumber) VALUES ('" . $customerId . "','" . $telephone . "')";
            $name = "name";
            $value = $_POST['name'];
            setcookie($name, $value, time() + 36000);
            setcookie("lastName", $_POST['lastName'], time() + 36000);
            setcookie("customerId", $customerId, time() + 36000);
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    public function addNewCustomer() {
        $conn = $this->connect();
        $name = htmlspecialchars($_POST['name']);
        $lastName = htmlspecialchars($_POST['lastName']);
        $address = htmlspecialchars($_POST['address']);
        $customerKind = htmlspecialchars($_POST['customerKind']);
        if (isset($name) && $name != '') {
            $sql = "INSERT INTO customer (name,lastName,address,customerKind,customerBalance) VALUES ('" . $name . "','" . $lastName . "','" . $address . "','" . $customerKind . "','" . 0 . "')";
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
                return true;
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

    public function addLoginInformation() {
        $conn = $this->connect();
        $username = htmlspecialchars($_POST['username']);
        $password = htmlspecialchars($_POST['password']);
        $customeId = htmlspecialchars($_POST['customerId']);
        $userKind = htmlspecialchars($_POST['userKind']);
        if (isset($_POST['setUserNamePassWord'])) {
            $sqlAsk = "SELECT * FROM user WHERE username = '$username'";
            $testResult = $conn->query($sqlAsk);
            if ($testResult->num_rows > 0) {
                echo "<h3>Το όνομα χρήστη $username χρησιμοποιείται <br> παρακαλούμε επιλέξτε διαφορετικό</h3>";
            } else {
                $sql = "INSERT INTO user (customerId,username,password,userKind) VALUES ($customeId,'$username','$password','$userKind') ";
                //echo $sql;
                if ($conn->query($sql) === true) {
                    echo 'Ο κωδικός προστέθηκε με επιτυχία';
                }
            }
        }
    }

    public function getBicycles() {
        $conn = $this->connect();
        $sql = "SELECT * FROM bicycle ORDER BY bicycleName";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    //χρήσιμη μόνο για αρχική ενημέρωση της βάσης από τον διαχειριστή
    public function getFreeBicycles() {
        $conn = $this->connect();
        $sql = "SELECT * FROM `bicycle` WHERE bicycleId NOT IN (SELECT bicycleId FROM parkingSpotHasBicycle) AND bicycleId NOT IN (SELECT bicycleId FROM rental)";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getParkingSpots() {
        $conn = $this->connect();
        $sql = "SELECT * FROM parkingSpot ORDER BY parkingSpotName";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo 'succes';
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getParkingSpotsWithBicycles() {
        $conn = $this->connect();
        $sql = "SELECT * FROM parkingSpotHasBicycle pshb INNER JOIN parkingSpot ON pshb.parkingSpotId=parkingSpot.parkingSpotId ORDER BY parkingSpotName";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo 'succes';
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getFreeAssignedParkingSpots() {
        $conn = $this->connect();
        $sql = "SELECT * FROM parkingSpot WHERE parkingSpotId NOT IN( SELECT parkingSpotId FROM parkingSpotHasBicycle ) AND parkingSpotId IN (SELECT parkingSpotId FROM dockingStationHasParkingSpot) ORDER BY parkingSpotName";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo 'succes';
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getNotAssignedParkingSpots() {
        $conn = $this->connect();
        $sql = "SELECT * FROM parkingSpot p WHERE p.parkingSpotId NOT IN (SELECT parkingSpotId FROM dockingStationHasParkingSpot) ORDER BY parkingSpotName";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo 'succes';
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getDockingStationParkingSpots($dockingStationId) {
        $conn = $this->connect();
        $sql = "SELECT * FROM parkingSpot p LEFT JOIN parkingSpotHasBicycle pshb ON p.parkingSpotId = pshb.parkingSpotId WHERE p.parkingSpotId IN (SELECT parkingSpotId FROM dockingStationHasParkingSpot WHERE dockingStationHasParkingSpot.dockingStationId = $dockingStationId)";
        //echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //echo 'succes';
            return $result;
        } else {
            echo "<h5>Δεν έχουν ανατεθεί θέσεις στάθμευσης</h5>";
        }
        $conn->close();
    }

    public function getDockingStations() {
        $conn = $this->connect();
        $sql = "SELECT * FROM dockingStation ORDER BY location";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getCustomers() {
        $conn = $this->connect();
        $sql = "SELECT * FROM customer ORDER BY name";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getCustomersWithActiveRental() {
        $conn = $this->connect();
        $sql = "SELECT * FROM customer WHERE customerId IN(SELECT customerId FROM rental WHERE ISNULL(rental.dropOfTime))";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getCustomersWhoOwe() {
        $conn = $this->connect();
        $sql = "SELECT * FROM customer WHERE customerBalance > 0";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getCustomersNotInActiveRental() {
        $conn = $this->connect();
        $sql = "SELECT * FROM customer WHERE customerId NOT IN(SELECT customerId FROM rental WHERE ISNULL(rental.dropOfTime)) ORDER BY name";
        echo $sql;
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getCustomerBalance() {
        $conn = $this->connect();
        $customerId = $_POST['customerId'];
        $sql = "SELECT customerBalance as cb FROM customer WHERE customerId=$customerId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row['cb'];
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getAllOwingCustomersBalance() {
        $conn = $this->connect();
        $sql = "SELECT * FROM customer WHERE customerBalance > 0";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //echo 'okkkkkkkkkkkk';            
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

    public function getAllPayments() {
        $conn = $this->connect();
        $sql = "SELECT * FROM customer INNER JOIN payment ON customer.customerId = payment.customerId";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            //echo 'okkkkkkkkkkkk';            
            return $result;
        } else {
            echo "0 results";
        }
        $conn->close();
    }

     public function getRentals() {
        $conn = $this->connect();
        $customerId = $_POST['customerId'];        
        if (isset($_POST['date'])) {
            $date = $_POST['date'];            
        } else {
            $date = '2020-01-01';
        }
        if (isset($customerId) && $customerId > 0) {
            if ($customerId == 6974004099) {
                $sql = "SELECT name,lastName,DATE(pickUpTime) as date,MINUTE(TIMEDIFF(dropOfTime,pickUpTime)) AS dif FROM rental r INNER JOIN customer c ON r.customerId = c.customerId WHERE r.pickUpTime >= '$date'  ORDER BY r.pickUpTime";
            } else {
                $sql = "SELECT name,lastName,DATE(pickUpTime) as date,MINUTE(TIMEDIFF(dropOfTime,pickUpTime)) AS dif FROM rental r INNER JOIN customer c ON r.customerId = c.customerId WHERE c.customerId = $customerId AND r.pickUpTime >= '$date'  ORDER BY r.pickUpTime";
            }
            //echo $sql;
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {                               
                //echo 'great';
            } else {
                echo "0 results";
            }
            return $result;
        }
    }
    
    public function setCustomerBalance() {
        $conn = $this->connect();
        $customerId = $_POST['customerId'];
        $ammount = $_POST['ammount'];
        if ($ammount > 0) {
            $sql = "UPDATE customer SET customerBalance = (customerBalance - $ammount) WHERE customerId = $customerId";
            if ($conn->query($sql) === TRUE) {
                echo "Το υπόλοιπο πελάτη ενημερώθηκε";
            } else {
                echo "Λάθος κατά την ενημέρωση υπολοίπου: " . $conn->error;
            }
            $sql1 = "INSERT INTO payment (customerId,ammount,date) VALUES ($customerId,$ammount,CURDATE())";
            if ($conn->query($sql1) === TRUE) {
                echo "Η πληρωμή πελάτη ενημερώθηκε";
            } else {
                echo "Λάθος κατά την ενημέρωση πληρωμής: " . $conn->error;
            }
        }
        $conn->close();
    }

    public function removeBicycleFromParkingSpot() {
        if (isset($_POST['rentalStart'])) {
            $conn = $this->connect();
            $parkingSpotId = $_POST['parkingSpotId'];
            $bicycleId = $_POST['bicycleId'];
            $sql = "DELETE FROM parkingSpotHasBicycle WHERE parkingSpotId=$parkingSpotId";
            //echo $sql;
            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $conn->close();
        }
    }

    public function rentalClearance() {
        $conn = $this->connect();
        if (isset($_POST['customerId'])) {
            $customerId = $_POST['customerId'];
            $sql = "SELECT customerBalance as cb FROM customer WHERE customerId = $customerId";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if ($row['cb'] > 0) {
                    return true;
                } else {
                    return false;
                }
            } else {
                echo "0 results";
            }
        }
        $conn->close();
    }

    public function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}
