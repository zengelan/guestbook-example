var redisApp = angular.module('redis', ['ui.bootstrap']);

/**
 * Constructor
 */
function RedisController() {}

RedisController.prototype.onRedis = function() {
    this.scope_.messages.push(this.scope_.msg);
    var value = this.scope_.messages.join();
    //old
    this.http_.get("guestbook.php?cmd=set&key=messages&value=" + value)
            .success(angular.bind(this, function(data) {
                this.scope_.redisResponse = "Updated.";
            }));
    //new
    this.http_.get("guestbook.php?cmd=add&value=" + this.scope_.msg)
            .success(angular.bind(this, function(data) {
                this.scope_.redisResponse = "Added.";
            }));
    this.scope_.msg = "";
};

redisApp.controller('RedisCtrl', function ($scope, $http, $location) {
        $scope.controller = new RedisController();
        $scope.controller.scope_ = $scope;
        $scope.controller.location_ = $location;
        $scope.controller.http_ = $http;

        $scope.controller.http_.get("guestbook.php?cmd=getall")
            .success(function(data) {
                console.log(data);
                $scope.messages = data.messages;
                $scope.clienthost = data.clienthost;
            });
});
