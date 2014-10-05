// var app = angular.module('location', ['ngRoute', 'controllers']);

// app.config(['$routeProvider', function($routeProvider) {
//         $routeProvider.
//         when('/', {
//             templateUrl: 'pages/index',
//             controller: 'PageController'
//         }).
//         otherwise({
//             redirectTo: '/'
//         });
//     }
// ]);

var app = angular.module('location', [])
	.controller('PageController', function() {
		this->content = 'Test';
	})