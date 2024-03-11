<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Food Order Form</title>
  <!-- <link rel="stylesheet" href="neworder.css"> -->
  <style>
    
    img{
      height: 50%;
      width: 50%;
    }
    .checkboxes {
      display: inline;
    }

    body {
      background-image: url('order1.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      padding: 20px;
    }

    * {
      color: rgb(63, 70, 72);
    }

    h1 {
      text-align: center;
    }

    form {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: transparent;
      border-radius: 8px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"],
    input[type="datetime-local"],
    input[type="number"],
    textarea {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    select {
      width: 100%;
      padding: 8px;
      margin-bottom: 10px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input[type="submit"] {
      background-color: #4caf50;
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      font-size: 16px;
      text-align: center;
    }

    input[type="submit"]:hover {
      background-color: #45a049;
    }

    table {
      width: 100%;
    }
  </style>
</head>

<body>

  <header>
    <h1>Restaurant Food Order Form</h1>
  </header>

  <main>
    <form action="forder.php" method="POST">
      <div class="form-group">
        <label for="name">Person Name:</label>
        <input type="text" id="name" name="name" placeholder="Enter Name" required>
      </div>

      <div class="form-group">
        <label for="email">Email Address:</label>
        <input type="email" id="email" name="email" placeholder="Enter email" required>
      </div>

      <div class="form-group">
        <label for="phone">Phone Number:</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter Phone number " required>
      </div>

      <div>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "register";

        // Establish database connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT name, price FROM menu";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
          // output data of each row
          echo "<table>
            <tr>
                <th>Dish Name</th>
                <th>Price</th>
                <th>Select</th>
            </tr>";
          while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["price"] . "</td>
                <td><input type='checkbox' name='selected_dishes[]' value='" . $row["name"] . "'></td>
              </tr>";
          }
          echo "</table>";
        } else {
          echo "0 results";
        }
        $conn->close();
        ?>
      </div>


      <div class="form-group">
        <label for="address">Delivery Address:</label>
        <input type="text" id="address" name="address" placeholder="Enter Delivery Address" required>
      </div>

      <div class="form-group">
        <label for="time">Preferred Delivery Time:</label>
        <input type="datetime-local" id="time" name="time" placeholder="Preferred Delivery Time">
      </div>

      <img src="upi.jpeg" alt="">

      <div class="form-group">
        <label for="comments">Additional Comments/Questions:</label>
        <textarea id="comments" name="comments" rows="4" placeholder="Enter Additional Comments/Questions"></textarea>
      </div>

      <div class="form-group">
        <label for="special-instructions">Special Instructions:</label>
        <textarea id="instructions" name="instructions" rows="4"
          placeholder="Enter Special Instructions"></textarea>
      </div>
      <input type="submit" name="submit" value="Submit">
    </form>
    <?php
    // Process form submission
    if (isset($_POST['submit'])) {
      if (isset($_POST['selected_dishes'])) {
        $selected_dishes = $_POST['selected_dishes'];
        $total_price = 0;

        echo "<script>alert('Selected Dishes:\\n";
        foreach ($selected_dishes as $dish) {
          echo "$dish\\n";
          // Query dish price
          $conn = new mysqli($servername, $username, $password, $dbname);
          $query_price = "SELECT DishPrice FROM menu WHERE DishName = ?";
          $stmt = $conn->prepare($query_price);
          $stmt->bind_param("s", $dish);
          $stmt->execute();
          $result_price = $stmt->get_result();
          if ($result_price->num_rows > 0) {
            $row = $result_price->fetch_assoc();
            $total_price += $row['DishPrice'];
          }
          $conn->close();
        }
        echo "\\nTotal Price: Rs $total_price');</script>";
      } else {
        echo "<p>No dishes selected</p>";
      }
    }
    // if (isset($_POST['submit'])) {
    //       ?>
    //
    <script type="text/javascript">
      //     </script>
    //
    <?php
    // }
    ?>
  </main>

</body>

</html>