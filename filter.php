<div class="filter">
    <?php if ($_GET[open] == "1") { ?>
        <a class="filterbutton on" title="Click here to hide open issues." href="project.php?id=<?php echo $project[id]; ?>&open=0&closed=<?php echo $_GET[closed]; ?>"><span>Open</span></a>
    <?php } else { ?>
        <a class="filterbutton off" title="Click here to show open issues." href="project.php?id=<?php echo $project[id]; ?>&open=1&closed=<?php echo $_GET[closed]; ?>"><span>Open</span></a>
    <?php } ?>
    <?php if ($_GET[closed] == "1") { ?>
        <a class="filterbutton on" title="Click here to hide closed issues." href="project.php?id=<?php echo $project[id]; ?>&closed=0&open=<?php echo $_GET[open]; ?>"><span>Closed</span></a>
    <?php } else { ?>
        <a class="filterbutton off" title="Click here to show closed issues." href="project.php?id=<?php echo $project[id]; ?>&closed=1&open=<?php echo $_GET[open]; ?>"><span>Closed</span></a>
    <?php } ?>
</div>