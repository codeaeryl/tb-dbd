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
    <!-- IMPORT style.css -->
    <link rel="stylesheet" href="style.css" type="text/css">
    <!-- IMPORT index.js NAVBAR, MODE TOGGLE RELATED -->
    <script type="text/javascript" src="index.js" defer></script>
    <!-- IMPORT Jquery -->
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
             <!-- TABLES btn -->
            <li>
                <button onclick=toggleSubMenu(this) class="dropdown-btn" id="master">
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
             <!-- Joined transaction btn -->
            <li>
                <a href="#" class="table-link" data-table="Transactions">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-80v-800l60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60 60 60 60-60v800l-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60-60-60-60 60Zm120-200h480v-80H240v80Zm0-160h480v-80H240v80Zm0-160h480v-80H240v80Zm-40 404h560v-568H200v568Zm0-568v568-568Z"/></svg>
                    <span>transactions (joined)</span>
                </a>
            </li>
            <!-- SELECT btn -->
            <li>
                <button id="toggle-select-form">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M222-200 80-342l56-56 85 85 170-170 56 57-225 226Zm0-320L80-662l56-56 85 85 170-170 56 57-225 226Zm298 240v-80h360v80H520Zm0-320v-80h360v80H520Z"/></svg>
                    <span>SELECT</span>
                </button>
            </li>
            <!-- ORDER BY btn -->
            <li>
                <button id="toggle-order-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-240v-80h240v80H120Zm0-200v-80h480v80H120Zm0-200v-80h720v80H120Z"/></svg>
                    <span>ASC</span>
                </button>
            </li>
            <!-- INSERT INTO btn -->
            <li>
                <button id="toggle-insert-form">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
                    <span>INSERT</span>
                </button>
            </li>
             <!-- UPDATE btn -->
            <li>
                <button id="toggle-edit-form">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
                    <span>UPDATE</span>
                </button>
            </li>
             <!-- DELETE btn -->
            <li>
                <button id="toggle-delete-form">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
                    <span>DELETE</span>
                </button>

            </li>
            <!--Toggle DARK/LIGHT Mode-->
            <li>
                <button onclick=toggleMode() id="toggle-mode-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path id="mode-path" d="M480-120q-150 0-255-105T120-480q0-150 105-255t255-105q14 0 27.5 1t26.5 3q-41 29-65.5 75.5T444-660q0 90 63 153t153 63q55 0 101-24.5t75-65.5q2 13 3 26.5t1 27.5q0 150-105 255T480-120Zm0-80q88 0 158-48.5T740-375q-20 5-40 8t-40 3q-123 0-209.5-86.5T364-660q0-20 3-40t8-40q-78 32-126.5 102T200-480q0 116 82 198t198 82Zm-10-270Z"/></svg>
                    <span id="mode-name">Dark Mode</span>
                </button>
            </li>
        </ul>
    </nav>
    <main style="position: relative;">
        <div id="container">
            Please select a Table.
        </div>
        <!-- FUCTION forms -->
        <div id="select-form-container" class="form-container" style="display : none;"></div>
        <div id="insert-form-container" class="form-container" style="display: none;"></div>
        <div id="edit-form-container" class="form-container" style="display: none;"></div>
        <div id="delete-form-container" class="form-container" style="display: none;">
            <form id="delete-form" method="POST">
                <input type="hidden" name="table" id="delete-table">
                <label for="delete-pk-select">Row ID to Delete:</label>
                <select name="pk_value" id="delete-pk-select" required>
                <option value="">-- Choose ID --</option>
                </select>
                <button type="submit">Delete</button>
            </form>
        </div>
    </main>
    <!-- main Jquery SCRIPT DATABASE RELATED-->
    <script>
let currentTable = '';
$(document).ready(function() {
    $('.table-link').on('click', function (e) {
        e.preventDefault();
        currentTable = $(this).data('table');
        closeAllSubMenus()
        $.post('load_table.php', { table: currentTable }, function (response) {
            $('#container').html(response);
        });
        // Update side btns
        $('#toggle-select-form').html(`
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M222-200 80-342l56-56 85 85 170-170 56 57-225 226Zm0-320L80-662l56-56 85 85 170-170 56 57-225 226Zm298 240v-80h360v80H520Zm0-320v-80h360v80H520Z"/></svg>
        <span>SELECT ${currentTable}</span>
        `);
        $('#toggle-insert-form').html(`
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-280h80v-160h160v-80H520v-160h-80v160H280v80h160v160ZM200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h560q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm0-560v560-560Z"/></svg>
        <span>INSERT ${currentTable}</span>
        `);
        $('#toggle-edit-form').html(`
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z"/></svg>
        <span>EDIT ${currentTable}</span>
        `);
        $('#toggle-delete-form').html(`
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z"/></svg>
        <span>DELETE ${currentTable}</span>
        `);
        //Refresh forms
        $.post('get_insert_form.php', { table: currentTable }, function (response) {
            $('#insert-form-container').html(response);
        });
        $.post('get_edit_form.php', { table: currentTable }, function (response) {
            $('#edit-form-container').html(response).hide();
        });
    });

    // Form visibility
    function toggleForm(formIdToShow) {
        $('.form-container').not(`#${formIdToShow}`).slideUp();

        const target = $(`#${formIdToShow}`);
        target.slideToggle(); // Toggle selected form
    }
    $(document).on('click', '#toggle-select-form', () => toggleForm('select-form-container'));
    $(document).on('click', '#toggle-insert-form', () => toggleForm('insert-form-container'));
    $(document).on('click', '#toggle-edit-form', () => toggleForm('edit-form-container'));
    $(document).on('click', '#toggle-delete-form', () => toggleForm('delete-form-container'));

    // hide all forms on table switch
    $(document).on('click', '.table-link', () => {
        $('.form-container').slideUp();
    });

     // EDIT FORM
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

    // Submit EDIT
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

    // Load SELECT checkboxes
    $('.table-link').on('click', function (e) {
        e.preventDefault();
        currentTable = $(this).data('table');

        $.ajax({
            type: 'POST',
            url: 'get_columns.php',
            data: { table: currentTable },
            success: function (response) {
                $('#select-form-container').html(response); // Load checkboxes into select div
            }
        });
    });
    // SELECT ALL checkbox
    $(document).on('change', '#select-all-columns', function () {
        const checked = $(this).is(':checked');
        $('.column-checkbox').prop('checked', checked);
    });

    // Submit SELECT
    $(document).on('submit', '#select-form', function (e) {
        e.preventDefault();
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

    // ORDER BY
    let currentOrder = 'asc';
    $('#toggle-order-btn').on('click', function () {
        currentOrder = currentOrder === 'asc' ? 'desc' : 'asc';
        // UPDATE ORDER side btn
        $(this).html(`
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M120-240v-80h240v80H120Zm0-200v-80h480v80H120Zm0-200v-80h720v80H120Z"/></svg>
        <span>${currentOrder.toUpperCase()}</span>
        `);
        $.ajax({
            type: 'POST',
            url: 'load_table.php',
            data: { table: currentTable, order: currentOrder },
            success: function (response) {
                $('#container').html(response);
            },
            error: function () {
                $('#container').html("Error loading table.");
            }
        });
    });

    // UPDATE EDIT <input>s
    $(document).on('change', '#primary-key', function () {
        const pkField = $(this).data('field');
        const pkValue = $(this).val();
        const table = $('input[name="table"]').val();

        if (!pkValue) return;

        $.post('get_row_data.php', {
            table: table,
            pk: pkField,
            pk_value: pkValue
        }, function (data) {
            try {
                const row = JSON.parse(data);

                // Update value of each field
                $('.edit-field').each(function () {
                    const field = $(this).attr('name');
                    if (row.hasOwnProperty(field)) {
                        $(this).val(row[field]);
                    } else {
                        $(this).val('');
                    }
                });

            } catch (e) {
                console.error("Invalid JSON:", e);
            }
        });
    });

    let primaryKeyCache = {}; // To avoid re-fetching PK multiple times
    // DELETE PK Dropdowns
    $('#toggle-delete-form').on('click', function () {
    $('#delete-table').val(currentTable);
    $.post('get_table_pks.php', { table: currentTable }, function (res) {
        try {
        const parsed = JSON.parse(res);
        const $select = $('#delete-pk-select');
        $select.empty().append(`<option value="">-- Choose ID --</option>`);
        parsed.values.forEach(id => {
            $select.append(`<option value="${id}">${id}</option>`);
        });
        } catch (e) {
        alert('Error loading PK list.');
        console.log('Raw:', res);
        }
    });
    // Submit DELETE
    $('#delete-form').on('submit', function (e) {
            e.preventDefault();
            const formData = $(this).serialize();
            $.post('delete_row.php', formData, function (response) {
                alert(response);
                $('.table-link[data-table="' + currentTable + '"]').click();
            });
        });
    });
});
    </script>
</body>
</html>