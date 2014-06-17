		</div>				
		<div id="cabeza">
			Intranet DHO Consultores
		</div>
		<div id="pie">
		Intranet <a href="http://www.dho-consultores.com">DHO Consultores</a> - 2012 Todos los derechos reservados.
		</div>
	</div>
	<div id="showLayer"></div>
	<div id="emergente"></div>	
	<div id="formuEmergente">
		<img id="close" src="<?php echo images;?>icon_close.png" <?php echo sizeImg3;?> />
		<div id="intFormuEmergente">
		</div>
	</div>
	<div id="info" class="izquierda">
		<br />
		<input type="text" id="hora" name="hora">
		<br /><br />
		<input type="text" id="fecha" name="fecha">
		<br /><br />
		<?php
			if(isset($_SESSION['usuario'])){
			$icon = "icon_male.png";
			if($_SESSION['usuario']['sexo']=="F"){
				$icon = "icon_female.png";
			}
		?>
		<a href="perfil.php">
			<img src="<?php echo images.$icon;?>" <?php echo sizeImg;?> /> 
			<?php echo $_SESSION['usuario']['nombre'];?>
			</a> - 
		<a href="<?php echo resources;?>salir.php">
			Salir
			<img src="<?php echo images;?>icon_exit.png" <?php echo sizeImg;?> /> 
		</a>
		<?php
			}
		?>		
	</div>
	<div id="info" class="derecha">
		<a href="http://www.dho-consultores.com" target="_blank">
			<img src="<?php echo images;?>dho.png" height="128" width="128" />
		</a>
	</div>
</body>
</html>
<?php
ob_end_flush();
?>