<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Assets/css/Bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="./Assets/css/Bootstrap/bootstrap-utilities.min.css">
  <link rel="stylesheet" href="./Assets/css/style.css">
  <title>IoT</title>
  <script src="./Assets/js/bootstrap.min.js"></script>
  <script src="./Assets/js/bootstrap.bundle.min.js"></script>
  <script src="./Assets/js/jquery.js"></script>

</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid ">
      <a class="navbar-brand" href="#">
        <h1 class="heading">Smart Parking System</h3>
      </a>
      <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <a class="nav-link" aria-current="page" href="#">About</a>
          <a class="nav-link" href="#">Contacts</a>
          <a class="nav-link" href="#">Pricing</a>
          <?php if((isset($_SESSION['signed']) && !$_SESSION['signed']) || !isset($_SESSION['signed'])):  ?>
          <a class="btn btn-light btn-outline-primary " data-bs-toggle="modal" href="#exampleModalToggle" role="button">Login</a>
          <?php else: ?> 
          <div class="account border border-2"> <a href="./?p=account">
              <div>Account: <span class="pills"><?= $_SESSION['username'] ?></span><span class="pills ml-2"> <?= $_SESSION['email'] ?></span></div>
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
  <div class="pricing-header px-3 py-3 pt-md-3 pb-md-3 mx-auto text-center">
    <h1 class="display-4"><strong>Park smart, Park with us!</strong> </h1>

    <?php
        // Retrieve all parking slots from database
        $sql = "SELECT * FROM parkings WHERE status=1";
        $parkings = $conn->query($sql);

        $total_slots_available = $parkings->num_rows;
    ?>
    <p class="lead"><span class="total-slot"><?= $total_slots_available ?></span> Slot Available Currently</p>
  </div>

  <div class="container">
    <div class="card-deck mb-3 text-center">

      <?php
        // Retrieve all parking slots from database
        $sql = "SELECT * FROM parkings";
        $parkings = $conn->query($sql);

        // List all parkings one by one
        while($row = $parkings->fetch_assoc()):

          // Now check the last time the spot was booked
          $parking_code = $row['parking_code'];
          $sql = "SELECT reserved_at FROM reservations WHERE parking_code='{$parking_code}' ORDER BY id DESC LIMIT 1";
          $query = $conn->query($sql);
          $last_reserve_time = ($query->num_rows > 0) ? date("D d M Y H:i", strtotime($query->fetch_assoc()['reserved_at'])) : "Never been reserved";
      ?>

      <?php if($row['status'] == 1): ?>

      <div class="card mb-4 shadow p-2">
        <div class="card-header ">
          <h4 class="my-0 font-weight-normal"> Available</h4>
        </div>
        <div class="card-body">
          <h1 class="card-title pricing-card-title"> <?= $row['parking_name'] ?> <small class="text-muted">/ E<?= $row['price'] ?> per hour</small></h1>
          <ul class="list-unstyled mt-3 mb-4">
            <li>Last Reserved: <b><?= $last_reserve_time ?></b></li>
            <li><img src="./Assets/Images/car.png" alt="car" class="car-img"></li>
          </ul>
          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" <?php if (isset($_SESSION['signed'])  && $_SESSION['signed']) { ?> data-bs-target="#staticBackdrop" <?php } else { ?> href="#exampleModalToggle" <?php } ?>>Reserve Spot</button>
        </div>
      </div>

      <?php else: ?>
      <div class="card mb-4 shadow p-2">
        <div class="card-header card-taken">
          <h4 class="my-0 font-weight-normal">Taken</h4>
        </div>
        <div class="card-body">
          <h1 class="card-title pricing-card-title"> <?= $row['parking_name'] ?> <small class="text-muted">/ E<?= $row['price'] ?> per hour</small></h1>
          <ul class="list-unstyled mt-3 mb-4">
            <li>Last Reserved: <b><?= $last_reserve_time ?></b></li>
            <li><img src="./Assets/Images/car.png" alt="car" class="car-img"></li>
          </ul>
          <!--button type="button" class="btn btn-lg btn-block btn-outline-primary">Book</button-->
        </div>
      </div>
      
      <?php endif; ?>

      <?php endwhile; ?>

      
    </div>
    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row">
        <div class="col-12 col-md">
          <h4>Smart Parking System Eswatini</h4>
          <small class="d-block mb-3 text-muted">&copy; Philani Softtech 2025</small>
        </div>
        <div class="col-6 col-md">
          <h5>Features</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-muted" href="#">Upcoming events</a></li>
            <li><a class="text-muted" href="#">Reviews</a></li>
            <li><a class="text-muted" href="#">Updates</a></li>
            <li><a class="text-muted" href="#">Reservations</a></li>
            <li><a class="text-muted" href="#">Payments</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>Resources</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-muted" href="#">Customer care</a></li>
            <li><a class="text-muted" href="#">Contacts</a></li>
            <li><a class="text-muted" href="#">Feedback</a></li>
            <li><a class="text-muted" href="#">Inquires</a></li>
          </ul>
        </div>
        <div class="col-6 col-md">
          <h5>About</h5>
          <ul class="list-unstyled text-small">
            <li><a class="text-muted" href="#">Team</a></li>
            <li><a class="text-muted" href="#">Locations</a></li>
            <li><a class="text-muted" href="#">Privacy</a></li>
            <li><a class="text-muted" href="#">Terms</a></li>
          </ul>
        </div>
      </div>
    </footer>
  </div>
  <!--Payment modal-->
  <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="POST" id="checkout">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">Payments</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="form-check">
            <p>
              Please input time interval <br>
            </p>
            <label class="form-check-number" for="flexRadioDefault1">
              Time in hours.
            </label>
            <input type="number" name="init_duration" id="number" min="1" placeholder="1 hour min">
            <br><br>
            <input class="form-check-input" type="radio" name="payment_method" value="momo" id="flexRadioDefault1" checked>
            <label class="form-check-label" for="flexRadioDefault1">
              Mobile Money <span></span> <input type="text" name="phone" id="" value="76992262">
            </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment_method" value="card" id="flexRadioDefault2">
            <label class="form-check-label" for="flexRadioDefault2">
              Debit card
            </label>
          </div>
          <select class="form-select" name="vehicle_registration" aria-label="Default select example">
          <option selected>Choose your vehicle</option>
            <?php 
              // Retrieve all vehicles from database
              $user_id = $_SESSION['email'];
              $sql = "SELECT * FROM vehicles WHERE owner='{$user_id}'";
              $vehicles = $conn->query($sql);

              // List all vehicles one by one
              while($row = $vehicles->fetch_assoc()):
            ?>
            
            <option value="<?= $row['vehicle_reg'] ?>"><?= $row['vehicle_reg'] ?></option>

            <?php endwhile; ?>
          </select>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
          <button type="submit" form="checkout" class="btn btn-primary">Checkout</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  <!--Login and sign in modals-->
  <div class="modal fade" id="exampleModalToggle" aria-hidden="true" aria-labelledby="exampleModalToggleLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalToggleLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form class="rounded border border-2 p-2" id="signin" method="POST">
            <!-- Email input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="email" name="email" id="form2Example1" class="form-control" />
              <label class="form-label" for="form2Example1">Email address</label>
            </div>

            <!-- Password input -->
            <div data-mdb-input-init class="form-outline mb-4">
              <input type="password" name="password" id="form2Example2" class="form-control" />
              <label class="form-label" for="form2Example2">Password</label>
            </div>

            <!-- 2 column grid layout for inline styling -->
            <div class="row mb-4">
              <div class="col d-flex justify-content-center">
                <!-- Checkbox -->
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" value="" id="form2Example31" checked />
                  <label class="form-check-label" for="form2Example31"> Remember me </label>
                </div>
              </div>

              <div class="col">
                <!-- Simple link -->
                <a href="#!">Forgot password?</a>
              </div>
            </div>
            <!-- Submit button -->
            <div class="text-center">
              <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary  mb-4" form="signin">Sign in</button>
            </div>
            <div class="text-center">You don't have an account? Click <a href="#" data-bs-target="#exampleModalToggle2" data-bs-toggle="modal" data-bs-dismiss="modal">here</a>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-danger">
          <h5 class="modal-title" id="exampleModalToggleLabel2">Register</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mask d-flex gradient-custom-3">
            <div class="container ">
              <div class="row d-flex justify-content-center align-items-center h-100 d-body" >
                <div class="card sign-in"
                  <div class="card " style="border-radius: 15px;">
                    <div class="card-body p-2">
                      <h2 class="text-uppercase text-center mb-2">Create an account</h2>
                      <form id="signup" method="POST">
                        <div data-mdb-input-init class="form-outline mb-2">
                          <input type="text" name="fullname" id="form3Example1cg" class="form-control form-control-lg" />
                          <label class="form-label" for="form3Example1cg">Your Name</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-2">
                          <input type="email" name="email" id="form3Example3cg" class="form-control form-control-lg" />
                          <label class="form-label" for="form3Example3cg">Your Email</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-2">
                          <input type="text" name="phone" id="form3Example3cg" class="form-control form-control-lg" />
                          <label class="form-label" for="form3Example3cg">Number</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-2">
                          <input type="password" name="password" id="form3Example4cg" class="form-control form-control-lg" />
                          <label class="form-label" for="form3Example4cg">Password</label>
                        </div>
                        <div data-mdb-input-init class="form-outline mb-2">
                          <input type="password" id="form3Example4cdg" class="form-control form-control-lg" />
                          <label class="form-label" for="form3Example4cdg">Repeat your password</label>
                        </div>
                        <div class="form-check d-flex justify-content-center mb-2">
                          <input class="form-check-input me-2" type="checkbox" value="" id="form2Example3cg" />
                          <label class="form-check-label" for="form2Example3g">
                            I agree all statements in <a href="#!" class="text-body"><u>Terms of service</u></a>
                          </label>
                        </div>
                        <div class="d-flex justify-content-center">
                          <button type="submit" data-mdb-button-init
                            data-mdb-ripple-init class="btn btn-primary btn-block btn-lg gradient-custom-4 text-body" form="signup">Register</button>
                        </div>
                        <p class="text-center text-muted mt-2 mb-0">Have already an account?
                          <p"
                            class="text-body">click <a href="#" data-bs-target="#exampleModalToggle" data-bs-toggle="modal" data-bs-dismiss="modal">here</a>
                        </p>
                        </p>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
</body>

<script>
  $(document).ready(function() {
    $('#signup').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: './server/action_call.php?action=signup',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
          if (resp == 1) {
            location.href = "./?p=verify";
          } else if (resp == 2) {
            alert("Sorry! This user is already registered.");
          } else {
            alert("An unknown error occurred." + resp);
          }
        }
      });
    });
  }) //end

  $(document).ready(function() {
    $('#signin').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: './server/action_call.php?action=signin',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
          if (resp == 1) {
            location.href = "./?p=home";
          } else if (resp == 0) {
            alert("Incorrect login email or password!");
          } else {
            alert("An unknown error occurred.");
          }
        }
      });
    });
  }) //end

  $(document).ready(function() {
    $('#checkout').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: './server/action_call.php?action=checkout',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
          if (resp == 1) {
            location.href = "./?p=account";
          } else if (resp == 0) {
            alert("Sorry! An error occurred while processing your payment.");
          } else {
            alert("An unknown error occurred." + resp);
          }
        }
      });
    });
  }) //end

</script>

</html>