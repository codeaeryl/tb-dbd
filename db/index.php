<?php
$host = 'localhost';
$db   = 'candy_crush_db';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>template</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <script type="text/javascript" src="index.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <!-- sidebar -->
    <nav id="sidebar">
        <ul>
            <!-- name + logo -->
            <li>
                <span class="logo">
                    <img src="../img/logo.jpeg" alt="">
                    Candy Crush<br>DBMS
                </span>
                <!-- close sidebar btn -->
                <button onclick=toggleSidebar() id="toggle-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-240 200-480l240-240 56 56-183 184 183 184-56 56Zm264 0L464-480l240-240 56 56-183 184 183 184-56 56Z"/></svg>
                </button>
            </li>
            <li>
                <button onclick=toggleSubMenu(this) class="dropdown-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm240-240H200v160h240v-160Zm80 0v160h240v-160H520Zm-80-80v-160H200v160h240Zm80 0h240v-160H520v160ZM200-680h560v-80H200v80Z"/></svg>
                    <span>TABLES</span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                </button>
                <ul class="sub-menu">
                    <div>
                        <li><a href="#" class="table-link" data-table="players">players</a></li>
                        <li><a href="#" class="table-link" data-table="friendships">friendships</a></li>
                        <li><a href="#" class="table-link" data-table="player_progress">player_progress</a></li>
                        <li><a href="#" class="table-link" data-table="game_sessions">game_sessions</a></li>
                        <li><a href="#" class="table-link" data-table="inventory">inventory</a></li>
                        <li><a href="#" class="table-link" data-table="items">items</a></li>
                        <li><a href="#" class="table-link" data-table="levels">levels</a></li>
                        <li><a href="#" class="table-link" data-table="leaderboards">leaderboards</a></li>
                        <li><a href="#" class="table-link" data-table="leaderboard_entries">leaderboard_entries</a></li>
                        <li><a href="#" class="table-link" data-table="transactions">transactions</a></li>
                    </div>
                </ul>
            </li>
            <li>
                <button onclick=toggleSubMenu(this) class="dropdown-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M222-200 80-342l56-56 85 85 170-170 56 57-225 226Zm0-320L80-662l56-56 85 85 170-170 56 57-225 226Zm298 240v-80h360v80H520Zm0-320v-80h360v80H520Z"/></svg>
                    <span>SELECT</span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-344 240-584l56-56 184 184 184-184 56 56-240 240Z"/></svg>
                </button>
                <ul class="sub-menu">
                    <div>
                        <div id="select"></div>

                        <li>
                            <button id="select-submit">
                                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                                <span>SUBMIT</span>
                            </button>
                        </li>
                    </div>
                </ul>
            </li>
            <li>
                <button id="toggle-insert-form" id="toggle-mode-btn"></button>
            </li>
            <!--Toggle Mode-->
            <li>
                <button onclick=toggleMode() id="toggle-mode-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path id="mode-path" d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z"/></svg>
                    <span id="mode-name">Dark Mode</span>
                </button>
            </li>
        </ul>
    </nav>
    <main>
        <div id="container"></div>
        <div id="insert-form-container" style="display: none;"></div> <!-- Hidden by default -->
    </main>
    <script>
let currentTable = '';
$(document).ready(function() {
    $('.table-link').on('click', function (e) {
        e.preventDefault();
        currentTable = $(this).data('table');
        // Load and display table
        $.post('load_table.php', { table: currentTable }, function (response) {
            $('#container').html(response);
        });
        $('#toggle-insert-form').html(`
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
        <span>INSERT INTO ${currentTable}</span>
        `);
        // Load insert form
        $.post('get_insert_form.php', { table: currentTable }, function (response) {
            $('#insert-form-container').html(response);
        });
    });
    // Toggle insert form visibility
    $(document).on('click', '#toggle-insert-form', function () {
        $('#insert-form-container').slideToggle(); // Smooth toggle
    });

    // Delegate form submission
    $(document).on('submit', '#insert-form', function (e) {
        e.preventDefault();

        $.ajax({
            url: 'insert_data.php',
            method: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                // Optionally reload table after insert
                $('.table-link[data-table="' + currentTable + '"]').trigger('click');
            },
            error: function (xhr) {
                alert('Insert failed: ' + xhr.responseText);
            }
        });
    });
    // Load column checkboxes when a table is clicked
    $('.table-link').on('click', function (e) {
        e.preventDefault();
        currentTable = $(this).data('table');

        $.ajax({
            type: 'POST',
            url: 'get_columns.php',
            data: { table: currentTable },
            success: function (response) {
                $('#select').html(response); // Load checkboxes into select div
            }
        });
    });
    // Delegate event after columns are dynamically loaded
    $(document).on('change', '#select-all-columns', function () {
        const checked = $(this).is(':checked');
        $('.column-checkbox').prop('checked', checked);
    });

    // Handle submit
    $('#select-submit').on('click', function () {
        let selected = [];
        $('input.column-checkbox:checked').each(function () {
            selected.push($(this).val());
        });

        if (selected.length === 0 || currentTable === '') {
            $('#container').html("Please select a table and at least one column.");
            return;
        }

        $.ajax({
            type: 'POST',
            url: 'load_table.php',
            data: {
                table: currentTable,
                columns: selected
            },
            success: function (response) {
                $('#container').html(response);
            },
            error: function (xhr, status, error) {
                $('#container').html("Error: " + error);
            }
        });
    });
});
    </script>
</body>
</html>