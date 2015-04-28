<p>Hi <?php echo $artist;?></p>

<p>There is a new Customer who is interested for tatto. Details provided below.</p>

<table>
	<tbody>
<?php
	foreach($leadData as $field => $value) {
		echo "<tr><td>";
		echo Inflector::humanize($field);
		echo "</td><td>{$value}</td></tr>";
	}
?>
	</tbody>
</table>
<b style="vertical-align: super;color: #222121;">Powered by &nbsp; </b>
						<?php 
							 echo $this->Html->link(
							    $this->Html->image('http://static.snaplion.com/1104/Photo/JnvGtvVjTwSp278046wK_logo.png', array('alt' => 'ittatyou', 'style' => 'margin-top:10px;')),
							    '/',
							    array('escapeTitle' => false, 'target' => '_blank"')
							);
						?>
<p>Thanks,</p>
