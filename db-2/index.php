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
    <title>Candy Crush DBMS</title>
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
                    <img src="https://seeklogo.com/images/C/candy-crush-saga-logo-393285519D-seeklogo.com.png" alt="Logo" style="width: 40px; height: 40px; margin-right: 10px;">
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
                    <span>MASTER TABLES</span>
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
                <button id="toggle-insert-form" style="display:none;"></button>
            </li>
            <li>
                <button id="toggle-edit-form" style="display:none;"></button>
            </li>
        </ul>
    </nav>
    <main>
        <div id="container">
            <h1>Welcome to Candy Crush DBMS</h1>
            <p>Please select a table from the sidebar to view its data.</p>
        </div>
        <div id="insert-form-container" style="display: none;"></div>
        <div id="edit-form-container" style="display: none;"></div>
    </main>
<script>
let currentTable = '';
$(document).ready(function() {
    // Event handler for clicking a table link
    $('.table-link').on('click', function (e) {
        e.preventDefault();
        currentTable = $(this).data('table');
        
        $.post('load_table.php', { table: currentTable }, function (response) {
            $('#container').html(response);
        }).fail(function() {
            alert("Error loading table.");
        });

        $('#toggle-insert-form').html(`
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
            <span>INSERT INTO ${currentTable}</span>
        `).show();
        
        $('#toggle-edit-form').html(`
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
            <span>EDIT ${currentTable}</span>
        `).show();
        
        $.post('get_insert_form.php', { table: currentTable }, function (response) {
            $('#insert-form-container').html(response);
        });
        
        $.post('get_edit_form.php', { table: currentTable }, function (response) {
            $('#edit-form-container').html(response).hide();
        });
    });

    $(document).on('click', '#toggle-insert-form', function () {
        $('#edit-form-container').slideUp();
        $('#insert-form-container').slideToggle();
    });

    $(document).on('click', '#toggle-edit-form', function () {
        $('#insert-form-container').slideUp();
        $('#edit-form-container').slideToggle();
    });

    $(document).on('submit', '#insert-form', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'insert_data.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $('.table-link[data-table="' + currentTable + '"]').trigger('click');
            },
            error: function (xhr) {
                alert('Insert failed: ' + xhr.responseText);
            }
        });
    });
    
    $(document).on('submit', '#edit-form', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'update_row.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function (response) {
                alert(response);
                $('.table-link[data-table="' + currentTable + '"]').trigger('click');
            },
            error: function (xhr) {
                alert('Update failed: ' + xhr.responseText);
            }
        });
    });
    
    // **NEW** - Handle delete button click
    $(document).on('click', '.delete-btn', function (e) {
        e.preventDefault();
        
        if (!confirm('Are you sure you want to delete this row? This action cannot be undone.')) {
            return;
        }

        const table = $(this).data('table');
        const pkColumn = $(this).data('pk-column');
        const pkValue = $(this).data('pk-value');

        $.ajax({
            url: 'delete_row.php',
            type: 'POST',
            data: { 
                table: table,
                pk_column: pkColumn,
                pk_value: pkValue
            },
            success: function(response) {
                alert(response);
                $('.table-link[data-table="' + table + '"]').trigger('click'); // Reload table
            },
            error: function(xhr) {
                alert('Delete failed: ' + xhr.responseText);
            }
        });
    });

    // Auto-fill edit form
    $(document).on('input', '#primary-key', function () {
        const pkField = $(this).data('field');
        const pkValue = $(this).val();
        const table = $('input[name="table"]').val();

        if (!pkValue) {
             $('.edit-field').attr('placeholder', 'Enter value to edit...');
             return;
        }

        $.post('get_row_data.php', {
            table: table,
            pk: pkField,
            pk_value: pkValue
        }, function (data) {
            try {
                const row = JSON.parse(data);
                if(row) {
                    $('.edit-field').each(function () {
                        const field = $(this).attr('name');
                        if (row.hasOwnProperty(field)) {
                            $(this).attr('placeholder', `Current: ${row[field]}`);
                        }
                    });
                }
            } catch (e) {
                console.error("Invalid JSON:", e, data);
                $('.edit-field').attr('placeholder', 'Enter value to edit...');
            }
        });
    });
});
</script>
</body>
</html>
