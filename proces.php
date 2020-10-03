<?php
$choosen = array();
if (isset($_GET['year'])) {
    $choosen['year'] = $_GET['year'];
}
else {
    $choosen['year'] = date('Y');
}
if (isset($_GET['half'])) {
    if ($_GET['half'] == '0'  || $_GET['half'] == '1') {
        $choosen['half'][$_GET['half']] = 'checked ';
        $choosen['half']['value'] = $_GET['half'];
    }
    else
    {
        $choosen['half'][floor((date('n')-1)/6)] = 'checked ';
        $choosen['half']['value'] = floor((date('n')-1)/6);
    }
}
else {
    $choosen['half'][floor((date('n')-1)/6)] = 'checked ';
    $choosen['half']['value'] = floor((date('n')-1)/6);
}

$months[] = 'Januari';
$months[] = 'Februari';
$months[] = 'Maart';
$months[] = 'April';
$months[] = 'Mei';
$months[] = 'Juni';
$months[] = 'Juli';
$months[] = 'Augustus';
$months[] = 'September';
$months[] = 'Oktober';
$months[] = 'November';
$months[] = 'December';

function getCalendarWeeks($firstofMonth) {
    return ceil((date("N", $firstofMonth) + date("t", $firstofMonth) - 1) / 7);
}

function monthCalendar($year, $month) {
	$firstofMonth=mktime(0,0,0, $month, 1, $year);
	$weekgap = 0;
  	?>
    <table>
        <?php
            for($dayofWeek = 0; $dayofWeek < 7; $dayofWeek++) {
                ?>
                <tr>
                    <?php
                        for($weekofMonth = 0; $weekofMonth < getCalendarWeeks($firstofMonth); $weekofMonth++) {
							if (2+$dayofWeek+$weekofMonth*7-date("N", $firstofMonth) > date("t", $firstofMonth) || 2+$dayofWeek+$weekofMonth*7-date("N", $firstofMonth) <= 0) {
								$daynumber = "";
								$hiddenfield = '';
								$onclick = '';
							}
							else {
								$daynumber = 2+$dayofWeek+$weekofMonth*7-date("N", $firstofMonth);
								$hiddenfield = '<input type="hidden" id="'.$month.'-'.$daynumber.'" value="false" />';
								$onclick = " class='dicht' onclick='switchDay(".$month.", ".$daynumber.", this)'";
							}
                            ?>
                                <td<?= $onclick ?>><?= $daynumber.$hiddenfield ?></td>
                            <?php
                        }
                    ?>
                </tr>
                <?php
             }
        ?>
    </table>
    <?php
}
?>
<html>
    <head>
        <style>
            body {
                font-family: Arial;
            }
            .open {
                background: #1b4266;
                color: white;
            }
            .dicht {
                background: white;
                color: #236fb6;
            }
            .title {
                background: white;
                color: #236fb6;
            }
            .bar {
                background: #236fb6;
            }
        </style>
        <script>
            function switchDay(month, daynumber, source) {
                if (document.getElementById(month + '-' + daynumber).value == 'true') {
                    document.getElementById(month + '-' + daynumber).value = 'false';
                }
                else {
                    document.getElementById(month + '-' + daynumber).value = 'true';
                }
                source.classList.toggle('dicht');
                source.classList.toggle('open');

            }
        </script>
    </head>
    <body>
        <form name="">
            Jaar<input type='number' name='year' value='<?= $choosen['year'] ?>' /><br>
            <input type="radio" name="half" value="0" <?= $choosen['half'][0] ?> /> eerste helft
            <input type="radio" name="half" value="1" <?= $choosen['half'][1] ?> /> tweede helft<br>
            <input type='submit' value='Toon kalender' />
        </form>
		<table>
	        <tr>
	        <?php
		        for ($month = 0; $month < 6; $month++) {
		            ?>
				<td class='title'><?= $months[$month+$choosen['half']['value']*6] ?></td>
				<?php 
				    if ($month < 5) {
				        ?>
				    <td class='bar'></td>
				    <?php
				    }
		        }
		    ?>
			</tr>
			<tr>
			    <td colspan='11' class='bar'></td>
			</tr>
			<tr>
		    <?php
		        for ($month = 0; $month < 6; $month++) {
		        ?>
				<td><?= monthCalendar($choosen['year'], $month+1+$choosen['half']['value']*6) ?></td>
				<?php
                if ($month < 5) {
			        ?>
			    <td class='bar'></td>
			    <?php
				    }
		        }
		    ?>
			</tr>
		</table>
    </body>
</html>
