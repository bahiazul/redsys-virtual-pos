<?php require_once __DIR__.'/response.php'; ?>
<!DOCTYPE html>
<html<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>OK &middot; Web Response &middot; RedsysVirtualPos Sample</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" integrity="sha512-dTfge/zgoMYpP7QbHy4gWMEGsbsdZeCXz7irItjcC3sPUFtf0kuFbDz/ixG7ArTxmDjLXDmezHubeNikyKGVyQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css" integrity="sha384-aUGj/X2zp5rLCbBxumKTCw2Z50WgIr1vs/PFN4praOTvYXWlVyh2UtNUU0KAUhAX" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="/">RedsysVirtualPos Sample</a>
        </div>
      </div>
    </nav>

    <div class="container">

      <div class="page-header">
        <h1>Web Response <span class="label label-success">OK</span></h1>
      </div>

<?php if (!$rsIsValid): ?>
      <div class="alert alert-danger" role="alert"><?php echo $rsCaption ?></div>
<?php endif ?>

      <div class="row">
        <div class="col-md-8">
<?php if (!empty($riTable)): ?>
            <?= $riTable ?>
<?php endif ?>
<?php if (!empty($rpTable)): ?>
            <?= $rpTable ?>
<?php endif ?>
<?php if (!empty($epTable)): ?>
            <?= $epTable ?>
<?php endif ?>
        </div>
        <div class="col-md-4">
<?php if (!empty($eiTable)): ?>
            <?= $eiTable ?>
<?php endif ?>
<?php if (!empty($erTable)): ?>
            <?= $erTable ?>
<?php endif ?>
          <p><a class="btn btn-success btn-lg btn-block" href="/" role="button">Retry</a></p>
        </div>
      </div>

    </div>
  </body>
</html>
