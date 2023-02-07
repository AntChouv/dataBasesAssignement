
<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!$_SESSION['loggedin']) {
    //echo 'pisoooo';
    header('Location: login.php');
    exit;
}

function __autoload($name) {
    include_once $name . '.php';
}

$page = new PageMaker();
$form = new FormMaker;
$db = new DbHandler();
$page->displayHeadMatter();
$dockingStationList = $db->getDockingStations();
?>
<div class="container-fluid">
    <div class="row">  
        <div class="col">
            <?php
            $page->displayMenu($dockingStationList);
            ?>
        </div>
    </div>  
    <div class="row"> 
        <div class="col">
            <?php
            switch (@$_REQUEST['action']) {
                case 'customer':
                    $form->newCustomerForm();
                    $db->addNewCustomer();
                    break;
                case 'setUserNamePassWord':
                    $form->setUserNamePassWordForm();
                    $db->addLoginInformation();
                    break;
                case 'newBicycle':
                    $form->newBicycleForm();
                    $db->addNewBicycle();
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'newParkingSpot':
                    $form->newParkingSpotForm();
                    $db->addNewParkingSpot();
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'newDockingStation':
                    $form->newDockingStationForm();
                    $db->addNewDockingStation();
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'rentalStart':
                    $form->newRentalForm();
                    if (isset($_POST['customerId'])) {
                        //$permission = $db->rentalClearance();
                        $money = $db->getCustomerBalance();
                        if ($money==0) {
                            $db->addPickUpParkingSpotToRental();
                            $db->removeBicycleFromParkingSpot();
                            ?>
                            <script>
                                if (window.history.replaceState) {
                                    window.history.replaceState(null, null, window.location.href);
                                }
                                location.reload()
                            </script>
                            <?php
                        } else {
                            
                            echo "<h4>Για να επιτραπή η ενοικίαση πρέπει να πληρώσετε $money  € από προηγούμενη ενοικίαση</h4>";
                        }
                    }
                    break;
                     
                case 'rentalFinish':
                    $rentalId = $db->getRentalId();
                    $form->newReturnForm();
                    $db->addDropOfParkingSpotDropOffTimeToRental($rentalId);
                    $db->addBicycleToParkingSpotAtRentalEnd($rentalId);
                    $db->addChargeAtRentalEnd($rentalId)
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                            location.reload()
                        }
                    </script>
                    <?php
                    break;
                case 'parkingSpots':
                    $parkingSpotResource = $db->getDockingStationParkingSpots($_GET['dockingStationId']);
                    $page->showDockingStationParkingSpotsAvailability($parkingSpotResource);
                    //$db->addNewDockingStation();
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'parkingSpotToDockingStation':
                    //$parkingSpotToDockingStationResource = $db->;
                    $form->addParkingSpotToDockingStationForm();
                    $db->addParkingSpotToDockingStation();
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'bicycleToParkingSpot':

                    $form->addBicycleToParkingSpotForm();
                    $db->addBicycleToParkingSpot();
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'telephone':
                    $form->addTelephoneForm();
                    $db->addPhone();
                    break;
                case 'payment':
                    //$ammount = $db->getCustomerBalance();
                    $form->newPaymentForm($ammount);                    
                    $db->setCustomerBalance();                    
                    ?>
                    <script>
                        if (window.history.replaceState) {
                            window.history.replaceState(null, null, window.location.href);
                        }
                    </script>
                    <?php
                    break;
                case 'customersBalance':
                    $customerBalancesResource = $db->getAllOwingCustomersBalance();
                    $page->displayCustomersBalance($customerBalancesResource);
                    break;
                case 'payments':
                    $customerPaymentsResource = $db->getAllPayments();
                    $page->displayCustomersPayments($customerPaymentsResource);
                    break;
                case 'rentals':
                    //$customerPaymentsResource = $db->getAllPayments();
                    $form->getRentalsForm();
                    $rentalsResource = $db->getRentals();
                    $page->displayRentals($rentalsResource);
                    break;
                default :
                    $page->displayFrontPage();
            }
            ?>
        </div>
    </div> 
    <div class="row">  
        <div class="col">
            <?php
// $page->displayMenu();
            ?>
        </div>
    </div>  
</div>

<?php
$page->displayEndMatter();


