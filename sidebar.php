<?php
// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Sidebar with Navigation Links -->
<aside class="sidebar">
    <h2>Dashboard</h2>
    <div class="nav-links">
        <a href="dashboard.php" <?php echo $current_page == 'dashboard.php' ? 'class="active"' : ''; ?>>Dashboard</a>
        <a href="reminders.php" <?php echo $current_page == 'reminders.php' ? 'class="active"' : ''; ?>>Reminders</a>
        <a href="Existing reminders.php" <?php echo $current_page == 'Existing reminders.php' ? 'class="active"' : ''; ?>>Existing Reminders</a>
        <a href="appointments.php" <?php echo $current_page == 'appointments.php' ? 'class="active"' : ''; ?>>Appointments</a>
        <a href="note.php" <?php echo $current_page == 'note.php' ? 'class="active"' : ''; ?>>Notes</a>
        <a href="drugs.php" <?php echo $current_page == 'drugs.php' ? 'class="active"' : ''; ?>>Drugs</a>
        <a href="Refill.php" <?php echo $current_page == 'Refill.php' ? 'class="active"' : ''; ?>>Drug Refill</a>
    </div>
    <a href="logout.php" class="logout-btn">Logout</a>
</aside>
