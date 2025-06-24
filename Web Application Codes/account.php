<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Account</title>
  <link rel="stylesheet" href="./Assets/css/account.css">
  <link rel="stylesheet" href="./Assets/css/Bootstrap/bootstrap.min.css">

  <script src="./Assets/js/jquery.js"></script>
</head>

<?php 
  if((isset($_SESSION['signed']) && !$_SESSION['signed']) || !isset($_SESSION['signed'])):
    header("Location: ./?p=home");
    exit;
  endif;

  // Retrieve user account details
  $email = $_SESSION['email'];
  $sql = "SELECT * FROM users WHERE email='{$email}' LIMIT 1";
  $user = $conn->query($sql)->fetch_assoc();

?>
<body>
  <div class="header fixed-top bg-primary shadow-sm p-3 mb-5" style="margin-bottom: 6rem;">
    <div class="d-flex justify-content-evenly align-items-center gap-2">
      <h1 class="h5 mb-0 text-white">Account Settings</h1>
      <a href="./?p=home" class="btn btn-white text-primary border text-white">Home</a>
    </div>
  </div>
  <div class="container-1 ">
    <div class="account">
      <div class="accounts" >
        <form id="update-form ">
          <div class="control-label">
          </div>
          <div class="user-password card p-2 m-3 card-form"> 
          <div class="form-horizontal">
            <div class="controls verify-message mb-2">
              <label for="iputCode">Change Password</label>
            </div>
            <div class="control-label">
            <input type="password" name="password" id="" value="<?= $user['password'] ?>"> 
            </div>
          </div>
        </div>
        <div class="user-name card p-2 m-3 card-form"> 
          <div class="form-horizontal">
            <div class="controls verify-message mb-2">
              <label for="iputCode">Change Name</label>
            </div>
            <div class="control-label">
              <input type="text" name="fullname" id="" value="<?= $user['fullname'] ?>">
            </div>
          </div>
        </div>
        <div class="user-email card m-3 p-2 card-form">
          <div class="form-horizontal">
            <div class="controls verify-message mb-2">
              <label for="iputCode">Change email</label>
            </div>
            <div class="control-label">
              <input type="email" name="email" id="" value="<?= $user['email'] ?>">
            </div>
          </div>
        </div>
        <div class="user-num card m-3 p-2 card-form">
          <div class="form-horizontal">
            <div class="controls verify-message mb-2">
              <label for="iputCode">Change number</label>
            </div>
            <div class="control-label">
              <input type="text" name="phone" id="" value="<?= $user['phone'] ?>">
            </div>
            
          </div>
        </div>
        <button type="submit" class="btn btn-primary btn-block mt-2 btn-update" form="update-form">Update Details</button>
        </form>
      </div>
    </div>
    
  <div class="container mb-2 d-flex justify-content-center align-items-center car-list">
    <div class="card shadow p-4 car-list-inner">
      <h2 class="text-center">Car List</h2>
      <ul class="list-group mb-4" id="car-list">
        <?php 
          // Retrieve all vehicles for user
          $sql = "SELECT * FROM vehicles WHERE owner='{$email}'";
          $cars = $conn->query($sql);

          if($cars->num_rows > 0):
            while($row = $cars->fetch_assoc()):
        ?>
        <li class="list-group-item"><?= $row['vehicle_reg'] ?></li>

        <?php endwhile; ?>
        <?php else: ?>
          <li class="list-group-item">No cars added yet.</li>
        <?php endif; ?>
      </ul>
      <form id="manage-vehicle">
        <div class="form-group mb-3">
          <label for="car-number">Car Number Plate</label>
          <input type="text" name="vehicle_reg" id="car-number" class="form-control" placeholder="Enter car number plate" required>
        </div>
        <div class="d-flex justify-content-between">
          <button type="submit" form="manage-vehicle" class="btn btn-success">Add Car</button>
          <button type="submit" id="remove-car" class="btn btn-danger">Remove Car</button>
        </div>
      </form>
    </div>
  </div>
  
  <div class="history p-2 shadow">
      <h4>History</h4>
      <?php 
        // Retrieve all history for user
        $sql = "SELECT r.id,r.vehicle_registration,r.reserved_at,r.parked_at,r.left_at,r.amount_paid,r.payment_method,p.parking_name,p.price,p.location FROM reservations r INNER JOIN parkings p ON r.parking_code=p.parking_code WHERE r.user='{$email}'";
        $history = $conn->query($sql);

        $non = ($history->num_rows > 0) ? $non=false : $non=true;
        $count = 1;

        while($row = $history->fetch_assoc()):
          $payment_method = $row['payment_method'];
          $reserved_at = !($row['reserved_at']==NULL) ? date("d D M Y H:i", strtotime($row['reserved_at'])) : "Haven't completed reservation!";
          $parked_at = !($row['parked_at']==NULL) ? date("d D M Y H:i", strtotime($row['parked_at'])) : "Haven't parked yet!";
          $left_at = !($row['left_at']==NULL) ? date("d D M Y H:i", strtotime($row['left_at'])) : "Haven't left yet!";
          $amount = $row['amount_paid'];
          $vehicle = $row['vehicle_registration'];

      ?>

      <div>
        <?= $count++ ?>. <span id="slot"><b><?= $row['parking_name'] ?></b></span> reserved for <span id="time"> <b><?= $vehicle ?> </b></span> at - <span id="time"> <b><?= $reserved_at ?></b></span> and parked from - <span id="date">
          <b><?= $parked_at ?></b></span> till - <span id="time"><b><?= $left_at ?></b></span>, paid <span id="time"> <b>E<?= $amount ?>.00 </b></span> using <span><b><?= strtoupper($payment_method) ?></b></span>
      </div>

      <?php endwhile; ?>

      <?php if($non): ?>
        <h5>You haven't made any reservations yet.</h5>
      <?php endif ?>
    </div>
  </div>

</body>

<script>
  $(document).ready(function() {
    $('#update-form').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: './server/action_call.php?action=update-user',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
          if (resp == 1) {
            alert("Details have been successfully updated.");
            location.reload();
          } else if (resp == 0) {
            alert("Sorry! An error occurred during update.");
          } else {
            alert("An unknown error occurred." + resp);
          }
        }
      });
    });

    $('#manage-vehicle').submit(function(e) {
      e.preventDefault();
      $.ajax({
        url: './server/action_call.php?action=manage-vehicle',
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
          if (resp == 1) {
            alert("Vehicle have been added successfully.");
            location.reload();
          } else if (resp == 0) {
            alert("Sorry! An error occurred vehicle registration.");
          } else {
            alert("An unknown error occurred." + resp);
          }
        }
      });
    });

    $('#add-car').click(function() {
      const carNumber = $('#car-number').val().trim();
      if (carNumber) {
        const carList = $('#car-list');
        if (!carList.children().filter((_, li) => $(li).text() === carNumber).length) {
          carList.append(`<li class="list-group-item">${carNumber}</li>`);
          $('#car-number').val('');
        } else {
          alert('Car is already in the list.');
        }
      } else {
        alert('Please enter a car number plate.');
      }
    });

    $('#remove-car').click(function() {
      const carNumber = $('#car-number').val().trim();
      if (carNumber) {
        const carList = $('#car-list');
        const carItem = carList.children().filter((_, li) => $(li).text() === carNumber);
        if (carItem.length) {
          carItem.remove();
          $('#car-number').val('');
        } else {
          alert('Car not found in the list.');
        }
      } else {
        alert('Please enter a car number plate.');
      }
    });
  }) //end

  </script>

</html>