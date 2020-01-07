<html ng-app="redis">
  <head>
    <title>McAfee SE Summit 2020 Guestbook</title>
    <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.12/angular.min.js"></script>
    <script src="controllers.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.13.0/ui-bootstrap-tpls.js"></script>
  </head>
  <body ng-controller="RedisCtrl">
    <div style="width: 50%; margin-left: 20px">
      <h2>McAfee SE Summit 2020 Guestbook</h2>
    <form>
    <fieldset>
    <input ng-model="msg" placeholder="Messages" class="form-control" type="text" name="input"><br>
    <button type="button" class="btn btn-primary" ng-click="controller.onRedis()">Submit</button>
    </fieldset>
    </form>
    <div>
      <div ng-repeat="msg in messages track by $index">
        {{msg}}
      </div>
    </div>
    </div>
    <div>Web server running on pod: <?php print (getenv('HOSTNAME')); ?></div>
    <?php
        $instanceid = getenv('INSTANCEID');
        if (empty($instanceid)){
            $instanceid="<UNKNOWN>";
        }
    ?>
    <div>Pod running on instance: <?php print ($instanceid); ?></div>
  </body>
</html>
