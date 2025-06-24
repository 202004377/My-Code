<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>
    <link rel="stylesheet" href="./Assets/css/style.css">
    <link rel="stylesheet" href="./Assets/css/Bootstrap/bootstrap.min.css">
    <script src="./Assets/js/bootstrap.bundle.js"></script>
    <script src="./Assets/js/jquery.js"></script>
</head>

<body>
    <div class="container verify">
        <div class="card mt-4 shadow p-2 max">
            <form id="verify" method="post" class="form-horizontal">
                <div class="controls verify-message mb-2">
                    <p>A Verification code have been sent to your email.</p>
                    <label for="iputCode">Enter Verification code</label>
                </div>
                <div class="control-label">
                    <input type="text" name="code" id="">
                </div>
                <button type="submit" form="verify" class="btn btn-primary btn-block mt-2">Verify</button>
            </form>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        $('#verify').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: './server/action_call.php?action=verify',
                data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                success: function (resp) {
                    if (resp == 1) {
                        location.href = "./?p=home";
                    } else {
                        alert("Invalid verification code!");
                    }
                }
            });
        });
    })  //end
</script>

</html>