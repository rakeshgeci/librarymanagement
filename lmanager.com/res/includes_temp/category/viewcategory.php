<?php

include_once "../classes/objects/class.database.php";

build_category_tree(0,'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');

 function build_category_tree($parent,$intend)
            {
                $connection = Database::Connect();
                $pog_query="select catid, catname FROM category WHERE parent = " . $parent;
                $cursor = mysql_query($pog_query, $connection);
                while($row = Database::Read($cursor))
                {
                    echo $row["catid"].$intend.$row['catname']."<br/>";
                    $ind = $intend."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                    build_category_tree($row["catid"],$ind);
                        
                }
                
                
            }