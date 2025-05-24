<?php 
require_once("database.php");
$query="SELECT * FROM friendships";
$result=mysqli_query($conn,$query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>friendship</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <style>
        html,body{
            margin:0;
            padding:0;
            box-sizing: border-box;
			background-color: #212529;

        }
        header{
            height: 150px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            background-color: #010203;
        }
        .flex {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
        .img {
            height: 120px;
            margin-right: 10px;
            margin-left: 10px;
			filter: grayscale(1);
        }
        .header-text{
            font-size: 2em;
        }
		table{
			display: block;
            overflow-x: auto;
            white-space: nowrap;
			height: 100%;
		}
		td {
            border: 2px solid black;
            margin: 0;
			background-color: white;
			color: black;
			padding:10px;
        }
        .f-row td{
			background-color: #212529;
            color: white;
            padding: 10px;
        }
    </style>
</head>
<body>
    <div>
        <header>
            <div class="flex">
                <img src="img/logo.jpeg" alt="" class="img">
                <div class="header-text text-light fw-bold">Database Management <br>System</div>
            </div>
            <div style="margin: 20px;">
                <div class="dropdown">
					<a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
						TABLES
					</a>

					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="players.php">players</a></li>
						<li><a class="dropdown-item" href="friendships.php">friendships</a></li>
						<li><a class="dropdown-item" href="levels.php">levels</a></li>
						<li><a class="dropdown-item" href="player_progress.php">player_progress</a></li>
						<li><a class="dropdown-item" href="items.php">items</a></li>
						<li><a class="dropdown-item" href="inventory.php">inventory</a></li>
						<li><a class="dropdown-item" href="transactions.php">transactions</a></li>
						<li><a class="dropdown-item" href="game_sessions.php">game_sessions</a></li>
						<li><a class="dropdown-item" href="leaderboards.php">leaderboards</a></li>
						<li><a class="dropdown-item" href="leaderboard_entries.php">leaderboard_entries</a></li>
					</ul>
				</div>
				</div>
            </div>
        </header>
		<content>
            <div class="header-text fw-light text-light m-2">
				friendships Table
			</div>
			<table>
				<tr class="f-row">
					<td>
						friendship_id
					</td>
					<td>
						player1_id
					</td>
					<td>
						player2_id
					</td>
					<td>
						status
					</td>
					<td>
						friendship_date
					</td>
				<tr>
					<?php
					while($row=mysqli_fetch_array($result)) {
					?>
					<td><?php echo $row['friendship_id'] ?></td>
					<td><?php echo $row['player1_id'] ?></td>
					<td><?php echo $row['player2_id'] ?></td>
					<td><?php echo $row['status'] ?></td>
					<td><?php echo $row['friendship_date'] ?></td>
				</tr>
					<?php
					}
					?>
			</table>
		</content>
    </div>
</body>
</html>