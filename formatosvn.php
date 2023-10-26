<html>

<head>
  <title>SVN</title>

  <script>
    function copiarAlPortapapeles(id_elemento) {
      var aux = document.createElement("input");
      aux.setAttribute("value", document.getElementById(id_elemento).innerHTML);
      document.body.appendChild(aux);
      aux.select();
      document.execCommand("copy");
      document.body.removeChild(aux);
    }
</script>

</head>

<body>
  <?php
  echo "<b>Texto ingresado:</b></br>" . $_REQUEST['texto'];
  echo "</br></br>";
  echo "Versión:</br>" . $_REQUEST['version'];
  echo "</br></br>";

  $formateado=$_REQUEST['texto'];
  $formateado=str_replace("\n"," ",$formateado);
  $formateado=str_replace("\\","/",$formateado);
  $formateado=str_replace("- ","",$formateado);
  $formateado=str_replace("docs/portal_kellun_ecp/","/portal_kellun_ecp/",$formateado);
  $formateado=str_replace(" /"," ",$formateado);
  $formateado="+".$formateado; //parche para signos / y - al comienzo
  $formateado=str_replace("+/","",$formateado);
  $formateado=str_replace("+","",$formateado);

  // preparar ruta chown

  $pos=strpos($formateado," "); 
  //echo " POS:".$pos;
  if ($pos=='') {
      $ruta="sudo chown apache.apache ".$formateado;
      //echo " ENTRÓ";
  } else {  
      $ruta=substr($formateado,0,$pos);
      $pos=strrpos($ruta,"/"); //última
      $pos2=strrpos(substr($ruta,0,$pos),"/"); //penúltima
      //echo $pos."-pos-".$pos2;
      $ruta=substr($ruta,0,$pos2+1);  
      $ruta="sudo chown apache.apache ".$ruta." -R";
  };
  
  $formateado="sudo svn update ".$formateado;
  $formateado=$formateado." -r ".$_REQUEST['version'];

  echo "<b>Comando SVN</b>:";
  echo "<p id='svnupdate'>" . $formateado . "</p>";  
  
  ?>
  <button onclick="copiarAlPortapapeles('svnupdate')">Copiar svn update...</button>
  </br></br>

  <?php
  echo "<b>Comando chown:</b></br>";
  echo "<p id='chownapache'>" . $ruta. "</p>" ;
  ?>

  <button onclick="copiarAlPortapapeles('chownapache')">Copiar chown...</button>
  </br></br>

  <a href="index.php"> <button>volver</button>  </a> 

</body>

</html>
