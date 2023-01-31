
      <?php
      require_once("config/funciones.inc.php");
      require_once("config/ClaseDB.php");
      require_once("config/Anuncio.php");

      // creamos objeto claseDB
      $db = new ClaseDB();
      $anuncios = $db->obtenerAnuncios();

      // Mostramos los anuncios
      consulta_full_anuncios($anuncios);
      ?>



