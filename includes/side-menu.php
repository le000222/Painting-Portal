<div class="side-menu animate-dropdown outer-bottom-xs">
    <div class="head"><i class="icon fa fa-align-justify fa-fw"></i> Genre</div>        
    <nav class="yamm megamenu-horizontal" role="navigation">
  
        <ul class="nav">
            <li class="dropdown menu-item">
                <?php
                    include('config.php');
                    
                    $sqlQuery = "SELECT * FROM genre";
                    
                    $result = $pdo->query($sqlQuery);
                    
                    while ($row = $result->fetch()) {
                ?>
                	<li class="dropdown yamn">
                		<a href="genre.php?id=<?php echo $row['id'];?>"><?php echo $row['genreName'];?></a>        
                	</li>
                <?php }
                ?>
			</li>
		</ul>
    </nav>
</div>